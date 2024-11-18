<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\InfoList\Entries;

use Filament\Infolists\Components;

class Action extends Entry
{
    public static function make(): Components\Entry
    {
        return Components\TextEntry::make('action')
            ->badge()
            ->label(trans('filament-alerts::messages.templates.form.action'));
    }
}
