<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Pages;

use Filament\Resources\Pages\EditRecord;
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource;

class EditNotificationsTemplate extends EditRecord
{
    protected static string $resource = NotificationsTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return FilamentAlerts::getPageActions(self::class);
    }
}
