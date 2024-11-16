<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasMessage
{
    private ?string $message = null;

    /**
     * @return $this
     */
    public function message(string $message): static
    {
        $this->message = $message;

        return $this;
    }
}
