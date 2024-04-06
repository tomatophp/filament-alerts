<?php

namespace TomatoPHP\FilamentAlerts\Resources\NotificationsLogsResource\Pages;

use TomatoPHP\FilamentAlerts\Resources\NotificationsLogsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNotificationsLogs extends ListRecords
{
    protected static string $resource = NotificationsLogsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
