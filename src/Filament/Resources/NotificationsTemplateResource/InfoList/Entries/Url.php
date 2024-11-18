<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\InfoList\Entries;

use Filament\Infolists\Components;

class Url extends Entry
{
    public static function make(): Components\Entry
    {
        return Components\TextEntry::make('url')
            ->label(trans('filament-alerts::messages.templates.form.url'));
    }
}
