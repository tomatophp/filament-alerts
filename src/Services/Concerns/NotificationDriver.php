<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

class NotificationDriver
{
    public ?string $key = null;

    public ?string $label = null;

    public string $icon = 'heroicon-o-bell';

    public string $color = 'info';

    public ?string $driver = null;

    public static function make(string $key): static
    {
        return (new self)->key($key);
    }

    public function key(string $key): static
    {
        $this->key = $key;

        return $this;
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function icon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function color(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function driver(string $driver): static
    {
        $this->driver = $driver;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'label' => $this->label,
            'icon' => $this->icon,
            'color' => $this->color,
            'driver' => $this->driver,
        ];
    }
}
