<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasReplaceTitle
{
    /**
     * @var string|array|null
     */
    private string|array|null $replaceTitle = null;

    /**
     * @param string|array $replaceTitle
     * @return $this
     */
    public function replaceTitle(string|array $replaceTitle): static
    {
        $this->replaceTitle = $replaceTitle;
        return $this;
    }
}
