<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasData
{
    /**
     * @var int|null
     */
    private ?string $data = null;

    /**
     * @return $this
     */
    public function data(string $data): static
    {
        $this->data = $data;

        return $this;
    }
}
