<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\InfoList\Entries;

use Filament\Infolists\Components;

class Providers extends Entry
{
    public static function make(): Components\Entry
    {
        return Components\TextEntry::make('providers')
            ->badge()
            ->label(trans('filament-alerts::messages.templates.form.providers'));
    }
}
