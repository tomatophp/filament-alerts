<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Pages;

use Filament\Resources\Pages\EditRecord;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource;

class EditNotificationsTemplate extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    public ?string $activeLocale = null;

    protected static string $resource = NotificationsTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return config('filament-alerts.resource.pages.edit')::make($this);
    }
}
