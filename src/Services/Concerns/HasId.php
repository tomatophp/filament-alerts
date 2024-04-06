<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasId
{
    /**
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @param ?int $id
     * @return $this
     */
    public function id(?int $id): static
    {
        $this->id = $id;
        return $this;
    }
}
