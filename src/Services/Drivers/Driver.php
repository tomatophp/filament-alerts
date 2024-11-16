<?php

namespace TomatoPHP\FilamentAlerts\Services\Drivers;

abstract class Driver
{
    public abstract function setup(): void;
    public abstract function send(): void;
}
