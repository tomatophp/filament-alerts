<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\Filters;

use Filament\Tables\Filters\BaseFilter;

abstract class Filter
{
    abstract public static function make(): BaseFilter;
}
