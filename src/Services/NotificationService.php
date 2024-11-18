<?php

namespace TomatoPHP\FilamentAlerts\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;
use TomatoPHP\FilamentAlerts\Services\Concerns\NotificationAction;
use TomatoPHP\FilamentAlerts\Services\Concerns\NotificationDriver;
use TomatoPHP\FilamentAlerts\Services\Concerns\NotificationTemplate;
use TomatoPHP\FilamentAlerts\Services\Concerns\NotificationType;
use TomatoPHP\FilamentAlerts\Services\Concerns\NotificationUser;

class NotificationService
{
    protected array $types = [];

    protected array $drivers = [];

    protected array $actions = [];

    protected array $templates = [];

    protected array $users = [];

    public function register(object | array $class): void
    {
        if (is_array($class)) {
            foreach ($class as $item) {
                $this->register($item);
            }
        } else {
            if ($class instanceof NotificationType) {
                $this->types[] = $class;
            } elseif ($class instanceof NotificationDriver) {
                $this->drivers[] = $class;
            } elseif ($class instanceof NotificationAction) {
                $this->actions[] = $class;
            } elseif ($class instanceof NotificationTemplate) {
                $this->templates[] = $class;
            } elseif ($class instanceof NotificationUser) {
                $this->users[] = $class;
            }
        }
    }

    public function loadTypes(): Collection
    {
        return collect($this->types);
    }

    public function loadDrivers(): Collection
    {
        return collect($this->drivers);
    }

    public function loadActions(): Collection
    {
        return collect($this->actions);
    }

    public function loadTemplates(): Collection
    {
        return collect($this->templates);
    }

    public function loadUsers(): Collection
    {
        return collect($this->users);
    }

    public function notify(?Model $user = null): SendNotification
    {
        return new SendNotification($user);
    }

    /**
     * @return bool|array
     *                    use to load template and replace template tags
     */
    public function loadTemplate(
        string | int $template,
        array $title = [],
        array $body = [],
        ?Model $user = null
    ): bool | NotificationTemplate {
        /*
         * Get Template By Key
         */
        $template = NotificationsTemplate::query()
            ->where('key', $template)
            ->orWhere('id', $template)
            ->first();

        if (! $template) {
            return false;
        }

        /*
         * Find & Replace Key/Value
         */
        $title = str_replace(array_keys($title) ?? '', array_values($title) ?? '', $template->title);
        $body = str_replace(array_keys($body) ?? '', array_values($body) ?? '', $template->body);

        /*
         * Set Template Image
         */
        $image = count($template->getMedia('image')) ? $template->getMedia('image')->first()->getUrl() : null;

        $notificationTemplate = NotificationTemplate::make($template->key)
            ->title($title)
            ->body($body)
            ->icon($template->icon)
            ->url($template->url)
            ->image($image)
            ->type($template->type);

        if (class_exists(Spatie\Permission\Models\Role::class)) {
            /*
           * Check Template For Roles
           */
            $collectRoles = [];
            foreach ($template->roles as $role) {
                $collectRoles[] = $role->id;
            }
            if (count($collectRoles)) {
                /*
                 * If Current User Has Role
                 */
                try {
                    if ($user->hasRole($collectRoles)) {
                        return $notificationTemplate;
                    }
                } catch (\Exception $exception) {
                    return false;
                }

                return false;
            }
        }

        return $notificationTemplate;
    }
}
