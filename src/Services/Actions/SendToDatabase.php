<?php

namespace TomatoPHP\FilamentAlerts\Services\Actions;

use Filament\Notifications\Notification;
use TomatoPHP\FilamentAlerts\Models\UserNotification;

trait SendToDatabase
{
    /**
     * @return bool
     *              use to save the notification into database
     */
    public function sendToDatabase(): bool
    {
        /*
         * Save Notification To Database
         */
        try {
            $notification = new UserNotification;
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
            $notification->created_by = auth()->user()->id;
            $notification->save();

            Notification::make($notification->id)
                ->title($notification->title)
                ->body($notification->description)
                ->icon($notification->icon)
                ->color($notification->type)
                ->actions($notification->url ? [
                    \Filament\Notifications\Actions\Action::make('view')
                        ->label('View')
                        ->url($notification->url)
                        ->markAsRead(),
                ] : [])
                ->sendToDatabase($notification->model_type::find($notification->model_id));

            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
