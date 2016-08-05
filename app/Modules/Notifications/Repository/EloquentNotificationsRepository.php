<?php

namespace BrngyWiFi\Modules\Notifications\Repository;

use BrngyWiFi\Modules\Alerts\Models\Alerts;
use BrngyWiFi\Modules\Caution\Repository\CautionRepositoryInterface;
use BrngyWiFi\Modules\Emergency\Repository\EmergencyRepositoryInterface;
use BrngyWiFi\Modules\EventGuestList\Models\EventGuestList;
use BrngyWiFi\Modules\Notifications\Models\Notifications;
use BrngyWiFi\Modules\RefCategory\Models\RefCategory;
use BrngyWiFi\Modules\SuggestionComplaints\Repository\SuggestionComplaintsRepositoryInterface;
use BrngyWiFi\Modules\User\Models\User;

class EloquentNotificationsRepository implements NotificationsRepositoryInterface
{
    /**
     * @var CautionRepositoryInterface
     */
    private $cautionRepositoryInterface;

    /**
     * @var EmergencyRepositoryInterface
     */
    private $emergencyRepositoryInterface;

    /**
     * @var SuggestionComplaintsRepositoryInterface
     */
    private $suggestionComplaintsRepositoryInterface;

    /**
     * @var Notifications
     */
    private $notifications;

    /**
     * @param Notifications
     */
    public function __construct(Notifications $notifications, EmergencyRepositoryInterface $emergencyRepositoryInterface, CautionRepositoryInterface $cautionRepositoryInterface, SuggestionComplaintsRepositoryInterface $suggestionComplaintsRepositoryInterface)
    {
        $this->notifications = $notifications;
        $this->emergencyRepositoryInterface = $emergencyRepositoryInterface;
        $this->cautionRepositoryInterface = $cautionRepositoryInterface;
        $this->suggestionComplaintsRepositoryInterface = $suggestionComplaintsRepositoryInterface;
    }

    /**
     * Create new notification
     *
     * @param array $payload
     * @return static
     */
    public function createNotifications($payload)
    {
        return $this->notifications->create($payload);
    }

    /**
     * Update a certain notification
     *
     * @param array $payload
     * @return static
     */
    public function updateNotifcations($payload)
    {
        return $this->notifications->find($payload->id)->fill(['status' => $payload->status, 'approved_by' => $payload->user_id])->save();
    }

    /**
     * Update a certain notification via chikka
     *
     * @param int $notif_id
     * @param int $status
     * @return static
     */
    public function updateNotifcationsViaChikka($notif_id, $status)
    {
        return $this->notifications->find($notif_id)->fill(['status' => $status])->save();
    }

    /**
     * Get all unexpected visitors in notifications
     *
     * @return static
     */
    public function getAllVisitors($homeOwnerId)
    {
        /*$user = User::find($homeOwnerId);

        return $users = User::with(['notifications' => function ($query) {
        $query->where('status', 0);
        }])
        ->where('main_account_id', $user->main_account_id)
        ->get()
        ->toArray();*/

        /*  $user = User::find($homeOwnerId);

        $homeowners = User::with(['notifications' => function ($query) {
        $query->where('status', 0);
        $query->select('id', 'user_id', 'visitors_id', 'home_owner_id', 'homeowner_address_id', 'status', 'created_at');

        $query->with(['visitors' => function ($query) {
        $query->select('id', 'name', 'ref_category_id', 'plate_number', 'car_description', 'notes', 'photo');
        $query->with(['refCategory' => function ($query) {
        $query->select('id', 'category_name');
        }]);
        }]);
        }])
        ->select('id', 'first_name', 'last_name', 'main_account_id')
        ->where('main_account_id', $user->main_account_id)
        ->get()
        ->toArray();
        $result = array();

        foreach ($homeowners as $key => $value) {
        if (!empty($value['notifications'])) {
        $result[] = $value;
        }
        }

        return $result;*/
        $main_homeowner = User::find($homeOwnerId);
        $notifications = $this->notifications
            ->with('visitors')
            ->with(['user' => function ($query) use ($homeOwnerId, $main_homeowner) {
                $query->select('id', 'first_name', 'last_name', 'main_account_id');
                $query->where('main_account_id', $main_homeowner->main_account_id);
            }])
            ->with(['homeOwnerAddress' => function ($query) use ($homeOwnerId) {
                $query->select('id', 'address');
            }])
            ->where('status', 0)

            ->whereBetween('updated_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d') . ' 24:00:00')))
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        $kevin = array();

        foreach ($notifications as $key => $value) {
            if ($value['user'] != null) {
                $kevin[] = $value;
            }
        }

        return $kevin;
    }

    /**
     * Get all approved unexpected visitors for security guard
     *
     * @return static
     */
    public function getApprovedUnexpectedVisitors($securityGuardId)
    {
        return $this->notifications
            ->with(['visitors' => function ($query) {
                //$query->select('id', 'name', 'ref_category_id');
                $query->select('id', 'name', 'ref_category_id');
                $query->with(['refCategory' => function ($query) {
                    $query->select('id', 'category_name');
                }]);
            }])
            ->with(['homeownerAddress' => function ($query) {
                $query->select('id', 'address');
            }])
            ->with(['approved' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name as homeowner_first_name', 'last_name as homeowner_last_name');
            }])
            ->where('status', 1)
            ->where('user_id', $securityGuardId)
            ->select('id', 'user_id', 'visitors_id', 'home_owner_id', 'homeowner_address_id', 'status', 'created_at', 'approved_by')
            ->get()
            ->toArray();
    }

    /**
     * Get all denied unexpected visitors for security guard
     *
     * @return static
     */
    public function getDeniedUnexpectedVisitors($securityGuardId)
    {
        return $this->notifications
            ->with(['visitors' => function ($query) {
                //$query->select('id', 'name', 'ref_category_id');
                $query->select('id', 'name', 'ref_category_id');
                $query->with(['refCategory' => function ($query) {
                    $query->select('id', 'category_name');
                }]);
            }])
            ->with(['homeownerAddress' => function ($query) {
                $query->select('id', 'address');
            }])
            ->with(['approved' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name as homeowner_first_name', 'last_name as homeowner_last_name');
            }])
            ->where('status', 2)
            ->where('user_id', $securityGuardId)
            ->select('id', 'user_id', 'visitors_id', 'home_owner_id', 'homeowner_address_id', 'status', 'created_at', 'approved_by')
            ->get()
            ->toArray();
    }

    /**
     * Get all waiting unexpected visitors for security guard
     *
     * @return static
     */
    public function getWaitingUnexpectedVisitors($securityGuardId)
    {
        return $this->notifications
            ->with(['visitors' => function ($query) {
                //$query->select('id', 'name', 'ref_category_id');
                $query->select('id', 'name', 'ref_category_id');
                $query->with(['refCategory' => function ($query) {
                    $query->select('id', 'category_name');
                }]);
            }])
            ->with(['homeownerAddress' => function ($query) {
                $query->select('id', 'address');
            }])
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name as homeowner_first_name', 'last_name as homeowner_last_name');
            }])
            ->where('status', 0)
            ->where('user_id', $securityGuardId)
            ->select('id', 'user_id', 'visitors_id', 'home_owner_id', 'homeowner_address_id', 'status', 'created_at', 'approved_by')
            ->get()
            ->toArray();
    }

    /**
     * Get all approved unexpected visitors for home owner
     *
     * @return static
     */
    public function getApprovedUnexpectedVisitorsByHomeowner($homeOwnerId)
    {
        /*return $this->notifications
        ->with(['visitors' => function ($query) {
        $query->select('id', 'name', 'ref_category_id');
        }])
        ->with(['homeownerAddress' => function ($query) {
        $query->select('id', 'address');
        }])
        ->with(['user' => function ($query) {
        $query->select('id', 'first_name', 'last_name');
        }])
        ->where('status', 1)
        ->where('home_owner_id', $homeOwnerId)
        ->select('id', 'user_id', 'visitors_id', 'home_owner_id', 'homeowner_address_id', 'status', 'created_at')
        ->orderBy('created_at', 'desc')
        ->get()
        ->toArray();*/
        $user = User::find($homeOwnerId);

        $homeowners = $users = User::with(['notifications' => function ($query) {
            $query->where('status', 1);
            $query->select('id', 'user_id', 'visitors_id', 'home_owner_id', 'homeowner_address_id', 'status', 'approved_by', 'created_at');

            $query->with(['approved' => function ($query) {
                $query->select('id', 'first_name AS approved_by_first_name', 'last_name AS approved_by_last_name');
            }]);

            $query->with(['visitors' => function ($query) {
                //$query->select('id', 'name', 'ref_category_id');
                $query->select('id', 'name', 'ref_category_id');
                $query->with(['refCategory' => function ($query) {
                    $query->select('id', 'category_name');
                }]);
            }]);
            $query->with(['homeOwnerAddress' => function ($query) {
                $query->select('id', 'address');
            }]);
        }])
            ->select('id', 'first_name', 'last_name', 'main_account_id')
            ->where('main_account_id', $user->main_account_id)
            ->get()
            ->toArray();

        $result = array();

        foreach ($homeowners as $key => $value) {
            if (!empty($value['notifications'])) {
                $result[] = $value;
            }
        }

        return $result;
    }

    /**
     * Get all denied unexpected visitors for home owner
     *
     * @return static
     */
    public function getDeniedUnexpectedVisitorsByHomeowner($homeOwnerId)
    {
        /*return $this->notifications
        ->with(['visitors' => function ($query) {
        $query->select('id', 'name', 'ref_category_id');
        }])
        ->with(['homeownerAddress' => function ($query) {
        $query->select('id', 'address');
        }])
        ->where('status', 2)
        ->where('home_owner_id', $homeOwnerId)
        ->select('id', 'user_id', 'visitors_id', 'home_owner_id', 'homeowner_address_id', 'status', 'created_at')
        ->orderBy('created_at', 'desc')
        ->get()
        ->toArray();*/
        $user = User::find($homeOwnerId);

        $homeowners = User::with(['notifications' => function ($query) {
            $query->where('status', 2);
            $query->select('id', 'user_id', 'visitors_id', 'home_owner_id', 'homeowner_address_id', 'status', 'approved_by', 'created_at');

            $query->with(['approved' => function ($query) {
                $query->select('id', 'first_name AS approved_by_first_name', 'last_name AS approved_by_last_name');
            }]);

            $query->with(['visitors' => function ($query) {
                $query->select('id', 'name', 'ref_category_id');
                $query->with(['refCategory' => function ($query) {
                    $query->select('id', 'category_name');
                }]);
            }]);
            $query->with(['homeOwnerAddress' => function ($query) {
                $query->select('id', 'address');
            }]);
        }])
            ->select('id', 'first_name', 'last_name', 'main_account_id')
            ->where('main_account_id', $user->main_account_id)
            ->get()
            ->toArray();

        $result = array();

        foreach ($homeowners as $key => $value) {
            if (!empty($value['notifications'])) {
                $result[] = $value;
            }
        }

        return $result;

    }

    /**
     * Get all unexpected guests
     *
     * @return static
     */
    public function getVisitorsCount()
    {
        $ref_category = RefCategory::get()->toArray();

        foreach ($ref_category as $rf) {
            $ref_category_unexpected = Notifications::select('notifications.*', 'notifications.id AS nid', 'visitors.*')
                ->join('visitors', 'notifications.visitors_id', '=', 'visitors.id')
                ->where('visitors.ref_category_id', $rf['id'])
                ->where('notifications.status', 0)
                ->whereBetween('notifications.updated_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d') . ' 24:00:00')))
                ->count();

            $ref_category_incoming = EventGuestList::select('event_guest_list.*', 'event.*')
                ->join('event', 'event_guest_list.event_id', '=', 'event.id')
                ->where('event.ref_category_id', $rf['id'])
                ->where('event_guest_list.status', 1)
                ->where('start', '>=', date('Y-m-d'))
                ->count();

            $data[$this->toLowerCase($rf['category_name'])]['total_count'] = $ref_category_unexpected + $ref_category_incoming;

            $notificationsLongLat['notif'] = Notifications::select('notifications.visitors_id', 'notifications.home_owner_id', 'notifications.homeowner_address_id', 'notifications.status', 'notifications.updated_at', 'visitors.id', 'visitors.ref_category_id', 'homeowner_address.id', 'homeowner_address.address', 'homeowner_address.latitude', 'homeowner_address.longitude')
                ->join('visitors', 'notifications.visitors_id', '=', 'visitors.id')
                ->join('homeowner_address', 'notifications.homeowner_address_id', '=', 'homeowner_address.id')
                ->where('visitors.ref_category_id', $rf['id'])
                ->where('notifications.status', 0)
                ->whereBetween('notifications.updated_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d') . ' 24:00:00')))
            //->groupBy('notifications.homeowner_address_id')
                ->get()
                ->toArray();

            $incomingLongLat['incoming'] = EventGuestList::select('event_guest_list.event_id', 'event_guest_list.home_owner_id', 'event_guest_list.status', 'event.id', 'event.homeowner_address_id', 'event.ref_category_id', 'homeowner_address.id AS haid', 'homeowner_address.home_owner_id AS hahoi', 'homeowner_address.address', 'homeowner_address.latitude', 'homeowner_address.longitude')
                ->join('event', 'event_guest_list.event_id', '=', 'event.id')
            // ->join('homeowner_address', 'event_guest_list.home_owner_id', '=', 'homeowner_address.home_owner_id')
                ->leftJoin('homeowner_address', function ($query) {
                    $query->on('homeowner_address.id', '=', 'event.homeowner_address_id');
                })
                ->where('event.ref_category_id', $rf['id'])
                ->where('event_guest_list.status', 1)
                ->where('event.start', '>=', date('Y-m-d'))
            //->groupBy('homeowner_address.latitude')
                ->get()
                ->toArray();

            $notifLngLat = $notificationsLongLat['notif'];

            $incomgLongLat = $incomingLongLat['incoming'];

            $data[$this->toLowerCase($rf['category_name'])]['location_unexpected_guests'] = $notifLngLat;

            $data[$this->toLowerCase($rf['category_name'])]['location_incoming_guests'] = $incomgLongLat;
        }

        $emergencyRepositoryInterface = $this->emergencyRepositoryInterface->getActiveEmergencyCount();
        $cautionRepositoryInterface = $this->cautionRepositoryInterface->getActiveCautionCount();

        $unidentifiedAlerts = Alerts::with('homeowner_address')->where('status', 0)->count();
        /*->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d') . ' 24:00:00')))*/
        $suggestionComplaintsRepositoryInterface = $this->suggestionComplaintsRepositoryInterface->getActiveIssueCount();

        $data['resident_alerts'] = $emergencyRepositoryInterface + $cautionRepositoryInterface + $unidentifiedAlerts;
        $data['issues'] = $suggestionComplaintsRepositoryInterface;

        return $data;
    }

    /**
     * Make string lowercase
     *
     * @return static
     */
    private function toLowerCase($string)
    {
        return str_replace(' ', '_', strtolower($string));
    }

    /**
     * Get a notification via chikka code
     *
     * @return static
     */
    public function getByChikkaCode($chikka_code)
    {
        if ($notification = $this->notifications->where(['chikka_code' => $chikka_code, 'status' => 0])->first()) {
            return $notification;
        }

        return false;
    }

    /**
     * Get first unexpected visitor.
     *
     * @return static
     */
    public function getFirstVisitor($home_owner_id)
    {
        if ($notification = $this->notifications->where(['home_owner_id' => $home_owner_id, 'status' => 0])->orderBy('created_at')->first()) {
            return $notification;
        }

        return false;
    }
}
