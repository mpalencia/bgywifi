<?php

namespace BrngyWiFi\Modules\ActionTaken\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\ActionTaken\Repository\ActionTakenRepositoryInterface;
use BrngyWiFi\Modules\Alerts\Models\Alerts;
use BrngyWiFi\Modules\Caution\Models\Caution;
use BrngyWiFi\Modules\Emergency\Models\Emergency;
use BrngyWiFi\Services\Curl\SendNotification;
use Illuminate\Http\Request;
use \BrngyWiFi\Modules\ActionTakenType\Models\ActionTakenType;

class ActionTakenController extends Controller
{
    /**
     * @var ActionTakenRepositoryInterface
     */
    private $actionTakenRepositoryInterface;

    protected $actionTakenType;

    protected $emergency;

    protected $caution;

    public function __construct(Emergency $emergency, Caution $caution, ActionTakenRepositoryInterface $actionTakenRepositoryInterface, ActionTakenType $actionTakenType)
    {
        $this->actionTakenRepositoryInterface = $actionTakenRepositoryInterface;
        $this->actionTakenType = $actionTakenType;
        $this->emergency = $emergency;
        $this->caution = $caution;
    }

    /**
     * Get all ActionTaken
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function getAllActionTaken($id)
    {
        return $this->actionTakenRepositoryInterface->getAllActionTaken($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveActionTaken(Request $request, SendNotification $curl)
    {
        $request = $request->getContent();

        $requestArray = json_decode($request);

        if ($requestArray->action_taken_type_id == 5) {
            if (array_key_exists('caution_id', json_decode($request, true))) {
                Caution::where('id', $requestArray->caution_id)->update(['status' => 1, 'end_date' => date('Y-m-d H:i:s')]);
            }

            if (array_key_exists('emergency_id', json_decode($request, true))) {
                Emergency::where('id', $requestArray->emergency_id)->update(['status' => 1, 'end_date' => date('Y-m-d H:i:s')]);
            }

            if (array_key_exists('unidentified_id', json_decode($request, true))) {
                Alerts::where('id', $requestArray->unidentified_id)->update(['status' => 1]);
            }
        }

        if ($this->actionTakenRepositoryInterface->createActionTaken($request)) {
            $requestArray = json_decode($request, true);
            $request = json_decode($request);

            $getActionTakenType = $this->actionTakenType->find($request->action_taken_type_id);

            if (array_key_exists('emergency_id', $requestArray)) {
                $alert = $this->emergency->with('emergencyType')->with('homeowner_address')->where('id', $request->emergency_id)->get()->toArray();
                $alertType = $alert[0]['emergency_type']['description'];
            } else if (array_key_exists('caution_id', $requestArray)) {
                $alert = $this->caution->with('cautionType')->with('homeowner_address')->where('id', $request->caution_id)->get()->toArray();
                $alertType = $alert[0]['caution_type']['description'];
            } else {
                $alert = Alerts::with('homeowner_address')->where('id', $request->unidentified_id)->get()->toArray();
                $alertType = "UNIDENTIFIED ALERT!";
            }

            $location = $alert[0]['homeowner_address']['address'];

            $fields = array(
                'app_id' => \Config::get('onesignal.' . 'brgyWifi.' . 'app-id'),
                'tags' => array(array('key' => 'userId', 'relation' => '=', 'value' => $request->home_owner_id)),
                'contents' => ["en" => $alertType . ' at ' . $location . '. ' . $getActionTakenType->message],
                'data' => ['additionalData' => 'action_taken_from_security'],
                'android_group' => 'BRGY Comms',
            );

            $fields = json_encode($fields);

            $response = $curl->call($fields);

            return ['result' => 'success'];
        }

        return ['result' => 'error'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveActionTakenViaChikka($request, SendNotification $curl)
    {
        //$request = $request->getContent();

        $requestArray = json_decode($request);

        if ($requestArray->action_taken_type_id == 5) {
            if (array_key_exists('caution_id', json_decode($request, true))) {
                Caution::where('id', $requestArray->caution_id)->update(['status' => 1, 'end_date' => date('Y-m-d H:i:s')]);
            }

            if (array_key_exists('emergency_id', json_decode($request, true))) {
                Emergency::where('id', $requestArray->emergency_id)->update(['status' => 1, 'end_date' => date('Y-m-d H:i:s')]);
            }

            if (array_key_exists('unidentified_id', json_decode($request, true))) {
                Alerts::where('id', $requestArray->unidentified_id)->update(['status' => 1]);
            }
        }

        if ($this->actionTakenRepositoryInterface->createActionTaken($request)) {
            $requestArray = json_decode($request, true);
            $request = json_decode($request);

            $getActionTakenType = $this->actionTakenType->find($request->action_taken_type_id);

            if (array_key_exists('emergency_id', $requestArray)) {
                $alert = $this->emergency->with('emergencyType')->with('homeowner_address')->where('id', $request->emergency_id)->get()->toArray();
                $alertType = $alert[0]['emergency_type']['description'];
            } else if (array_key_exists('caution_id', $requestArray)) {
                $alert = $this->caution->with('cautionType')->with('homeowner_address')->where('id', $request->caution_id)->get()->toArray();
                $alertType = $alert[0]['caution_type']['description'];
            } else {
                $alert = Alerts::with('homeowner_address')->where('id', $request->unidentified_id)->get()->toArray();
                $alertType = "UNIDENTIFIED ALERT!";
            }

            $location = $alert[0]['homeowner_address']['address'];

            $fields = array(
                'app_id' => \Config::get('onesignal.' . 'brgyWifi.' . 'app-id'),
                'tags' => array(array('key' => 'userId', 'relation' => '=', 'value' => $request->home_owner_id)),
                'contents' => ["en" => $alertType . ' at ' . $location . '. ' . $getActionTakenType->message],
                'data' => ['additionalData' => 'action_taken_from_security'],
                'android_group' => 'BRGY Comms',
            );

            $fields = json_encode($fields);

            $response = $curl->call($fields);

            return ['result' => 'success', 'response' => $response];
        }

        return ['result' => 'error'];
    }

    public function sendMsg($mobileNumber = '09067279052', $msgReply = null)
    {
        if (!isset($msgReply)) {
            $msgReply = urlencode('Your number is not registered. Kindly contact your Organization\'s Uploader Representative to be added to the system.');
        }

        $message_id = $this->generate_msgid(32);
        $secretKey = GABAY_CHIKKA_API_SECRET_KEY; //default secret key
        $clientId = GABAY_CHIKKA_CLIENT_ID; //default client ID

        $fields = array(
            'message_type' => urlencode('SEND'),
            'mobile_number' => urlencode($mobileNumber),
            'shortcode' => urlencode(GABAY_SHORTCODE),
            'message_id' => urlencode($message_id),
            'message' => $msgReply,
            'client_id' => $clientId,
            'secret_key' => $secretKey,
        );

        $fields_string = '';
        foreach ($fields as $key => $value) {$fields_string .= $key . '=' . $value . '&';}
        rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        Storage::prepend('sendLog.log', 'Result : ' . $result . '  Date: ' . date("Y-m-d H:i:s"));
        return true;
    }
}
