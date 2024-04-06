<?php

namespace TomatoPHP\FilamentAlerts;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\View\View;
use TomatoPHP\FilamentAlerts\Resources\NotificationsLogsResource;
use TomatoPHP\FilamentAlerts\Resources\NotificationsTemplateResource;
use TomatoPHP\FilamentAlerts\Resources\UserNotificationResource;
use TomatoPHP\FilamentAlerts\Pages\EmailSettingsPage;
use TomatoPHP\FilamentAlerts\Pages\NotificationsSettingsPage;


class FilamentAlertsPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-alerts';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                NotificationsLogsResource::class,
                UserNotificationResource::class,
                NotificationsTemplateResource::class
            ])
            ->pages([
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
