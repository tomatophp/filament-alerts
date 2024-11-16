<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasIcon
{
    private ?string $icon = null;

    /**
     * @return $this
     */
    public function icon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }
}
