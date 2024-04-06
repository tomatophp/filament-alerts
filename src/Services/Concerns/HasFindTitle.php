<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasFindTitle
{
    /**
     * @var string|array|null
     */
    private string|array|null $findTitle = null;

    /**
     * @param string|array $findTitle
     * @return $this
     */
    public function findTitle(string|array $findTitle): static
    {
        $this->findTitle = $findTitle;
        return $this;
    }
}
