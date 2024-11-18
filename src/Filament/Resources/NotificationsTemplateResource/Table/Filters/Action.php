<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\Filters;

use Filament\Tables;
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;

class Action extends Filter
{
    public static function make(): Tables\Filters\SelectFilter
    {
        return Tables\Filters\SelectFilter::make('action')
            ->label(trans('filament-alerts::messages.templates.form.action'))
            ->searchable()
            ->preload()
            ->options(FilamentAlerts::loadActions()->pluck('label', 'key')->toArray());
    }
}
