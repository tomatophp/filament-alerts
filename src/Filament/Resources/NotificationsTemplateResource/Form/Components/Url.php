<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Form\Components;

use Filament\Forms;

class Url extends Component
{
    public static function make(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('url')
            ->label(trans('filament-alerts::messages.templates.form.url'))
            ->columnSpan(3)
            ->url()
            ->maxLength(255);
    }
}
