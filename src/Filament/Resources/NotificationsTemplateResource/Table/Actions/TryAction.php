<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\Actions;

use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Tables;
use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;
use TomatoPHP\FilamentAlerts\Services\SendNotification;

class TryAction extends Action
{
    public static function make(): Tables\Actions\Action
    {
        return Tables\Actions\Action::make('try')
            ->iconButton()
            ->tooltip(trans('filament-alerts::messages.templates.actions.try'))
            ->label(trans('filament-alerts::messages.templates.actions.try'))
            ->requiresConfirmation()
            ->action(function (NotificationsTemplate $record) {
                $matchesTitle = [];
                preg_match('/{.*?}/', $record->title, $matchesTitle);
                $titleFill = [];
                foreach ($matchesTitle as $titleItem) {
                    $titleFill[] = 'test-title';
                }
                $matchesBody = [];
                preg_match('/{.*?}/', $record->body, $matchesBody);
                $titleBody = [];
                foreach ($matchesBody as $bodyItem) {
                    $titleBody[] = 'test-body';
                }

                try {
                    SendNotification::make($record->providers)
                        ->template($record->key)
                        ->findTitle($matchesTitle)
                        ->replaceTitle($titleFill)
                        ->findBody($matchesBody)
                        ->replaceBody($titleBody)
                        ->model(User::class)
                        ->id(User::first()->id)
                        ->privacy('private')
                        ->fire();

                    Notification::make()
                        ->title(trans('filament-alerts::messages.templates.actions.try-notification'))
                        ->success()
                        ->send();

                } catch (\Exception $exception) {
                    Notification::make()
                        ->title(trans('filament-alerts::messages.templates.actions.try-notification-danger'))
                        ->danger()
                        ->send();
                }
            })
            ->color('success')
            ->icon('heroicon-o-paper-airplane');
    }
}
