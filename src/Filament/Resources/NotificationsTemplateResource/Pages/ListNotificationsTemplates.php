<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Pages;

use Filament\Resources\Pages\ListRecords;
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource;

class ListNotificationsTemplates extends ListRecords
{
    protected static string $resource = NotificationsTemplateResource::class;

    public function getTitle(): string
    {
        return trans('filament-alerts::messages.templates.title');
    }

    public static function getNavigationLabel(): string
    {
        return trans('filament-alerts::messages.templates.title');
    }

    protected function getHeaderActions(): array
    {
        return FilamentAlerts::getPageActions(self::class);
    }
}
