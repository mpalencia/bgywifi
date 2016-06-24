<?php

namespace BrngyWiFi\Listeners;

use BrngyWiFi\Events\MessageAlertsWasCreated;
use BrngyWiFi\Modules\UserRoles\Repository\UserRolesRepositoryInterface;
use BrngyWiFi\Services\Curl\SendNotification;
use BrngyWiFi\Services\Curl\SendWebNotification;

class SendMessageAlertsNotification
{
    /**
     * @var UserRolesRepositoryInterface
     */
    private $userRolesRepositoryInterface;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        UserRolesRepositoryInterface $userRolesRepositoryInterface,
        SendNotification $sendNotification
    ) {
        $this->userRolesRepositoryInterface = $userRolesRepositoryInterface;
        $this->sendNotification = $sendNotification;
    }

    /**
     * Handle the event.
     *
     * @param  MessageAlertsWasCreated  $event
     * @return void
     */
    public function handle(MessageAlertsWasCreated $event)
    {
        $securities = $this->userRolesRepositoryInterface->getAllSecurity();

        if (empty($securities)) {
            return 0;
        }

        /*$details = "";

        foreach ($securities as $security) {
        $details = "EMERGENCY! " . $event->type[0]['description'] . " From " . $event->type[0]['first_name'] . " " . $event->type[0]['last_name'] . " At " . $event->type[0]['address'];
        $fields = array(
        'app_id' => \Config::get('onesignal.' . 'brgyWifi.' . 'app-id'),
        'tags' => array(array('key' => 'userType', 'relation' => '=', 'value' => 2)),
        'contents' => ["en" => $details],
        'data' => ['alert' => $event->alert, 'additionalData' => $event->category],
        'android_group' => 'BRGY Comms',
        'included_segments' => array('All'),
        );

        $response = $this->sendNotification->call(json_encode($fields));
        }*/
        $details = "EMERGENCY! " . $event->type[0]['description'] . " From " . $event->type[0]['first_name'] . " " . $event->type[0]['last_name'] . " At " . $event->type[0]['address'];
        $fields = array(
            'app_id' => \Config::get('onesignal.' . 'brgyWifi.' . 'app-id'),
            'tags' => array(array('key' => 'userType', 'relation' => '=', 'value' => 2)),
            'contents' => ["en" => $details],
            'data' => ['alert' => $event->alert, 'additionalData' => $event->category],
            'android_group' => 'BRGY Comms',
            'included_segments' => array('All'),
        );

        $response = $this->sendNotification->call(json_encode($fields));
        $webNotification = new SendWebNotification($details);
        $webNotification->call();

        return true;
    }
}
