<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsLogsResource\Pages;
use TomatoPHP\FilamentAlerts\Models\NotificationsLogs;

class NotificationsLogsResource extends Resource
{
    protected static ?string $model = NotificationsLogs::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';

    public static function getNavigationGroup(): string
    {
        return trans('filament-alerts::messages.group');
    }

    public static function getNavigationLabel(): string
    {
        return trans('filament-alerts::messages.logs.title');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->description(fn ($record) => $record->created_at->diffForHumans())
                    ->label(trans('filament-alerts::messages.logs.form.created_at'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('model.name')
                    ->description(fn ($record) => $record->model_type)
                    ->label(trans('filament-alerts::messages.logs.form.user'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(trans('filament-alerts::messages.logs.form.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->label(trans('filament-alerts::messages.logs.form.type'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('provider')
                    ->badge()
                    ->label(trans('filament-alerts::messages.logs.form.provider'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(trans('filament-alerts::messages.logs.form.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageNotificationsLogs::route('/'),
        ];
    }
}
