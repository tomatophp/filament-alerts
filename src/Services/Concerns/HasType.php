<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasType
{
    /**
     * @var string|null
     */
    public ?string $type = "success";

    /**
     * @param ?string $type
     * @return static
     */
    public function type(?string $type): static {
        $this->type = $type;
        return $this;
    }
}
