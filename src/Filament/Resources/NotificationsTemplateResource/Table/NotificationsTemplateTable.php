<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table;

use Filament\Tables\Columns\Column;
use Filament\Tables\Table;

class NotificationsTemplateTable
{
    protected static array $columns = [];

    public static function make(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->bulkActions(config('filament-alerts.resource.table.bulkActions')::make())
            ->actions(config('filament-alerts.resource.table.actions')::make())
            ->filters(config('filament-alerts.resource.table.filters')::make())
            ->headerActions(config('filament-alerts.resource.table.header-actions')::make())
            ->columns(self::getColumns());
    }

    public static function getDefaultColumns(): array
    {
        return [
            Columns\Name::make(),
            Columns\Key::make(),
            Columns\Title::make(),
            Columns\Type::make(),
            Columns\Action::make(),
            Columns\CreatedAt::make(),
            Columns\UpdatedAt::make(),
        ];
    }

    private static function getColumns(): array
    {
        return array_merge(self::getDefaultColumns(), self::$columns);
    }

    public static function register(Column | array $column): void
    {
        if (is_array($column)) {
            foreach ($column as $item) {
                if ($item instanceof Column) {
                    self::$columns[] = $item;
                }
            }
        } else {
            self::$columns[] = $column;
        }
    }
}
