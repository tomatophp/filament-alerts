<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource;

class CreateNotificationsTemplate extends CreateRecord
{
    protected static string $resource = NotificationsTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return FilamentAlerts::getPageActions(self::class);
    }
}
