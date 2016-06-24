<?php

namespace BrngyWiFi\Modules\Admin\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\ActionTaken\Models\ActionTaken;
use BrngyWiFi\Modules\Caution\Models\Caution;
use BrngyWiFi\Modules\Emergency\Models\Emergency;
use BrngyWiFi\Modules\EventGuestList\Models\EventGuestList;
use BrngyWiFi\Modules\Notifications\Models\Notifications;
use BrngyWiFi\Modules\SuggestionComplaints\Models\SuggestionComplaints;
use BrngyWiFi\Modules\User\Models\User;
use BrngyWiFi\Services\Reports\GenerateReport;
use DateTime;
use Illuminate\Http\Request;
use \BrngyWiFi\Modules\UserRoles\Models\UserRoles;

class ReportsController extends Controller
{
    private $request;

    private $generateReport;

    private $emergency;

    private $caution;

    private $notifications;

    private $eventGuestList;

    private $suggestionComplaints;

    private $user;

    private $userRoles;

    public function __construct(
        Request $request,
        GenerateReport $generateReport,
        Emergency $emergency,
        Caution $caution,
        Notifications $notifications,
        ActionTaken $actionTaken,
        EventGuestList $eventGuestList,
        SuggestionComplaints $suggestionComplaints,
        User $user,
        UserRoles $userRoles
    ) {
        $this->request = $request;
        $this->generateReport = $generateReport;
        $this->emergency = $emergency;
        $this->caution = $caution;
        $this->notifications = $notifications;
        $this->actionTaken = $actionTaken;
        $this->eventGuestList = $eventGuestList;
        $this->suggestionComplaints = $suggestionComplaints;
        $this->user = $user;
        $this->userRoles = $userRoles;
    }

    public function index()
    {
        return view('Admin::reports');
    }

    public function generateReport()
    {
        $start_date = $this->request->start_date;
        $end_date = $this->request->end_date;

        /*$emergencyReport = $this->actionTaken
        ->with(['homeOwner' => function ($query) {
        $query->select('id', 'first_name', 'last_name');
        }])
        ->with(['security' => function ($query) {
        $query->select('id', 'first_name', 'last_name');
        }])
        ->with(['emergency' => function ($query) {
        $query->select('id', 'emergency_type_id', 'homeowner_address_id', 'home_owner_id');

        $query->with(['homeownerAddress' => function ($query) {
        $query->select('id', 'address', 'home_owner_id');
        }]);

        $query->with(['emergencyType' => function ($query) {
        $query->select('id', 'description');
        }]);
        }])
        ->with(['actionTakenType' => function ($query) {
        $query->select('id', 'message');
        }])
        ->where('caution_id', null)
        ->whereBetween('created_at', array(new \DateTime($start_date . ' 00:00:00'), new \DateTime($end_date . ' 24:00:00')))
        ->orderBy('created_at')
        ->get()
        ->toArray();

        $emergency = array_map(function ($structure) use ($emergencyReport) {
        return [
        'Emergency Type' => $structure['emergency']['emergency_type']['description'],
        'Home Owner Name' => $structure['home_owner']['first_name'] . ' ' . $structure['home_owner']['last_name'],
        'Home Owner Address' => $structure['emergency']['homeowner_address']['address'],
        'Action Taken' => $structure['action_taken_type']['message'],
        'Reported By' => $structure['security']['first_name'] . ' ' . $structure['security']['last_name'],
        'Date' => date_format(date_create($structure['created_at']), "M d, Y"),
        'Time' => date_format(date_create($structure['created_at']), "H:i A"),
        ];
        }, $emergencyReport);*/
/*
$emergency = $this->emergency
->with(['emergencyType' => function ($query) {
$query->select('id', 'description');
}])
->with(['homeowner_address' => function ($query) {
$query->select('id', 'address', 'home_owner_id');
}])
->with(['user' => function ($query) {
$query->select('id', 'first_name', 'last_name');
}])
->with(['actionTaken' => function ($query) {
$query->with(['actionTakenType' => function ($query) {
$query->select('id', 'message');
}]);
}])
->select()
->get()
->toArray();*/

        /*$emergencyReport = $this->user
        ->with(['emergency' => function ($query) {
        $query->with(['actionTakenType' => function ($query) {
        $query->select('id', 'message');
        }]);
        }])
        ->with(['homeownerAddress' => function ($query) {
        $query->select('id', 'address', 'home_owner_id');
        }])
        ->select('id', 'first_name', 'last_name', 'created_at')
        ->get()
        ->toArray();*/

        $emergencyReport = $this->userRoles
            ->with(['user' => function ($query) use ($start_date, $end_date) {
                $query->select('id', 'first_name', 'last_name');

                $query->with(['emergency' => function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('created_at', array(new \DateTime($start_date . ' 00:00:00'), new \DateTime($end_date . ' 24:00:00')));
                }]);
                $query->with(['homeownerAddress' => function ($query) {
                    $query->select('id', 'address', 'home_owner_id');
                }]);
            }])
            ->select('user_id', 'role_id')
            ->where('role_id', 3)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        $cautionReport = $this->userRoles
            ->with(['user' => function ($query) use ($start_date, $end_date) {
                $query->select('id', 'first_name', 'last_name');

                $query->with(['caution' => function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('created_at', array(new \DateTime($start_date . ' 00:00:00'), new \DateTime($end_date . ' 24:00:00')));
                }]);
                $query->with(['homeownerAddress' => function ($query) {
                    $query->select('id', 'address', 'home_owner_id');
                }]);
            }])
            ->select('user_id', 'role_id')
            ->where('role_id', 3)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        $issuesReport = $this->userRoles
            ->with(['user' => function ($query) use ($start_date, $end_date) {
                $query->select('id', 'first_name', 'last_name');

                $query->with(['issues' => function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('created_at', array(new \DateTime($start_date . ' 00:00:00'), new \DateTime($end_date . ' 24:00:00')));
                }]);
            }])
            ->select('user_id', 'role_id')
            ->where('role_id', 3)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        $emergency = array_map(function ($structure) use ($emergencyReport) {

            $ctr = 0;

            $averageResolutionTime = '';
            $totalAverageResolutionTime = '';
            $days = 00;
            $hours = 00;
            $minutes = 00;

            if (!empty($structure['user']['emergency'])) {

                foreach ($structure['user']['emergency'] as $key => $value) {

                    if ($value['status'] == 1) {
                        $ctr = $ctr + 1;
                        $start = new \DateTime($value['created_at']);
                        $end = new \DateTime($value['end_date']);
                        $parts = explode(':', $start->diff($end)->format('%D:%H:%I'));

                        $days = $days + $parts[0];
                        $hours = $hours + $parts[1];
                        $minutes = $minutes + $parts[2];
                        if ($hours >= 24) {
                            $days = $days + 1;
                            $hours = $hours - 24;
                        }

                        if ($minutes >= 60) {
                            $hours = $hours + 1;
                            $minutes = $minutes - 60;
                        }
                    }
                }

                $totalAverageResolutionTime = $days . ' day(s) ' . $hours . ' hour(s) ' . $minutes . ' minutes';

                return [
                    'Homeowner' => $structure['user']['first_name'] . ' ' . $structure['user']['last_name'],
                    'Address' => $structure['user']['homeowner_address'][0]['address'],
                    'Emergency Logged' => count($structure['user']['emergency']),
                    'Emergency Resolved' => $ctr,
                    '% Emergency Resolved' => number_format($ctr / count($structure['user']['emergency']) * 100, 2, '.', '') . '%',
                    'Ave. Resolution Time' => $totalAverageResolutionTime,
                ];
            }

        }, $emergencyReport);

        $caution = array_map(function ($structure) use ($cautionReport) {

            $ctrCaution = 0;

            $averageResolutionTime = '';
            $totalAverageResolutionTime = '';
            $days = 00;
            $hours = 00;
            $minutes = 00;

            if (!empty($structure['user']['caution'])) {

                foreach ($structure['user']['caution'] as $key => $value) {

                    if ($value['status'] == 1) {
                        $ctrCaution = $ctrCaution + 1;

                        $start = new \DateTime($value['created_at']);
                        $end = new \DateTime($value['end_date']);

                        $parts = explode(':', $start->diff($end)->format('%D:%H:%I'));

                        $days = $days + $parts[0];
                        $hours = $hours + $parts[1];
                        $minutes = $minutes + $parts[2];
                        if ($hours >= 24) {
                            $days = $days + 1;
                            $hours = $hours - 24;
                        }

                        if ($minutes >= 60) {
                            $hours = $hours + 1;
                            $minutes = $minutes - 60;
                        }
                    }
                }

                $totalAverageResolutionTime = $days . ' day(s) ' . $hours . ' hour(s) ' . $minutes . ' minutes';

                return [
                    'Homeowner' => $structure['user']['first_name'] . ' ' . $structure['user']['last_name'],
                    'Address' => $structure['user']['homeowner_address'][0]['address'],
                    'Caution Logged' => count($structure['user']['caution']),
                    'Cation Resolved' => $ctrCaution,
                    '% Emergency Resolved' => number_format($ctrCaution / count($structure['user']['caution']) * 100, 2, '.', '') . '%',
                    'Ave. Resolution Time' => $totalAverageResolutionTime,
                ];
            }

        }, $cautionReport);

        $issues = array_map(function ($structure) use ($issuesReport) {

            $ctrIssues = 0;
            $days = 00;
            $hours = 00;
            $minutes = 00;
            if (!empty($structure['user']['issues'])) {
                foreach ($structure['user']['issues'] as $key => $value) {
                    if ($value['resolved'] == 1) {
                        $ctrIssues = $ctrIssues + 1;

                        $start = new \DateTime($value['created_at']);
                        $end = new \DateTime($value['end_date']);

                        $parts = explode(':', $start->diff($end)->format('%D:%H:%I'));

                        $days = $days + $parts[0];
                        $hours = $hours + $parts[1];
                        $minutes = $minutes + $parts[2];
                        if ($hours >= 24) {
                            $days = $days + 1;
                            $hours = $hours - 24;
                        }

                        if ($minutes >= 60) {
                            $hours = $hours + 1;
                            $minutes = $minutes - 60;
                        }
                    }
                }

                $totalAverageResolutionTime = $days . ' day(s) ' . $hours . ' hour(s) ' . $minutes . ' minutes';

                return [
                    'Homeowner' => $structure['user']['first_name'] . ' ' . $structure['user']['last_name'],
                    'Issues Logged' => count($structure['user']['issues']),
                    'Issues Resolved' => $ctrIssues,
                    '% Emergency Resolved' => number_format($ctrIssues / count($structure['user']['issues']) * 100, 2, '.', '') . '%',
                    'Ave. Resolution Time' => $totalAverageResolutionTime,
                ];
            }

        }, $issuesReport);

        /*$cautionRawReport = $this->actionTaken
        ->with(['homeOwner' => function ($query) {
        $query->select('id', 'first_name', 'last_name');
        }])
        ->with(['security' => function ($query) {
        $query->select('id', 'first_name', 'last_name');
        }])
        ->with(['caution' => function ($query) {
        $query->select('id', 'caution_type_id', 'homeowner_address_id', 'home_owner_id', 'message');

        $query->with(['homeownerAddress' => function ($query) {
        $query->select('id', 'address', 'home_owner_id');
        }]);

        $query->with(['cautionType' => function ($query) {
        $query->select('id', 'description');
        }]);
        }])
        ->with(['actionTakenType' => function ($query) {
        $query->select('id', 'message');
        }])
        ->where('emergency_id', null)
        ->orderBy('created_at')
        ->get()
        ->toArray();

        $cautionRaw = array_map(function ($structure) use ($cautionRawReport) {
        return [
        'Caution Type' => $structure['caution']['caution_type']['description'],
        'Home Owner Name' => $structure['home_owner']['first_name'] . ' ' . $structure['home_owner']['last_name'],
        'Home Owner Address' => $structure['caution']['homeowner_address']['address'],
        'Message' => $structure['caution']['message'],
        'Action Taken' => $structure['action_taken_type']['message'],
        'Reported By' => $structure['security']['first_name'] . ' ' . $structure['security']['last_name'],
        'Date' => date_format(date_create($structure['created_at']), "M d, Y"),
        'Time' => date_format(date_create($structure['created_at']), "H:i A"),
        ];
        }, $cautionRawReport);*/
        $emergencyRawReport = $this->emergency->with(['user' => function ($query) {
            $query->select('id', 'first_name', 'last_name');
        }])
            ->with(['homeowner_address' => function ($query) {
                $query->select('id', 'address');
            }])
            ->with(['emergencyType' => function ($query) {

            }])
            ->whereBetween('created_at', array(new \DateTime($start_date . ' 00:00:00'), new \DateTime($end_date . ' 24:00:00')))
            ->select('id', 'home_owner_id', 'emergency_type_id', 'homeowner_address_id', 'status', 'end_date', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        $emergencyRaw = array_map(function ($structure) use ($emergencyRawReport) {

            $ctrIssues = 0;
            $days = 00;
            $hours = 00;
            $minutes = 00;

            $ctrIssues = $ctrIssues + 1;

            $start = new \DateTime($structure['created_at']);
            $end = new \DateTime($structure['end_date']);

            $parts = explode(':', $start->diff($end)->format('%D:%H:%I'));

            $days = $days + $parts[0];
            $hours = $hours + $parts[1];
            $minutes = $minutes + $parts[2];
            if ($hours >= 24) {
                $days = $days + 1;
                $hours = $hours - 24;
            }

            if ($minutes >= 60) {
                $hours = $hours + 1;
                $minutes = $minutes - 60;
            }

            $resolved_time = 'In-Progress';
            $totalAverageResolutionTime = 'In-Progress';

            if (!is_null($structure['end_date'])) {
                $resolved_time = date_format(date_create($structure['end_date']), "M d, Y") . ' ' . date_format(date_create($structure['end_date']), "H:i A");
                $totalAverageResolutionTime = $days . ' day(s) ' . $hours . ' hour(s) ' . $minutes . ' minutes';
            }

            return [
                'Home Owner Name' => $structure['user']['first_name'] . ' ' . $structure['user']['last_name'],
                'Home Owner Address' => $structure['homeowner_address']['address'],
                'Emergency Description' => $structure['emergency_type']['description'],
                'Emergency Creation Date/Time' => date_format(date_create($structure['created_at']), "M d, Y") . ' ' . date_format(date_create($structure['created_at']), "H:i A"),
                'Emergency Resolved Date/Time' => $resolved_time,
                'Resolution Time' => $totalAverageResolutionTime,
                'Resolved' => ($structure['status'] == 1) ? 'Resolved' : 'In-Progress',
            ];

        }, $emergencyRawReport);

        $cautionRawReport = $this->caution->with(['user' => function ($query) {
            $query->select('id', 'first_name', 'last_name');
        }])
            ->with(['homeowner_address' => function ($query) {
                $query->select('id', 'address');
            }])
            ->with(['cautionType' => function ($query) {

            }])
            ->whereBetween('created_at', array(new \DateTime($start_date . ' 00:00:00'), new \DateTime($end_date . ' 24:00:00')))
            ->select('id', 'home_owner_id', 'caution_type_id', 'homeowner_address_id', 'message', 'status', 'end_date', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        $cautionRaw = array_map(function ($structure) use ($cautionRawReport) {

            $ctrIssues = 0;
            $days = 00;
            $hours = 00;
            $minutes = 00;

            $ctrIssues = $ctrIssues + 1;

            $start = new \DateTime($structure['created_at']);
            $end = new \DateTime($structure['end_date']);

            $parts = explode(':', $start->diff($end)->format('%D:%H:%I'));

            $days = $days + $parts[0];
            $hours = $hours + $parts[1];
            $minutes = $minutes + $parts[2];
            if ($hours >= 24) {
                $days = $days + 1;
                $hours = $hours - 24;
            }

            if ($minutes >= 60) {
                $hours = $hours + 1;
                $minutes = $minutes - 60;
            }

            $resolved_time = 'In-Progress';
            $totalAverageResolutionTime = 'In-Progress';

            if (!is_null($structure['end_date'])) {
                $resolved_time = date_format(date_create($structure['end_date']), "M d, Y") . ' ' . date_format(date_create($structure['end_date']), "H:i A");
                $totalAverageResolutionTime = $days . ' day(s) ' . $hours . ' hour(s) ' . $minutes . ' minutes';
            }

            return [
                'Home Owner Name' => $structure['user']['first_name'] . ' ' . $structure['user']['last_name'],
                'Home Owner Address' => $structure['homeowner_address']['address'],
                'Caution Description' => $structure['caution_type']['description'],
                'Message' => $structure['message'],
                'Caution Creation Date/Time' => date_format(date_create($structure['created_at']), "M d, Y") . ' ' . date_format(date_create($structure['created_at']), "H:i A"),
                'Caution Resolved Date/Time' => $resolved_time,
                'Resolution Time' => $totalAverageResolutionTime,
                'Resolved' => ($structure['status'] == 1) ? 'Resolved' : 'In-Progress',
            ];

        }, $cautionRawReport);

        $notificationsReport = $this->notifications
            ->with('visitors')
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->with(['homeOwnerAddress' => function ($query) {
                $query->select('id', 'address');
            }])
            ->where('status', 1)
            ->orWhere('status', 2)
            ->whereBetween('created_at', array(new \DateTime($start_date . ' 00:00:00'), new \DateTime($end_date . ' 24:00:00')))
            ->select('id', 'user_id', 'visitors_id', 'home_owner_id', 'status', 'homeowner_address_id', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        $notifications = array_map(function ($structure) use ($notificationsReport) {
            return [
                'Visitor Name' => $structure['visitors']['name'],
                'Plate Number' => $structure['visitors']['plate_number'],
                'Car Description' => $structure['visitors']['car_description'],
                'Notes' => $structure['visitors']['notes'],
                'Home Owner Name' => $structure['user']['first_name'] . ' ' . $structure['user']['last_name'],
                'Home Owner Address' => $structure['home_owner_address']['address'],
                'Date' => date_format(date_create($structure['created_at']), "M d, Y"),
                'Time' => date_format(date_create($structure['created_at']), "h:i A"),
            ];
        }, $notificationsReport);

        $incomingGuestsReport = $this->eventGuestList
            ->with(['event' => function ($query) {
                $query->select('id', 'name', 'start', 'end', 'ref_category_id', 'created_at');

                $query->with(['refCategory' => function ($query) {
                    $query->select('id', 'category_name');
                }]);

            }])
            ->with(['guestList' => function ($query) {
                $query->select('id', 'guest_name');
            }])
            ->select('id', 'event_id', 'guest_list_id', 'home_owner_id', 'status')
            ->where('status', 1)
            ->orWhere('status', 2)
            ->whereBetween('updated_at', array(new \DateTime($start_date . ' 00:00:00'), new \DateTime($end_date . ' 24:00:00')))
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        $incomingGuests = array_map(function ($structure) use ($incomingGuestsReport) {
            return [
                'Purpose of Visit' => $structure['event']['ref_category']['category_name'],
                'Description' => $structure['event']['name'],
                'Start' => $structure['event']['start'],
                'End' => $structure['event']['end'],
                'Guest Name' => $structure['guest_list']['guest_name'],
                'Date' => date_format(date_create($structure['event']['created_at']), "M d, Y"),
                'Time' => date_format(date_create($structure['event']['created_at']), "h:i A"),
            ];
        }, $incomingGuestsReport);

        $suggestionComplaintsReport = $this->suggestionComplaints
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
                $query->with(['homeOwnerAddressPrimary' => function ($query) {
                    $query->select('id', 'address', 'home_owner_id');

                }]);
            }])
            ->whereBetween('created_at', array(new \DateTime($start_date . ' 00:00:00'), new \DateTime($end_date . ' 24:00:00')))
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        $suggestionComplaints = array_map(function ($structure) use ($suggestionComplaintsReport) {

            $status = 'Resolved';

            if ($structure['resolved'] == 0) {
                $status = 'In-Progress';
            }

            switch ($structure['issue_type']) {
                case 1:
                    $issue_type = 'Suggestion';
                    break;
                case 2:
                    $issue_type = 'Complaint';
                    break;
                default:
                    $issue_type = 'Issue';
                    break;
            }

            $resolution_time = 'In-Progress';

            if ($structure['resolved'] == 1) {

                $start = new \DateTime($structure['created_at']);
                $end = new \DateTime($structure['end_date']);

                $resolution_time = $start->diff($end)->format('%D day(s) %H hour(s) %I minute(s)');

            }

            return [
                'Resident Name' => $structure['user']['first_name'] . ' ' . $structure['user']['last_name'],
                'Resident Address' => $structure['user']['home_owner_address_primary']['address'],
                'Issue Type' => $issue_type,
                'Issue Description' => $structure['message'],
                'Issue Creation Date/Time' => $structure['created_at'],
                'Issue Resolved Date/Time' => $structure['end_date'],
                'Resolution Time' => $resolution_time,
                'Resolved' => $status,

            ];
        }, $suggestionComplaintsReport);

        /*echo "<pre>";
        print_r(array_filter($suggestionComplaints));
        die;*/
        $reportType = array(
            'Emergency Report' => array_filter($emergency),
            'Emergency Raw Report' => $emergencyRaw,
            'Caution Report' => array_filter($caution),
            'Caution Raw Report' => $cautionRaw,
            'Issues Report' => array_filter($issues),
            'Issues Raw Report' => $suggestionComplaints,
            'Unexpected Guest Report' => $notifications,
            'Expected Guests Report' => $incomingGuests,
        );

        $this->generateReport->generate($reportType);

        return json_encode(array('msgCode' => 1, 'msg' => 'Success'));
    }
}
