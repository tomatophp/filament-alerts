<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ViewRecord;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsLogsResource;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource;

class ViewNotificationsTemplates extends ViewRecord
{
    use ListRecords\Concerns\Translatable;

    #[Reactive]
    public ?string $activeLocale = null;

    protected static string $resource = NotificationsTemplateResource::class;
}
