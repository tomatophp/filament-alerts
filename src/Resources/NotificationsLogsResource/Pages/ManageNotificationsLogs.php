<?php

namespace TomatoPHP\FilamentAlerts\Resources\NotificationsLogsResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;
use TomatoPHP\FilamentAlerts\Resources\NotificationsLogsResource;
use Filament\Actions;

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
            Action::make('notifications')->action(fn()=> redirect()->route('filament.admin.resources.user-notifications.index'))->color('danger')->label(trans('filament-alerts::messages.back')),

        ];
    }
}
