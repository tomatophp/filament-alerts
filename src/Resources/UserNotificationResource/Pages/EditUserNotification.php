<?php

namespace TomatoPHP\FilamentAlerts\Resources\UserNotificationResource\Pages;

use TomatoPHP\FilamentAlerts\Resources\UserNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserNotification extends EditRecord
{
    protected static string $resource = UserNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
