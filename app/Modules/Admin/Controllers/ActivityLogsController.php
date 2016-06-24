<?php

namespace BrngyWiFi\Modules\Admin\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use \BrngyWiFi\Modules\Caution\Models\Caution;
use \BrngyWiFi\Modules\Emergency\Models\Emergency;
use \BrngyWiFi\Modules\Notifications\Models\Notifications;

class ActivityLogsController extends Controller
{
    protected $user;

    protected $response;

    protected $emergency;

    protected $caution;

    public function __construct(ResponseFactory $response, Emergency $emergency, Caution $caution)
    {
        $this->response = $response;
        $this->emergency = $emergency;
        $this->caution = $caution;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['visitors'] = Notifications::select('notifications.*', 'notifications.id AS nid', 'users.*', 'users.first_name AS fhname', 'users.*', 'users.last_name AS lhname', 'visitors.*')
            ->join('users', 'notifications.home_owner_id', '=', 'users.id')
            ->join('visitors', 'notifications.visitors_id', '=', 'visitors.id')
            ->where(array('notifications.status' => 1))
            ->orWhere(array('notifications.status' => 2))
            ->orderBy('notifications.created_at', 'DESC')
            ->get();

        $data['emergency'] = $this->emergency
            ->with(['emergencyType' => function ($query) {
                $query->select('id', 'description');
            }])
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->with(['homeOwnerAddress' => function ($query) {
                $query->select('id', 'address');
            }])
            ->with(['actionTaken' => function ($query) {
                $query->with(['actionTakenType' => function ($query) {
                    $query->select('id', 'message');
                }]);
                $query->with(['security' => function ($query) {
                    $query->select('id', 'first_name', 'last_name');
                }]);
                $query->select('id', 'emergency_id', 'action_taken_type_id', 'security_guard_id', 'created_at');
                $query->orderBy('updated_at', 'desc');
            }])

            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        $data['caution'] = $this->caution
            ->with(['cautionType' => function ($query) {
                $query->select('id', 'description');
            }])
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->with(['homeOwnerAddress' => function ($query) {
                $query->select('id', 'address');
            }])
            ->with(['actionTaken' => function ($query) {
                $query->with(['actionTakenType' => function ($query) {
                    $query->select('id', 'message');
                }]);
                $query->with(['security' => function ($query) {
                    $query->select('id', 'first_name', 'last_name');
                }]);
                $query->select('id', 'caution_id', 'action_taken_type_id', 'security_guard_id', 'created_at');
                $query->orderBy('updated_at', 'desc');
            }])

            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Admin::activity_logs', $data);
    }
}
