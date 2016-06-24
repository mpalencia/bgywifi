<?php

namespace BrngyWiFi\Modules\DeviceUser\Repository;

use BrngyWiFi\Modules\DeviceUser\Models\DeviceUser;

interface DeviceUserRepositoryInterface
{
    /**
     * Get a DeviceUser
     *
     * @param array $id
     * @return static
     */
    public function getDeviceUser($id);

    /**
     * Get all DeviceUser
     *
     * @return static
     */
    public function getAllDeviceUser();

    /**
     * Get all DeviceUser By Home owner id
     *
     * @param $home_owner_id home owner id
     * @return \Illuminate\Http\Response
     */
    public function getAllDeviceUserByHomeowner($home_owner_id);

    /**
     * Create new DeviceUser
     *
     * @param array $payload
     * @return static
     */
    public function createDeviceUser($payload);

    /**
     * Update a DeviceUser
     *
     * @param array $id
     * @return static
     */
    public function updateDeviceUser($id, $payload);
}
