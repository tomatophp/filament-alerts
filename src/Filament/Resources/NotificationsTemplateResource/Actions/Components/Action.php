<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Actions\Components;

use Filament\Actions;

abstract class Action
{
    abstract public static function make(): Actions\Action;
}
