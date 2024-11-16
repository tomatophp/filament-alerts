<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasTitle
{
    public ?string $title = null;

    public function title(?string $title): static
    {
        $this->title = $title;

        return $this;
    }
}
