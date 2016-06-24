<?php

namespace BrngyWiFi\Modules\EventGuestList\Repository;

use BrngyWiFi\Modules\EventGuestList\Models\EventGuestList;

class EloquentEventGuestListRepository implements EventGuestListRepositoryInterface
{
    /**
     * @var EventGuestList
     */
    private $eventGuestList;

    /**
     * @param EventGuestList
     */
    public function __construct(EventGuestList $eventGuestList)
    {
        $this->eventGuestList = $eventGuestList;
    }

    /**
     * Get all EventGuestLists by event id for security
     *
     * @param int $eventId
     * @param int $homeOwnerId
     * @return static
     */
    public function getEventGuestListByEventId($eventId, $homeOwnerId)
    {
        /*return $this->eventGuestList
        ->join('event', 'event_guest_list.event_id', '=', 'event.id')
        ->join('guest_list', 'event_guest_list.guest_list_id', '=', 'guest_list.id')
        ->where('event_guest_list.event_id', $eventId)
        ->where('event_guest_list.home_owner_id', $homeOwnerId)
        ->where('guest_list.deleted_at', '=', null)
        ->get();*/

        return $this->eventGuestList
            ->with(['event' => function ($query) {
                $query->select('id', 'name', 'start', 'end');
            }])
            ->with(['guest_list' => function ($query) {
                $query->select('id', 'guest_name');
            }])
            ->select('id', 'event_id', 'guest_list_id', 'home_owner_id', 'status')
            ->where('event_id', $eventId)
            ->where('home_owner_id', $homeOwnerId)
        //->where('status', '!=', 1)
            ->get()
            ->toArray();
    }

    /**
     * Get all EventGuestLists by event id and home owner id
     *
     * @param int $id
     * @return static
     */
    public function getIncomingGuestsByEvents($eventId, $homwOwnerId)
    {
        return $this->eventGuestList
            ->with('event')
            ->with('guestList')
            ->where('event_id', $eventId)
            ->where('home_owner_id', $homwOwnerId)
            ->where('status', 1)
            ->get()
            ->toArray();
    }

    /**
     * Get all EventGuestLists by homeowner id filter by event end date
     *
     * @param int $homeOwnerId
     * @return static
     */
    public function getNotificationsEventGuestList($homeOwnerId)
    {
        return $this->eventGuestList
            ->with(['guestList' => function ($query) use ($homeOwnerId) {
                $query->where('home_owner_id', $homeOwnerId);
            }])
            ->with(['event' => function ($query) use ($homeOwnerId) {
                $query->where('end', '>=', date('Y-m-d'));
            }])
            ->where('status', 1)
            ->where('home_owner_id', $homeOwnerId)
            ->get()
            ->toArray();
    }

    /**
     * Get all EventGuestLists by event id and homeowner id
     *
     * @param int $eventId
     * @param int $homeOwnerId
     * @return static
     */
    public function getEventGuestList($eventId, $homeOwnerId)
    {
        return $this->eventGuestList
            ->with('event')
            ->with('guestList')
            ->where('event_id', $eventId)
            ->where('home_owner_id', $homeOwnerId)
            ->where('status', 0)
            ->get()
            ->toArray();
    }

    /**
     * Get a certain EventGuestList
     *
     * @param array $payload
     * @return static
     */
    public function getEventGuestListById($id)
    {
        return $this->eventGuestList
            ->with('guestList')
            ->find(array_keys($id)[0])
            ->toArray();
    }

    /**
     * Create new EventGuestList
     *
     * @param array $payload
     * @return static
     */
    public function createEventGuestList($payload)
    {
        return $this->eventGuestList->create($payload);
    }

    /**
     * Update status of EventGuestList
     *
     * @param array $guestListIds
     * @return boolean
     */
    public function updateEventGuestList($guestListIds)
    {
        $result = false;

        $guestListIds = json_decode($guestListIds, true);

        foreach ($guestListIds as $gli => $gliVal) {
            //if ($gliVal == 'true') {
            $result = true;
            $this->eventGuestList->find($gli)->fill(['status' => 1])->save();
            //}
        }

        return $result;
    }

    /**
     * Update status of EventGuestList to 2 - Homeowner confirmed the incoming guests.
     *
     * @param array $guestListIds
     * @return boolean
     */
    public function updateAllEventGuestListStatus($homeOwnerId, $guestListIds)
    {
        $guestListIds = json_decode($guestListIds, true);
        $result = false;

        foreach ($guestListIds as $gli => $gliVal) {

            if (\DB::table('event_guest_list')
                ->where('guest_list_id', $gliVal)
                ->where('home_owner_id', $homeOwnerId)
                ->update(['status' => 2])
            ) {
                $result = true;
            }

        }

        if ($result) {
            return ['result' => 'success'];
        }

        return ['result' => 'error', 'error' => "There's an error in sending notification to homeowner. Please check your connection and try again."];
    }

    /**
     * Update a certain EventGuestList
     *
     * @param array $guestListIds
     * @return boolean
     */
    public function updateEventGuestListById($guestListId)
    {
        return $this->eventGuestList->find($guestListId)->fill(['status' => 2])->save();
    }

    /**
     * Delete a certain EventGuestList
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteEventGuestList($id)
    {
        return $this->eventGuestList->find($id)->delete();
    }

    /**
     * Get all guests in village
     *
     * @return boolean
     */
    public function getAllGuestsAndVisitors()
    {
        return $this->eventGuestList
            ->with('homeowner')
        //->with('guestList')
            ->with(['event' => function ($query) {
                $query->where('end', '>=', date('Y-m-d'));
            }])
            ->where('status', 1)
            ->orWhere('status', 2)
        /*->groupBy('home_owner_id')*/
            ->get()
            ->toArray();
    }
}
