<?php

namespace BrngyWiFi\Modules\UserRoles\Repository;

use BrngyWiFi\Modules\UserRoles\Models\UserRoles;

interface UserRolesRepositoryInterface
{
    /**
     * Get all security
     *
     * @param array $id
     * @return static
     */
    public function getAllSecurity();
}
