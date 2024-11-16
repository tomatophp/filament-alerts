<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasTemplate
{
    private string | array | object | null $template = null;

    /**
     * @return $this
     */
    public function template(string | array | object | null $template): static
    {
        $this->template = $template;

        return $this;
    }
}
