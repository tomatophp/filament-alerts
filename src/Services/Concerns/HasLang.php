<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasLang
{
    /**
     * @var string|null
     */
    private ?string $lang = null;

    /**
     * @param string $lang
     * @return $this
     */
    public function lang(string $lang): static
    {
        $this->lang = $lang;
        return $this;
    }
}
