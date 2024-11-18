<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

class NotificationUser
{
    public ?string $label = null;

    public ?string $model = null;

    public string $icon = 'heroicon-o-information-circle';

    public string $color = 'success';

    public static function make(string $model): static
    {
        return (new self)->model($model);
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function model(string $model): static
    {
        $this->model = $model;

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
            'model' => $this->model,
            'icon' => $this->icon,
            'color' => $this->color,
        ];
    }
}
