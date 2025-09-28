<?php

namespace TomatoPHP\FilamentAlerts\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\Facades\Filament;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Panel;
use Filament\Schemas\SchemasServiceProvider;
use Filament\SpatieLaravelSettingsPluginServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\Attributes\WithEnv;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as BaseTestCase;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use Spatie\LaravelSettings\LaravelSettingsServiceProvider;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Actions\Components;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Pages\EditNotificationsTemplate;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Pages\ListNotificationsTemplates;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Pages\ViewNotificationsTemplates;
use TomatoPHP\FilamentAlerts\FilamentAlertsServiceProvider;
use TomatoPHP\FilamentAlerts\Services\Concerns\NotificationAction;
use TomatoPHP\FilamentAlerts\Services\Concerns\NotificationDriver;
use TomatoPHP\FilamentAlerts\Services\Concerns\NotificationType;
use TomatoPHP\FilamentAlerts\Services\Concerns\NotificationUser;
use TomatoPHP\FilamentAlerts\Services\Drivers\DatabaseDriver;
use TomatoPHP\FilamentAlerts\Services\Drivers\EmailDriver;
use TomatoPHP\FilamentAlerts\Tests\Models\User;
use TomatoPHP\FilamentIcons\FilamentIconsServiceProvider;
use TomatoPHP\FilamentSettingsHub\FilamentSettingsHubServiceProvider;
use TomatoPHP\FilamentTranslationComponent\FilamentTranslationComponentServiceProvider;

#[WithEnv('DB_CONNECTION', 'testing')]
abstract class TestCase extends BaseTestCase
{
    use LazilyRefreshDatabase;
    use WithWorkbench;

    public ?Panel $panel;

    protected function setUp(): void
    {
        parent::setUp();

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

        FilamentAlerts::register(
            NotificationUser::make(config('filament-alerts.try.model'))
                ->label('User')
                ->icon('heroicon-o-user')
                ->color('primary')
        );

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

        FilamentAlerts::registerAction(Components\CreateAction::make(), ListNotificationsTemplates::class);
        FilamentAlerts::registerAction([
            Components\EditAction::make(),
            Components\DeleteAction::make(),
        ], ViewNotificationsTemplates::class);

        FilamentAlerts::registerAction([
            Components\ViewAction::make(),
            Components\DeleteAction::make(),
        ], EditNotificationsTemplate::class);

        $this->panel = Filament::getCurrentOrDefaultPanel();

    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../vendor/tomatophp/filament-settings-hub/migrations');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    protected function getPackageProviders($app): array
    {
        $providers = [
            ActionsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            LivewireServiceProvider::class,
            NotificationsServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            LaravelSettingsServiceProvider::class,
            MediaLibraryServiceProvider::class,
            SpatieLaravelSettingsPluginServiceProvider::class,
            FilamentIconsServiceProvider::class,
            SchemasServiceProvider::class,
            FilamentTranslationComponentServiceProvider::class,
            FilamentSettingsHubServiceProvider::class,
            FilamentAlertsServiceProvider::class,
            AdminPanelProvider::class,
        ];

        sort($providers);

        return $providers;
    }

    public function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('auth.guards.testing.driver', 'session');
        $app['config']->set('auth.guards.testing.provider', 'testing');
        $app['config']->set('auth.providers.testing.driver', 'eloquent');
        $app['config']->set('auth.providers.testing.model', User::class);

        $app['config']->set('filament-translations.paths', [
            __DIR__ . '/../../vendor/orchestra/testbench-core/laravel',
        ]);

        $app['config']->set('filament-icons.cache', false);
        $app['config']->set('queue.default', 'sync');
        $app['config']->set('filament-alerts.try.model', User::class);

        $app['config']->set('view.paths', [
            ...$app['config']->get('view.paths'),
            __DIR__ . '/../resources/views',
        ]);
    }
}
