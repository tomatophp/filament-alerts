<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\Actions;

use Filament\Notifications\Notification;
use Filament\Tables;
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;
use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;

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
                    $titleFill[$titleItem] = 'test-title';
                }
                $matchesBody = [];
                preg_match('/{.*?}/', $record->body, $matchesBody);
                $titleBody = [];
                foreach ($matchesBody as $bodyItem) {
                    $titleBody[$bodyItem] = 'test-body';
                }

                try {
                    $user = config('filament-alerts.try.model')::query()->first();
                    if ($user) {
                        FilamentAlerts::notify($user)
                            ->template($record->id)
                            ->title($titleFill)
                            ->body($titleBody)
                            ->send();
                    }

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
