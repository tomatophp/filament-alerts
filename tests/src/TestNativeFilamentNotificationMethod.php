<?php

namespace TomatoPHP\FilamentAlerts\Tests;

use Filament\Notifications\Notification;
use TomatoPHP\FilamentAlerts\Services\Drivers\DatabaseDriver;
use TomatoPHP\FilamentAlerts\Tests\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    actingAs(User::factory()->create());
});

it('can send notification using Filament Native Notification', function () {
    $user = User::factory()->create();

    Notification::make()
        ->title('Test title')
        ->body('Test body')
        ->icon('heroicon-o-bell')
        ->info()
        ->sendUse($user, DatabaseDriver::class);

    assertDatabaseHas('user_notifications', [
        'model_id' => $user->id,
        'model_type' => get_class($user),
        'title' => 'Test title',
        'description' => 'Test body',
        'icon' => 'heroicon-o-bell',
        'type' => 'info',
    ]);

});
