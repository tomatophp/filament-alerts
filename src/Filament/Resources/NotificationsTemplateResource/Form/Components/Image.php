<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Form\Components;

use Filament\Forms;

class Image extends Component
{
    public static function make(): Forms\Components\SpatieMediaLibraryFileUpload
    {
        return Forms\Components\SpatieMediaLibraryFileUpload::make('image')
            ->label(trans('filament-alerts::messages.templates.form.image'))
            ->collection('image')
            ->maxFiles(1)
            ->maxWidth(1024)
            ->acceptedFileTypes(['image/*'])
            ->columnSpan(3);
    }
}
