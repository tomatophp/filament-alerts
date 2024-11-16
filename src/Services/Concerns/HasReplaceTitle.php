<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasReplaceTitle
{
    private string | array | null $replaceTitle = null;

    /**
     * @return $this
     */
    public function replaceTitle(string | array $replaceTitle): static
    {
        $this->replaceTitle = $replaceTitle;

        return $this;
    }
}
