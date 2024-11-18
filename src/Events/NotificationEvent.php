<?php

namespace TomatoPHP\FilamentAlerts\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationEvent
{
    use Dispatchable;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public array $data) {}

    public function broadcastOn()
    {
        return ['notifications'];
    }
}
