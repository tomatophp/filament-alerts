<?php

namespace TomatoPHP\FilamentAlerts\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationEvent
{
    use Dispatchable;
    use SerializesModels;

    public $replacements;

    public $type;

    public $notified;

    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notified, $replacements, $type = '', $data = '')
    {
        $this->replacements = $replacements;
        $this->type = $type;
        $this->notified = $notified;
        $this->data = $data;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
