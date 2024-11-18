<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsLogsResource\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsLogsResource;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource;

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
                ->action(fn () => redirect()->to(NotificationsTemplateResource::getUrl()))
                ->color('danger')
                ->label(trans('filament-alerts::messages.back')),
        ];
    }
}
