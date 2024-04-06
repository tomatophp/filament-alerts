<?php

namespace TomatoPHP\FilamentSettingsHub\Pages;

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
use TomatoPHP\FilamentAlerts\Settings\EmailSettings;
use TomatoPHP\FilamentAlerts\Settings\NotificationsSettings;
use TomatoPHP\FilamentSettingsHub\Settings\SitesSettings;


class EmailSettingsPage extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = EmailSettings::class;

    public function getTitle(): string
    {
        return trans('filament-alerts::messages.settings.email.title');
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
                TextInput::make('mail_mailer')
                    ->label(trans('filament-settings-hub::messages.settings.mail_mailer'))
                    ->hint(config('filament-settings-hub.show_hint') ?'setting("mail_mailer")': null),
                TextInput::make('mail_host')
                    ->label(trans('filament-settings-hub::messages.settings.mail_host'))
                    ->hint(config('filament-settings-hub.show_hint') ?'setting("mail_host")': null),
                TextInput::make('mail_port')
                    ->label(trans('filament-settings-hub::messages.settings.mail_port'))
                    ->hint(config('filament-settings-hub.show_hint') ?'setting("mail_port")': null),
                TextInput::make('mail_password')
                    ->label(trans('filament-settings-hub::messages.settings.mail_password'))
                    ->hint(config('filament-settings-hub.show_hint') ?'setting("mail_password")': null),
                TextInput::make('mail_encryption')
                    ->label(trans('filament-settings-hub::messages.settings.mail_encryption'))
                    ->hint(config('filament-settings-hub.show_hint') ?'setting("mail_encryption")': null),
                TextInput::make('mail_from_address')
                    ->label(trans('filament-settings-hub::messages.settings.mail_from_address'))
                    ->hint(config('filament-settings-hub.show_hint') ?'setting("mail_from_address")': null),
                TextInput::make('mail_from_name')
                    ->label(trans('filament-settings-hub::messages.settings.mail_from_name'))
                    ->hint(config('filament-settings-hub.show_hint') ?'setting("mail_from_name")': null),
            ])

        ];
    }
}
