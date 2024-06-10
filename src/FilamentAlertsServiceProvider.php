<?php

namespace TomatoPHP\FilamentAlerts;

use Filament\Facades\Filament;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Actions\ActionGroup;
use Filament\Notifications\Notification;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;
use Livewire\Livewire;
use TomatoPHP\FilamentAlerts\Livewire\Firebase;
use TomatoPHP\FilamentSettingsHub\Facades\FilamentSettingsHub;
use TomatoPHP\FilamentSettingsHub\Services\Contracts\SettingHold;


class FilamentAlertsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register generate command
        $this->commands([
           \TomatoPHP\FilamentAlerts\Console\FilamentAlertsInstall::class,
           \TomatoPHP\FilamentAlerts\Console\FilamentAlertsFCM::class,
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

        Livewire::component(Firebase::class);

    }

    public function boot(): void
    {

    }
}
