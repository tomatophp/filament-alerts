<?php

namespace TomatoPHP\FilamentAlerts\Resources;

use Guava\FilamentIconPicker\Tables\IconColumn;
use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;
use TomatoPHP\FilamentAlerts\Resources\UserNotificationResource\Pages;
use TomatoPHP\FilamentAlerts\Resources\UserNotificationResource\RelationManagers;
use TomatoPHP\FilamentAlerts\Models\UserNotification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Concerns\Translatable;


class UserNotificationResource extends Resource
{
    use Translatable;

    protected static ?string $model = UserNotification::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell';

    protected static ?int $navigationSort = 2;


    public static function getNavigationGroup(): string
    {
        return "Notifications";
    }

    public static function getTitle(): string
    {
        return "Notifications";
    }

    public static function getNavigationLabel(): string
    {
        return "Notifications";
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('template_id')
                    ->searchable()
                    ->validationAttribute('template_id','required|exists:notifications_templates,id')
                    ->label('Template')
                    ->options(
                        NotificationsTemplate::pluck('name', 'id')->toArray()
                    )
                    ->required(),
                Forms\Components\Select::make('privacy')
                    ->searchable()
                    ->options([
                        'public' => 'Public',
                        'private' => 'Private',
                    ])
                    ->live()
                    ->required()
                    ->default('public'),
                Forms\Components\Select::make('model_type')
                    ->searchable()
                    ->label('User Type')
                    ->options(config('filament-alerts.models'))
                    ->required()
                    ->live(),
                Forms\Components\Select::make('model_id')
                    ->searchable()
                    ->label('User')
                    ->hidden(fn (Forms\Get $get): bool => $get('privacy') !== 'private')
                    ->options(fn (Forms\Get $get) => $get('model_type') ? $get('model_type')::pluck('name', 'id')->toArray() : [])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('model.name')
                    ->label('User')
                    ->searchable(),
                Tables\Columns\TextColumn::make('template.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('url')
                    ->searchable(),
                IconColumn::make('icon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('privacy')
                    ->searchable(),
                Tables\Columns\TextColumn::make('createdBy.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
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
            'index' => Pages\ManageUserNotifications::route('/'),
        ];
    }

}
