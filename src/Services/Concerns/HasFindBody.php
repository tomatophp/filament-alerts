<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasFindBody
{
    /**
     * @var string|array|null
     */
    private string|array|null $findBody = null;

    /**
     * @param string|array $findBody
     * @return $this
     */
    public function findBody(string|array $findBody): static
    {
        $this->findBody = $findBody;
        return $this;
    }
}
