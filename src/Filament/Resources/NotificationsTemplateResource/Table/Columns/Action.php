<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\Columns;

use Filament\Tables;

class Action extends Column
{
    public static function make(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('action')
            ->badge()
            ->color('info')
            ->state(fn ($record) => str($record->action)->title())
            ->icon('heroicon-o-bell')
            ->sortable()
            ->label(trans('filament-alerts::messages.templates.form.action'))
            ->searchable();
    }
}
