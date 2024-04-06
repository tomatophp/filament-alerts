<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasMessage
{
    /**
     * @var string|null
     */
    private ?string $message = null;

    /**
     * @param string $message
     * @return $this
     */
    public function message(string $message): static
    {
        $this->message = $message;
        return $this;
    }
}
