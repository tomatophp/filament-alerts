<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\BulkActions;

use Filament\Tables\Actions\BulkAction;

abstract class Action
{
    abstract public static function make(): BulkAction;
}
