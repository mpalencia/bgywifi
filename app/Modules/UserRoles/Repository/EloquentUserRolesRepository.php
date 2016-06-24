<?php

namespace BrngyWiFi\Modules\UserRoles\Repository;

use BrngyWiFi\Modules\UserRoles\Models\UserRoles;

class EloquentUserRolesRepository implements UserRolesRepositoryInterface
{
    /**
     * @var UserRoles
     */
    private $userRoles;

    /**
     * @param UserRoles
     */
    public function __construct(UserRoles $userRoles)
    {
        $this->userRoles = $userRoles;
    }

    /**
     * Get all security
     *
     * @param array $id
     * @return static
     */
    public function getAllSecurity()
    {
        return $this->userRoles->where('role_id', 2)->select('user_id', 'role_id')->get()->toArray();
    }
}
