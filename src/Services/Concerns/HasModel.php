<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasModel
{
    /**
     * @var string|null
     */
    private ?string $model = null;

    /**
     * @param string $model
     * @return $this
     */
    public function model(string $model): static
    {
        $this->model = $model;
        return $this;
    }
}
