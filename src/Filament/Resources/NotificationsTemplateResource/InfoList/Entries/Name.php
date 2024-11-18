<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\InfoList\Entries;

use Filament\Infolists\Components;

class Name extends Entry
{
    public static function make(): Components\Entry
    {
        return Components\TextEntry::make('name')
            ->label(trans('filament-alerts::messages.templates.form.name'));
    }
}
