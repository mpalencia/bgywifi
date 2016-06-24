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

class ResidentialController extends Controller
{

    private $user;

    public function users($roleId = 3, $limit = null, $orderBy = "ASC", $view = 'residentials')
    {

        if (isset($limit)) {
            $data['homeowners'] = DB::table('users')
                ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->where('user_roles.role_id', '=', $roleId)
                ->orderBy('users.id', $orderBy)
                ->take($limit)
                ->get();
        } else {
            $data['homeowners'] = DB::table('users')
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

    public function addressList($homeOwnerId, $view = 'address_list')
    {
        $data['address'] = HomeownerAddress::where('home_owner_id', $homeOwnerId)->get();
        $data['resident'] = User::find($homeOwnerId);

        return view('Admin::' . $view, $data);
    }

    public function addResidential(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'last_name' => 'required|max:50',
            'first_name' => 'required|max:50',
            'address' => 'required|max:100',
            'contact_no' => 'required|max:12',
            'email' => 'required|max:50|email|unique:users',
            'username' => 'required|max:30|unique:users|min:5',
            'password' => 'required|max:100|min:5',
        ]);

        if ($validator->fails()) {
            return array('msg' => json_encode($validator->errors()->first()), 'msgCode' => 0);
        }

        $output = array('msg' => 'error', 'msgCode' => 0);

        $data = array(
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'contact_no' => '63' . $request->input('contact_no'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
            'remember_token' => str_random(10),
        );
        $checkUser = User::where(array('username' => $data['username']))->first();

        if (empty($request->input('address'))) {
            return array('msg' => 'Address is required.', 'msgCode' => 0);
        }

        if (empty($request->input('long_lat'))) {
            return array('msg' => 'Longitude & Latitude are required.', 'msgCode' => 0);
        }

        if (is_null($checkUser)) {
            $user = User::create($data);

            //dd($user);
            if ($user) {
                //add homeowner's address
                $long_lat = $request->input('long_lat');
                $ctr = 0;
                $primary = 1;

                foreach ($request->input('address') as $address) {
                    //$angle = $this->convertAddress($address);
                    $long_lat_exploded = explode(',', $long_lat[$ctr]);

                    HomeownerAddress::create(
                        array(
                            'home_owner_id' => $user->id,
                            'address' => $address,
                            'latitude' => $long_lat_exploded[0],
                            'longitude' => $long_lat_exploded[1],
                            'primary' => $primary,
                        )
                    );
                    $primary = 0;
                    $ctr++;
                }

                //create user role
                if (UserRoles::create(array('user_id' => $user->id, 'role_id' => 3))) {
                    $output = array('msg' => 'New residential account has been added.', 'msgCode' => 1);
                }
            }
        } else {
            $output = array('msg' => 'Username is already exist', 'msgCode' => 0);
        }

        return $output;
    }

    public function editResidential(Request $request)
    {

        $output = array('msg' => 'error', 'msgCode' => 0);

        $data = array(
            'id' => $request->input('id'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'contact_no' => '63' . $request->input('contact_no'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
        );

        $validator = \Validator::make($request->all(), [
            'last_name' => 'required|max:50',
            'first_name' => 'required|max:50',
            'email' => 'required|max:50|email|unique:users,email,' . $data['id'],
            'contact_no' => 'required|max:12',
            'username' => 'required|max:30|min:5|unique:users,username,' . $data['id'],
            'password' => 'min:5|max:100',
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
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->email = $data['email'];
            $user->contact_no = $data['contact_no'];
            $user->username = $data['username'];
            $user->password = $data['password'];

            $result = $user->save();

            if ($result) {
                $output = array('msg' => 'Residential account has been updated.', 'msgCode' => 1);
            }
        }

        return $output;
    }

    public function postResidentialAddress(Request $request)
    {
        $long_lat = $request->input('long_lat');
        $address = $request->input('address');
        $homeOwnerId = $request->input('home_owner_id');
        $long_lat_exploded = explode(',', $long_lat);

        $validator = \Validator::make($request->all(), [
            'long_lat' => 'required',
            'address' => 'required|unique:homeowner_address',
        ]);

        if ($validator->fails()) {
            return array('msg' => json_encode($validator->errors()->first()), 'msgCode' => 0);
        }

        HomeownerAddress::create(
            array(
                'home_owner_id' => $homeOwnerId,
                'address' => $address,
                'latitude' => $long_lat_exploded[0],
                'longitude' => $long_lat_exploded[1])
        );

        return array('msg' => 'Address has been added.', 'msgCode' => 1);
    }
    public function editResidentialAddress(Request $request)
    {
        $output = array('msg' => 'Address, Longitude and Latitude are required.');
        if (empty($request->input('address'))) {
            return array('msg' => 'Address is required.', 'msgCode' => 0);
        }

        if (empty($request->input('long_lat'))) {
            return array('msg' => 'Longitude & Latitude are required.', 'msgCode' => 0);
        }

        $long_lat = $request->input('long_lat');
        $addressId = $request->input('addressId');
        $homeOwnerId = $request->input('home_owner_id');
        $address = $request->input('address');

        $validator = \Validator::make($request->all(), [
            'long_lat' => 'required',
            'address' => 'required|unique:homeowner_address,address,' . $addressId,
        ]);

        if ($validator->fails()) {
            return array('msg' => json_encode($validator->errors()->first()), 'msgCode' => 0);
        }

        /* foreach ($request->input('address') as $address) {
        //$angle = $this->convertAddress($address);
        $long_lat_exploded = explode(',', $long_lat[$ctr]);
        $homeowner_address_validate = HomeownerAddress::where('address', $address)->get();
        if (empty($homeowner_address_validate)) {
        HomeownerAddress::create(
        array(
        'home_owner_id' => $homeOwnerId,
        'address' => $address,
        'latitude' => $long_lat_exploded[0],
        'longitude' => $long_lat_exploded[1])
        );
        }

        $ctr++;
        }*/

        $long_lat_exploded = explode(',', $long_lat);

        $result = DB::table('homeowner_address')->where('id', $addressId)->update(['address' => $address, 'latitude' => $long_lat_exploded[0], 'longitude' => $long_lat_exploded[1]]);

        $output = array('msg' => 'Residential account has been updated.', 'msgCode' => 1);

        return $output;
    }

    public function deleteResidentialAddress($id)
    {
        if (HomeownerAddress::find($id)->delete()) {
            return array('msg' => 'Address has been deleted.', 'msgCode' => 1);
        }

        return array('msg' => 'Address does not exist.', 'msgCode' => 0);
    }

    private function convertAddress($address)
    {
        $address = str_replace(" ", "+", $address);
        $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=$address";
        $response = file_get_contents($url);
        $json = json_decode($response, true);

        if (!array_key_exists(0, $json['results'])) {
            return [
                'latitude' => 0,
                'longitude' => 0,
            ];
        }

        return [
            'latitude' => $json['results'][0]['geometry']['location']['lat'],
            'longitude' => $json['results'][0]['geometry']['location']['lng'],
        ];
    }

}
