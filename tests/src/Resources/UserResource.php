<?php

namespace TomatoPHP\FilamentAlerts\Tests\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use TomatoPHP\FilamentAlerts\Filament\Actions\Table\NotificationAction;
use TomatoPHP\FilamentAlerts\Tests\Models\User;
use TomatoPHP\FilamentAlerts\Tests\Resources\UserResource\Pages\ListUsers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function form(Schema $form): Schema
    {
        return parent::form($form);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id'),
        ])
            ->actions([
                NotificationAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
        ];
    }
}
