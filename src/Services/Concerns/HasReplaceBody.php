<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasReplaceBody
{
    /**
     * @var string|array|null
     */
    private string|array|null $replaceBody = null;

    /**
     * @param string|array $replaceBody
     * @return $this
     */
    public function replaceBody(string|array $replaceBody): static
    {
        $this->replaceBody = $replaceBody;
        return $this;
    }
}
