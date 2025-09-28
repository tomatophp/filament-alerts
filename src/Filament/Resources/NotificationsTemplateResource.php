<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Pages;
use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;

class NotificationsTemplateResource extends Resource
{
    protected static ?string $model = NotificationsTemplate::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-bell';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function getNavigationGroup(): string
    {
        return trans('filament-alerts::messages.group');
    }

    public static function getNavigationLabel(): string
    {
        return trans('filament-alerts::messages.templates.title');
    }

    public static function getTitle(): string
    {
        return trans('filament-alerts::messages.templates.title');
    }

    public static function getLabel(): ?string
    {
        return trans('filament-alerts::messages.templates.single');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('filament-alerts::messages.templates.title');
    }

    public static function getTranslatableLocales(): array
    {
        return array_keys(filament('filament-alerts')->lang);
    }

    public static function infolist(Schema $infolist): Schema
    {
        return config('filament-alerts.resource.infolist.class')::make($infolist);
    }

    public static function form(Schema $form): Schema
    {
        return config('filament-alerts.resource.form.class')::make($form);
    }

    public static function table(Table $table): Table
    {
        return config('filament-alerts.resource.table.class')::make($table);
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
            'index' => Pages\ListNotificationsTemplates::route('/'),
            'create' => Pages\CreateNotificationsTemplate::route('/create'),
            'edit' => Pages\EditNotificationsTemplate::route('/{record}/edit'),
            'view' => Pages\ViewNotificationsTemplates::route('/{record}'),
        ];
    }
}
