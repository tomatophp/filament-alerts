<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\InfoList;

use Filament\Infolists\Components\Entry;
use Filament\Schemas\Schema;

class NotificationsTemplateInfoList
{
    protected static array $schema = [];

    public static function make(Schema $infolist): Schema
    {
        return $infolist->schema(self::getSchema());
    }

    public static function getDefaultComponents(): array
    {
        return [
            Entries\Name::make(),
            Entries\Key::make(),
            Entries\Type::make(),
            Entries\Action::make(),
            Entries\Providers::make(),
            Entries\Title::make(),
            Entries\Body::make(),
            Entries\Image::make(),
            Entries\Url::make(),
        ];
    }

    private static function getSchema(): array
    {
        return array_merge(self::getDefaultComponents(), self::$schema);
    }

    public static function register(Entry | array $component): void
    {
        if (is_array($component)) {
            foreach ($component as $item) {
                if ($item instanceof Entry) {
                    self::$schema[] = $item;
                }
            }

        } else {
            self::$schema[] = $component;
        }
    }
}
