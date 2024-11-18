<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\InfoList\Entries;

use Filament\Infolists\Components;

class Icon extends Entry
{
    public static function make(): Components\Entry
    {
        return Components\IconEntry::make('icon')
            ->label(trans('filament-alerts::messages.templates.form.icon'));
    }
}
