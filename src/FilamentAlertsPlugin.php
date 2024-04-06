<?php

namespace TomatoPHP\FilamentAlerts;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\View\View;
use TomatoPHP\FilamentSettingsHub\Pages\EmailSettingsPage;
use TomatoPHP\FilamentSettingsHub\Pages\NotificationsSettingsPage;


class FilamentAlertsPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-alerts';
    }

    public function register(Panel $panel): void
    {
        $panel->pages([
                NotificationsSettingsPage::class,
                EmailSettingsPage::class
            ]);

    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return new static();
    }
}
