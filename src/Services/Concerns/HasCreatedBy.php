<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasCreatedBy
{
    private ?int $createdBy = null;

    /**
     * @return $this
     */
    public function createBy(int $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
