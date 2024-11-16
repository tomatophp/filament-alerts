<?php

namespace TomatoPHP\FilamentAlerts\Traits;

use TomatoPHP\FilamentAlerts\Jobs\NotifyDatabaseJob;
use TomatoPHP\FilamentAlerts\Jobs\NotifyEmailJob;
use TomatoPHP\FilamentAlerts\Models\UserNotification;

trait InteractsWithNotifications
{
    public function notifyEmail(
        string $message,
        ?string $subject = null,
        ?string $url = null
    ) {
        dispatch(new NotifyEmailJob([
            'email' => $this->email,
            'subject' => $subject,
            'message' => $message,
            'url' => $url,
        ]));
    }

    public function notifyDB(
        string $message,
        ?string $title = null,
        ?string $url = null
    ) {
        dispatch(new NotifyDatabaseJob([
            'model_type' => get_called_class(),
            'model_id' => $this->id,
            'subject' => $title,
            'message' => $message,
            'url' => $url,
        ]));
    }
    public function getUserNotifications()
    {
        return $this->morphMany(UserNotification::class, 'model');
    }
}
