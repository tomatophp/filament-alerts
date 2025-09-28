<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource;

class ViewNotificationsTemplates extends ViewRecord
{
    protected static string $resource = NotificationsTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return FilamentAlerts::getPageActions(self::class);
    }
}
