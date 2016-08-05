<?php

namespace BrngyWiFi\Modules\DeviceUser\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\DeviceUser\Repository\DeviceUserRepositoryInterface;
use BrngyWiFi\Modules\HomeownerAddress\Models\HomeownerAddress;
use BrngyWiFi\Modules\UserRoles\Models\UserRoles;
use BrngyWiFi\Modules\User\Models\User;
use Illuminate\Http\Request;

class DeviceUserController extends Controller
{
    /**
     * @var DeviceUserRepositoryInterface
     */
    private $deviceUserRepositoryInterface;

    /**
     * @var Illuminate\Http\Request
     */
    private $request;

    /**
     * @param DeviceUser
     */
    public function __construct(DeviceUserRepositoryInterface $deviceUserRepositoryInterface, Request $request)
    {
        $this->deviceUserRepositoryInterface = $deviceUserRepositoryInterface;
        $this->request = $request;
    }

    /**
     * Get all DeviceUser
     *
     * @param deviceUserRepositoryInterface DeviceUserRepositoryInterface
     * @param request array
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllDeviceUser()
    {
        return $this->deviceUserRepositoryInterface->getAllDeviceUser();
    }

    /**
     * Get all DeviceUser By Home owner id
     *
     * @param $home_owner_id home owner id
     * @return \Illuminate\Http\Response
     */
    public function getAllDeviceUserByHomeowner($home_owner_id)
    {
        return $this->deviceUserRepositoryInterface->getAllDeviceUserByHomeowner($home_owner_id);
    }

    /**
     * Create new device user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveDeviceUser()
    {
        $request = json_decode($this->request->getContent(), true);
        $mainHomeowner = User::with(['homeownerAddress' => function ($query) {
            $query->select('home_owner_id', 'address', 'primary', 'latitude', 'longitude');
            $query->where('primary', 1);
        }])
            ->select('id', 'first_name', 'last_name')
            ->where('id', $request['home_owner_id'])
            ->get()
            ->toArray();

        $validator = \Validator::make($request, [
            'email' => 'required|email|unique:device_user',
            'mobile_no' => 'required|unique:device_user',
        ]);

        if ($validator->fails()) {
            return ['result' => 'error', 'error' => $validator->errors()];
        }

        if ($this->deviceUserRepositoryInterface->createDeviceUser($this->request->getContent())) {
            $newHomeowner = User::create(
                array(
                    'first_name' => $request['first_name'], //$mainHomeowner[0]['first_name'],
                    'last_name' => $request['last_name'], //$mainHomeowner[0]['last_name'],
                    'email' => $request['email'],
                    'username' => $request['email'],
                    'password' => bcrypt($request['mobile_no']),
                    'contact_no' => $request['mobile_no'],
                    'remember_token' => str_random(10),
                    'main_account_id' => $request['home_owner_id'],
                )
            );

            HomeownerAddress::create(
                array(
                    'home_owner_id' => $newHomeowner->id,
                    'address' => $mainHomeowner[0]['homeowner_address'][0]['address'],
                    'latitude' => $mainHomeowner[0]['homeowner_address'][0]['latitude'],
                    'longitude' => $mainHomeowner[0]['homeowner_address'][0]['longitude'],
                    'primary' => 1,
                )
            );

            UserRoles::create(['user_id' => $newHomeowner->id, 'role_id' => 3]);

            $email = \Mail::send('emails.new_device_user', ['username' => $request['email'], 'password' => $request['mobile_no']], function ($m) use ($request) {
                $m->from('brgywifi01@gmail.com', 'BRGY COMMS');

                $m->to($request['email'], '')->subject('BRGY COMMS Account Details');
            });
            if ($email) {
                return ['result' => 'success'];
            }

        }

        return ['result' => 'error'];

    }

    /**
     * Update device user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateDeviceUser($id)
    {
        $request = json_decode($this->request->getContent(), true);

        $validator = \Validator::make($request, [
            'email' => 'required|email|unique:device_user,email,' . $id,
            'mobile_no' => 'required|unique:device_user,mobile_no,' . $id,
        ]);

        if ($validator->fails()) {
            return ['result' => 'error', 'error' => $validator->errors()];
        }

        $deviceUser = $this->deviceUserRepositoryInterface->getDeviceUser($id);

        if ($user = $this->deviceUserRepositoryInterface->updateDeviceUser($id, $this->request->getContent())) {

            $newHomeowner = User::where('username', $deviceUser->email)->update(
                array(
                    'first_name' => $request['first_name'],
                    'last_name' => $request['last_name'],
                    'email' => $request['email'],
                    'username' => $request['email'],
                    'password' => bcrypt($request['mobile_no']),
                    'contact_no' => $request['mobile_no'],
                )
            );

            $email = \Mail::send('emails.new_device_user', ['username' => $request['email'], 'password' => $request['mobile_no']], function ($m) use ($request) {
                $m->from('brgywifi01@gmail.com', 'BRGY COMMS');

                $m->to($request['email'], '')->subject('BRGY COMMS Account Details');
            });
            if ($email) {
                return ['result' => 'success'];
            }
        }

        return ['result' => 'error', 'error' => 'All fields are required.'];
    }

    /**
     * Delete a device user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteDeviceUser($id)
    {
        $deviceUser = $this->deviceUserRepositoryInterface->getDeviceUser($id);

        if ($this->deviceUserRepositoryInterface->deleteDeviceUser($id)) {

            User::where('username', $deviceUser->email)->delete();

            return ['result' => 'success'];
        }

        return ['result' => 'error', 'error' => 'User already deleted.'];
    }
}
