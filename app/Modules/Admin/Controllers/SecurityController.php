<?php

namespace BrngyWiFi\Modules\Admin\Controllers;

use Auth;
use BrngyWiFi\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use \BrngyWiFi\Modules\Admin\Models\Admin;
use \BrngyWiFi\Modules\HomeownerAddress\Models\HomeownerAddress;
use \BrngyWiFi\Modules\Messages\Models\Messages;
use \BrngyWiFi\Modules\UserRoles\Models\UserRoles;
use \BrngyWiFi\Modules\User\Models\User;

class SecurityController extends Controller
{

    private $user;

    public function users($roleId = 2, $limit = null, $orderBy = "ASC", $view = 'security')
    {

        if (isset($limit)) {
            $data['securities'] = DB::table('users')
                ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->where('user_roles.role_id', '=', $roleId)
                ->orderBy('users.id', $orderBy)
                ->take($limit)
                ->get();
        } else {
            $data['securities'] = DB::table('users')
                ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->where('user_roles.role_id', '=', $roleId)
                ->orderBy('users.id', $orderBy)
                ->get();
        }

        $data['unread_msg'] = Messages::select('messages.*', 'messages.id AS mid', 'messages.created_at AS datesent', 'users.*')
            ->join('users', 'messages.from_user_id', '=', 'users.id')
            ->where(array('users.id' => Auth::user()->id, 'messages.status' => 1))
            ->limit(5)
            ->orderBy('messages.id', 'DESC')
            ->get();
        return view('Admin::' . $view, $data);
    }
    public function addSecurity(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'last_name' => 'required',
            'first_name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:5',
        ]);

        if ($validator->fails()) {

            return array('msg' => json_encode($validator->errors()->first()), 'msgCode' => 0);
        }

        $output = array('msg' => 'error', 'msgCode' => 0);

        $data = array(
            'last_name' => $request->input('last_name'),
            'first_name' => $request->input('first_name'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('confirm_password')),
            'remember_token' => str_random(10),
        );
        $checkUser = User::where(array('username' => $data['username']))->first();
        if (is_null($checkUser)) {
            $user = User::create($data);

            //dd($user);
            if ($user) {
                //create user role
                if (UserRoles::create(array('user_id' => $user->id, 'role_id' => 2))) {
                    $output = array('msg' => 'New security account has been added.', 'msgCode' => 1);
                }

                HomeownerAddress::create(
                    array(
                        'home_owner_id' => $user->id,
                        'address' => 'Westgrove',
                        'latitude' => '14.2366558',
                        'longitude' => '121.0400705',
                        'primary' => 1,
                    )
                );
            }
        } else {
            $output = array('msg' => 'Username is already exist', 'msgCode' => 0);
        }

        return $output;
    }

    public function editSecurity(Request $request)
    {
        $output = array('msg' => 'error', 'msgCode' => 0);

        $data = array(
            'id' => $request->input('id'),
            'last_name' => $request->input('last_name'),
            'first_name' => $request->input('first_name'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
        );

        $validator = \Validator::make($request->all(), [
            'last_name' => 'required',
            'first_name' => 'required',
            'username' => 'required|unique:users,username,' . $data['id'],
            'password' => 'min:5',
        ]);

        if ($validator->fails()) {
            return array('msg' => json_encode($validator->errors()->first()), 'msgCode' => 0);
        }

        $checkUser = User::where(array('id' => $data['id']))->first();
        if (is_null($checkUser)) {
            $output = array('msg' => 'Residential account not found.', 'msgCode' => 0);
        } else {
            $user = User::find($data['id']);

            if (!empty($request->input('confirm_password'))) {
                $user->password = $data['password'];
            }
            $user->last_name = $data['last_name'];
            $user->first_name = $data['first_name'];
            $user->username = $data['username'];
            $user->password = $data['password'];

            $result = $user->save();

            /*HomeownerAddress::create(
            array($request->input('address')
            'home_owner_id' => $user->id,
            'latitude' => $angle['latitude'],
            'longitude' => $angle['longitude'])
            );*/
            if ($result) {
                $output = array('msg' => 'Security account has been updated.', 'msgCode' => 1);
            }
        }

        return $output;
    }

    public function deleteSecurity(Request $request)
    {
        $userId = $request->input('id');
        $isDeleted = User::where('id', $userId)->delete();

        $output = array('msg' => 'Failed to delete security.', 'msgCode' => 0);
        if ($isDeleted) {
            $output = array('msg' => 'Security has been deleted.', 'msgCode' => 1);
        }

        return $output;
    }

}
