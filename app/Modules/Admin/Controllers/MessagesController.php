<?php

namespace BrngyWiFi\Modules\Admin\Controllers;

use Auth;
use BrngyWiFi\Commands\SendNotificationsToAllHomeownerCommand;
use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Services\Curl\SendNotification;
use DB;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;
use \BrngyWiFi\Modules\Admin\Models\Admin;
use \BrngyWiFi\Modules\Messages\Models\Messages;
use \BrngyWiFi\Modules\UserRoles\Models\UserRoles;
use \BrngyWiFi\Modules\User\Models\User;

class MessagesController extends Controller
{

    private $user;
    public $bus;
    public function __construct(Dispatcher $bus)
    {
        $this->bus = $bus;
    }
    public function messages()
    {

        $data['messages'] = Messages::select('messages.*', 'messages.id AS mid', 'messages.created_at AS datesent', 'users.*')
            ->join('users', 'messages.from_user_id', '=', 'users.id')
            ->where(array('users.id' => Auth::user()->id))
            ->orderBy('datesent', 'desc')
            ->get();

        $data['messages'] = Messages::with(['to_user' => function ($query) {
            $query->select('id', 'first_name', 'last_name');
        }])
            ->with(['from_user' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->where(array('from_user_id' => Auth::user()->id))
            ->orderBy('created_at', 'desc')
            ->get();

        $data['residentials'] = DB::table('users')
            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id', '=', 3)
            ->orderBy('users.id', 'DESC')
            ->get();

        return view('Admin::messages', $data);
    }

    public function send(Request $request, SendNotification $curl)
    {
        $adminId = Auth::user()->id;
        $msgData = array(
            'to_user_id' => $request->input('to_user_id'),
            'from_user_id' => $adminId,
            'message' => $request->input('message'),
        );

        $result = array('msg' => 'Message send failed', 'msgCode' => 0);

        if ($msgData['to_user_id'] != 0) {

            if (Messages::create($msgData)) {

                $result = array('msg' => 'Message has been sent', 'msgCode' => 1);

                $fields = array(
                    'app_id' => \Config::get('onesignal.' . 'brgyWifi.' . 'app-id'),
                    'tags' => array(array('key' => 'userId', 'relation' => '=', 'value' => $msgData['to_user_id'])),
                    'contents' => ["en" => $request->input('message')],
                    'data' => ['additionalData' => 'message_from_admin'],
                    'android_group' => 'BRGY Comms',
                );

                $fields = json_encode($fields);

                $response = $curl->call($fields);
            }

            return $result;
        }

        $homeowners = UserRoles::with(['user' => function ($query) {
            $query->select('id', 'first_name', 'last_name');
        }])
            ->where('role_id', 3)
            ->get();

        $test = $this->dispatch(new SendNotificationsToAllHomeownerCommand($homeowners, $request->all(), $adminId));

        return array('msg' => 'Messages has been sent.', 'msgCode' => 1);
    }

    public function submitCurl($data = null, $headers = array(), $url = null, $method = 'POST')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        //dd($result);
        curl_close($ch);

        return $result;

    }

    public function sendNotif($msgData = null)
    {
        $output = 0;
        if (isset($msgData)) {
            $content = array(
                "en" => $msgData['message'],
            );

            if ($msgData['to_user_id'] == 0) {
                $fields = array(
                    'app_id' => \Config::get('onesignal.' . 'brgyWifi.' . 'app-id'),
                    'included_segments' => ['All'],
                    'contents' => $content,
                );
            } else {
                $fields = array(
                    'app_id' => \Config::get('onesignal.' . 'brgyWifi.' . 'app-id'),
                    'tags' => array(array('key' => 'userId', 'relation' => '=', 'value' => $msgData['to_user_id'])),
                    'contents' => $content,
                );
            }

            $fields = json_encode($fields);
            $headers = array(
                'Content-Type: application/json',
                'Authorization: Basic ZTRjNWYyZjItN2JiMi0xMWU1LTkwMmYtYTAzNjlmMmQ5MzI4',
            );
            $res = $this->submitCurl($fields, $headers, 'https://onesignal.com/api/v1/notifications', 'POST');
            $output = json_decode($res, true);
        }
        return $output;

    }

    public function deleteMessage(Request $request)
    {
        $id = $request->input('id');
        $isDeleted = Messages::where('id', $id)->delete();

        $output = array('msg' => 'Failed to delete message.', 'msgCode' => 0);
        if ($isDeleted) {
            $output = array('msg' => 'Message has been deleted.', 'msgCode' => 1);
        }

        return $output;
    }
}
