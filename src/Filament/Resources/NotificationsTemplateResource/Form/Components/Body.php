<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Form\Components;

use Filament\Forms;

class Body extends Component
{
    public static function make(): Forms\Components\Textarea
    {
        return Forms\Components\Textarea::make('body')
            ->label(trans('filament-alerts::messages.templates.form.body'))
            ->columnSpanFull();
    }
}
