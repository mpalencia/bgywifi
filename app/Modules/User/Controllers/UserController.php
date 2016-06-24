<?php

namespace BrngyWiFi\Modules\User\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\Alerts\Models\Alerts;
use BrngyWiFi\Modules\UserRoles\Repository\UserRolesRepositoryInterface;
use BrngyWiFi\Modules\User\Repository\UserRepositoryInterface;
use BrngyWiFi\Services\Curl\SendNotification;
use BrngyWiFi\Services\Curl\SendWebNotification;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Redirect;
use \BrngyWiFi\Modules\UserRoles\Models\UserRoles;
use \BrngyWiFi\Modules\User\Models\User;

class UserController extends Controller
{

    /**
     * @var User
     */
    protected $user;

    public function __construct(UserRepositoryInterface $user, UserRolesRepositoryInterface $userRolesRepositoryInterface)
    {
        $this->userRolesRepositoryInterface = $userRolesRepositoryInterface;
        $this->user = $user;
    }

    /**
     * Get a certain home owner user
     *
     * @param ResponseFactory $response
     * @param integer $id
     * @return User|null
     */
    public function getHomeOwnerUsers(ResponseFactory $response)
    {
        return UserRoles::with(['user' => function ($query) {
            $query->select('id', 'first_name', 'last_name');
        }])
            ->where('role_id', 3)
            ->get()
            ->toArray();
    }
    /**
     * Get a certain user
     *
     * @param integer $id
     * @return User|null
     */
    public function getUserBytId($id)
    {
        return $this->user->getUserById($id);
    }

    /**
     * Get a certain user's address
     *
     * @param integer $id
     * @return User|null
     */
    public function getUserAddressById($id)
    {
        return $this->user->getUserAddressById($id);
    }

    /**
     * Update a certain user
     *
     * @param int $id
     * @return User|null
     */
    public function updateUser($id, Request $request)
    {
        if ($this->user->updateUser($id, json_decode($request->getContent(), true))) {
            return ['result' => 'success'];
        }

        return ['result' => 'error'];
    }

    /**
     * Delete a certain user
     *
     * @param integer $id
     * @return User|null
     */
    public function deleteUser($id)
    {
        User::destroy($id);
        return Redirect::to('admin/users');
    }

    /**
     * Validate a certain user's pin code
     *
     * @param int $id
     * @param array $pinCode
     * @return User|null
     */
    public function validatePinCode($id, Request $request, SendNotification $curl)
    {
        if ($homeowner = $this->user->validatePinCode($id, json_decode($request->getContent(), true))) {

            $securities = $this->userRolesRepositoryInterface->getAllSecurity();

            if (empty($securities)) {
                return ['result' => 'error', 'data' => 'No security guard found in database.'];
            }

            /*foreach ($securities as $security) {
            $details = "UNIDENTIFIED ALERT! From " . $homeowner[0]['first_name'] . " " . $homeowner[0]['last_name'] . " At " . $homeowner[0]['home_owner_address'][0]['address'];
            $fields = array(
            'app_id' => \Config::get('onesignal.' . 'brgyWifi.' . 'app-id'),
            'tags' => array(array('key' => 'userId', 'relation' => '=', 'value' => $security['user_id'])),
            'contents' => ["en" => $details],
            'data' => ['additionalData' => 'pin_code'],
            'android_group' => 'BRGY Comms',
            'included_segments' => array('All'),
            );

            $response = $curl->call(json_encode($fields));
            }*/
            $details = "UNIDENTIFIED ALERT! From " . $homeowner[0]['first_name'] . " " . $homeowner[0]['last_name'] . " At " . $homeowner[0]['home_owner_address'][0]['address'];

            $fields = array(
                'app_id' => \Config::get('onesignal.' . 'brgyWifi.' . 'app-id'),
                'tags' => array(array('key' => 'userType', 'relation' => '=', 'value' => 2)),
                'contents' => ["en" => $details],
                'data' => ['additionalData' => 'pin_code'],
                'android_group' => 'BRGY Comms',
            );
            $curl->call(json_encode($fields));

            $webNotification = new SendWebNotification($details);
            $response = $webNotification->call();

            Alerts::create(array('home_owner_id' => $homeowner[0]['id'], 'homeowner_address_id' => $homeowner[0]['home_owner_address'][0]['id']));

            return ['result' => 'success', 'data' => $homeowner, 'response' => $response];
        }

        return ['result' => 'error', 'error' => 'Wrong Pin Code.'];
    }

    /**
     * Validate a certain user's pin code via chikka
     *
     * @param int $id
     * @param array $pinCode
     * @return User|null
     */
    public function validatePinCodeViaChikka($request)
    {
        $request = json_decode($request->message, true);

        if ($homeowner = $this->user->validatePinCode($request['home_owner_id'], $request)) {

            $securities = $this->userRolesRepositoryInterface->getAllSecurity();

            if (empty($securities)) {
                return ['result' => 'error', 'data' => 'No security guard found in database.'];
            }

            $details = "UNIDENTIFIED ALERT! From " . $homeowner[0]['first_name'] . " " . $homeowner[0]['last_name'] . " At " . $homeowner[0]['home_owner_address'][0]['address'];

            $fields = array(
                'app_id' => \Config::get('onesignal.' . 'brgyWifi.' . 'app-id'),
                'tags' => array(array('key' => 'userType', 'relation' => '=', 'value' => 2)),
                'contents' => ["en" => $details],
                'data' => ['additionalData' => 'pin_code'],
                'android_group' => 'BRGY Comms',
            );
            (new SendNotification)->call(json_encode($fields));

            $webNotification = new SendWebNotification($details);
            $response = $webNotification->call();

            Alerts::create(array('home_owner_id' => $homeowner[0]['id'], 'homeowner_address_id' => $homeowner[0]['home_owner_address'][0]['id'], 'from_chikka' => 1));

            return ['result' => 'success', 'data' => $homeowner, 'response' => $response];
        }

        return ['result' => 'error', 'error' => 'Wrong Pin Code.'];
    }

    /**
     * Validate a certain user's pin code before update
     *
     * @param int $id
     * @param array $pinCode
     * @return User|null
     */
    public function validatePinCodeBeforeUpdate($id, Request $request)
    {
        $request = json_decode($request->getContent(), true);

        if ($homeowner = $this->user->validatePinCode($id, $request)) {

            return ['result' => 'success'];
        }

        return ['result' => 'error', 'error' => 'Wrong Pin Code.'];
    }

    /**
     * Generate password and send it to the given email
     *
     * @return array
     */
    public function forgotPassword(Request $request)
    {
        $request = json_decode($request->getContent(), true);

        if (!array_key_exists('email', $request)) {
            return ['result' => 'error', 'error' => 'Email is required.'];
        }

        if (!$user = $this->user->getUserByEmail($request['email'])) {
            return ['result' => 'error', 'error' => 'Email is does not exist.'];
        }

        $tempPassword = str_random(5);

        $request['password'] = bcrypt($tempPassword);

        if ($this->user->updateUser($user[0]['id'], $request)) {

            $email = \Mail::send('emails.new_device_user', ['username' => $user[0]['username'], 'password' => $tempPassword], function ($m) use ($request) {
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
     * Change password of a user
     *
     * @return array
     */
    public function changePassword($id, Request $request)
    {
        $request = json_decode($request->getContent(), true);

        $request['password'] = bcrypt($request['password']);

        if ($this->user->updateUser($id, $request)) {
            return ['result' => 'success'];
        }

        return ['result' => 'error'];
    }
}
