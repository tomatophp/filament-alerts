<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Form\Components;

use Filament\Forms;

class Title extends Component
{
    public static function make(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('title')
            ->label(trans('filament-alerts::messages.templates.form.title'))
            ->required()
            ->maxLength(255);
    }
}
