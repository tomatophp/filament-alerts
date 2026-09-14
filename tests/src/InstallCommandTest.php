<?php

use Illuminate\Support\Facades\Artisan;
use TomatoPHP\FilamentAlerts\FilamentAlertsServiceProvider;

use function Pest\Laravel\artisan;

it('boots the service provider', function () {
    expect(app()->getProviders(FilamentAlertsServiceProvider::class))->not->toBeEmpty()
        ->and(config('filament-alerts'))->toBeArray();
});

it('registers the install command', function () {
    expect(Artisan::all())->toHaveKey('filament-alerts:install');
});

it('runs the install command', function () {
    artisan('filament-alerts:install')->assertSuccessful();
});
