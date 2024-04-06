<?php

namespace TomatoPHP\FilamentAlerts\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use TomatoPHP\FilamentAlerts\Models\NotificationsLogs;

class NotifySMSMisrJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ?string $phone;
    public ?string $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($arrgs)
    {
        $this->phone = $arrgs['phone'];
        $this->message  = $arrgs['message'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $params = [
            'environment' => config('tomato-notifications.drivers.sms-misr.environment', 1),
            'username' => config('tomato-notifications.drivers.sms-misr.username'),
            'password' => config('tomato-notifications.drivers.sms-misr.password'),
            'language' => config('tomato-notifications.drivers.sms-misr.language', 1),
            'sender' => config('tomato-notifications.drivers.sms-misr.sender'),
            'mobile' => $this->phone,
            'message' => $this->message,
            'delayUntil' => null,
        ];

        Http::post('https://smsmisr.com/api/SMS', $params)->json();

        $log = new NotificationsLogs();
        $log->title = "SMS Message";
        $log->description = $this->message;
        $log->provider = "sms-misr";
        $log->type = "info";
        $log->save();
    }
}
