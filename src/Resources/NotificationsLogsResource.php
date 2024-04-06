<?php

namespace TomatoPHP\FilamentAlerts\Resources;

use TomatoPHP\FilamentAlerts\Resources\NotificationsLogsResource\Pages;
use TomatoPHP\FilamentAlerts\Resources\NotificationsLogsResource\RelationManagers;
use TomatoPHP\FilamentAlerts\Models\NotificationsLogs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('model.name')
                    ->label(trans('filament-alerts::messages.logs.form.user'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(trans('filament-alerts::messages.logs.form.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(trans('filament-alerts::messages.logs.form.type'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('provider')
                    ->label(trans('filament-alerts::messages.logs.form.provider'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(trans('filament-alerts::messages.logs.form.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(trans('filament-alerts::messages.logs.form.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ManageNotificationsLogs::route('/')
        ];
    }
}
