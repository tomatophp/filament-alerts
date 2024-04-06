<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasCreatedBy
{
    /**
     * @var int|null
     */
    private ?int $createdBy = null;

    /**
     * @param int $createdBy
     * @return $this
     */
    public function createBy(int $createdBy): static
    {
        $this->createdBy = $createdBy;
        return $this;
    }
}
