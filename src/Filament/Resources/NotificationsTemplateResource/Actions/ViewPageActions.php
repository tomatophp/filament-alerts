<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Actions;

use Filament\Actions\LocaleSwitcher;

final class ViewPageActions
{
    use Contracts\CanRegister;

    public function getDefaultActions(): array
    {
        return [
            Components\EditAction::make(),
            Components\DeleteAction::make(),
            LocaleSwitcher::make(),
        ];
    }
}
