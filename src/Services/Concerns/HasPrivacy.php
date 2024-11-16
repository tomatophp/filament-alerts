<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasPrivacy
{
    private ?string $privacy = 'public';

    /**
     * @return $this
     */
    public function privacy(string $privacy): static
    {
        $this->privacy = $privacy;

        return $this;
    }
}
