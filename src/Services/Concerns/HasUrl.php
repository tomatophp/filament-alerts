<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasUrl
{
    /**
     * @var string|null
     */
    public ?string $url = null;

    /**
     * @param ?string $url
     * @return static
     */
    public function url(?string $url): static {
        $this->url = $url;
        return $this;
    }
}
