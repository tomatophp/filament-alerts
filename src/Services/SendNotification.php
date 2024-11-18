<?php

namespace TomatoPHP\FilamentAlerts\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use TomatoPHP\FilamentAlerts\Events\NotificationEvent;
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;
use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;

class SendNotification
{
    protected string $template;

    protected ?string $model;

    protected string | int | null $modelId = null;

    protected array $drivers = [];

    protected array $data = [];

    protected array $title = [];

    protected array $body = [];

    public function __construct(public ?Model $user = null)
    {
        if ($user) {
            $this->model = get_class($user);
            $this->modelId = $user->id;
        }
    }

    /**
     * @return $this
     */
    public function template(int | string $template): static
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return $this
     */
    public function model(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return $this
     */
    public function modelId(int | string | null $modelId): static
    {
        $this->modelId = $modelId;

        return $this;
    }

    /**
     * @return $this
     */
    public function drivers(array $drivers): static
    {
        $this->drivers = $drivers;

        return $this;
    }

    /**
     * @return $this
     */
    public function data(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return $this
     */
    public function title(array $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return $this
     */
    public function body(array $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function send(): void
    {
        $template = NotificationsTemplate::query()
            ->where('key', $this->template)
            ->orWhere('id', $this->template)
            ->first();
        $drivers = $this->drivers ?: FilamentAlerts::loadDrivers()->whereIn('key', $template->providers)->pluck('driver')->toArray();
        foreach ($drivers as $driver) {
            $driver = FilamentAlerts::loadDrivers()->where('driver', $driver)->first();
            if ($driver) {
                Event::dispatch(new NotificationEvent([
                    'driver' => $driver->driver,
                    'template' => $this->template,
                    'model' => $this->model,
                    'modelId' => $this->modelId,
                    'title' => $this->title,
                    'body' => $this->body,
                    'data' => $this->data,
                ]));

                app($driver->driver)->send(
                    template: $this->template,
                    model: $this->model,
                    modelId: $this->modelId,
                    title: $this->title,
                    body: $this->body,
                    data: $this->data
                );
            }
        }
    }
}
