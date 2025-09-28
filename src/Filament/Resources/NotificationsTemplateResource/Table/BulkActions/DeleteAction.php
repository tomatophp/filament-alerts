<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\BulkActions;

use Filament\Actions;

class DeleteAction extends Action
{
    public static function make(): Actions\DeleteBulkAction
    {
        return Actions\DeleteBulkAction::make();
    }
}
