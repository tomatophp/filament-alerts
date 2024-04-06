<?php

namespace TomatoPHP\FilamentAlerts\Resources\NotificationsTemplateResource\Pages;

use TomatoPHP\FilamentAlerts\Resources\NotificationsTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNotificationsTemplate extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    #[Reactive]
    public ?string $activeLocale = null;

    protected static string $resource = NotificationsTemplateResource::class;

    public function getTitle():string
    {
        return "Create Template";
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
