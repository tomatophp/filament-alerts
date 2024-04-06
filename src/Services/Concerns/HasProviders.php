<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasProviders
{
    /**
     * @var string|array|null
     */
    private string|array|null $providers = ['email'];

    /**
     * @param string|array $providers
     * @return $this
     */
    public function providers(string|array $providers): static
    {
        $this->providers = $providers;
        return $this;
    }
}
