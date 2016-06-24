<?php

namespace BrngyWiFi\Modules\Event\Repository;

use BrngyWiFi\Modules\EventGuestList\Models\EventGuestList;
use BrngyWiFi\Modules\Event\Models\Event;
use BrngyWiFi\Modules\GuestList\Models\GuestList;

class EloquentEventRepository implements EventRepositoryInterface
{
    /**
     * @var Event
     */
    private $event;

    /**
     * @var GuestList
     */
    private $guestList;

    /**
     * @var EventGuestList
     */
    private $eventGuestList;

    /**
     * @param Event
     * @param GuestList
     * @param EventGuestList
     */
    public function __construct(Event $event, GuestList $guestList, EventGuestList $eventGuestList)
    {
        $this->event = $event;
        $this->guestList = $guestList;
        $this->eventGuestList = $eventGuestList;
    }

    /**
     * Get all events by status active and date now
     *
     * @param array $payload
     * @return static
     */
    public function getEvents()
    {
        return $this->event
        /*->with(['eventGuestList' => function ($query) {
        $query->select('event_id', 'home_owner_id', 'guest_list_id', 'status');
        $query->where('status', 0);

        $query->with(['guestList' => function ($query) {
        $query->select('id', 'guest_name');
        }]);
        }])*/
            ->with(['address' => function ($query) {
                $query->select('id', 'home_owner_id', 'address');
            }]) /*
        ->with(['refCategory' => function ($query) {
        $query->select('id', 'category_name');

        }])*/
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->select('event.id', 'event.homeowner_address_id', 'home_owner_id', 'ref_category_id', 'name', 'start', 'end', 'status')
            ->join('users', 'event.home_owner_id', '=', 'users.id')
            ->where('status', 0)
            ->where('start', '=', date('Y-m-d'))
            ->orderBy('users.first_name', 'asc')
            ->get()
            ->toArray();
    }

    /**
     * * Get all events by incoming guests and needs approval
     *
     * @param array $payload
     * @return static
     */
    public function getIncomingGuestEvents($refCategoryId, $homeOwnerId)
    {
        return $this->event
            ->with(['refCategory' => function ($query) {
                $query->select('id', 'category_name');
            }])
            ->with(['eventGuestList' => function ($query) {
                $query->select('id', 'event_id', 'guest_list_id', 'status');
            }])
            ->select('id', 'home_owner_id', 'ref_category_id', 'name', 'start', 'end', 'status')
            ->where('home_owner_id', $homeOwnerId)
            ->where('ref_category_id', $refCategoryId)
            ->where('end', '>=', date('Y-m-d'))
            ->get()
            ->toArray();
    }

    /**
     * Get all events by status active and date now
     *
     * @param array $payload
     * @return static
     */
    public function getEventsByHomeOwnerId($id)
    {
        return $this->event
            ->where('home_owner_id', $id)
            ->where('status', 0)
            ->where('start', '>=', date('Y-m-d'))
            ->get()
            ->toArray();
        /*return $this->event
    ->with(['address' => function ($query) {
    $query->select('id', 'home_owner_id', 'address');
    $query->where('primary', 1);
    }])
    ->with(['user' => function ($query) {
    $query->select('id', 'first_name', 'last_name');
    }])
    ->select('id', 'home_owner_id', 'ref_category_id', 'name', 'start', 'end', 'status')
    ->where('home_owner_id', $id)
    ->where('start', '>=', date('Y-m-d'))
    ->get()
    ->toArray();*/
    }

    /**
     * Get all events by user id
     *
     * @param int $id
     * @return static
     */
    public function getEventsByUserId($id)
    {
        return $this->event
            ->where('home_owner_id', $id)
            ->where('start', '>=', date('Y-m-d'))
            ->get()
            ->toArray();
    }

    /**
     * Get a certain event
     *
     * @param array $payload
     * @return static
     */
    public function getEventById($id)
    {
        return $this->event->find($id)->toArray();
    }

    /**
     * Get event and guests
     *
     * @param array $payload
     * @return static
     */
    public function getEventAndGuests($event_id)
    {
        return $this->event
            ->with(['eventGuestList' => function ($query) {
                $query->select('guest_list_id', 'event_id', 'status');
                $query->with(['guestList' => function ($query) {
                    $query->select('id', 'guest_name');
                }]);
            }])
            ->with(['address' => function ($query) {
                $query->select('id', 'address');
            }])
            ->select('id', 'home_owner_id', 'ref_category_id', 'name', 'start', 'end', 'homeowner_address_id')
            ->where('id', $event_id)
        //->whereBetween('end', array(date($startDate), date($endDate)))
            ->where('end', '>=', date('Y-m-d'))
            ->groupBy('ref_category_id')
            ->get()
            ->toArray();
        //->whereBetween('event.end', array(date($startDate), date($endDate)))

        /*return $this->event->select('event.id',
    'event.home_owner_id',
    'event.ref_category_id',
    'event.name',
    'event.start',
    'event.end',
    'event.status',
    'event_guest_list.event_id',
    'event_guest_list.guest_list_id',
    'guest_list.id',
    'guest_list.guest_name')
    ->join('event_guest_list', 'event.id', '=', 'event_guest_list.id')
    ->join('guest_list', 'event_guest_list.guest_list_id', '=', 'guest_list.id')
    ->where('event.id', $event_id)
    ->get();*/
    }

    /**
     * Create new event and guest list
     *
     * @param array $payload
     * @return static
     */
    public function createEvent($payload)
    {
        $payload = json_decode($payload, true);

        if (!array_key_exists('event', $payload)) {
            return ['result' => 'error', 'message' => 'All fields are required.'];
        }

        if (!array_key_exists('visitors', $payload)) {
            return ['result' => 'error', 'message' => 'Visitor field is required.'];
        }

        $event = $payload['event'];

        if (!array_key_exists('end', $event)) {
            $event['end'] = $event['start'];
        }

        $eventData = array(
            'home_owner_id' => $event['home_owner_id'],
            'ref_category_id' => $event['ref_category_id'],
            'homeowner_address_id' => $event['homeowner_address_id'],
            'name' => $event['name'],
            'start' => $event['start'],
            'end' => $event['end'],
        );

        $event = $this->event->create($eventData);

        if ($event) {
            $guestListData = $payload['visitors'];

            foreach ($guestListData as $key => $value) {
                $expectedVisitorsData = array('home_owner_id' => $event['home_owner_id'], 'guest_name' => $value);
                $guestList = $this->createGuestInGuestList($expectedVisitorsData, $event->id);
            }

            if ($guestList) {
                return ['result' => 'success'];
            }
        }

        return ['result' => 'error', 'message' => 'All fields are required.'];
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
     * Update event and guest list
     *
     * @param array $payload
     * @return static
     */
    public function updateEventAndGuestList($eventId, $payload)
    {
        $payload = json_decode($payload, true);

        if (!array_key_exists('event', $payload)) {
            return ['result' => 'error', 'message' => 'All fields are required.'];
        }

        $event = $payload['event'];

        if (!array_key_exists('end', $event)) {
            $event['end'] = $event['start'];
        }

        if (array_key_exists('new_visitors', $payload)) {
            foreach ($payload['new_visitors'] as $key => $value) {
                $guestListResult = $this->guestList->create(['home_owner_id' => $event['home_owner_id'], 'guest_name' => $value]);

                $this->eventGuestList->create(['event_id' => $eventId, 'guest_list_id' => $guestListResult->id, 'home_owner_id' => $event['home_owner_id']]);
            }
        }

        $eventData = array(
            'home_owner_id' => $event['home_owner_id'],
            'ref_category_id' => $event['ref_category_id'],
            'homeowner_address_id' => $event['homeowner_address_id'],
            'name' => $event['name'],
            'start' => $event['start'],
            'end' => $event['end'],
        );

        $event = $this->event->find($eventId)->fill($eventData)->save();

        if (array_key_exists('visitors', $payload)) {
            $guestListData = $payload['visitors'];

            foreach ($guestListData as $key => $value) {

                $expectedVisitorsData = array('guest_name' => $value);

                $guestList = $this->updateGuestInGuestList($key, $expectedVisitorsData, $eventId);
            }
        }
        if (!$event) {
            return ['result' => 'error', 'message' => 'All fields are required.'];
        }

        return ['result' => 'success'];

    }

    /**
     * Update GuestList
     *
     * @param array $payload
     * @return static
     */
    public function updateGuestInGuestList($guestListId, $expectedVisitorsData, $eventId)
    {

        return $guestList = $this->guestList->find($guestListId)->fill($expectedVisitorsData)->save();
    }

    /**
     * Update a certain event
     *
     * @param array $payload
     * @return boolean
     */
    public function updateEvent($id, $payload)
    {
        return $this->event->find($id)->fill($payload)->save();
    }

    /**
     * Delete a certain event
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteEvent($id)
    {
        return $this->event->find($id)->delete();
    }
}
