<?php

namespace TomatoPHP\FilamentAlerts\Services\Drivers;

use TomatoPHP\FilamentAlerts\Jobs\NotifyEmailJob;

class EmailDriver extends Driver
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
            $email = $model::find($modelId)?->email;
            if ($email) {
                dispatch(new NotifyEmailJob([
                    'email' => $email,
                    'subject' => $title,
                    'message' => $body,
                    'url' => $url,
                ]));
            }
        } else {
            foreach ($model::all() as $user) {
                $email = $user->email;
                if ($email) {
                    dispatch(new NotifyEmailJob([
                        'email' => $email,
                        'subject' => $title,
                        'message' => $body,
                        'url' => $url,
                    ]));
                }
            }
        }

    }
}
