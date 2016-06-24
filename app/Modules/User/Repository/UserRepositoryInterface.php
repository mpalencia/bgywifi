<?php

namespace BrngyWiFi\Modules\User\Repository;

use BrngyWiFi\Modules\User\Models\User;

interface UserRepositoryInterface
{
    //public function createVisitors($payload);

    /**
     * Get a certain user by email
     *
     * @param string $email
     * @return User|null
     */

    public function getUserByEmail($email);

    /**
     * Get a certain user
     *
     * @param integer $id
     * @return User|null
     */
    public function getUserById($id);

    /**
     * Get a certain user's address
     *
     * @param integer $id
     * @return User|null
     */
    public function getUserAddressById($id);

    /**
     * Update a certain user
     *
     * @param int $id
     * @return User|null
     */
    public function updateUser($id, $pin_code);

    /**
     * Validate a certain user's pin code
     *
     * @param int $id
     * @param array $pinCode
     * @return User|null
     */
    public function validatePinCode($id, $pinCode);
}
