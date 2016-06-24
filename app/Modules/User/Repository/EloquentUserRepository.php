<?php

namespace BrngyWiFi\Modules\User\Repository;

use BrngyWiFi\Modules\User\Models\User;

class EloquentUserRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /* public function createuser($payload)
    {
    return $this->user->create($payload);
    }*/

    /*public function updateuser($id)
    {
    return $this->user->find($id)->fill($data)->save();
    }*/

    /**
     * Get a certain user by email
     *
     * @param string $email
     * @return User|null
     */

    public function getUserByEmail($email)
    {
        if ($user = $this->user->where('email', $email)->get()->toArray()) {
            return $user;
        }

        return false;
    }

    /**
     * Get a certain user
     *
     * @param integer $id
     * @return User|null
     */

    public function getUserById($id)
    {
        return $this->user->find($id);
    }

    /**
     * Get a certain user's address
     *
     * @param integer $id
     * @return User|null
     */
    public function getUserAddressById($id)
    {
        return $this->user->find($id);
    }

    /**
     * Update a certain user
     *
     * @param int $id
     * @return User|null
     */
    public function updateUser($id, $payload)
    {
        if (array_key_exists('pin_code', $payload)) {
            $payload['pin_code'] = md5($payload['pin_code']);
        }

        return $this->user->where('id', $id)->update($payload);
    }

    /**
     * Validate a certain user's pin code
     *
     * @param int $id
     * @param array $pinCode
     * @return User|null
     */
    public function validatePinCode($id, $pinCode)
    {
        $user = $this->user
            ->with('homeOwnerAddress')
            ->select('id', 'first_name', 'last_name', 'pin_code')
            ->where('pin_code', md5($pinCode['pin_code']))
            ->where('id', $id)
            ->get()
            ->toArray();

        if (!empty($user)) {
            return $user;
        }

        return false;
    }
}
