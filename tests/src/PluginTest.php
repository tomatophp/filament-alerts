<?php

use Filament\Facades\Filament;
use TomatoPHP\FilamentAlerts\FilamentAlertsPlugin;

it('registers plugin', function () {
    $panel = Filament::getCurrentPanel();

    $panel->plugins([
        FilamentAlertsPlugin::make(),
    ]);

    expect($panel->getPlugin('filament-alerts'))
        ->not()
        ->toThrow(Exception::class);
});
