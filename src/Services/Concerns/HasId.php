<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasId
{
    private ?int $id = null;

    /**
     * @return $this
     */
    public function id(?int $id): static
    {
        $this->id = $id;

        return $this;
    }
}
