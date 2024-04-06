<?php

namespace TomatoPHP\FilamentAlerts\Services\Concerns;

trait HasTitle
{
    /**
     * @var string|null
     */
    public ?string $title = null;

    /**
     * @param ?string $title
     * @return static
     */
    public function title(?string $title): static {
        $this->title = $title;
        return $this;
    }
}
