<?php

namespace TomatoPHP\FilamentAlerts\Services\Drivers;

use TomatoPHP\FilamentAlerts\Jobs\NotifyDatabaseJob;

class DatabaseDriver extends Driver
{
    public function setup(): void
    {
        // TODO: Implement setup() method.
    }

    public function sendIt(
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
        ?int $template_id = null,
    ): void {
        if ($modelId) {
            dispatch(new NotifyDatabaseJob([
                'model_type' => $model,
                'modelId' => $modelId,
                'title' => $title,
                'body' => $body,
                'url' => $url,
                'icon' => $icon,
                'type' => $type,
                'action' => $action,
                'data' => $data,
                'template_id' => $template_id,
            ]));
        } else {
            foreach ($model::all() as $user) {
                dispatch(new NotifyDatabaseJob([
                    'model_type' => $model,
                    'modelId' => $user->id,
                    'title' => $title,
                    'body' => $body,
                    'url' => $url,
                    'icon' => $icon,
                    'type' => $type,
                    'action' => $action,
                    'data' => $data,
                    'template_id' => $template_id,
                ]));
            }
        }

    }
}
