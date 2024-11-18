<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Form\Components;

use Filament\Forms;

class Name extends Component
{
    public static function make(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('name')
            ->label(trans('filament-alerts::messages.templates.form.name'))
            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                $set('key', str($get('name'))->slug());
            })
            ->lazy()
            ->required()
            ->columnSpan(3)
            ->maxLength(255);
    }
}
