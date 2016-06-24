<?php

namespace BrngyWiFi\Modules\GuestList\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\GuestList\Repository\GuestListRepositoryInterface;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

class GuestListController extends Controller
{
    /**
     * @var GuestList
     */
    protected $guestList;

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
        GuestListRepositoryInterface $guestList,
        Request $request,
        ResponseFactory $response) {
        $this->guestList = $guestList;
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

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store($eventId)
    {
        return $this->guestList->createGuestInGuestList($this->request->all(), $eventId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    public function update($id)
    {
        if ($this->guestList->updateGuestInGuestList(json_decode($this->request->getContent(), true), $id)) {
            return $this->response->make(['result' => 'success']);
        }

        return $this->response->make(['result' => 'error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    public function destroy($id)
    {
        if ($this->guestList->deleteGuestInGuestList($id)) {
            return $this->response->make(['result' => 'success']);
        }

        return $this->response->make(['result' => 'error']);
    }

    /**
     * Get all guest for home owner settings
     *
     * @param  int $homeOwnerId
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getAllGuests($homeOwnerId)
    {
        return $this->guestList->getAllGuestsForHomeowner($homeOwnerId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveGuestList($eventId)
    {
        return $this->response->make(['isSuccess' => $this->guestList->createGuestInGuestList($this->request->all(), $eventId)]);
    }
}
