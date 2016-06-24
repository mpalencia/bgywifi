<?php

namespace BrngyWiFi\Modules\Admin\Controllers;

use Auth;
use BrngyWiFi\Http\Controllers\Controller;
use \BrngyWiFi\Modules\Admin\Models\Admin;
use \BrngyWiFi\Modules\Messages\Models\Messages;
use \BrngyWiFi\Modules\Notifications\Models\Notifications;
use \BrngyWiFi\Modules\User\Models\User;

class VisitorController extends Controller
{

    private $user;
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function visitors()
    {

        $data['visitors'] = Notifications::select('ref_category.*', 'notifications.*', 'notifications.id AS nid', 'users.*', 'users.first_name AS fname', 'users.last_name AS lname', 'visitors.*')
            ->join('users', 'notifications.home_owner_id', '=', 'users.id')
            ->join('visitors', 'notifications.visitors_id', '=', 'visitors.id')
            ->join('ref_category', 'visitors.ref_category_id', '=', 'ref_category.id')
        //->join('homeowner_address', 'visitors.ref_category_id', '=', 'homeowner_address.id')
        //->where(array('notifications.status' => 1))
            ->orderBy('nid', 'DESC')
            ->get();

        $data['unread_msg'] = Messages::select('messages.*', 'messages.id AS mid', 'messages.created_at AS datesent', 'users.*')
            ->join('users', 'messages.from_user_id', '=', 'users.id')
            ->where(array('users.id' => Auth::user()->id, 'messages.status' => 1))
            ->limit(5)
            ->orderBy('messages.id', 'DESC')
            ->get();
        //dd($data);
        return view('Admin::visitor', $data);
    }

}
