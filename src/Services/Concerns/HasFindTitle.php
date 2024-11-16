<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasFindTitle
{
    private string | array | null $findTitle = null;

    /**
     * @return $this
     */
    public function findTitle(string | array $findTitle): static
    {
        $this->findTitle = $findTitle;

        return $this;
    }
}
