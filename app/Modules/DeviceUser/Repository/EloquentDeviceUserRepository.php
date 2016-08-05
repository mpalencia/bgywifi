<?php

namespace BrngyWiFi\Modules\DeviceUser\Repository;

use BrngyWiFi\Modules\DeviceUser\Models\DeviceUser;

class EloquentDeviceUserRepository implements DeviceUserRepositoryInterface
{
    /**
     * @var DeviceUser
     */
    private $deviceUser;

    /**
     * @param DeviceUser
     */
    public function __construct(DeviceUser $deviceUser)
    {
        $this->deviceUser = $deviceUser;
    }

    /**
     * Get a DeviceUser
     *
     * @param array $id
     * @return static
     */
    public function getDeviceUser($id)
    {
        return $this->deviceUser->find($id);
    }

    /**
     * Get all DeviceUser
     *
     * @return static
     */
    public function getAllDeviceUser()
    {
        return $this->deviceUser->get()->toArray();
    }

    /**
     * Get all DeviceUser By Home owner id
     *
     * @param $home_owner_id home owner id
     * @return \Illuminate\Http\Response
     */
    public function getAllDeviceUserByHomeowner($home_owner_id)
    {
        return $this->deviceUser
            ->select('device_user.id', 'device_user.home_owner_id', 'device_user.email', 'device_user.mobile_no', 'users.id as user_id', 'users.first_name', 'users.last_name')->where('home_owner_id', $home_owner_id)
            ->leftJoin('users', 'device_user.email', '=', 'users.email')
            ->get()
            ->toArray();
    }

    /**
     * Create new DeviceUser
     *
     * @param array $payload
     * @return static
     */
    public function createDeviceUser($payload)
    {

        return $this->deviceUser->create(json_decode($payload, true));
    }

    /**
     * Update a DeviceUser
     *
     * @param array $id
     * @return static
     */
    public function updateDeviceUser($id, $payload)
    {
        if ($this->deviceUser->find($id)->fill(json_decode($payload, true))->save()) {
            return $this->deviceUser->find($id);
        }

        return false;
    }

    /**
     * Delete a DeviceUser
     *
     * @param array $id
     * @return static
     */
    public function deleteDeviceUser($id)
    {
        return $this->deviceUser->find($id)->delete();
    }
}
