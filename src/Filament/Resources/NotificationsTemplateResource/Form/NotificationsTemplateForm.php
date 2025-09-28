<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Form;

use Filament\Forms\Components\Field;
use Filament\Schemas;
use Filament\Schemas\Schema;

class NotificationsTemplateForm
{
    protected static array $schema = [];

    public static function make(Schema $form): Schema
    {
        return $form->schema(self::getSchema())->columns(1);
    }

    public static function getDefaultComponents(): array
    {
        return [
            Schemas\Components\Section::make(trans('filament-alerts::messages.templates.sections.details.title'))
                ->description(trans('filament-alerts::messages.templates.sections.details.description'))
                ->columns(6)
                ->schema([
                    Components\Name::make(),
                    Components\Key::make(),
                    Components\Type::make(),
                    Components\Providers::make(),
                    Components\Action::make(),
                ]),
            Schemas\Components\Section::make(trans('filament-alerts::messages.templates.sections.content.title'))
                ->description(trans('filament-alerts::messages.templates.sections.content.description'))
                ->columns(2)
                ->schema([
                    Components\Title::make(),
                    Components\Body::make(),
                    Components\Icon::make(),
                ]),
            Schemas\Components\Section::make(trans('filament-alerts::messages.templates.sections.media.title'))
                ->description(trans('filament-alerts::messages.templates.sections.media.description'))
                ->columns(2)
                ->schema([
                    Components\Image::make(),
                    Components\Url::make(),
                ]),
        ];
    }

    private static function getSchema(): array
    {
        return array_merge(self::getDefaultComponents(), self::$schema);
    }

    public static function register(Field | array $component): void
    {
        if (is_array($component)) {
            foreach ($component as $item) {
                if ($item instanceof Field) {
                    self::$schema[] = $item;
                }
            }

        } else {
            self::$schema[] = $component;
        }
    }
}
