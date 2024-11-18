<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Form\Components;

use Filament\Forms;

class Key extends Component
{
    public static function make(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('key')
            ->label(trans('filament-alerts::messages.templates.form.key'))
            ->unique(table: 'notifications_templates', column: 'key', ignorable: fn ($record) => $record)
            ->required()
            ->columnSpan(3)
            ->maxLength(255);
    }
}
