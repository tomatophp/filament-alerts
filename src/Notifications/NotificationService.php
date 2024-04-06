<?php

namespace TomatoPHP\FilamentAlerts\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Support\Facades\File;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\WebpushFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Messagebird\MessagebirdChannel;
use NotificationChannels\Messagebird\MessagebirdMessage;
use NotificationChannels\PusherPushNotifications\PusherChannel;
use NotificationChannels\PusherPushNotifications\PusherMessage;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;

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
    public ?string $data;
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
        $provider = "email",
        $model = null,
        $modelId = null,
        $phone = null,
        $email = null,
        $data = null,
    )
    {
        $this->title = $title;
        $this->message  = $message;
        $this->icon  = $icon;
        $this->url  = $url;
        $this->image  = $image;
        $this->type  = $type;
        $this->privacy  = $privacy;
        $this->model  = $model;
        $this->modelId  = $modelId;
        $this->provider  = $provider;
        $this->phone  = $phone;
        $this->email  = $email;
        $this->data  = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        if ($this->provider === 'fcm-api' || $this->provider === 'fcm-web') {
            return [FcmChannel::class];
        }

        if ($this->provider === 'pusher-api' || $this->provider === 'pusher-web') {
            return [PusherChannel::class];
        }

        if ($this->provider === 'slack') {
            return ['slack'];
        }

        if ($this->provider === 'discord') {
            return [DiscordChannel::class];
        }

        if ($this->provider === 'sms-messagebird') {
            return [MessagebirdChannel::class];
        }

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

    public function toMessagebird($notifiable): MessagebirdMessage
    {
        return (new MessagebirdMessage($this->message))->setRecipients($this->phone);
    }

    public function toFcm($notifiable): FcmMessage
    {
        return FcmMessage::create()
            ->setData([
                'title' => $this->title,
                'message' => $this->message,
                'icon' => $this->icon,
                'url' => $this->url,
                'image' => $this->image,
                'type' => $this->type,
                'privacy' => $this->privacy,
                'model' => (string)$this->model,
                'model_id' => (string)$this->modelId,
                'data' =>  $this->data??"" ,
            ])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle($this->title)
                ->setBody($this->message)
                ->setImage($this->image))
            ->setWebpush(
                \NotificationChannels\Fcm\Resources\WebpushConfig::create()
                    ->setFcmOptions(WebpushFcmOptions::create()->setAnalyticsLabel('analytics'))
            )
            ->setAndroid(
                AndroidConfig::create()
                    ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                    ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
            )->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios'))
                     ->setPayload([
                        'aps' => [
                            'mutable-content' => 1,
                            'sound' => 'default',
                        ],
                    ])
            );
    }

    public function toPushNotification($notifiable): PusherMessage
    {
        return PusherMessage::create()
            ->web()
            ->title($this->title)
            ->link($this->url)
            ->body($this->message)
            ->setOption('icon', $this->icon)
            ->setOption('image', $this->image)
            ->setOption('type', $this->type)
            ->setOption('privacy', $this->privacy)
            ->setOption('model', $this->model)
            ->setOption('model_id', $this->modelId)
            ->setOption('data', $this->data)
            ->withAndroid(
                PusherMessage::create()
                    ->IOS()
                    ->icon($this->icon)
                    ->badge(1)
                    ->title($this->title)
                    ->link($this->url)
                    ->body($this->message)
            )
            ->withiOS(
                PusherMessage::create()
                    ->android()
                    ->icon($this->icon)
                    ->badge(1)
                    ->title($this->title)
                    ->link($this->url)
                    ->body($this->message)
            );
    }

    public function toSlack($notifiable): SlackMessage
    {
        $message = $this->message;
        return (new SlackMessage)
            ->error()
            ->content('Whoops! Something went wrong.')
            ->attachment(function ($attachment) use ($message) {
                $attachment->title('Error on project ' . config('app.name'))
                    ->content($message);
            });
    }

    public function toDiscord($notifiable): DiscordMessage
    {
        if (!empty($this->ref)) {
            return DiscordMessage::create($this->message, $this->ref);
        }

        return DiscordMessage::create($this->message);
    }
}
