<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasImage
{
    private ?string $image = null;

    /**
     * @return $this
     */
    public function image(string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
