<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Form\Components;

use Filament\Forms;
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;

class Type extends Component
{
    public static function make(): Forms\Components\Select
    {
        return Forms\Components\Select::make('type')
            ->label(trans('filament-alerts::messages.templates.form.type'))
            ->searchable()
            ->preload()
            ->options(FilamentAlerts::loadTypes()->pluck('label', 'key')->toArray())
            ->columnSpan(2)
            ->default('success');
    }
}
