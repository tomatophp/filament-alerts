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

class NotifySlackJob implements ShouldQueue
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
        if($this->message){
            if($this->url){
                $blocks = [
                    "type"=> "section",
                    "block_id"=>"section567",
                    "text"=> [
                        "type"=> "mrkdwn",
                        "text" => "<$this->url|$this->title> \n $this->message",
                    ],
                ];
            }
            else {
                $blocks = [
                    "type"=> "section",
                    "block_id"=>"section567",
                    "text"=> [
                        "type"=> "mrkdwn",
                        "text" => "*$this->title* \n $this->message",
                    ],
                ];
            }


            if($image){
                $blocks['accessory'] = [
                    "type"=> "image",
                    "image_url"=> $this->image,
                    "alt_text"=> $this->title
                ];
            }

            $params = [
                "text" => $this->title,
                "blocks" => [
                    (object)$blocks
                ]
            ];
        }
        else {
            if($this->url){
                $params = [
                    'text' => "<$this->url|$this->title>"
                ];
            }
            else {
                $params = [
                    'text' => $this->title
                ];
            }
        }

        Http::post($this->webhook ?? config('tomato-notifications.drivers.slack.webhook'), $params)->json();

        $log = new NotificationsLogs();
        $log->title = $this->title;
        $log->description = $this->message;
        $log->provider = "slack";
        $log->type = "info";
        $log->save();
    }
}
