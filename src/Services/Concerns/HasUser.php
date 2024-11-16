<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasUser
{
    public ?object $user = null;

    public function user(?object $user): static
    {
        $this->user = $user;

        return $this;
    }
}
