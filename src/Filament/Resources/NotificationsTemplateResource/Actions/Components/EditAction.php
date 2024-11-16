<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Actions\Components;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Pages\EditNotificationsTemplate;

class EditAction extends Action
{
    public static function make(?Model $record = null): Actions\Action
    {
        return Actions\Action::make('edit')
            ->url(EditNotificationsTemplate::getUrl(['record' => $record]));
    }
}
