<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\Columns;

use Filament\Tables;

class Name extends Column
{
    public static function make(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('name')
            ->description(fn ($record) => $record->key)
            ->sortable()
            ->label(trans('filament-alerts::messages.templates.form.name'))
            ->searchable();
    }
}
