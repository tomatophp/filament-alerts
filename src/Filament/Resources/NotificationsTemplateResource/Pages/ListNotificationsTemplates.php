<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsLogsResource;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource;

class ListNotificationsTemplates extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    #[Reactive]
    public ?string $activeLocale = null;

    protected static string $resource = NotificationsTemplateResource::class;

    public function getTitle(): string
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
            Action::make('logs')
                ->icon('heroicon-o-archive-box-arrow-down')
                ->hiddenLabel()
                ->action(fn () => redirect()->to(NotificationsLogsResource::getUrl()))
                ->color('info')
                ->tooltip(trans('filament-alerts::messages.notifications.logs'))
                ->label(trans('filament-alerts::messages.notifications.logs')),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
