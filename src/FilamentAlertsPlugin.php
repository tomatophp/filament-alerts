<?php

namespace TomatoPHP\FilamentAlerts;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\SpatieLaravelTranslatablePlugin;
use Illuminate\Support\Facades\Config;
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;
use TomatoPHP\FilamentAlerts\Filament\Pages\EmailSettingsPage;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsLogsResource;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource;
use TomatoPHP\FilamentAlerts\Services\Concerns\NotificationAction;
use TomatoPHP\FilamentAlerts\Services\Concerns\NotificationDriver;
use TomatoPHP\FilamentAlerts\Services\Concerns\NotificationType;
use TomatoPHP\FilamentAlerts\Services\Concerns\NotificationUser;
use TomatoPHP\FilamentAlerts\Services\Drivers\DatabaseDriver;
use TomatoPHP\FilamentAlerts\Services\Drivers\EmailDriver;
use TomatoPHP\FilamentSettingsHub\Facades\FilamentSettingsHub;
use TomatoPHP\FilamentSettingsHub\FilamentSettingsHubPlugin;
use TomatoPHP\FilamentSettingsHub\Services\Contracts\SettingHold;

class FilamentAlertsPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-alerts';
    }

    public ?bool $useSettingsHub = false;

    public ?bool $hideNotificationsResource = false;

    public ?array $lang = [
        'en' => 'English',
        'ar' => 'Arabic',
    ];

    public function register(Panel $panel): void
    {
        $panel
            ->plugin(SpatieLaravelTranslatablePlugin::make())
            ->resources((! $this->hideNotificationsResource) ? [
                NotificationsLogsResource::class,
                NotificationsTemplateResource::class,
            ] : []);

        if ($this->useSettingsHub) {
            if (! $panel->hasPlugin('filament-settings-hub')) {
                $panel->plugin(FilamentSettingsHubPlugin::make());
            }
            $panel->pages([
                EmailSettingsPage::class,
            ]);
        }
    }

    public function hideNotificationsResource(?bool $hideNotificationsResource = true): static
    {
        $this->hideNotificationsResource = $hideNotificationsResource;

        return $this;
    }

    public function useSettingsHub(?bool $useSettingsHub = true): static
    {
        $this->useSettingsHub = $useSettingsHub;

        return $this;
    }

    public function lang(?array $lang = []): static
    {
        $this->lang = $lang;

        return $this;
    }

    public function boot(Panel $panel): void
    {
        if (class_exists(FilamentSettingsHub::class) && $this->useSettingsHub) {
            FilamentSettingsHub::register([
                SettingHold::make()
                    ->label('filament-alerts::messages.settings.email.title')
                    ->icon('heroicon-o-envelope')
                    ->page(EmailSettingsPage::class)
                    ->order(2)
                    ->description('filament-alerts::messages.settings.email.description')
                    ->group('filament-alerts::messages.settings.group'),
            ]);

            try {
                Config::set('mail.mailers.smtp', [
                    'transport' => setting('mail_mailer'),
                    'host' => setting('mail_host'),
                    'port' => setting('mail_port'),
                    'encryption' => setting('mail_encryption'),
                    'username' => setting('mail_username'),
                    'password' => setting('mail_password'),
                    'timeout' => null,
                    'auth_mode' => null,
                ]);

                Config::set('mail.from', [
                    'address' => setting('mail_from_address'),
                    'name' => setting('mail_from_name'),
                ]);

            } catch (\Exception $e) {
                \Log::error($e);
            }
        }

        if (config('filament-alerts.predefined.users')) {
            FilamentAlerts::register(
                NotificationUser::make(config('filament-alerts.try.model'))
                    ->label('User')
                    ->icon('heroicon-o-user')
                    ->color('primary')
            );
        }

        if (config('filament-alerts.predefined.types')) {
            FilamentAlerts::register(
                [
                    NotificationType::make('success')
                        ->label('Success')
                        ->icon('heroicon-o-check-circle')
                        ->color('success'),
                    NotificationType::make('danger')
                        ->label('Danger')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger'),
                    NotificationType::make('info')
                        ->label('Info')
                        ->icon('heroicon-o-information-circle')
                        ->color('info'),
                ]
            );
        }

        if (config('filament-alerts.predefined.drivers')) {
            FilamentAlerts::register(
                [
                    NotificationDriver::make('database')
                        ->label('Database')
                        ->color('primary')
                        ->icon('heroicon-o-server-stack')
                        ->driver(DatabaseDriver::class),
                    NotificationDriver::make('email')
                        ->label('Email')
                        ->color('info')
                        ->icon('heroicon-o-envelope')
                        ->driver(EmailDriver::class),
                ]
            );
        }

        if (config('filament-alerts.predefined.actions')) {
            FilamentAlerts::register(
                [
                    NotificationAction::make('system')
                        ->label('System')
                        ->icon('heroicon-o-cog')
                        ->color('primary'),
                    NotificationAction::make('manual')
                        ->label('Manual')
                        ->icon('heroicon-o-hand')
                        ->color('info'),
                ]
            );
        }
    }

    public static function make(): FilamentAlertsPlugin
    {
        return new FilamentAlertsPlugin;
    }
}
