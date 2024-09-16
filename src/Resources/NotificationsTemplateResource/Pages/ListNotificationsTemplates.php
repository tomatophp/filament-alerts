<?php

namespace TomatoPHP\FilamentAlerts\Resources\NotificationsTemplateResource\Pages;

use Filament\Pages\Actions\Action;
use TomatoPHP\FilamentAlerts\Resources\NotificationsTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use TomatoPHP\FilamentAlerts\Resources\UserNotificationResource;

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
            Actions\Action::make('notifications')
                ->action(fn()=> redirect()->to(UserNotificationResource::getUrl('index')))
                ->color('danger')
                ->label(trans('filament-alerts::messages.back')),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
