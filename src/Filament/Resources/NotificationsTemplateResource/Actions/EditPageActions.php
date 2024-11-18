<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Actions;

use Filament\Actions\LocaleSwitcher;

final class EditPageActions
{
    use Contracts\CanRegister;

    public function getDefaultActions(): array
    {
        return [
            Components\ViewAction::make(),
            Components\DeleteAction::make(),
            LocaleSwitcher::make(),
        ];
    }
}
