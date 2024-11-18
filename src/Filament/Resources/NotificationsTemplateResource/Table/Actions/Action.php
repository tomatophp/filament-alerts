<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\Actions;

abstract class Action
{
    abstract public static function make(): \Filament\Tables\Actions\Action;
}
