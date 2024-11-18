<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\InfoList\Entries;

use Filament\Infolists\Components;

class Color extends Entry
{
    public static function make(): Components\Entry
    {
        return Components\ColorEntry::make('color')
            ->label(trans('filament-alerts::messages.templates.form.color'));
    }
}
