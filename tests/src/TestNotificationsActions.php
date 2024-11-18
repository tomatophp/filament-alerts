<?php

namespace TomatoPHP\FilamentAlerts\Tests;

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
        ->callTableAction('clone', $template)
        ->assertHasNoTableActionErrors();

});

it('can try notification template', function () {
    User::factory()->create();
    $template = NotificationsTemplate::factory()->create();

    livewire(Pages\ListNotificationsTemplates::class)
        ->callTableAction('try', $template)
        ->assertHasNoTableActionErrors();
});

it('can send notification template', function () {
    $user = User::factory()->create();
    $template = NotificationsTemplate::factory()->create();

    livewire(Pages\ListNotificationsTemplates::class)
        ->callTableAction('send', $template, [
            'privacy' => 'private',
            'model_type' => User::class,
            'model_id' => $user->id,
        ])
        ->assertHasNoTableActionErrors();
});

it('can send notification using selected template', function () {
    $user = User::factory()->create();
    $template = NotificationsTemplate::factory()->create();

    livewire(ListUsers::class)
        ->callTableAction('send', $user, [
            'template_id' => $template->id,
        ])
        ->assertHasNoTableActionErrors();
});
