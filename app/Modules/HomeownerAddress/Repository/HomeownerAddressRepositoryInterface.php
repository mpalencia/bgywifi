<?php

namespace BrngyWiFi\Modules\HomeownerAddress\Repository;

use BrngyWiFi\Modules\HomeownerAddress\Models\HomeownerAddress;

interface HomeownerAddressRepositoryInterface
{
    /**
     * Get all HomeownerAddress
     *
     * @param integer $homeownerOwnerId
     * @return static
     */
    public function getAllHomeownerAddress($homeownerOwnerId);

    /**
     * Create new HomeownerAddress for emergency
     *
     * @param array $payload
     * @return static
     */
    public function createHomeownerAddress($payload);
}
