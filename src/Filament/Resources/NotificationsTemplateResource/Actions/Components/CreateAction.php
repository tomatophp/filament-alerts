<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Actions\Components;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;

class CreateAction extends Action
{
    public static function make(?Model $record = null): Actions\Action
    {
        return Actions\CreateAction::make()->label(trans('filament-alerts::messages.templates.create'));
    }
}
