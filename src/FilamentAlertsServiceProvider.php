<?php

namespace TomatoPHP\FilamentAlerts;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use TomatoPHP\FilamentSettingsHub\Facades\FilamentSettingsHub;
use TomatoPHP\FilamentSettingsHub\Services\Contracts\SettingHold;


class FilamentAlertsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register generate command
        $this->commands([
           \TomatoPHP\FilamentAlerts\Console\FilamentAlertsInstall::class,
        ]);

        //Register Config file
        $this->mergeConfigFrom(__DIR__.'/../config/filament-alerts.php', 'filament-alerts');

        //Publish Config
        $this->publishes([
           __DIR__.'/../config/filament-alerts.php' => config_path('filament-alerts.php'),
        ], 'filament-alerts-config');

        //Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        //Publish Migrations
        $this->publishes([
           __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'filament-alerts-migrations');
        //Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-alerts');

        //Publish Views
        $this->publishes([
           __DIR__.'/../resources/views' => resource_path('views/vendor/filament-alerts'),
        ], 'filament-alerts-views');

        //Register Langs
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-alerts');

        //Publish Lang
        $this->publishes([
           __DIR__.'/../resources/lang' => base_path('lang/vendor/filament-alerts'),
        ], 'filament-alerts-lang');

        //Register Routes
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

    }

    public function boot(): void
    {
        FilamentSettingsHub::register([
            SettingHold::make()
                ->label('Firebase Settings')
                ->icon('heroicon-o-fire')
                ->route('filament.admin.pages.notifications-settings-page')
                ->description('Update Firebase Settings')
                ->group('Notifications'),
            SettingHold::make()
                ->label('Email Settings')
                ->icon('heroicon-o-envelope')
                ->route('filament.admin.pages.email-settings-page')
                ->description('Update Email Provider Settings')
                ->group('Notifications'),
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
}
