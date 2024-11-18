<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource;

class CreateNotificationsTemplate extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = NotificationsTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return config('filament-alerts.resource.pages.create')::make($this);
    }
}
