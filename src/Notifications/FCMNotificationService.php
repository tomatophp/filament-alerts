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

class FCMNotificationService extends Notification
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
        return [FcmChannel::class];
    }

    public function toFcm($notifiable): FcmMessage
    {
        $data = [];
        $notifcation = \NotificationChannels\Fcm\Resources\Notification::create();

        if($this->message){
            $data['message'] = $this->message;
            $notifcation->setBody($this->message);
        }
        if($this->title){
            $data['title'] = $this->title;
            $notifcation->setTitle($this->title);
        }
        if($this->icon){
            $data['icon'] = $this->icon;
        }
        if($this->url){
            $data['url'] = $this->url;
        }
        if($this->image){
            $data['image'] = $this->image;
            $notifcation->setImage($this->image);
        }
        if($this->type){
            $data['type'] = $this->type;
        }
        if($this->data){
            $data['data'] = $this->data;
        }

        $fcm= FcmMessage::create();
        $fcm->setData($data)->setNotification($notifcation);

        if($this->type === 'web' || $this->type === 'all'){
            $fcm->setWebpush(
                \NotificationChannels\Fcm\Resources\WebpushConfig::create()
                    ->setFcmOptions(
                        WebpushFcmOptions::create()
                            ->setAnalyticsLabel('analytics')
                    )
            );
        }
        if($this->type === 'android' || $this->type === 'all'){
            $fcm->setAndroid(
                AndroidConfig::create()
                    ->setFcmOptions(
                        AndroidFcmOptions::create()
                            ->setAnalyticsLabel('analytics')
                    )
                    ->setNotification(
                        AndroidNotification::create()
                            ->setColor('#0A0A0A')
                    )
            );
        }
        if($this->type === 'ios' || $this->type === 'all'){
            $fcm->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(
                        ApnsFcmOptions::create()
                            ->setAnalyticsLabel('analytics_ios')
                    )
                    ->setPayload([
                        'aps' => [
                            'mutable-content' => 1,
                            'sound' => 'default',
                        ],
                    ])
            );
        }

        return $fcm;
    }
}
