<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait IsDatabase
{
    /**
     * @var bool
     */
    public bool $database = false;

    /**
     * @param ?bool $database
     * @return static
     */
    public function database(bool $database=true): static {
        $this->database = $database;
        return $this;
    }
}
