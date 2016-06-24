<?php

namespace BrngyWiFi\Modules\GuestList\Repository;

use BrngyWiFi\Modules\GuestList\Models\GuestList;

interface GuestListRepositoryInterface
{
    /**
     * Get all GuestLists by status event id and home owner id
     *
     * @param int $homeOwnerId
     * @return static
     */
    public function getAllGuestsForHomeowner($homeOwnerId);

    /**
     * Create new GuestList
     *
     * @param array $payload
     * @param int $eventId
     * @param int $homeOwnerId
     * @return static
     */
    public function createGuestInGuestList($payload, $eventId);

    /**
     * Update a certain GuestList
     *
     * @param array $payload
     * @return boolean
     */
    public function updateGuestInGuestList($payload, $id);

    /**
     * Delete a certain GuestList
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteGuestInGuestList($id);
}
