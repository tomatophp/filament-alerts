<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Form\Components;

use Filament\Forms\Components\TextInput;

class Icon extends Component
{
    public static function make(): TextInput
    {
        if (class_exists(\TomatoPHP\FilamentIcons\Components\IconPicker::class)) {
            return \TomatoPHP\FilamentIcons\Components\IconPicker::make('icon')
                ->label(trans('filament-alerts::messages.templates.form.icon'))
                ->default('heroicon-o-check-circle');
        }

        return TextInput::make('icon')
            ->label(trans('filament-alerts::messages.templates.form.icon'))
            ->default('heroicon-o-check-circle');
    }
}
