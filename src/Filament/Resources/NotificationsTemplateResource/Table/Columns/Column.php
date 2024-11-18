<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\Columns;

abstract class Column
{
    abstract public static function make(): \Filament\Tables\Columns\Column;
}
