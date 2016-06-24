<?php

namespace BrngyWiFi\Commands;

use BrngyWiFi\Commands\Command;
use BrngyWiFi\Services\Curl\SendNotification;
use Illuminate\Contracts\Bus\SelfHandling;
/*use Illuminate\Contracts\Queue\ShouldBeQueued;*/
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use \BrngyWiFi\Modules\Messages\Models\Messages;

class SendNotificationsToAllHomeownerCommand extends Command implements /*ShouldBeQueued,*/SelfHandling
{
    use InteractsWithQueue, SerializesModels;

    public $homeowners;

    public $request;

    public $adminId;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($homeowners, $request, $adminId)
    {
        $this->homeowners = $homeowners;
        $this->request = $request;
        $this->adminId = $adminId;
    }

    public function handle(SendNotification $curl)
    {
        $request = $this->request;

        foreach ($this->homeowners as $key => $value) {

            if (Messages::create(['to_user_id' => $value->user->id, 'from_user_id' => $this->adminId, 'message' => $request['message']])) {
                $result = array('msg' => 'Message has been sent', 'msgCode' => 1);
            }

            $fields = array(
                'app_id' => \Config::get('onesignal.' . 'brgyWifi.' . 'app-id'),
                'tags' => array(array('key' => 'userId', 'relation' => '=', 'value' => $value->user->id)),
                'contents' => ["en" => $request['message']],
                'data' => ['additionalData' => 'message_from_admin'],
                'android_group' => 'BRGY Comms',
            );

            $fields = json_encode($fields);

            $response = $curl->call($fields);

            $this->release();
        }

    }
}
