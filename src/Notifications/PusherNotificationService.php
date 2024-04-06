<?php

namespace TomatoPHP\FilamentAlerts\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Support\Facades\File;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\WebpushFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\PusherPushNotifications\PusherChannel;
use NotificationChannels\PusherPushNotifications\PusherMessage;

class PusherNotificationService extends Notification
{
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        public string $message,
        public ?string $type='web',
        public ?string $title=null,
        public ?string $icon=null,
        public ?string $image=null,
        public ?string $url=null,
        public ?array $data=[],
    )
    {}

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return [PusherChannel::class];
    }

    public function toPushNotification($notifiable): PusherMessage
    {
        $pusher = PusherMessage::create();

        if($this->title){
            $pusher->title($this->title);
        }
        if($this->url){
            $pusher->link($this->url);
        }
        if($this->message){
            $pusher->body($this->message);
        }
        if($this->icon){
            $pusher->setOption('icon', $this->icon);
        }
        if($this->image){
            $pusher->setOption('image', $this->image);
        }
        if($this->type){
            $pusher->setOption('type', $this->type);
        }
        if($this->data){
            $pusher->setOption('data', $this->data);
        }

        if($this->type === 'web'){
            $pusher->web();
        }
        if($this->type==='android'){
            $pusher->withAndroid(
                PusherMessage::create()
                    ->IOS()
                    ->icon($this->icon)
                    ->badge(1)
                    ->title($this->title)
                    ->link($this->url)
                    ->body($this->message)
            );
        }
        if($this->type === 'ios'){
            $pusher->withiOS(
                PusherMessage::create()
                    ->android()
                    ->icon($this->icon)
                    ->badge(1)
                    ->title($this->title)
                    ->link($this->url)
                    ->body($this->message)
            );
        }

        return $pusher;
    }
}
