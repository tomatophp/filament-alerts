<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Actions;

use Filament\Actions\Action;
use Filament\Actions\LocaleSwitcher;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsLogsResource;

final class ManagePageActions
{
    use Contracts\CanRegister;

    public function getDefaultActions(): array
    {
        return [
            Components\CreateAction::make(),
            Action::make('logs')
                ->icon('heroicon-o-archive-box-arrow-down')
                ->hiddenLabel()
                ->action(fn () => redirect()->to(NotificationsLogsResource::getUrl()))
                ->color('info')
                ->tooltip(trans('filament-alerts::messages.logs.title'))
                ->label(trans('filament-alerts::messages.logs.title')),
            LocaleSwitcher::make(),
        ];
    }
}
