<?php

namespace TomatoPHP\FilamentAlerts\Filament\Actions;

use Filament\Actions\Action;
use Filament\Forms;
use Filament\Notifications\Notification;
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;
use TomatoPHP\FilamentAlerts\Tests\Models\NotificationsTemplate;

class NotificationAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->name('send')
            ->requiresConfirmation()
            ->iconButton()
            ->label(trans('filament-alerts::messages.actions.send.label'))
            ->tooltip(trans('filament-alerts::messages.actions.send.label'))
            ->icon('heroicon-o-bell')
            ->schema(fn ($record) => [
                Forms\Components\Select::make('template_id')
                    ->label(trans('filament-alerts::messages.actions.send.form.template_id'))
                    ->searchable()
                    ->preload()
                    ->options(NotificationsTemplate::query()->pluck('name', 'id')->toArray()),
            ])
            ->action(function (array $data, $record) {
                FilamentAlerts::notify()
                    ->model(get_class($record))
                    ->modelId($record->id)
                    ->template($data['template_id'])
                    ->send();

                Notification::make()
                    ->title(trans('filament-alerts::messages.actions.send.notification'))
                    ->success()
                    ->send();
            });
    }
}
