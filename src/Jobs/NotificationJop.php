<?php

namespace TomatoPHP\FilamentAlerts\Jobs;

use Filament\Notifications\Actions\Action;
use Filament\Notifications\Actions\ActionGroup;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\File;
use TomatoPHP\FilamentAlerts\Models\NotificationsLogs;
use TomatoPHP\FilamentAlerts\Notifications\NotificationService;
use Shabayek\Sms\Facades\Sms;

class NotificationJop implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ?string $title;
    public ?string $message;
    public ?string $icon;
    public ?string $url;
    public ?string $image;
    public ?string $type;
    public ?string $privacy;
    public ?string $model;
    public ?string $model_id;
    public ?string $provider;
    public ?object $user;
    public ?string $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($arrgs)
    {
        $this->title = $arrgs['title'];
        $this->message  = $arrgs['message'];
        $this->icon  = $arrgs['icon'];
        $this->url  = $arrgs['url'];
        $this->image  = $arrgs['image'];
        $this->type  = $arrgs['type'];
        $this->privacy  = $arrgs['privacy'];
        $this->model  = $arrgs['model'];
        $this->model_id  = $arrgs['model_id'];
        $this->provider  = $arrgs['provider'];
        $user = $this->model::find($this->model_id);
        $this->user = $user;
        $this->data  = $arrgs['data'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        if($this->provider === 'sms-misr'){
            if($this->user->phone){
                $params = [
                    'environment' => config('tomato-notifications.drivers.sms-misr.environment', 1),
                    'username' => config('tomato-notifications.drivers.sms-misr.username'),
                    'password' => config('tomato-notifications.drivers.sms-misr.password'),
                    'language' => config('tomato-notifications.drivers.sms-misr.language', 1),
                    'sender' => config('tomato-notifications.drivers.sms-misr.sender'),
                    'mobile' => $this->user->phone,
                    'message' => $this->message,
                    'delayUntil' => null,
                ];

                Http::post('https://smsmisr.com/api/SMS', $params)->json();
            }
        }
        else if ($this->provider === 'fcm-api' || $this->provider === 'fcm-web') {
            $this->user->notifyFCMSDK(
                message: $this->message,
                type: $this->provider,
                title: $this->title,
                url: $this->url,
                image: $this->image,
                icon: $this->icon,
                data: [
                    'url' => $this->url,
                    'id' => $this->model_id,
                    'actions' => [],
                    'body' => $this->message,
                    'color' => null,
                    'duration' => null,
                    'icon' => $this->icon,
                    'iconColor' => null,
                    'status' => null,
                    'title' => $this->title,
                    'view' => null,
                    'viewData' => null,
                    'data'=> $this->data
                ],
                sendToDatabase: false
            );
        }
        else {
            $this->user->notify(new NotificationService(
                $this->title,
                $this->message,
                $this->icon,
                (string)$this->image,
                $this->url,
                $this->type,
                $this->privacy,
                $this->provider,
                $this->model,
                (string)$this->model_id,
                null,null,$this->data
            ));
        }

        $log = new NotificationsLogs();
        $log->title = $this->title;
        $log->description = $this->message;
        $log->model_type = $this->model;
        $log->model_id = $this->model_id;
        $log->provider = $this->provider;
        $log->type = $this->type;
        $log->save();
    }
}
