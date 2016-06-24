<?php

namespace BrngyWiFi\Modules\Event\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\Event\Repository\EventRepositoryInterface;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * @var Event
     */
    protected $event;

    /**
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $response;

    /**
     * @param Event $event
     * @param Request $request
     * @param ResponseFactory $response
     */
    public function __construct(
        EventRepositoryInterface $event,
        Request $request,
        ResponseFactory $response) {
        $this->event = $event;
        $this->request = $request;
        $this->response = $response;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->event->getEvents();
    }

    public function getIncomingGuestEvents($refCategoryId, $homeOwnerId)
    {
        return $this->event->getIncomingGuestEvents($refCategoryId, $homeOwnerId);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEvent($id)
    {
        return $this->event->getEventById($id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEventsByHomeOwnerId($id)
    {
        return $this->event->getEventsByHomeOwnerId($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Event
     */
    public function store()
    {
        return $this->event->createEvent($this->request->getContent());
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory;
     */
    public function update($id)
    {
        return $this->event->updateEventAndGuestList($id, $this->request->getContent());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory;
     */
    public function destroy($id)
    {
        if ($this->event->deleteEvent($id)) {
            return $this->response->make(['result' => 'success']);
        }

        return $this->response->make(['result' => 'error']);
    }

    /**
     * Get events by user id
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory;
     */
    public function getEventsByUserId($id)
    {
        return $this->event->getEventsByUserId($id);
    }

    /**
     * Get event and guests
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory;
     */
    public function getEventAndGuests($event_id)
    {
        return $this->event->getEventAndGuests($event_id);
    }

}
