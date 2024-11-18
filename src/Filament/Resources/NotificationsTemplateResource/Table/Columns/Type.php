<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\Columns;

use Filament\Tables;

class Type extends Column
{
    public static function make(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('type')
            ->sortable()
            ->state(fn ($record) => str($record->type)->title())
            ->badge()
            ->icon(fn ($record) => $record->icon)
            ->label(trans('filament-alerts::messages.templates.form.type'))
            ->searchable();
    }
}
