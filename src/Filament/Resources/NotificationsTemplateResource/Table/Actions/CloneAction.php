<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\Actions;

use Filament\Notifications\Notification;
use Filament\Tables;
use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;

class CloneAction extends Action
{
    public static function make(): Tables\Actions\Action
    {
        return Tables\Actions\Action::make('clone')
            ->iconButton()
            ->tooltip(trans('filament-alerts::messages.templates.actions.clone'))
            ->label(trans('filament-alerts::messages.templates.actions.clone'))
            ->requiresConfirmation()
            ->action(function (NotificationsTemplate $record) {

                NotificationsTemplate::create([
                    'name' => $record->name . ' (Clone)',
                    'key' => $record->key . '-clone-' . time(),
                    'title' => $record->title . ' (Clone)',
                    'body' => $record->body,
                    'url' => $record->url,
                    'icon' => $record->icon,
                    'type' => $record->type,
                    'providers' => $record->providers,
                    'action' => $record->action,
                ]);

                Notification::make()
                    ->title(trans('filament-alerts::messages.templates.actions.clone-notification'))
                    ->success()
                    ->send();
            })
            ->color('info')
            ->icon('heroicon-o-document-duplicate');
    }
}
