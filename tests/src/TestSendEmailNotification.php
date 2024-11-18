<?php

namespace TomatoPHP\FilamentAlerts\Tests;

use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;
use TomatoPHP\FilamentAlerts\Services\Drivers\EmailDriver;
use TomatoPHP\FilamentAlerts\Tests\Models\NotificationsTemplate;
use TomatoPHP\FilamentAlerts\Tests\Models\User;

use function Pest\Laravel\assertDatabaseHas;

it('can use FilamentAlerts Facade To Notify User Email', function () {
    $user = User::factory()->create();
    $template = NotificationsTemplate::factory()->create();

    FilamentAlerts::notify($user)
        ->template($template->id)
        ->drivers([EmailDriver::class])
        ->title([
            'name' => $user->name,
        ])
        ->body([
            'date' => now()->toDateTimeString(),
        ])
        ->send();

    assertDatabaseHas('notifications_logs', [
        'title' => $template->title,
        'description' => $template->body,
        'provider' => 'email',
        'type' => 'info',
    ]);
});
