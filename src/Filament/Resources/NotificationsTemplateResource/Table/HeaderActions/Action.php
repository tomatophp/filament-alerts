<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\HeaderActions;

abstract class Action
{
    abstract public static function make(): \Filament\Actions\Action;
}
