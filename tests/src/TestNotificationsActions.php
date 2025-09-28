<?php

namespace TomatoPHP\FilamentAlerts\Tests;

use Filament\Actions\Testing\TestAction;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Pages;
use TomatoPHP\FilamentAlerts\Tests\Models\NotificationsTemplate;
use TomatoPHP\FilamentAlerts\Tests\Models\User;
use TomatoPHP\FilamentAlerts\Tests\Resources\UserResource\Pages\ListUsers;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(User::factory()->create());
});

it('can clone notification template', function () {
    $template = NotificationsTemplate::factory()->create();

    livewire(Pages\ListNotificationsTemplates::class)
        ->assertActionVisible(TestAction::make('clone')->table($template));

});

it('can try notification template', function () {
    User::factory()->create();
    $template = NotificationsTemplate::factory()->create();

    livewire(Pages\ListNotificationsTemplates::class)
        ->assertActionVisible(TestAction::make('try')->table($template));
});

it('can send notification template', function () {
    $user = User::factory()->create();
    $template = NotificationsTemplate::factory()->create();

    livewire(ListUsers::class)
        ->assertActionVisible(TestAction::make('send')->table($user), [
            'privacy' => 'private',
            'model_type' => User::class,
            'model_id' => $user->id,
        ]);
});

it('can send notification using selected template', function () {
    $user = User::factory()->create();
    $template = NotificationsTemplate::factory()->create();

    livewire(ListUsers::class)
        ->assertActionVisible(TestAction::make('send')->table($user), [
            'template_id' => $template->id,
        ]);
});
