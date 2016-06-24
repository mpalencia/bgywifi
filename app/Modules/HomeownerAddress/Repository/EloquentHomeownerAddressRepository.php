<?php

namespace BrngyWiFi\Modules\HomeownerAddress\Repository;

use BrngyWiFi\Modules\HomeownerAddress\Models\HomeownerAddress;

class EloquentHomeownerAddressRepository implements HomeownerAddressRepositoryInterface
{
    /**
     * @var HomeownerAddress
     */
    private $homeownerAddress;

    /**
     * @param HomeownerAddress
     */
    public function __construct(HomeownerAddress $homeownerAddress)
    {
        $this->homeownerAddress = $homeownerAddress;
    }

    /**
     * Get all HomeownerAddress
     *
     * @param integer $homeownerOwnerId
     * @return static
     */
    public function getAllHomeownerAddress($homeownerOwnerId)
    {
        return $this->homeownerAddress->select('id', 'address', 'latitude', 'longitude', 'home_owner_id', 'primary')->where('home_owner_id', $homeownerOwnerId)->get()->toArray();
    }

    /**
     * Create new HomeownerAddress
     *
     * @param array $payload
     * @return static
     */
    public function createHomeownerAddress($payload)
    {

        return $this->homeownerAddress->create(json_decode($payload, true));
    }
}
