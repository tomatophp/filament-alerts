<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\InfoList\Entries;

use Filament\Infolists\Components;

class Image extends Entry
{
    public static function make(): Components\Entry
    {
        return Components\SpatieMediaLibraryImageEntry::make('image')
            ->collection('image')
            ->label(trans('filament-alerts::messages.templates.form.image'));
    }
}
