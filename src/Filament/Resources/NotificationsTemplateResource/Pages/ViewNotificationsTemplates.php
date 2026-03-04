<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource;

class ViewNotificationsTemplates extends ViewRecord
{
    protected static string $resource = NotificationsTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return config('filament-alerts.resource.pages.view')::make($this);
    }
}
