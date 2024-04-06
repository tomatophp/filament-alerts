<?php

namespace TomatoPHP\FilamentAlerts\Services\Notifications\Interfaces;

interface NotificationInterface
{
    public function send(array $notified, array $replacements = []);
}
