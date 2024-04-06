<?php

namespace TomatoPHP\FilamentAlerts\Resources\NotificationsTemplateResource\Pages;

use TomatoPHP\FilamentAlerts\Resources\NotificationsTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNotificationsTemplate extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    #[Reactive]
    public ?string $activeLocale = null;

    protected static string $resource = NotificationsTemplateResource::class;

    public function getTitle():string
    {
        return trans('filament-alerts::messages.templates.edit');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
