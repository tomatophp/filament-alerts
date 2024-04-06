<?php

namespace TomatoPHP\FilamentAlerts\Resources\UserNotificationResource\Pages;

use Filament\Pages\Actions\Action;
use TomatoPHP\FilamentAlerts\Resources\UserNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserNotifications extends ListRecords
{
    protected static string $resource = UserNotificationResource::class;

    public function getTitle():string
    {
        return "Notifications";
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('logs')->action(fn()=> redirect()->route('filament.admin.pages.settings-hub'))->color('info')->label(trans('filament-settings-hub::messages.back')),
        ];
    }
}
