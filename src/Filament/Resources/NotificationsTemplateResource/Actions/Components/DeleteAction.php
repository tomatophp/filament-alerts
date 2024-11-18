<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Actions\Components;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;

class DeleteAction extends Action
{
    public static function make(?Model $record = null): Actions\Action
    {
        return Actions\DeleteAction::make('deleteSelectedNotificationsTemplate');
    }
}
