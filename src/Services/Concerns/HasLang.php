<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasLang
{
    private ?string $lang = null;

    /**
     * @return $this
     */
    public function lang(string $lang): static
    {
        $this->lang = $lang;

        return $this;
    }
}
