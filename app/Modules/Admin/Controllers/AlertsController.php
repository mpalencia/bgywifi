<?php

namespace BrngyWiFi\Modules\Admin\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\User\Models\User;
use BrngyWiFi\Services\Chikka\ChikkaReply;
use BrngyWiFi\Services\Curl\SendNotification;
use Illuminate\Http\Request;
use \BrngyWiFi\Modules\ActionTakenType\Models\ActionTakenType;
use \BrngyWiFi\Modules\ActionTaken\Models\ActionTaken;
use \BrngyWiFi\Modules\Alerts\Models\Alerts;
use \BrngyWiFi\Modules\Caution\Models\Caution;
use \BrngyWiFi\Modules\EmergencyType\Models\EmergencyType;
use \BrngyWiFi\Modules\Emergency\Models\Emergency;
use \BrngyWiFi\Modules\HomeownerAddress\Models\HomeownerAddress;

class AlertsController extends Controller
{
    protected $user;

    protected $response;

    protected $emergency;

    protected $caution;

    protected $actionTakenType;

    public function __construct(Emergency $emergency, Caution $caution, ActionTakenType $actionTakenType, Alerts $alerts)
    {
        $this->emergency = $emergency;
        $this->caution = $caution;
        $this->alerts = $alerts;
        $this->actionTakenType = $actionTakenType;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alerts'] = $this->alerts
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->with(['homeowner_address' => function ($query) {
                $query->select('id', 'address');
            }])
            ->where('status', 0)
            ->orderBy('created_at', 'desc')
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
        //->where('status', 0)
        //->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
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
        //->where('status', 0)
        //->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
            ->orderBy('created_at', 'desc')
            ->get();

        $data['actionTakenType'] = $this->actionTakenType->get()->toArray();
        $data['emergency_type'] = EmergencyType::get()->toArray();
        return view('Admin::alerts', $data);
    }

    public function getUnidentified()
    {
        $ua = $data['alerts'] = $this->alerts
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->with(['homeowner_address' => function ($query) {
                $query->select('id', 'address');
            }])
            ->where('status', 0)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
        $unidentified = array_map(function ($structure) use ($ua) {

            $action = '<button id="view-unidentified" type="button" class="btn btn-primary btn-circle view-unidentified" onclick="unidentifiedClick(this)" title="View" data-toggle="modal" data-target="#unidentifiedModal"
                        data-homeowner="' . $structure['user']['first_name'] . ' ' . $structure['user']['last_name'] . '"
                        data-date="' . date_format(date_create($structure['created_at']), 'M d, Y h:i A') . '"
                        data-home-owner-id="' . $structure['home_owner_id'] . '"
                        data-security-guard-id="' . \Auth::user()->id . '"
                        data-unidentified-id="' . $structure['id'] . '"
                        data-unidentified-status="' . $structure['status'] . '">
                        <i class="glyphicon glyphicon-eye-open"></i>
                    </button>';

            $markButton = '<button id="markas-button" type="button" class="btn btn-danger btn-circle view-markas" onclick="markasClick(this)" title="Set Emergency Type" data-toggle="modal" data-target="#markasModal"
                        data-homeowner="' . $structure['user']['first_name'] . ' ' . $structure['user']['last_name'] . '"
                        data-date="' . date_format(date_create($structure['created_at']), 'M d, Y h:i A') . '"
                        data-home-owner-id="' . $structure['home_owner_id'] . '"
                        data-security-guard-id="' . \Auth::user()->id . '"
                        data-unidentified-id="' . $structure['id'] . '"
                        data-unidentified-status="' . $structure['status'] . '">
                        <i class="glyphicon glyphicon-exclamation-sign"></i>
                    </button>';

            return [
                'homeowner_name' => $structure['user']['first_name'] . ' ' . $structure['user']['last_name'],
                'address' => $structure['homeowner_address']['address'],
                'date_&_time' => date_format(date_create($structure['created_at']), "M d, Y h:i A"),
                'action' => $action,
                'markButton' => $markButton,
            ];
        }, $ua);

        return ['data' => $unidentified];
    }

    public function getEmergencies()
    {
        $e = $this->emergency
            ->with(['emergencyType' => function ($query) {
                $query->select('id', 'description');
            }])
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->with(['homeOwnerAddress' => function ($query) {
                $query->select('id', 'address', 'home_owner_id');
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
        //->where('status', 0)
        //->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
        $emergency = array_map(function ($structure) use ($e) {
            if ($structure['status'] == 0) {
                $status = '<span class="label label-danger">In-Progress</span>';
            } elseif ($structure['status'] == 2) {
                $status = '<span class="label label-primary">False Alarm</span>';
            } else {
                $status = '<span class="label label-success">Resolved</span>';
            }
            $action = '<button id="view-emergency" type="button" class="btn btn-primary btn-circle view-emergency" onclick="emergencyClick(this)" title="View" data-toggle="modal" data-target="#emergencyModal"
                        data-emergency="' . $structure['emergency_type']['description'] . '"
                        data-homeowner="' . $structure['user']['first_name'] . ' ' . $structure['user']['last_name'] . '"
                        data-date="' . date_format(date_create($structure['created_at']), 'M d, Y h:i A') . '"
                        data-home-owner-id="' . $structure['home_owner_id'] . '"
                        data-security-guard-id="' . \Auth::user()->id . '"
                        data-emergency-id="' . $structure['id'] . '"
                        data-emergency-status="' . $structure['status'] . '">
                        <i class="glyphicon glyphicon-eye-open"></i>
                    </button>';
            return [
                'emergency_type' => $structure['emergency_type']['description'],
                'homeowner_name' => $structure['user']['first_name'] . ' ' . $structure['user']['last_name'],
                'address' => $structure['home_owner_address']['address'],
                'date_&_time' => date_format(date_create($structure['created_at']), "M d, Y h:i A"),
                'status' => $status,
                'action' => $action,
            ];
        }, $e);

        return ['data' => $emergency];
    }

    public function getCautions()
    {
        $c = $this->caution
            ->with(['cautionType' => function ($query) {
                $query->select('id', 'description');
            }])
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->with(['homeOwnerAddress' => function ($query) {
                $query->select('id', 'address', 'home_owner_id');
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
        //->where('status', 0)
        //->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d', strtotime("+1 day")) . ' 24:00:00')))
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
        $caution = array_map(function ($structure) use ($c) {
            if ($structure['status'] == 0) {
                $status = '<span class="label label-danger">In-Progress</span>';
            } elseif ($structure['status'] == 2) {
                $status = '<span class="label label-primary">False Alarm</span>';
            } else {
                $status = '<span class="label label-success">Resolved</span>';
            }
            $action = '<button id="view-caution" type="button" class="btn btn-primary btn-circle view-caution" onclick="cautionClick(this)" title="View" data-toggle="modal" data-target="#cautionModal"
                        data-caution="' . $structure['caution_type']['description'] . '"
                        data-homeowner="' . $structure['user']['first_name'] . ' ' . $structure['user']['last_name'] . '"
                        data-date="' . date_format(date_create($structure['created_at']), 'M d, Y h:i A') . '"
                        data-home-owner-id="' . $structure['home_owner_id'] . '"
                        data-security-guard-id="' . \Auth::user()->id . '"
                        data-caution-id="' . $structure['id'] . '"
                        data-caution-status="' . $structure['status'] . '">
                        <i class="glyphicon glyphicon-eye-open"></i>
                    </button>';
            return [
                'caution_type' => $structure['caution_type']['description'],
                'homeowner_name' => $structure['user']['first_name'] . ' ' . $structure['user']['last_name'],
                'address' => $structure['home_owner_address']['address'],
                'date_&_time' => date_format(date_create($structure['created_at']), "M d, Y h:i A"),
                'status' => $status,
                'action' => $action,
            ];
        }, $c);

        return ['data' => $caution];
    }

    public function getUnidentifiedUpdate($unidentified_id)
    {
        $u = ActionTaken::with(['actionTakenType' => function ($query) {
            $query->select('id', 'message');
        }])
            ->with(['security' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->where('unidentified_id', $unidentified_id)
            ->get()
            ->toArray();

        $unidentified = array_map(function ($structure) use ($u) {
            return [
                'action_taken_type' => $structure['action_taken_type']['message'],
                'date' => date_format(date_create($structure['created_at']), "M d, Y"),
                'time' => date_format(date_create($structure['created_at']), "h:i A"),
                'reported_by' => $structure['security']['first_name'] . ' ' . $structure['security']['last_name'],
            ];
        }, $u);

        return ['data' => $unidentified];
    }

    public function getEmergencyUpdate($emergency_id)
    {
        $e = ActionTaken::with(['actionTakenType' => function ($query) {
            $query->select('id', 'message');
        }])
            ->with(['security' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->where('emergency_id', $emergency_id)
            ->get()
            ->toArray();

        $emergency = array_map(function ($structure) use ($e) {
            return [
                'action_taken_type' => $structure['action_taken_type']['message'],
                'date' => date_format(date_create($structure['created_at']), "M d, Y"),
                'time' => date_format(date_create($structure['created_at']), "h:i A"),
                'reported_by' => $structure['security']['first_name'] . ' ' . $structure['security']['last_name'],
            ];
        }, $e);

        return ['data' => $emergency];
    }

    public function getCautionUpdate($caution_id)
    {
        $c = ActionTaken::with(['actionTakenType' => function ($query) {
            $query->select('id', 'message');
        }])
            ->with(['security' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->where('caution_id', $caution_id)
            ->get()
            ->toArray();

        $caution = array_map(function ($structure) use ($c) {
            return [
                'action_taken_type' => $structure['action_taken_type']['message'],
                'date' => date_format(date_create($structure['created_at']), "M d, Y"),
                'time' => date_format(date_create($structure['created_at']), "h:i A"),
                'reported_by' => $structure['security']['first_name'] . ' ' . $structure['security']['last_name'],
            ];
        }, $c);

        return ['data' => $caution];
    }

    public function updateActionTaken(Request $request, SendNotification $curl)
    {

        if ($request->action_taken_type_id == 5) {
            if (array_key_exists('caution_id', $request->all())) {
                Caution::where('id', $request->caution_id)->update(['status' => 1, 'end_date' => date('Y-m-d H:i:s')]);
            }

            if (array_key_exists('emergency_id', $request->all())) {
                Emergency::where('id', $request->emergency_id)->update(['status' => 1, 'end_date' => date('Y-m-d H:i:s')]);
            }

            if (array_key_exists('unidentified_id', $request->all())) {
                Alerts::where('id', $request->unidentified_id)->update(['status' => 1]);
            }
        }

        if ($request->action_taken_type_id == 9) {
            if (array_key_exists('caution_id', $request->all())) {
                Caution::where('id', $request->caution_id)->update(['status' => 2, 'end_date' => date('Y-m-d H:i:s')]);
            }

            if (array_key_exists('emergency_id', $request->all())) {
                Emergency::where('id', $request->emergency_id)->update(['status' => 2, 'end_date' => date('Y-m-d H:i:s')]);
            }

            if (array_key_exists('unidentified_id', $request->all())) {
                Alerts::where('id', $request->unidentified_id)->update(['status' => 2]);
            }
        }

        if (ActionTaken::create($request->all())) {

            $getActionTakenType = $this->actionTakenType->find($request->action_taken_type_id);

            if (array_key_exists('emergency_id', $request->all())) {
                $alert = $this->emergency->with('emergencyType')->with('homeowner_address')->where('id', $request->emergency_id)->get()->toArray();
                $alertType = $alert[0]['emergency_type']['description'];
            } elseif (array_key_exists('caution_id', $request->all())) {
                $alert = $this->caution->with('cautionType')->with('homeowner_address')->where('id', $request->caution_id)->get()->toArray();
                $alertType = $alert[0]['caution_type']['description'];
            } else {
                $alert = $this->alerts->with('homeowner_address')->where('id', $request->unidentified_id)->get()->toArray();
                $alertType = "Unidentified Alert";
            }

            $location = $alert[0]['homeowner_address']['address'];

            $fields = array(
                'app_id' => \Config::get('onesignal.' . 'brgyWifi.' . 'app-id'),
                'tags' => array(array('key' => 'userId', 'relation' => '=', 'value' => $request->home_owner_id)),
                'contents' => ["en" => $alertType . ' at ' . $location . '. ' . $getActionTakenType->message],
                'data' => ['additionalData' => 'action_taken_from_admin'],
                'android_group' => 'BRGY Comms',
            );

            $fields = json_encode($fields);

            $responsed = $curl->call($fields);
            $chikkaReply = new ChikkaReply();
            $homeowner = User::find($request->home_owner_id);
            $chikkaReply->call($homeowner, true, $getActionTakenType->message, $homeowner->contact_no);
            return array('msg' => 'Homeowner has been notified', 'msgCode' => 1);
        }

        return array('msg' => "There's an error in udpating alert.", 'msgCode' => 0);
    }

    public function reopenEmergency($id)
    {
        if ($this->emergency->where('id', $id)->update(['status' => 0, 'end_date' => null])) {
            return array('msg' => "Emergency has been re-opened", 'msgCode' => 1);
        }

        return array('msg' => "There's an error in re-opening emergency.", 'msgCode' => 0);
    }

    public function reopenCaution($id)
    {
        if ($this->caution->where('id', $id)->update(['status' => 0, 'end_date' => null])) {
            return array('msg' => "Caution has been re-opened", 'msgCode' => 1);
        }

        return array('msg' => "There's an error in re-opening caution.", 'msgCode' => 0);
    }

    public function updateAlertType(Request $request)
    {
        $homeowner_address = HomeownerAddress::where(['home_owner_id' => $request->home_owner_id, 'primary' => 1])->get()->toArray();

        $request->merge(array('homeowner_address_id' => $homeowner_address[0]['id']));

        if (!$this->alerts->where('id', $request->unidentified_id)->update(['status' => 1])) {
            return array('msg' => $request->unidentified_id, 'msgCode' => 0);
        }

        $request->except(['unidentified_id']);

        if ($emergency = $this->emergency->create($request->all())) {

            ActionTaken::where('unidentified_id', $request->unidentified_id)->update(['unidentified_id' => null, 'emergency_id' => $emergency->id]);

            return array('msg' => 'Unidentified alert has been changed.', 'msgCode' => 1);
        }

        return array('msg' => "There's an error in saving emergency type.", 'msgCode' => 0);
    }
}
