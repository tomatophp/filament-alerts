<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\InfoList\Entries;

use Filament\Infolists\Components;

class Key extends Entry
{
    public static function make(): Components\Entry
    {
        return Components\TextEntry::make('key')
            ->label(trans('filament-alerts::messages.templates.form.key'));
    }
}
