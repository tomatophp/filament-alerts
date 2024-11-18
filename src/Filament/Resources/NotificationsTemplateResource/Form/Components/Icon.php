<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Form\Components;

use TomatoPHP\FilamentIcons\Components\IconPicker;

class Icon extends Component
{
    public static function make(): IconPicker
    {
        return IconPicker::make('icon')
            ->label(trans('filament-alerts::messages.templates.form.icon'))
            ->default('heroicon-o-check-circle');
    }
}
