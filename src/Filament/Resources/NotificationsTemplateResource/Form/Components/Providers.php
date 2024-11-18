<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Form\Components;

use Filament\Forms;
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;

class Providers extends Component
{
    public static function make(): Forms\Components\Select
    {
        return Forms\Components\Select::make('providers')
            ->label(trans('filament-alerts::messages.templates.form.providers'))
            ->searchable()
            ->preload()
            ->multiple()
            ->columnSpan(2)
            ->options(FilamentAlerts::loadDrivers()->pluck('label', 'key')->toArray());
    }
}
