<?php

namespace TomatoPHP\FilamentAlerts\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use TomatoPHP\FilamentAlerts\Jobs\NotifyDatabaseJob;
use TomatoPHP\FilamentAlerts\Jobs\NotifyDiscordJob;
use TomatoPHP\FilamentAlerts\Jobs\NotifyEmailJob;
use TomatoPHP\FilamentAlerts\Jobs\NotifyFCMJob;
use TomatoPHP\FilamentAlerts\Jobs\NotifyPusherJob;
use TomatoPHP\FilamentAlerts\Jobs\NotifySlackJob;
use TomatoPHP\FilamentAlerts\Jobs\NotifySMSMisrJob;
use TomatoPHP\FilamentAlerts\Mail\SendEmail;
use TomatoPHP\FilamentAlerts\Models\UserNotification;
use TomatoPHP\FilamentAlerts\Models\UserToken;

trait InteractsWithNotifications
{
    public function notifySMSMisr(
        string $message
    ): void
    {
        dispatch(new NotifySMSMisrJob([
            'phone' => $this->phone,
            'message' => $message,
        ]));
    }

    public function notifyEmail(
        string $message,
        ?string $subject = null,
        ?string $url = null
    )
    {
        dispatch(new NotifyEmailJob([
            'email' => $this->email,
            'subject' => $subject,
            'message' => $message,
            'url' => $url
        ]));
    }

    public function notifyDB(
        string $message,
        ?string $title=null,
        ?string $url =null
    )
    {
        dispatch(new NotifyDatabaseJob([
            'model_type' => get_called_class(),
            'model_id' => $this->id,
            'subject' => $title,
            'message' => $message,
            'url' => $url,
        ]));
    }

    public function notifySlack(
        string $title,
        string $message=null,
        ?string $url=null,
        ?string $image=null,
        ?string $webhook=null
    )
    {
        dispatch(new NotifySlackJob([
            'webhook' => $webhook,
            'title' => $title,
            'message' => $message,
            'url' => $url,
            'image' => $image,
        ]));
    }

    public function notifyDiscord(
        string $title,
        string $message=null,
        ?string $url=null,
        ?string $image=null,
        ?string $webhook=null
    )
    {
        dispatch(new NotifyDiscordJob([
            'webhook' => $webhook,
            'title' => $title,
            'message' => $message,
            'url' => $url,
            'image' => $image,
        ]));
    }

    public function notifyPusherSDK(
        string $token,
        string $title,
        string $message
    )
    {
        dispatch(new NotifyPusherJob([
            'user' => $this,
            'title' => $title,
            'message' => $message,
            'icon' => $icon,
            'image' => $image,
            'url' => $url,
            'type' => $type,
            'data' => $data,
        ]));
    }

    public function getUserNotifications()
    {
        return $this->morphMany(UserNotification::class, 'model');
    }

    public function userTokensPusher()
    {
        return $this->morphOne(UserToken::class, 'model')->where('provider', 'pusher');
    }
}
