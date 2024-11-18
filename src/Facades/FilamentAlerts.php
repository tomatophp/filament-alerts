<?php

namespace TomatoPHP\FilamentAlerts\Facades;

use Illuminate\Support\Facades\Facade;
use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;
use TomatoPHP\FilamentAlerts\Services\SendNotification;

/**
 * @method static void register(object|array $class)
 * @method static \Illuminate\Support\Collection loadTypes()
 * @method static \Illuminate\Support\Collection loadDrivers()
 * @method static \Illuminate\Support\Collection loadActions()
 * @method static \Illuminate\Support\Collection loadUsers()
 * @method static \Illuminate\Support\Collection loadTemplates()
 * @method static NotificationsTemplate loadTemplate(int|string $template, array $title=[], array $body=[], ?Model $user=null)
 * @method static SendNotification notify(?Model $user=null)
 */
class FilamentAlerts extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filament-alerts';
    }
}
