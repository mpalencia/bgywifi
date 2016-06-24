<?php

namespace BrngyWiFi\Modules\EventGuestList\Repository;

use BrngyWiFi\Modules\EventGuestList\Models\EventGuestList;

interface EventGuestListRepositoryInterface
{
    /**
     * Get all EventGuestLists by event id for security
     *
     * @param int $eventId
     * @param int $homeOwnerId
     * @return static
     */
    public function getEventGuestListByEventId($eventId, $homeOwnerId);

    /**
     * Get all EventGuestLists by event id and home owner id
     *
     * @param int $id
     * @return static
     */
    public function getIncomingGuestsByEvents($eventId, $homwOwnerId);

    /**
     * Get all EventGuestLists by homeowner id filter by event end date
     *
     * @param int $homeOwnerId
     * @return static
     */
    public function getNotificationsEventGuestList($homeOwnerId);

    /**
     * Get all EventGuestLists by event id filter by event end date
     *
     * @param int $eventId
     * @param int $homeOwnerId
     * @return static
     */
    public function getEventGuestList($eventId, $homeOwnerId);

    /**
     * Get a certain EventGuestList
     *
     * @param array $payload
     * @return static
     */
    public function getEventGuestListById($id);

    /**
     * Create new EventGuestList
     *
     * @param array $payload
     * @return static
     */
    public function createEventGuestList($payload);

    /**
     * Update status of EventGuestList
     *
     * @param array $guestListIds
     * @return boolean
     */
    public function updateEventGuestList($guestListIds);

    /**
     * Update status of EventGuestList to 2 - Homeowner confirmed the incoming guests.
     *
     * @param array $guestListIds
     * @return boolean
     */
    public function updateAllEventGuestListStatus($homeOwnerId, $guestListIds);

    /**
     * Update a certain EventGuestList
     *
     * @param array $guestListIds
     * @return boolean
     */
    public function updateEventGuestListById($guestListId);

    /**
     * Delete a certain EventGuestList
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteEventGuestList($id);

    /**
     * Get all guests in village
     *
     * @return boolean
     */
    public function getAllGuestsAndVisitors();
}
