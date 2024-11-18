<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Actions\Components;

use Filament\Actions\StaticAction;

abstract class Action
{
    abstract public static function make(): StaticAction;
}
