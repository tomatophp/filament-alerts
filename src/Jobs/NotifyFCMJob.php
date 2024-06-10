<?php

namespace TomatoPHP\FilamentAlerts\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use TomatoPHP\FilamentAlerts\Mail\SendEmail;
use TomatoPHP\FilamentAlerts\Models\NotificationsLogs;
use TomatoPHP\FilamentAlerts\Notifications\FCMNotificationService;

class NotifyFCMJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ?Model $user;
    public ?string $title;
    public ?string $message;
    public ?string $image;
    public ?string $icon;
    public ?string $url;
    public ?string $type;
    public ?array $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($arrgs)
    {
        $this->user = $arrgs['user'];
        $this->title = $arrgs['title'];
        $this->message  = $arrgs['message'];
        $this->icon  = $arrgs['icon'];
        $this->url  = $arrgs['url'];
        $this->image  = $arrgs['image'];
        $this->type  = $arrgs['type'];
        $this->data  = $arrgs['data'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->setFCM($this->type)->notify(new FCMNotificationService(
            $this->message,
            $this->type,
            $this->title,
            $this->icon,
            $this->image,
            $this->url,
            $this->data,
        ));

        $log = new NotificationsLogs();
        $log->title = $this->title;
        $log->description = $this->message;
        $log->model_id= $this->user->id;
        $log->model_type = get_class($this->user);
        $log->provider = "fcm";
        $log->type = "info";
        $log->save();
    }
}
