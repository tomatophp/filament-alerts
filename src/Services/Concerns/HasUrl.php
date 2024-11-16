<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasUrl
{
    public ?string $url = null;

    public function url(?string $url): static
    {
        $this->url = $url;

        return $this;
    }
}
