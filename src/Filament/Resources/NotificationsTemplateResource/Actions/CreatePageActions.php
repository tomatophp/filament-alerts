<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Actions;

use Filament\Actions\LocaleSwitcher;

final class CreatePageActions
{
    use Contracts\CanRegister;

    public function getDefaultActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
