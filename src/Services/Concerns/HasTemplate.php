<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasTemplate
{
    /**
     * @var string|array|object|null
     */
    private string|array|object|null $template = null;

    /**
     * @param string|array|object|null $template
     * @return $this
     */
    public function template(string|array|object|null $template): static
    {
        $this->template = $template;
        return $this;
    }
}
