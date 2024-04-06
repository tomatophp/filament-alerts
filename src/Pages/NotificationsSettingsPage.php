<?php

namespace TomatoPHP\FilamentAlerts\Pages;

use Filament\Forms\Components\Checkbox;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\Action;
use Filament\Pages\SettingsPage;
use Filament\Forms\Components\Grid;
use Spatie\Sitemap\SitemapGenerator;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\ButtonAction;
use Filament\Forms\Components\FileUpload;
use TomatoPHP\FilamentAlerts\Settings\NotificationsSettings;
use TomatoPHP\FilamentSettingsHub\Settings\SitesSettings;


class NotificationsSettingsPage extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = NotificationsSettings::class;

    public function getTitle(): string
    {
        return trans('filament-alerts::messages.settings.notifications.title');
    }

    protected function getActions(): array
    {
        return [
            Action::make('back')->action(fn()=> redirect()->route('filament.admin.pages.settings-hub'))->color('danger')->label(trans('filament-settings-hub::messages.back')),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(['default' => 1])->schema([
                Checkbox::make('notifications_allow')
                    ->label(trans('filament-settings-hub::messages.settings.notifications_allow'))
                    ->hint(config('filament-settings-hub.show_hint') ?'setting("notifications_allow")': null),
                TextInput::make('fcm_apiKey')
                    ->label(trans('filament-settings-hub::messages.settings.fcm_apiKey'))
                    ->hint(config('filament-settings-hub.show_hint') ?'setting("fcm_apiKey")': null),
                TextInput::make('fcm_authDomain')
                    ->label(trans('filament-settings-hub::messages.settings.fcm_authDomain'))
                    ->hint(config('filament-settings-hub.show_hint') ?'setting("fcm_authDomain")': null),
                TextInput::make('fcm_projectId')
                    ->label(trans('filament-settings-hub::messages.settings.fcm_projectId'))
                    ->hint(config('filament-settings-hub.show_hint') ?'setting("fcm_projectId")': null),
                TextInput::make('fcm_storageBucket')
                    ->label(trans('filament-settings-hub::messages.settings.fcm_storageBucket'))
                    ->hint(config('filament-settings-hub.show_hint') ?'setting("fcm_storageBucket")': null),
                TextInput::make('fcm_messagingSenderId')
                    ->label(trans('filament-settings-hub::messages.settings.fcm_messagingSenderId'))
                    ->hint(config('filament-settings-hub.show_hint') ?'setting("fcm_messagingSenderId")': null),
                TextInput::make('fcm_appId')
                    ->label(trans('filament-settings-hub::messages.settings.fcm_appId'))
                    ->hint(config('filament-settings-hub.show_hint') ?'setting("fcm_appId")': null),
                TextInput::make('fcm_measurementId')
                    ->label(trans('filament-settings-hub::messages.settings.fcm_measurementId'))
                    ->hint(config('filament-settings-hub.show_hint') ?'setting("fcm_measurementId")': null),
                FileUpload::make('fcm_cr')
                    ->label(trans('filament-settings-hub::messages.settings.fcm_cr'))
                    ->hint(config('filament-settings-hub.show_hint') ?'setting("fcm_cr")': null),
                TextInput::make('fcm_database_url')
                    ->label(trans('filament-settings-hub::messages.settings.fcm_database_url'))
                    ->hint(config('filament-settings-hub.show_hint') ?'setting("fcm_database_url")': null),
                TextInput::make('fcm_vapid')
                    ->label(trans('filament-settings-hub::messages.settings.fcm_vapid'))
                    ->hint(config('filament-settings-hub.show_hint') ?'setting("fcm_vapid")': null),
            ])

        ];
    }
}
