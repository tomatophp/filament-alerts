<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasImage
{
    /**
     * @var string|null
     */
    private ?string $image = null;

    /**
     * @param string $image
     * @return $this
     */
    public function image(string $image): static
    {
        $this->image = $image;
        return $this;
    }
}
