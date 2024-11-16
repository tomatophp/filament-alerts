<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

class NotificationAction
{
    public ?string $label =null;
    public ?string $key = null;
    public string $icon = "heroicon-o-information-circle";
    public string $color = "info";

    public static function make(string $key): static
    {
        return (new static())->key($key);
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

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'key' => $this->key,
            'icon' => $this->icon,
            'color' => $this->color,
        ];
    }

}
