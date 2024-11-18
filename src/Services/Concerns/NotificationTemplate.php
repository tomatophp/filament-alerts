<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

class NotificationTemplate
{
    public ?string $label = null;

    public ?string $key = null;

    public ?string $title = null;

    public ?string $body = null;

    public ?string $url = null;

    public ?string $image = null;

    public ?string $icon = 'heroicon-o-information-circle';

    public ?string $color = 'success';

    public array $providers = [];

    public ?string $action = 'system';

    public ?string $type = 'success';

    public static function make(string $key): static
    {
        return (new self)->key($key);
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function key(string $key): static
    {
        $this->key = $key;

        return $this;
    }

    public function icon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function color(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function title(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function body(?string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function url(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function image(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function providers(array $providers): static
    {
        $this->providers = $providers;

        return $this;
    }

    public function action(?string $action): static
    {
        $this->action = $action;

        return $this;
    }

    public function type(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'key' => $this->key,
            'icon' => $this->icon,
            'color' => $this->color,
            'title' => $this->title,
            'body' => $this->body,
            'url' => $this->url,
            'image' => $this->image,
            'providers' => $this->providers,
            'action' => $this->action,
            'type' => $this->type,
        ];
    }
}
