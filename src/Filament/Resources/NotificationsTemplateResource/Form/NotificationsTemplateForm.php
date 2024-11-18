<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Form;

use Filament\Forms;
use Filament\Forms\Components\Field;
use Filament\Forms\Form;

class NotificationsTemplateForm
{
    protected static array $schema = [];

    public static function make(Form $form): Form
    {
        return $form->schema(self::getSchema());
    }

    public static function getDefaultComponents(): array
    {
        return [
            Forms\Components\Section::make('Template Details')
                ->description('The Name of the template and the unique key to access the template from the code')
                ->columns(6)
                ->schema([
                    Components\Name::make(),
                    Components\Key::make(),
                    Components\Type::make(),
                    Components\Providers::make(),
                    Components\Action::make(),
                ]),
            Forms\Components\Section::make('Notification Content')
                ->description('The title and body of the notification')
                ->columns(2)
                ->schema([
                    Components\Title::make(),
                    Components\Icon::make(),
                    Components\Body::make(),
                ]),
            Forms\Components\Section::make('Notification Media and URL')
                ->description('The image and the URL to redirect the user to')
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
