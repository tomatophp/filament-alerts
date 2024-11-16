<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait IsDatabase
{
    public bool $database = false;

    /**
     * @param  ?bool  $database
     */
    public function database(bool $database = true): static
    {
        $this->database = $database;

        return $this;
    }
}
