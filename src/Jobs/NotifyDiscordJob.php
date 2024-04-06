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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use TomatoPHP\FilamentAlerts\Mail\SendEmail;
use TomatoPHP\FilamentAlerts\Models\NotificationsLogs;

class NotifyDiscordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ?string $webhook;
    public ?string $title;
    public ?string $message;
    public ?string $url;
    public ?string $image;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($arrgs)
    {
        $this->webhook = $arrgs['webhook'];
        $this->title = $arrgs['title'];
        $this->message  = $arrgs['message'];
        $this->url  = $arrgs['url'];
        $this->image  = $arrgs['image'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $embeds = [];
        if($this->message){
            $embeds = [
                'title' => $this->title,
                'description' => $this->message,
            ];
        }

        if($this->url && !$this->message){
            $embeds = [
                'title' => $this->title,
            ];
        }

        if($this->url){
            $embeds['url'] = $this->url;
        }

        if($this->image){
            $embeds['image'] = [
                'url' => $this->image
            ];
        }


        if(count($embeds)> 0){
            $params = [
                'content' => "@everyone",
                'embeds' => [
                    $embeds
                ]
            ];
        }
        else {
            $params = [
                'content' => $this->title,
            ];
        }

        Http::post($this->webhook ?? config('tomato-notifications.drivers.discord.webhook'), $params)->json();

        $log = new NotificationsLogs();
        $log->title = $this->title;
        $log->description = $this->message;
        $log->provider = "discord";
        $log->type = "info";
        $log->save();
    }
}
