<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasUser
{
    /**
     * @var object|null
     */
    public ?object $user = null;

    /**
     * @param ?object $user
     * @return static
     */
    public function user(?object $user): static {
        $this->user = $user;
        return $this;
    }
}
