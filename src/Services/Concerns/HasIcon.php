<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasIcon
{
    /**
     * @var string|null
     */
    private ?string $icon = null;

    /**
     * @param string $icon
     * @return $this
     */
    public function icon(string $icon): static
    {
        $this->icon = $icon;
        return $this;
    }
}
