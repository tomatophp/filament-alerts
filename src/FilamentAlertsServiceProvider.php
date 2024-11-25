<?php

namespace TomatoPHP\FilamentAlerts;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use TomatoPHP\FilamentAlerts\Services\Drivers\EmailDriver;
use TomatoPHP\FilamentAlerts\Services\NotificationService;

class FilamentAlertsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register generate command
        $this->commands([
            \TomatoPHP\FilamentAlerts\Console\FilamentAlertsInstall::class,
        ]);

        //Register Config file
        $this->mergeConfigFrom(__DIR__ . '/../config/filament-alerts.php', 'filament-alerts');

        //Publish Config
        $this->publishes([
            __DIR__ . '/../config/filament-alerts.php' => config_path('filament-alerts.php'),
        ], 'filament-alerts-config');

        //Register Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        //Publish Migrations
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'filament-alerts-migrations');
        //Register views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-alerts');

        //Publish Views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/filament-alerts'),
        ], 'filament-alerts-views');

        //Register Langs
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'filament-alerts');

        //Publish Lang
        $this->publishes([
            __DIR__ . '/../resources/lang' => base_path('lang/vendor/filament-alerts'),
        ], 'filament-alerts-lang');

        $this->app->bind('filament-alerts', function () {
            return new NotificationService;
        });

        Notification::macro('sendUse', function (Model $user, string $driver = EmailDriver::class, array $data = []): static {
            /** @var Notification $this */
            app($driver)->sendIt(
                title: $this->getTitle(),
                body: $this->getBody(),
                icon: $this->getIcon(),
                type: $this->getStatus(),
                url: count($this->getActions()) ? $this->getActions()[0]->getUrl() ?? null : null,
                model: get_class($user),
                modelId: $user->id,
                image: $data['image'] ?? null,
                data: $data,
            );

            return $this;
        });
    }

    public function boot(): void {}
}
