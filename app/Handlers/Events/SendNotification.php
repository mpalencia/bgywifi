<?php

namespace BrngyWiFi\Handlers\Events;

use BrngyWiFi\Events\MessageAlertsWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotification
{
    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessageAlertsWasCreated  $event
     * @return void
     */
    public function handle(MessageAlertsWasCreated $event)
    {
        //
    }
}
