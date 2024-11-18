<?php

namespace TomatoPHP\FilamentAlerts\Jobs;

use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use TomatoPHP\FilamentAlerts\Models\NotificationsLogs;
use TomatoPHP\FilamentAlerts\Models\UserNotification;

class NotifyDatabaseJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public ?string $model_type;

    public int | string | null $modelId;

    public ?int $template_id = null;

    public ?string $title;

    public ?string $body;

    public ?string $url;

    public ?string $icon;

    public ?string $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($arrgs)
    {
        $this->model_type = $arrgs['model_type'];
        $this->modelId = $arrgs['modelId'];
        $this->body = $arrgs['body'];
        $this->title = $arrgs['title'] ?? 'New Alert';
        $this->url = $arrgs['url'] ?? '#';
        $this->icon = $arrgs['icon'] ?? 'heroicon-o-information-circle';
        $this->type = $arrgs['type'] ?? 'info';
        $this->template_id = $arrgs['template_id'] ?? null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notification = new UserNotification;
        $notification->title = $this->title ?? 'New Alert';
        $notification->description = $this->body;
        $notification->template_id = $this->template_id;
        $notification->icon = $this->icon;
        $notification->type = $this->type;
        $notification->url = $this->url ?? '#';
        $notification->model_type = $this->model_type;
        $notification->model_id = $this->modelId;
        $notification->privacy = 'private';
        $notification->created_by = $this->modelId;
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

        if ($notification) {
            $log = new NotificationsLogs;
            $log->title = $this->title;
            $log->description = $this->body;
            $log->model_type = $this->model_type;
            $log->model_id = $this->modelId;
            $log->provider = 'database';
            $log->type = $this->type;
            $log->save();
        }
    }
}
