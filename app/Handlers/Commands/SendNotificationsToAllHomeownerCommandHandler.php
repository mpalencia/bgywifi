<?php

namespace BrngyWiFi\Handlers\Commands;

use BrngyWiFi\Commands\SendNotificationsToAllHomeownerCommand;
use BrngyWiFi\Services\Curl\SendNotification;

class SendNotificationsToAllHomeownerCommandHandler
{
    /**
     * Create the command handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the command.
     *
     * @param  SendNotificationsToAllHomeownerCommand  $command
     * @return void
     */
    public function handle(SendNotificationsToAllHomeownerCommand $command)
    {
        $request = $this->request;

        foreach ($this->homeowners as $key => $value) {

            $command->release();
        }

    }
}
