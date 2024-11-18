<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\Filters;

use Filament\Tables;
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;

class Type extends Filter
{
    public static function make(): Tables\Filters\SelectFilter
    {
        return Tables\Filters\SelectFilter::make('type')
            ->label(trans('filament-alerts::messages.templates.form.type'))
            ->searchable()
            ->preload()
            ->options(FilamentAlerts::loadTypes()->pluck('label', 'key')->toArray());
    }
}
