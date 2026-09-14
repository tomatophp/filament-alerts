<?php

namespace TomatoPHP\FilamentAlerts\Tests;

use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\InfoList\NotificationsTemplateInfoList;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Pages\ListNotificationsTemplates;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\NotificationsTemplateActions;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\NotificationsTemplateBulkActions;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\NotificationsTemplateHeaderActions;
use TomatoPHP\FilamentAlerts\Services\Drivers\DatabaseDriver;
use TomatoPHP\FilamentAlerts\Tests\Models\NotificationsTemplate;
use TomatoPHP\FilamentAlerts\Tests\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

function resetRegisteredTableHooks(): void
{
    foreach ([NotificationsTemplateActions::class, NotificationsTemplateHeaderActions::class, NotificationsTemplateBulkActions::class] as $class) {
        (new \ReflectionProperty($class, 'actions'))->setValue(null, []);
    }
}

beforeEach(fn () => resetRegisteredTableHooks());
afterEach(fn () => resetRegisteredTableHooks());

arch('package code does not depend on the test suite')
    ->expect('TomatoPHP\FilamentAlerts')
    ->not->toUse('TomatoPHP\FilamentAlerts\Tests');

it('points the infolist config at the real InfoList class', function () {
    expect(config('filament-alerts.resource.infolist.class'))
        ->toBe(NotificationsTemplateInfoList::class);
});

it('registers custom table actions built with Filament\Actions', function () {
    actingAs(User::factory()->create());

    NotificationsTemplateActions::register(Action::make('customRecordAction'));
    NotificationsTemplateHeaderActions::register([Action::make('customHeaderAction')]);
    NotificationsTemplateBulkActions::register(BulkAction::make('customBulkAction'));

    livewire(ListNotificationsTemplates::class)
        ->loadTable()
        ->assertTableActionExists('customRecordAction')
        ->assertTableActionExists('customHeaderAction')
        ->assertTableBulkActionExists('customBulkAction');
});

it('ships a factory for the package template model', function () {
    $template = \TomatoPHP\FilamentAlerts\Models\NotificationsTemplate::factory()->create();

    expect($template->exists)->toBeTrue()
        ->and($template->getTranslation('title', 'en'))->not->toBeEmpty()
        ->and($template->providers)->toBe(['database']);
});

it('sends a notification selected by template key', function () {
    $user = User::factory()->create();
    $template = NotificationsTemplate::factory()->create();

    FilamentAlerts::notify($user)
        ->template($template->key)
        ->drivers([DatabaseDriver::class])
        ->send();

    assertDatabaseHas('user_notifications', [
        'model_id' => $user->id,
        'model_type' => $user::class,
        'template_id' => $template->id,
    ]);
});
