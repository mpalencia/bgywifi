<?php

namespace BrngyWiFi\Modules\Messages\Controllers;

use Auth;
use BrngyWiFi\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use \BrngyWiFi\Modules\Messages\Models\Messages;
use \BrngyWiFi\Modules\User\Models\User;

class MessagesController extends Controller
{
    private $user;
    /*public function __construct()
    {
    $this->middleware('auth');
    }*/
    public function messages()
    {

        $data['messages'] = Messages::select('messages.*', 'messages.id AS mid', 'messages.created_at AS datesent', 'users.*')
            ->join('users', 'messages.from_user_id', '=', 'users.id')
            ->where(array('users.id' => Auth::user()->id))
            ->get();

        $data['residentials'] = DB::table('users')
            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id', '=', 3)
            ->orderBy('users.id', 'DESC')
            ->get();

        return view('Admin::messages', $data);
    }

    public function getAllMessagesByHomeowner($homeOwnerId)
    {
        return Messages::select('messages.id', 'messages.message', 'messages.status', 'messages.created_at', 'messages.to_user_id')
            ->where(array('messages.to_user_id' => $homeOwnerId, 'status' => 0))
            ->orderBy('messages.created_at')
            ->get();
    }

    public function send(Request $request)
    {
        $msgData = array(
            'to_user_id' => $request->input('to_user_id'),
            'from_user_id' => Auth::user()->id,
            'message' => $request->input('message'),
            'category' => $request->input('category'),
        );
        $msg = Messages::create($msgData);
        $result = array('msg' => 'Message send failed', 'msgCode' => 0);
        if ($msg) {
            $result = array('msg' => 'Message has been sent', 'msgCode' => 1);
            $this->sendNotif($msgData);
        }

        return $result;
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
                    'app_id' => "e4c5f252-7bb2-11e5-902f-a0369f2d9328",
                    'included_segments' => ['All'],
                    'contents' => $content,
                );
            } else {
                $fields = array(
                    'app_id' => "e4c5f252-7bb2-11e5-902f-a0369f2d9328",
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
