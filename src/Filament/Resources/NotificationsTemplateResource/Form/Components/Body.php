<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Form\Components;

use Filament\Forms;
use TomatoPHP\FilamentTranslationComponent\Components\Translation;

class Body extends Component
{
    public static function make(): Forms\Components\Field
    {
        return Translation::make('body')
            ->label(trans('filament-alerts::messages.templates.form.body'))
            ->textarea()
            ->columnSpanFull();
    }
}
