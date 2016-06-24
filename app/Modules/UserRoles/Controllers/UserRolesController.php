<?php

namespace BrngyWiFi\Modules\UserRoles\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\UserRoles\Models\UserRoles;
use BrngyWiFi\Modules\UserRoles\Repository\UserRolesRepositoryInterface;

class UserRolesController extends Controller
{
    /**
     * @var UserRolesRepositoryInterface
     */
    private $userRolesRepositoryInterface;

    /**
     * @param UserRoles
     */
    public function __construct(UserRoles $userRoles, UserRolesRepositoryInterface $userRolesRepositoryInterface)
    {
        $this->userRoles = $userRoles;
        $this->userRolesRepositoryInterface = $userRolesRepositoryInterface;
    }

    public function getAllSecurity()
    {
        return $this->userRolesRepositoryInterface->getAllSecurity();
    }
}
