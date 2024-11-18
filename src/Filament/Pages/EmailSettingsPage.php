<?php

namespace TomatoPHP\FilamentAlerts\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use TomatoPHP\FilamentAlerts\Settings\EmailSettings;

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
            Action::make('back')->action(fn () => redirect()->route('filament.' . filament()->getCurrentPanel()->getId() . '.pages.settings-hub'))->color('danger')->label(trans('filament-alerts::messages.back')),
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
                    ->label(trans('filament-alerts::messages.settings.email.mail_mailer'))
                    ->hint(config('filament-alerts.show_hint') ? 'setting("mail_mailer")' : null),
                TextInput::make('mail_host')
                    ->label(trans('filament-alerts::messages.settings.email.mail_host'))
                    ->hint(config('filament-alerts.show_hint') ? 'setting("mail_host")' : null),
                TextInput::make('mail_port')
                    ->label(trans('filament-alerts::messages.settings.email.mail_port'))
                    ->hint(config('filament-alerts.show_hint') ? 'setting("mail_port")' : null),
                TextInput::make('mail_username')
                    ->label(trans('filament-alerts::messages.settings.email.mail_username'))
                    ->hint(config('filament-alerts.show_hint') ? 'setting("mail_username")' : null),
                TextInput::make('mail_password')
                    ->label(trans('filament-alerts::messages.settings.email.mail_password'))
                    ->hint(config('filament-alerts.show_hint') ? 'setting("mail_password")' : null),
                TextInput::make('mail_encryption')
                    ->label(trans('filament-alerts::messages.settings.email.mail_encryption'))
                    ->hint(config('filament-alerts.show_hint') ? 'setting("mail_encryption")' : null),
                TextInput::make('mail_from_address')
                    ->label(trans('filament-alerts::messages.settings.email.mail_from_address'))
                    ->hint(config('filament-alerts.show_hint') ? 'setting("mail_from_address")' : null),
                TextInput::make('mail_from_name')
                    ->label(trans('filament-alerts::messages.settings.email.mail_from_name'))
                    ->hint(config('filament-alerts.show_hint') ? 'setting("mail_from_name")' : null),
            ]),

        ];
    }
}
