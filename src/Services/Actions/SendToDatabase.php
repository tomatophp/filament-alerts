<?php

namespace TomatoPHP\FilamentAlerts\Services\Actions;

use TomatoPHP\FilamentAlerts\Models\UserNotification;

trait SendToDatabase
{
    /**
     * @return bool
     * use to save the notification into database
     */
    public function sendToDatabase(): bool
    {
        /*
         * Save Notification To Database
         */
        try {
            $notification = new UserNotification();
            $notification->title = $this->title;
            $notification->description = $this->message;
            $notification->icon = $this->icon;
            $notification->type = $this->type;
            $notification->url = $this->url;
            $notification->data = json_decode($this->data);
            if ($this->template) {
                $notification->template_id = $this->templateModel->id;
            }
            $notification->model_type = $this->model;
            $notification->model_id = $this->id;
            $notification->privacy = $this->privacy;
            $notification->save();

            return true;
        }catch (\Exception $exception){
            return false;
        }
    }

}
