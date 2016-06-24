<?php

namespace BrngyWiFi\Modules\EventGuestList\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\EventGuestList\Repository\EventGuestListRepositoryInterface;
use BrngyWiFi\Modules\Event\Models\Event;
use BrngyWiFi\Modules\RefCategory\Models\RefCategory;
use BrngyWiFi\Services\Curl\SendNotification;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

class EventGuestListController extends Controller
{
    /**
     * @var EventGuestList
     */
    protected $eventGuestList;

    /**
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $response;

    /**
     * @param EventGuestList $eventGuestList
     * @param Request $request
     * @param ResponseFactory $response
     */
    public function __construct(
        EventGuestListRepositoryInterface $eventGuestList,
        Request $request,
        ResponseFactory $response) {
        $this->eventGuestList = $eventGuestList;
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($guestListId)
    {
        return $this->response->make(['isSuccess' => $this->eventGuestList->updateEventGuestListById($guestListId)]);
    }

    /**
     * Get EventGuestList and guest list
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEventGuestListByEventId($eventId, $homeOwnerId)
    {
        return $this->eventGuestList->getEventGuestListByEventId($eventId, $homeOwnerId);
    }

    /**
     * Get guests in guest list by event id and homeowner id
     *
     * @param  int  $eventId
     * @param  int  $homeOwnerId
     * @return \Illuminate\Http\Response
     */
    public function getEventGuestList($eventId, $homeOwnerId)
    {
        return $this->eventGuestList->getEventGuestList($eventId, $homeOwnerId);
    }

    /**
     * Get guests in guest list by homeowner id for homeowner's notifications
     *
     * @param  int  $homeOwnerId
     * @return \Illuminate\Http\Response
     */
    public function getNotificationsEventGuestList($homeOwnerId)
    {
        return $this->eventGuestList->getNotificationsEventGuestList($homeOwnerId);
    }

    /**
     * Send Notification to Home Owner
     * -incoming exptected visitors
     *
     * @param Request $request
     * @param BrngyWiFi\Services\Curl\SendNotification $curl
     * @return Illuminate\Http\JsonResponse
     */
    public function sendIncomingVisitorsToHomeOwner($home_owner_id, $event_id, Request $request, SendNotification $curl)
    {
        $event = Event::find($event_id);
        $ref_category = RefCategory::find($event->ref_category_id);

        $fields = array(
            'app_id' => \Config::get('onesignal.' . 'brgyWifi.' . 'app-id'),
            'tags' => array(array('key' => 'userId', 'relation' => '=', 'value' => $home_owner_id)),
            'contents' => ["en" => 'Visitors are coming!' . "\n\n" . 'Purpose of Visit: ' . $ref_category->category_name],
            'data' => ['guests' => json_decode($request->getContent(), true), 'additionalData' => 'message_from_admin'],
            'android_group' => 'BRGY Comms',
        );

        if ($this->eventGuestList->updateEventGuestList($request->getContent())) {
            $response = $curl->call(json_encode($fields));

            if (array_key_exists('errors', json_decode($response, true))) {
                return $this->response->make(['result' => 'error']);
            }

            return $this->response->make(['result' => 'success']);
        }

        return $this->response->make(['result' => 'error']);
    }

    private function buildVisitorData($guests)
    {
        $visitorsInfo = $this->eventGuestList->getEventGuestListById($guests);

        $visitor = array_map(function ($structure) use ($visitorsInfo) {
            return [
                'guests' => $structure,
            ];
        }, $visitorsInfo);

        return ['en' => $visitor['guest_list']['guests']['guest_name'] . 'is coming'];
    }

    /**
     * Get all guests in village
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllGuestsAndVisitors()
    {
        $allGuests = $this->eventGuestList->getAllGuestsAndVisitors();

        $visitor = array_map(function ($structure) use ($allGuests) {
            $address = str_replace(" ", "+", $structure['homeowner']['address']);
            $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=$address";
            $response = file_get_contents($url);
            $json = json_decode($response, true);
            return [
                'guest' => $structure,
                'lat' => $json['results'][0]['geometry']['location']['lat'],
                'lng' => $json['results'][0]['geometry']['location']['lng'],
                'numberOfVisitors' => count($structure),
            ];
        }, $allGuests);

        return $visitor;
    }

    /**
     * Get all guests in village
     *
     * @return \Illuminate\Http\Response
     */
    public function getIncomingGuestsByEvents($event_id, $home_owner_id)
    {
        return $this->eventGuestList->getIncomingGuestsByEvents($event_id, $home_owner_id);
    }

    /**
     * Update status of EventGuestList to 2 - Homeowner confirmed the incoming guests.
     *
     * @param array $guestListIds
     * @return boolean
     */
    public function updateAllEventGuestListStatus($homeOwnerId, Request $request)
    {
        return $this->eventGuestList->updateAllEventGuestListStatus($homeOwnerId, $request->getContent());
    }
}
