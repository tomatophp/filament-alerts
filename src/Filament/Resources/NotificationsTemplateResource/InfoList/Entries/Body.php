<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\InfoList\Entries;

use Filament\Infolists\Components;

class Body extends Entry
{
    public static function make(): Components\Entry
    {
        return Components\TextEntry::make('body')
            ->label(trans('filament-alerts::messages.templates.form.body'));
    }
}
