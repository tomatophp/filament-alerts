<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasReplaceBody
{
    private string | array | null $replaceBody = null;

    /**
     * @return $this
     */
    public function replaceBody(string | array $replaceBody): static
    {
        $this->replaceBody = $replaceBody;

        return $this;
    }
}
