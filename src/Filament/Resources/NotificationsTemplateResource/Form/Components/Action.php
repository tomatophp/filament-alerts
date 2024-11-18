<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Form\Components;

use Filament\Forms;
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;

class Action extends Component
{
    public static function make(): Forms\Components\Select
    {
        return Forms\Components\Select::make('action')
            ->label(trans('filament-alerts::messages.templates.form.action'))
            ->searchable()
            ->preload()
            ->columnSpan(2)
            ->options(FilamentAlerts::loadActions()->pluck('label', 'key')->toArray())
            ->default('manual');
    }
}
