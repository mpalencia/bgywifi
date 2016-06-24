<?php

namespace BrngyWiFi\Modules\HomeownerAddress\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\HomeownerAddress\Repository\HomeownerAddressRepositoryInterface;
use Illuminate\Http\Request;

class HomeownerAddressController extends Controller
{
    /**
     * @var HomeownerAddressRepositoryInterface
     */
    private $homeownerAddressRepositoryInterface;

    /**
     * @param ActionTaken
     */
    public function __construct(HomeownerAddressRepositoryInterface $homeownerAddressRepositoryInterface)
    {
        $this->homeownerAddressRepositoryInterface = $homeownerAddressRepositoryInterface;
    }

    /**
     * Get all HomeownerAddress
     *
     * @param integer $id
     * @return static
     */
    public function getAllHomeownerAddress($homeownerOwnerId)
    {
        return $this->homeownerAddressRepositoryInterface->getAllHomeownerAddress($homeownerOwnerId);
    }

    /**
     * Create new HomeownerAddress
     *
     * @param array $payload
     * @return static
     */
    public function createHomeownerAddress(Request $payload)
    {

        return $this->homeownerAddress->create(json_decode($payload, true));
    }
}
