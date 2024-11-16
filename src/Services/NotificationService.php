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

    /**
     * @param object|array $class
     * @return void
     */
    public function register(object|array $class): void
    {
        if(is_array($class)) {
            foreach($class as $item) {
                $this->register($item);
            }
        }
        else {
             if($class instanceof NotificationType) {
                 $this->types[] = $class;
             }
            else if($class instanceof NotificationDriver) {
                $this->drivers[] = $class;
            }
            else if($class instanceof NotificationAction) {
                $this->actions[] = $class;
            }
            else if($class instanceof NotificationTemplate) {
                $this->templates[] = $class;
            }
            else if($class instanceof NotificationUser) {
                $this->users[] = $class;
            }
        }
    }

    /**
     * @return Collection
     */
    public function loadTypes(): Collection
    {
        return collect($this->types);
    }

    /**
     * @return Collection
     */
    public function loadDrivers(): Collection
    {
        return collect($this->drivers);
    }

    /**
     * @return Collection
     */
    public function loadActions(): Collection
    {
        return collect($this->actions);
    }

    /**
     * @return Collection
     */
    public function loadTemplates(): Collection
    {
        return collect($this->templates);
    }

    /**
     * @return Collection
     */
    public function loadUsers(): Collection
    {
        return collect($this->users);
    }

    /**
     * @return bool|array
     *  use to load template and replace template tags
     */
    public function loadTemplate(string $key, array $findTitle=[], array $replaceTitle=[], array $findBody=[], array $replaceBody=[],?Model $user=null): bool|NotificationTemplate
    {
        /*
         * Get Template By Key
         */
        $template = NotificationsTemplate::query()->where('key', $key)->first();

        if(!$template){
            return false;
        }

        /*
         * Find & Replace Key/Value
         */
        $title = str_replace($findTitle ?? '', $replaceTitle ?? '', $template->title);
        $body = str_replace($findBody ?? '', $replaceBody ?? '', $template->body);

        /*
         * Set Template Image
         */
        $image = count($template->getMedia('image')) ? $template->getMedia('image')->first()->getUrl() : null;

        $notificationTemplate = NotificationTemplate::make($key)
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
