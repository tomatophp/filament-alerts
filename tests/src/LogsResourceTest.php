<?php

namespace TomatoPHP\FilamentAlerts\Tests;

use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsLogsResource;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsLogsResource\Pages;
use TomatoPHP\FilamentAlerts\Tests\Models\NotificationsLogs;
use TomatoPHP\FilamentAlerts\Tests\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(User::factory()->create());
});

it('can render template resource', function () {
    get(NotificationsLogsResource::getUrl())->assertSuccessful();
});

it('can list templates', function () {
    NotificationsLogs::query()->delete();
    $logs = NotificationsLogs::factory()->count(10)->create();

    livewire(Pages\ManageNotificationsLogs::class)
        ->loadTable()
        ->assertCanSeeTableRecords($logs)
        ->assertCountTableRecords(10);
});

it('can render templates name/title/type/action column in table', function () {
    NotificationsLogs::factory()->count(10)->create();

    livewire(Pages\ManageNotificationsLogs::class)
        ->loadTable()
        ->assertCanRenderTableColumn('created_at')
        ->assertCanRenderTableColumn('model.name')
        ->assertCanRenderTableColumn('title')
        ->assertCanRenderTableColumn('provider')
        ->assertCanRenderTableColumn('type');
});

it('can render template list page', function () {
    livewire(Pages\ManageNotificationsLogs::class)->assertSuccessful();
});
