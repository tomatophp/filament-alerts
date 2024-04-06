<?php

namespace TomatoPHP\FilamentAlerts\Services\Notifications\Interfaces;

interface INotification
{
    public function send($event):void;
}
