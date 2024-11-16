<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasModel
{
    private ?string $model = null;

    /**
     * @return $this
     */
    public function model(string $model): static
    {
        $this->model = $model;

        return $this;
    }
}
