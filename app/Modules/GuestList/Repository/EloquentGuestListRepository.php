<?php

namespace BrngyWiFi\Modules\GuestList\Repository;

use BrngyWiFi\Modules\EventGuestList\Models\EventGuestList;
use BrngyWiFi\Modules\GuestList\Models\GuestList;

class EloquentGuestListRepository implements GuestListRepositoryInterface
{
    /**
     * @var GuestList
     */
    private $guestList;

    /**
     * @var EventGuestList
     */
    private $eventGuestList;

    /**
     * @param GuestList
     * @param EventGuestList
     */
    public function __construct(GuestList $guestList, EventGuestList $eventGuestList)
    {
        $this->guestList = $guestList;
        $this->eventGuestList = $eventGuestList;
    }

    /**
     * Get all GuestLists by status event id and home owner id
     *
     * @param int $eventId
     * @param int $homeOwnerId
     * @return static
     */
    public function getAllGuestsForHomeowner($homeOwnerId)
    {
        return $this->guestList
            ->where('home_owner_id', $homeOwnerId)
            ->get()
            ->toArray();
    }

    /**
     * Create new GuestList
     *
     * @param array $payload
     * @return static
     */
    public function createGuestInGuestList($payload, $eventId)
    {
        $guestList = $this->guestList->create($payload);
        $homeOwnerId = $guestList->home_owner_id;

        return $this->saveGuestListInEvent($guestList, $eventId, $homeOwnerId);
    }

    /**
     * Save guest list in event
     *
     * @param array $payload
     * @return static
     */
    public function saveGuestListInEvent($payload, $eventId, $homeOwnerId)
    {
        return $this->eventGuestList->insert(
            [
                'home_owner_id' => $homeOwnerId,
                'event_id' => $eventId,
                'guest_list_id' => $payload->id,
            ]
        );
    }

    /**
     * Update a certain GuestList
     *
     * @param array $payload
     * @return boolean
     */
    public function updateGuestInGuestList($payload, $id)
    {
        return $this->guestList->where('id', $id)->update($payload);
    }

    /**
     * Delete a certain GuestList
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteGuestInGuestList($id)
    {
        $this->eventGuestList->where('guest_list_id', $id)->delete();
        return $this->guestList->find($id)->delete();
    }
}
