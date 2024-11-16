<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource;

class CreateNotificationsTemplate extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    #[Reactive]
    public ?string $activeLocale = null;

    protected static string $resource = NotificationsTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
