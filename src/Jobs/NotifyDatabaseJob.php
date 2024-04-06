<?php

namespace TomatoPHP\FilamentAlerts\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use TomatoPHP\FilamentAlerts\Mail\SendEmail;
use TomatoPHP\FilamentAlerts\Models\NotificationsLogs;
use TomatoPHP\FilamentAlerts\Models\UserNotification;

class NotifyDatabaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ?string $model_type;
    public ?int $model_id;
    public ?string $subject;
    public ?string $message;
    public ?string $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($arrgs)
    {
        $this->model_type = $arrgs['model_type'];
        $this->model_id = $arrgs['model_id'];
        $this->subject = $arrgs['subject'];
        $this->message  = $arrgs['message'];
        $this->url  = $arrgs['url'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notification = new UserNotification();
        $notification->title = $this->subject ?? "New Alert";
        $notification->description = $this->message;
        $notification->icon = "bx bx-bell";
        $notification->type = "info";
        $notification->url = $this->url ?? "#";
        $notification->model_type = $this->model_type;
        $notification->model_id = $this->model_id;
        $notification->privacy = "private";
        $notification->save();

        if($notification){
            $log = new NotificationsLogs();
            $log->title = $this->subject;
            $log->description = $this->message;
            $log->model_type = $this->model_type;
            $log->model_id = $this->model_id;
            $log->provider = "database";
            $log->type = "info";
            $log->save();
        }
    }
}
