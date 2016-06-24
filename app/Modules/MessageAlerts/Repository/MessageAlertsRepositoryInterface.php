<?php

namespace BrngyWiFi\Modules\MessageAlerts\Repository;

use BrngyWiFi\Modules\MessageAlerts\Models\MessageAlerts;

interface MessageAlertsRepositoryInterface
{
    /**
     * Create new message alert
     *
     * @param array $payload
     * @return static
     */
    public function createMessageAlerts($payload);

    /**
     * Update a message alert
     *
     * @param array $id
     * @return static
     */
    public function updateMessageAlerts($id);
}
