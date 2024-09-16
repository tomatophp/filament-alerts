<?php

namespace TomatoPHP\FilamentAlerts\Resources\NotificationsLogsResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;
use TomatoPHP\FilamentAlerts\Resources\NotificationsLogsResource;
use Filament\Actions;
use TomatoPHP\FilamentAlerts\Resources\UserNotificationResource;

class ManageNotificationsLogs extends ManageRecords
{
    protected static string $resource = NotificationsLogsResource::class;

    public function getTitle(): string
    {
        return trans('filament-alerts::messages.logs.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('notifications')
                ->action(fn()=> redirect()->to(UserNotificationResource::getUrl('index')))
                ->color('danger')
                ->label(trans('filament-alerts::messages.back')),
        ];
    }
}
