<?php

namespace TomatoPHP\FilamentAlerts\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 * @method static void register(object|array $class)
 * @method static \Illuminate\Support\Collection loadTypes()
 * @method static \Illuminate\Support\Collection loadDrivers()
 * @method static \Illuminate\Support\Collection loadActions()
 * @method static \Illuminate\Support\Collection loadUsers()
 *
 */
class FilamentAlerts extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filament-alerts';
    }
}
