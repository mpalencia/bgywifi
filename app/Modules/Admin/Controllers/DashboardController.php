<?php

namespace BrngyWiFi\Modules\Admin\Controllers;

use Auth;
use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\SuggestionComplaints\Models\SuggestionComplaints;
use DB;
use \BrngyWiFi\Modules\Admin\Models\Admin;
use \BrngyWiFi\Modules\Alerts\Models\Alerts;
use \BrngyWiFi\Modules\Caution\Models\Caution;
use \BrngyWiFi\Modules\Emergency\Models\Emergency;
use \BrngyWiFi\Modules\Event\Models\Event;
use \BrngyWiFi\Modules\Messages\Models\Messages;
use \BrngyWiFi\Modules\Notifications\Models\Notifications;
use \BrngyWiFi\Modules\RefCategory\Models\RefCategory;
use \BrngyWiFi\Modules\User\Models\User;

class DashboardController extends Controller
{

    private $user;
    protected $response;
    public function dashboard()
    {
        $limit = 5;

        $data['residentials'] = DB::table('users')
            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id', '=', 3)
            ->orderBy('users.id', 'DESC')
            ->get();

        $data['alerts'] = DB::table('emergency')->count() + DB::table('caution')->count();

        $data['emergencyCount'] = DB::table('emergency')
            ->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
            ->where('status', '=', 0)->count();

        $data['cautionCount'] = DB::table('caution')
            ->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
            ->where('status', '=', 0)->count();

        $data['issuesCount'] = DB::table('suggestion_complaints')
            ->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
            ->where('resolved', '=', 0)->count();

        $data['emergency'] = DB::table('emergency')
            ->select(
                'emergency.home_owner_id',
                'emergency.emergency_type_id',
                'emergency.homeowner_address_id',
                'emergency.status',
                'emergency.created_at',
                'users.first_name',
                'users.last_name',
                'emergency_type.id as etid',
                'emergency_type.description',
                'homeowner_address.home_owner_id as hahoi',
                'homeowner_address.address',
                'homeowner_address.latitude',
                'homeowner_address.longitude'
            )
            ->join('users', 'emergency.home_owner_id', '=', 'users.id')
            ->join('emergency_type', 'emergency.emergency_type_id', '=', 'emergency_type.id')
            ->join('homeowner_address', 'emergency.homeowner_address_id', '=', 'homeowner_address.id')
        //->where('emergency.status', '=', 0)
            ->where('homeowner_address.primary', '=', 1)
        //->whereBetween('emergency.created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
            ->orderBy('emergency.created_at', 'DESC')
            ->limit(10)
            ->get();

        $data['caution'] = DB::table('caution')
            ->select(
                'caution.home_owner_id',
                'caution.caution_type_id',
                'caution.homeowner_address_id',
                'caution.status',
                'caution.created_at',
                'users.first_name',
                'users.last_name',
                'caution_type.id as etid',
                'caution_type.description',
                'homeowner_address.home_owner_id as hahoi',
                'homeowner_address.address',
                'homeowner_address.latitude',
                'homeowner_address.longitude'
            )
            ->join('users', 'caution.home_owner_id', '=', 'users.id')
            ->join('caution_type', 'caution.caution_type_id', '=', 'caution_type.id')
            ->join('homeowner_address', 'caution.homeowner_address_id', '=', 'homeowner_address.id')
        //->where('caution.status', '=', 0)
            ->where('homeowner_address.primary', '=', 1)
        //->whereBetween('caution.created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
            ->orderBy('caution.created_at', 'DESC')
            ->limit(10)
            ->get();

        $data['issues'] = DB::table('suggestion_complaints')->count();

        $data['issue'] = DB::table('suggestion_complaints')
            ->select('suggestion_complaints.*', 'homeowner_address.home_owner_id', 'homeowner_address.address', 'users.id', 'users.first_name', 'users.last_name')
            ->join('users', 'suggestion_complaints.home_owner_id', '=', 'users.id')
            ->join('homeowner_address', 'suggestion_complaints.home_owner_id', '=', 'homeowner_address.home_owner_id')
            ->where('homeowner_address.primary', '=', 1)
            ->orderBy('suggestion_complaints.created_at', 'DESC')
            ->limit(10)
            ->get();

        /*echo "<pre>";
        print_r($data['emergency']);die;*/
        $data['security'] = DB::table('users')
            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id', '=', 2)
            ->orderBy('users.id', 'DESC')
            ->get();

        $data['all_events'] = DB::table('event')
            ->select('event.*', 'event.id AS eid', 'users.*')
            ->join('users', 'event.home_owner_id', '=', 'users.id')
            ->where('event.status', '=', 0)
            ->where('event.end', '>=', date('Y-m-d'))
            ->whereNull('event.deleted_at')
            ->orderBy('event.id', 'DESC')
            ->get();

        $data['events'] = DB::table('event')
            ->select('event.*', 'event.id AS eid', 'users.id AS uid', 'users.first_name', 'users.last_name', 'homeowner_address.*')
            ->join('users', 'event.home_owner_id', '=', 'users.id')
            ->join('homeowner_address', 'event.home_owner_id', '=', 'homeowner_address.home_owner_id')
            ->where('event.status', '=', 0)
            ->where('event.end', '>=', date('Y-m-d'))
            ->whereNull('event.deleted_at')
            ->take($limit)
            ->orderBy('event.start', 'DESC')
        //->groupBy('homeowner_address.home_owner_id')
            ->limit(10)
            ->get();

        $data['expecting_visitors'] = DB::table('event_guest_list')
            ->join('guest_list', 'guest_list.id', '=', 'event_guest_list.guest_list_id')
            ->join('users', 'users.id', '=', 'event_guest_list.home_owner_id')
            ->join('homeowner_address', 'event_guest_list.home_owner_id', '=', 'homeowner_address.home_owner_id')
            ->where(array('homeowner_address.primary' => 1))
            ->orderBy('event_guest_list.created_at', 'DESC')
            ->limit(10)
            ->get();

        $data['event_visitors'] = DB::table('event_guest_list')
            ->join('guest_list', 'guest_list.id', '=', 'event_guest_list.guest_list_id')
            ->join('users', 'users.id', '=', 'event_guest_list.home_owner_id')
            ->join('homeowner_address', 'event_guest_list.home_owner_id', '=', 'homeowner_address.home_owner_id')
            ->join('event', 'event.id', '=', 'event_guest_list.event_id')
            ->select('event_guest_list.*', 'guest_list.*', 'users.*', 'homeowner_address.*', 'event.id', 'event.start')
            ->where(array('homeowner_address.primary' => 1))
            ->take($limit)
            ->orderBy('event.start', 'DESC')
            ->limit(10)
            ->get();

        /*$data['unexpected_visitors'] = DB::table('notifications')
        ->join('visitors', 'visitors.id', '=', 'notifications.visitors_id')
        ->join('users', 'users.id', '=', 'notifications.approved_by')
        ->join('homeowner_address', 'notifications.home_owner_id', '=', 'homeowner_address.home_owner_id')
        ->where(array('homeowner_address.primary' => 1))
        ->take(10)
        ->orderBy('notifications.created_at', 'DESC')
        ->get();*/
        $data['unexpected_visitors'] = Notifications::with(['visitors' => function ($query) {

        }])
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->with(['approved' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->with(['homeOwnerAddress' => function ($query) {
                $query->select('id', 'address');
                //$query->where('primary', 1);
            }])
            ->limit(10)
            ->orderBy('created_at')
            ->get();

        $data['unexpected_visitors_count'] = DB::table('notifications')
            ->join('visitors', 'visitors.id', '=', 'notifications.visitors_id')
            ->join('users', 'users.id', '=', 'notifications.home_owner_id')
            ->join('homeowner_address', 'notifications.homeowner_address_id', '=', 'homeowner_address.id')
        //->where(array( /*'notifications.status' => 1,*/'homeowner_address.primary' => 1))
            ->count();

        $data['categories'] = RefCategory::get();

        $data['unread_msg'] = Messages::select('messages.*', 'messages.id AS mid', 'messages.created_at AS datesent', 'users.*')
            ->join('users', 'messages.from_user_id', '=', 'users.id')
            ->where(array('users.id' => Auth::user()->id, 'messages.status' => 1))
            ->limit(5)
            ->orderBy('messages.id', 'DESC')
            ->get();

        return view('Admin::dashboard', $data);
    }

    public function getEventsLongLat()
    {
        $events = Event::select('event.*', 'event.id AS eid', 'users.id AS uid', 'users.first_name', 'users.last_name', 'homeowner_address.*')
            ->join('users', 'event.home_owner_id', '=', 'users.id')
            ->join('homeowner_address', 'event.homeowner_address_id', '=', 'homeowner_address.id')
            ->where('event.status', '=', 0)
        // ->where('homeowner_address.primary', '=', 1)
            ->where('event.start', '>=', date('Y-m-d'))
            ->orderBy('event.id', 'DESC')
            ->get()
            ->toArray();

        return array_map(function ($structure) use ($events) {
            return [
                'category' => $structure['ref_category_id'],
                'latitude' => $structure['latitude'],
                'longitude' => $structure['longitude'],
                'homeowner_name' => $structure['first_name'] . ' ' . $structure['last_name'],
                'homeowner_address' => $structure['address'],
            ];
        }, $events);
    }

    public function getAllAlertCount()
    {
        $emergencies = Emergency::select('emergency_type.*', 'emergency.*', 'emergency.id AS eid', 'users.id AS uid', 'users.first_name', 'users.last_name', 'homeowner_address.*')
            ->join('users', 'emergency.home_owner_id', '=', 'users.id')
            ->join('homeowner_address', 'emergency.homeowner_address_id', '=', 'homeowner_address.id')
            ->join('emergency_type', 'emergency.emergency_type_id', '=', 'emergency_type.id')
        //->where('homeowner_address.primary', '=', 1)
        //->whereBetween('emergency.created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
            ->where('emergency.status', 0)
            ->orderBy('emergency.created_at', 'DESC')
            ->get()
            ->toArray();

        $e = array_map(function ($structure) use ($emergencies) {
            return [
                'latitude' => $structure['latitude'],
                'longitude' => $structure['longitude'],
                'homeowner_name' => $structure['first_name'] . ' ' . $structure['last_name'],
                'homeowner_address' => $structure['address'],
                'emergency_type' => $structure['description'],
            ];
        }, $emergencies);

        //CAUTION
        $caution = Caution::select('caution_type.*', 'caution.*', 'caution.id AS eid', 'users.id AS uid', 'users.first_name', 'users.last_name', 'homeowner_address.*')
            ->join('users', 'caution.home_owner_id', '=', 'users.id')
            ->join('homeowner_address', 'caution.homeowner_address_id', '=', 'homeowner_address.id')
            ->join('caution_type', 'caution.caution_type_id', '=', 'caution_type.id')
        //->where('homeowner_address.primary', '=', 1)
        //->whereBetween('caution.created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
            ->where('caution.status', 0)
            ->orderBy('caution.created_at', 'DESC')
            ->get()
            ->toArray();

        $c = array_map(function ($structure) use ($caution) {
            return [
                'latitude' => $structure['latitude'],
                'longitude' => $structure['longitude'],
                'homeowner_name' => $structure['first_name'] . ' ' . $structure['last_name'],
                'homeowner_address' => $structure['address'],
                'caution_type' => $structure['description'],
            ];
        }, $caution);

        //ISSUES
        $issues = SuggestionComplaints::select('suggestion_complaints.*', 'suggestion_complaints.id AS scid', 'users.id AS uid', 'users.first_name', 'users.last_name', 'homeowner_address.*')
            ->join('users', 'suggestion_complaints.home_owner_id', '=', 'users.id')
            ->join('homeowner_address', 'suggestion_complaints.home_owner_id', '=', 'homeowner_address.home_owner_id')
            ->where('homeowner_address.primary', '=', 1)
        //->whereBetween('suggestion_complaints.created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
            ->where('suggestion_complaints.resolved', 0)
            ->orderBy('suggestion_complaints.created_at', 'DESC')
            ->get()
            ->toArray();

        $i = array_map(function ($structure) use ($issues) {
            switch ($structure['issue_type']) {
                case '1':
                    $issue_type = 'Suggestion';
                    break;
                case '2':
                    $issue_type = 'Complaint';
                    break;
                default:
                    $issue_type = 'Issue';
                    break;
            }
            return [
                'latitude' => $structure['latitude'],
                'longitude' => $structure['longitude'],
                'homeowner_name' => $structure['first_name'] . ' ' . $structure['last_name'],
                'homeowner_address' => $structure['address'],
                'issue_type' => $issue_type,
            ];
        }, $issues);

        //UNIDENTIFIED
        $unidentified = Alerts::select('alerts.*', 'alerts.id AS scid', 'users.id AS uid', 'users.first_name', 'users.last_name', 'homeowner_address.*')
            ->join('users', 'alerts.home_owner_id', '=', 'users.id')
            ->join('homeowner_address', 'alerts.homeowner_address_id', '=', 'homeowner_address.id')
        //->where('homeowner_address.primary', '=', 1)
            ->where('alerts.status', '=', 0)
        //->whereBetween('alerts.created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
            ->orderBy('alerts.created_at', 'DESC')
            ->get()
            ->toArray();

        $u = array_map(function ($structure) use ($unidentified) {
            return [
                'latitude' => $structure['latitude'],
                'longitude' => $structure['longitude'],
                'homeowner_name' => $structure['first_name'] . ' ' . $structure['last_name'],
                'homeowner_address' => $structure['address'],
            ];
        }, $unidentified);

        return ['emergency' => $e, 'caution' => $c, 'issues' => $i, 'unidentified' => $u];
    }

    /*public function getEmergency()
    {
    $emergencies = Emergency::select('emergency.*', 'emergency.id AS eid', 'users.id AS uid', 'users.first_name', 'users.last_name', 'homeowner_address.*')
    ->join('users', 'emergency.home_owner_id', '=', 'users.id')
    ->join('homeowner_address', 'emergency.home_owner_id', '=', 'homeowner_address.home_owner_id')
    ->where('homeowner_address.primary', '=', 1)
    ->whereBetween('emergency.created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
    ->orderBy('emergency.created_at', 'DESC')
    ->get()
    ->toArray();

    return array_map(function ($structure) use ($emergencies) {
    return [
    'latitude' => $structure['latitude'],
    'longitude' => $structure['longitude'],
    'homeowner_name' => $structure['first_name'] . ' ' . $structure['last_name'],
    'homeowner_address' => $structure['address'],
    ];
    }, $emergencies);
    }

    public function getCaution()
    {
    $caution = Caution::select('caution.*', 'caution.id AS eid', 'users.id AS uid', 'users.first_name', 'users.last_name', 'homeowner_address.*')
    ->join('users', 'caution.home_owner_id', '=', 'users.id')
    ->join('homeowner_address', 'caution.home_owner_id', '=', 'homeowner_address.home_owner_id')
    ->where('homeowner_address.primary', '=', 1)
    ->whereBetween('caution.created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
    ->orderBy('caution.created_at', 'DESC')
    ->get()
    ->toArray();

    return array_map(function ($structure) use ($caution) {
    return [
    'latitude' => $structure['latitude'],
    'longitude' => $structure['longitude'],
    'homeowner_name' => $structure['first_name'] . ' ' . $structure['last_name'],
    'homeowner_address' => $structure['address'],
    ];
    }, $caution);
    }

    public function getIssues()
    {
    $issues = SuggestionComplaints::select('suggestion_complaints.*', 'suggestion_complaints.id AS scid', 'users.id AS uid', 'users.first_name', 'users.last_name', 'homeowner_address.*')
    ->join('users', 'suggestion_complaints.home_owner_id', '=', 'users.id')
    ->join('homeowner_address', 'suggestion_complaints.home_owner_id', '=', 'homeowner_address.home_owner_id')
    ->where('homeowner_address.primary', '=', 1)
    ->whereBetween('suggestion_complaints.created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
    ->orderBy('suggestion_complaints.created_at', 'DESC')
    ->get()
    ->toArray();

    return array_map(function ($structure) use ($issues) {
    return [
    'latitude' => $structure['latitude'],
    'longitude' => $structure['longitude'],
    'homeowner_name' => $structure['first_name'] . ' ' . $structure['last_name'],
    'homeowner_address' => $structure['address'],
    ];
    }, $issues);
    }

    public function getUnidentifiedAlerts()
    {
    $unidentified = Alerts::select('alerts.*', 'alerts.id AS scid', 'users.id AS uid', 'users.first_name', 'users.last_name', 'homeowner_address.*')
    ->join('users', 'alerts.home_owner_id', '=', 'users.id')
    ->join('homeowner_address', 'alerts.home_owner_id', '=', 'homeowner_address.home_owner_id')
    ->where('homeowner_address.primary', '=', 1)
    ->whereBetween('alerts.created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
    ->orderBy('alerts.created_at', 'DESC')
    ->get()
    ->toArray();

    return array_map(function ($structure) use ($unidentified) {
    return [
    'latitude' => $structure['latitude'],
    'longitude' => $structure['longitude'],
    'homeowner_name' => $structure['first_name'] . ' ' . $structure['last_name'],
    'homeowner_address' => $structure['address'],
    ];
    }, $unidentified);
    }*/

    public function getAlertsCount()
    {
        $data['emergencyCount'] = DB::table('emergency')
        //->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
            ->where('status', 0)
            ->whereNull('end_date')
            ->count();

        $data['cautionCount'] = DB::table('caution')
        //->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
            ->where('status', 0)
            ->whereNull('end_date')
            ->count();

        $data['issuesCount'] = DB::table('suggestion_complaints')
        //->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
            ->where('resolved', 0)
            ->whereNull('end_date')
            ->count();

        $data['unidentifiedAlertsCount'] = DB::table('alerts')
            ->where('status', 0)
        //->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
            ->count();

        return ['data' => $data];
    }

    public function getTotalAlerts()
    {
        return [
            'alerts' => DB::table('emergency')->count() + DB::table('caution')->count() + DB::table('alerts')->where('status', 0)->count(),
            'issues' => DB::table('suggestion_complaints')->count(),
            'events' => DB::table('event')->where('event.end', '>=', date('Y-m-d'))->whereNull('deleted_at')->count(),
            'unexpected_guests' => DB::table('notifications')->count(),
        ];
    }

    public function getEventCount()
    {
        $categories = RefCategory::get();

        $category = [];

        foreach ($categories as $key => $value) {
            $category[str_replace(' ', '_', strtolower($value['category_name']))]['count'] = DB::table('event')->where('start', '>=', date('Y-m-d'))->where(array('ref_category_id' => $value['id'], 'status' => 0))->whereNull('deleted_at')->count();
            $category[str_replace(' ', '_', strtolower($value['category_name']))]['category_name'] = $value['category_name'];
        }

        return $category;
    }
}
