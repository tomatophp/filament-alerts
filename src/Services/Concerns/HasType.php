<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasType
{
    public ?string $type = 'success';

    public function type(?string $type): static
    {
        $this->type = $type;

        return $this;
    }
}
