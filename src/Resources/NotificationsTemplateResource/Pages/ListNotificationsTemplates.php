<?php

namespace TomatoPHP\FilamentAlerts\Resources\NotificationsTemplateResource\Pages;

use TomatoPHP\FilamentAlerts\Resources\NotificationsTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNotificationsTemplates extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    #[Reactive]
    public ?string $activeLocale = null;

    protected static string $resource = NotificationsTemplateResource::class;

    public function getTitle():string
    {
        return trans('filament-alerts::messages.templates.title');
    }

    public static function getNavigationLabel(): string
    {
        return trans('filament-alerts::messages.templates.title');
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label(trans('filament-alerts::messages.templates.create')),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
