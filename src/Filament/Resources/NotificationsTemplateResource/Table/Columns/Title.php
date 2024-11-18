<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\Columns;

use Filament\Tables;

class Title extends Column
{
    public static function make(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('title')
            ->description(fn ($record) => $record->body)
            ->label(trans('filament-alerts::messages.templates.form.title'))
            ->searchable();
    }
}
