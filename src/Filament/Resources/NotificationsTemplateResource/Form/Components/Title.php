<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Form\Components;

use Filament\Forms;
use TomatoPHP\FilamentTranslationComponent\Components\Translation;

class Title extends Component
{
    public static function make(): Forms\Components\Field
    {
        return Translation::make('title')
            ->label(trans('filament-alerts::messages.templates.form.title'))
            ->required()
            ->columnSpanFull();
    }
}
