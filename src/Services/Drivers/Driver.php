<?php

namespace TomatoPHP\FilamentAlerts\Services\Drivers;

use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;

abstract class Driver
{
    abstract public function setup(): void;

    abstract public function sendIt(
        string $title,
        string $model,
        int | string | null $modelId = null,
        ?string $body = null,
        ?string $url = null,
        ?string $icon = null,
        ?string $image = null,
        ?string $type = 'info',
        ?string $action = 'system',
        ?array $data = [],
        ?int $template_id = null
    ): void;

    public function send(
        int | string $template,
        string $model,
        int | string | null $modelId = null,
        array $title = [],
        array $body = [],
        array $data = []
    ): void {
        $loadTemplate = FilamentAlerts::loadTemplate(
            $template,
            $title,
            $body,
        );

        $this->sendIt(
            title: $loadTemplate->title,
            model: $model,
            modelId: $modelId,
            body: $loadTemplate->body,
            url: $loadTemplate->url,
            icon: $loadTemplate->icon,
            image: $loadTemplate->image,
            type: $loadTemplate->type,
            action: $loadTemplate->action,
            data: $data,
            template_id: $template
        );
    }
}
