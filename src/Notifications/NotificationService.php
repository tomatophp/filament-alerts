<?php

namespace TomatoPHP\FilamentAlerts\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;
use NotificationChannels\Messagebird\MessagebirdChannel;
use NotificationChannels\Messagebird\MessagebirdMessage;
use NotificationChannels\PusherPushNotifications\PusherChannel;
use NotificationChannels\PusherPushNotifications\PusherMessage;
use TomatoPHP\FilamentAlerts\Jobs\NotifySlackJob;

class NotificationService extends Notification
{
    public ?string $title;

    public ?string $message;

    public ?string $icon;

    public ?string $url;

    public ?string $image;

    public ?string $type;

    public ?string $privacy;

    public ?string $model;

    public ?string $modelId;

    public ?string $provider;

    public ?string $phone;

    public ?string $email;

    public ?array $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        $title,
        $message,
        $icon,
        $image,
        $url,
        $type,
        $privacy,
        $provider = 'email',
        $model = null,
        $modelId = null,
        $phone = null,
        $email = null,
        $data = [],
    ) {
        $this->title = $title;
        $this->message = $message;
        $this->icon = $icon;
        $this->url = $url;
        $this->image = $image;
        $this->type = $type;
        $this->privacy = $privacy;
        $this->model = $model;
        $this->modelId = $modelId;
        $this->provider = $provider;
        $this->phone = $phone;
        $this->email = $email;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->title)
            ->greeting($this->title)
            ->line($this->message)
            ->action('Open Link', $this->url)
            ->line('Thank you for using our application!');
    }
}
