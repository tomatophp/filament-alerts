<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\Columns;

use Filament\Tables;

class Key extends Column
{
    public static function make(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('key')
            ->hidden()
            ->label(trans('filament-alerts::messages.templates.form.key'))
            ->searchable();
    }
}
