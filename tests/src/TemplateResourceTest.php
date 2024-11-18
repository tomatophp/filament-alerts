<?php

namespace TomatoPHP\FilamentAlerts\Tests;

use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Pages;
use TomatoPHP\FilamentAlerts\Tests\Models\NotificationsTemplate;
use TomatoPHP\FilamentAlerts\Tests\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertEmpty;

beforeEach(function () {
    actingAs(User::factory()->create());
});

it('can render template resource', function () {
    get(NotificationsTemplateResource::getUrl())->assertSuccessful();
});

it('can list templates', function () {
    NotificationsTemplate::query()->delete();
    $tempaltes = NotificationsTemplate::factory()->count(10)->create();

    livewire(Pages\ListNotificationsTemplates::class)
        ->loadTable()
        ->assertCanSeeTableRecords($tempaltes)
        ->assertCountTableRecords(10);
});

it('can render templates name/title/type/action column in table', function () {
    NotificationsTemplate::factory()->count(10)->create();

    livewire(Pages\ListNotificationsTemplates::class)
        ->loadTable()
        ->assertCanRenderTableColumn('name')
        ->assertCanRenderTableColumn('title')
        ->assertCanRenderTableColumn('type')
        ->assertCanRenderTableColumn('action');
});

it('can render template list page', function () {
    livewire(Pages\ListNotificationsTemplates::class)->assertSuccessful();
});

it('can render view template action', function () {
    livewire(Pages\ListNotificationsTemplates::class, [
        'record' => NotificationsTemplate::factory()->create(),
    ])
        ->mountAction('view')
        ->assertSuccessful();
});

it('can render view template page', function () {
    get(NotificationsTemplateResource::getUrl('view', [
        'record' => NotificationsTemplate::factory()->create(),
    ]))->assertSuccessful();
});

it('can render template create action', function () {
    livewire(Pages\ListNotificationsTemplates::class)
        ->mountAction('create')
        ->assertSuccessful();
});

it('can render template create page', function () {
    get(NotificationsTemplateResource::getUrl('create'))->assertSuccessful();
});

it('can create new template', function () {
    $newData = NotificationsTemplate::factory()->make();

    livewire(Pages\CreateNotificationsTemplate::class)
        ->fillForm([
            'name' => $newData->name,
            'key' => str($newData->name)->slug(),
            'body' => [
                'en' => $newData->sentence,
                'ar' => $newData->sentence,
            ],
            'title' => [
                'en' => $newData->sentence,
                'ar' => $newData->sentence,
            ],
            'url' => $newData->url,
            'icon' => 'heroicon-o-bell',
            'type' => 'info',
            'providers' => ['database', 'email'],
            'action' => 'system',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    assertDatabaseHas(NotificationsTemplate::class, [
        'name' => $newData->name,
        'key' => str($newData->name)->slug(),
        'type' => 'info',
        'action' => 'system',
    ]);
});

it('can validate template input', function () {
    livewire(Pages\CreateNotificationsTemplate::class)
        ->fillForm([
            'name' => null,
            'key' => null,
            'title' => null,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'name' => 'required',
            'key' => 'required',
            'title' => 'required',
        ]);
});

it('can render template edit action', function () {
    livewire(Pages\ListNotificationsTemplates::class, [
        'record' => NotificationsTemplate::factory()->create(),
    ])
        ->mountAction('edit')
        ->assertSuccessful();
});

it('can render template edit page', function () {
    get(NotificationsTemplateResource::getUrl('edit', [
        'record' => NotificationsTemplate::factory()->create(),
    ]))->assertSuccessful();
});

it('can retrieve template data', function () {
    $template = NotificationsTemplate::factory()->create();

    livewire(Pages\EditNotificationsTemplate::class, [
        'record' => $template->getRouteKey(),
    ])
        ->assertFormSet([
            'name' => $template->name,
            'key' => $template->key,
            'url' => $template->url,
            'icon' => $template->icon,
            'type' => $template->type,
            'providers' => $template->providers,
            'action' => $template->action,
        ]);
});

it('can validate edit template input', function () {
    $template = NotificationsTemplate::factory()->create();

    livewire(Pages\EditNotificationsTemplate::class, [
        'record' => $template->getRouteKey(),
    ])
        ->fillForm([
            'name' => null,
            'key' => null,
            'title' => null,
        ])
        ->call('save')
        ->assertHasFormErrors([
            'name' => 'required',
            'key' => 'required',
            'title' => 'required',
        ]);
});

it('can save template data', function () {
    $template = NotificationsTemplate::factory()->create();
    $newData = NotificationsTemplate::factory()->make();

    livewire(Pages\EditNotificationsTemplate::class, [
        'record' => $template->getRouteKey(),
    ])
        ->fillForm([
            'name' => $newData->name,
            'title' => $newData->title,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($template->refresh())
        ->name->toBe($newData->name)
        ->title->toBe($newData->title);
});

it('can delete template', function () {
    $template = NotificationsTemplate::factory()->create();

    livewire(Pages\EditNotificationsTemplate::class, [
        'record' => $template->getRouteKey(),
    ])
        ->callAction('deleteSelectedNotificationsTemplate');

    assertEmpty(NotificationsTemplate::query()->find($template->getRouteKey()));
});
