<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasFindBody
{
    private string | array | null $findBody = null;

    /**
     * @return $this
     */
    public function findBody(string | array $findBody): static
    {
        $this->findBody = $findBody;

        return $this;
    }
}
