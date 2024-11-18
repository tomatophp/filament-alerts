<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\InfoList\Entries;

use Filament\Infolists\Components;

class Title extends Entry
{
    public static function make(): Components\Entry
    {
        return Components\TextEntry::make('title')
            ->label(trans('filament-alerts::messages.templates.form.title'));
    }
}
