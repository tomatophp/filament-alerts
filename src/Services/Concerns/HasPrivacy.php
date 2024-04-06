<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasPrivacy
{
    /**
     * @var string|null
     */
    private ?string $privacy = 'public';

    /**
     * @param string $privacy
     * @return $this
     */
    public function privacy(string $privacy): static
    {
        $this->privacy = $privacy;
        return $this;
    }
}
