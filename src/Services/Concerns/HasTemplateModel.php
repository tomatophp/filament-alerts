<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasTemplateModel
{
    public ?object $templateModel = null;

    public function templateModel(?object $templateModel): static
    {
        $this->templateModel = $templateModel;

        return $this;
    }
}
