<?php

namespace BrngyWiFi\Events;

use BrngyWiFi\Events\Event;
use Illuminate\Queue\SerializesModels;

class MessageAlertsWasCreated extends Event
{
    use SerializesModels;

    public $type;

    public $alert;

    public $category;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($alert, $type, $category = null)
    {
        $this->alert = $alert;
        $this->type = $type;
        $this->category = $category;
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
