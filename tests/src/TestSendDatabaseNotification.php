<?php

namespace TomatoPHP\FilamentAlerts\Tests;

use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;
use TomatoPHP\FilamentAlerts\Services\Drivers\DatabaseDriver;
use TomatoPHP\FilamentAlerts\Tests\Models\NotificationsTemplate;
use TomatoPHP\FilamentAlerts\Tests\Models\User;

use function Pest\Laravel\assertDatabaseHas;

it('can use FilamentAlerts Facade To Notify User Database', function () {
    $user = User::factory()->create();
    $template = NotificationsTemplate::factory()->create();

    FilamentAlerts::notify($user)
        ->template($template->id)
        ->drivers([DatabaseDriver::class])
        ->title([
            'name' => $user->name,
        ])
        ->body([
            'date' => now()->toDateTimeString(),
        ])
        ->send();

    assertDatabaseHas('user_notifications', [
        'model_id' => $user->id,
        'model_type' => get_class($user),
        'template_id' => $template->id,
        'title' => $template->title,
        'description' => $template->body,
        'icon' => $template->icon,
        'type' => $template->type,
    ]);
});
