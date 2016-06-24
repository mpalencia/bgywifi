<?php

namespace BrngyWiFi\Modules\Admin\Controllers;

use Auth;
use BrngyWiFi\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use \BrngyWiFi\Modules\Admin\Models\Admin;
use \BrngyWiFi\Modules\Event\Models\Event;
use \BrngyWiFi\Modules\Messages\Models\Messages;
use \BrngyWiFi\Modules\User\Models\User;

class EventController extends Controller
{

    private $user;

    protected $response;

    public function __construct(ResponseFactory $response)
    {
        $this->response = $response;

    }
    public function events($view = 'events', $residentialId = null)
    {
        $where = array('event.status' => 0);
        if (isset($residentialId)) {
            $where = array('event.status' => 0, 'event.home_owner_id' => $residentialId);
            $data['residential_name'] = User::where(array('id' => $residentialId))->first();
        }

        $data['events'] = Event::select('event.*', 'event.id AS eid', 'users.*', 'ref_category.*', 'event_guest_list.*', 'guest_list.*')
            ->join('users', 'event.home_owner_id', '=', 'users.id')
            ->join('ref_category', 'event.ref_category_id', '=', 'ref_category.id')
            ->join('event_guest_list', 'event.id', '=', 'event_guest_list.event_id')
            ->join('guest_list', 'event_guest_list.guest_list_id', '=', 'guest_list.id')
        //->where($where)
            ->where('event.end', '>=', date('Y-m-d'))
        //->orderBy('users.first_name', 'ASC')
            ->orderBy('event.start', 'DESC')
            ->get();

        $data['unread_msg'] = Messages::select('messages.*', 'messages.id AS mid', 'messages.created_at AS datesent', 'users.*')
            ->join('users', 'messages.from_user_id', '=', 'users.id')
            ->where(array('users.id' => Auth::user()->id, 'messages.status' => 1))
            ->limit(5)
            ->orderBy('messages.id', 'DESC')
            ->get();
        //dd($data);
        return view('Admin::' . $view, $data);
    }

    public function events_by_residential()
    {

        $data['events'] = Event::select('event.*', 'event.id AS eid', 'users.*', 'ref_category.*')
            ->join('users', 'event.home_owner_id', '=', 'users.id')
            ->join('ref_category', 'event.ref_category_id', '=', 'ref_category.id')
            ->where(array('status' => 0))
            ->orderBy('users.first_name', $orderBy)
            ->get();

        //dd($data);
        return view('Admin::' . $view, $data);
    }

    public function active_events(Request $request)
    {

        $data['events'] = Event::where(array('status' => 0))->get();
        return $data;
    }
    public function addEvent(Request $request)
    {
        $output = array('msg' => 'error', 'msgCode' => 0);

        $data = array(
            'home_owner_id' => $request->input('home_owner_id'),
            'name' => $request->input('name'),
            'start' => $request->input('start'),
            'end' => $request->input('end'),
            'status' => $request->input('status'),
        );
        $checkEvent = Event::where(array('name' => $data['name'], 'home_owner_id' => $data['home_owner_id']))->first();
        if (is_null($checkEvent)) {
            $event = Event::create($data);

            //dd($user);
            if ($event) {
                $output = array('msg' => 'New event has been added to residential account', 'msgCode' => 1);
            }
        } else {
            $output = array('msg' => 'Event is already exist on this residential account', 'msgCode' => 0);
        }

        return $output;
    }

    public function editEvent(Request $request)
    {
        $output = array('msg' => 'error', 'msgCode' => 0);

        $data = array(
            'home_owner_id' => $request->input('home_owner_id'),
            'name' => $request->input('name'),
            'start' => $request->input('start'),
            'end' => $request->input('end'),
            'status' => $request->input('status'),
        );

        $checkEvent = Event::where(array('id' => $data['id']))->first();
        if (is_null($checkEvent)) {
            $output = array('msg' => 'Event account not found.', 'msgCode' => 0);
        } else {
            $event = Event::find($data['id']);

            $event->home_owner_id = $data['home_owner_id'];
            $event->name = $data['name'];
            $event->start = $data['start'];
            $event->end = $data['end'];
            $event->status = $data['status'];

            $result = $event->save();

            if ($result) {
                $output = array('msg' => 'Event has been updated on this residential account.', 'msgCode' => 1);
            }
        }

        return $output;
    }

    public function deleteEvent(Request $request)
    {
        $eventId = $request->input('id');
        $isDeleted = Event::where('id', $eventId)->delete();

        $output = array('msg' => 'Failed to delete event.', 'msgCode' => 0);
        if ($isDeleted) {
            $output = array('msg' => 'Event has been deleted.', 'msgCode' => 1);
        }

        return $output;
    }

}
