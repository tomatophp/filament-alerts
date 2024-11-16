<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasProviders
{
    private string | array | null $providers = ['email'];

    /**
     * @return $this
     */
    public function providers(string | array $providers): static
    {
        $this->providers = $providers;

        return $this;
    }
}
