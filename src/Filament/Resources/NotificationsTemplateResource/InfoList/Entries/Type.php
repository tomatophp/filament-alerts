<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\InfoList\Entries;

use Filament\Infolists\Components;

class Type extends Entry
{
    public static function make(): Components\Entry
    {
        return Components\TextEntry::make('type')
            ->badge()
            ->label(trans('filament-alerts::messages.templates.form.type'));
    }
}