<?php

namespace BrngyWiFi\Modules\Emergency\Controllers;

use BrngyWiFi\Events\MessageAlertsWasCreated;
use BrngyWiFi\Http\Controllers\AuthenticateController;
use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\ActionTakenType\Models\ActionTakenType;
use BrngyWiFi\Modules\ActionTaken\Controllers\ActionTakenController;
use BrngyWiFi\Modules\Caution\Repository\CautionRepositoryInterface;
use BrngyWiFi\Modules\Emergency\Repository\EmergencyRepositoryInterface;
use BrngyWiFi\Modules\Notifications\Repository\NotificationsRepositoryInterface;
use BrngyWiFi\Modules\RefCategory\Models\RefCategory;
use BrngyWiFi\Modules\UserRoles\Repository\UserRolesRepositoryInterface;
use BrngyWiFi\Modules\User\Controllers\UserController;
use BrngyWiFi\Modules\User\Models\User;
use BrngyWiFi\Modules\Visitors\Repository\VisitorsRepositoryInterface;
use BrngyWiFi\Services\Chikka\ChikkaReply;
use BrngyWiFi\Services\Curl\SendNotification;
use Illuminate\Http\Request;
use Storage;

class EmergencyController extends Controller
{
    /**
     * @var EmergencyRepositoryInterface
     */
    private $emergencyRepositoryInterface;

    /**
     * @var CautionRepositoryInterface
     */
    private $cautionRepositoryInterface;

    /**
     * @var UserRolesRepositoryI000000nterface
     */
    private $userRolesRepositoryInterface;

    /**
     * @var Notifications
     */
    protected $notifications;

    /**
     * @var Visitors
     */
    protected $visitors;

    /**
     * @var AuthenticateController
     */
    protected $authenticate;

    /**
     * @var UserController
     */
    protected $userController;

    /**
     * @var ActionTakenController
     */
    protected $actionTakenController;

    /**
     * @param Emergency
     * @param UserRoles
     */
    public function __construct(
        CautionRepositoryInterface $cautionRepositoryInterface,
        EmergencyRepositoryInterface $emergencyRepositoryInterface,
        UserRolesRepositoryInterface $userRolesRepositoryInterface,
        VisitorsRepositoryInterface $visitors,
        NotificationsRepositoryInterface $notifications,
        AuthenticateController $authenticate,
        UserController $userController,
        ActionTakenController $actionTakenController
    ) {
        $this->emergencyRepositoryInterface = $emergencyRepositoryInterface;
        $this->cautionRepositoryInterface = $cautionRepositoryInterface;
        $this->userRolesRepositoryInterface = $userRolesRepositoryInterface;
        $this->visitors = $visitors;
        $this->notifications = $notifications;
        $this->authenticate = $authenticate;
        $this->userController = $userController;
        $this->actionTakenController = $actionTakenController;
    }

    /**
     * Get a certain emergency
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmergency($id)
    {
        return $this->emergencyRepositoryInterface->getEmergency($id);
    }
    /**
     * Get all emergency messages
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllEmergency()
    {
        return $this->emergencyRepositoryInterface->getAllEmergency();
    }

    /**
     * Get all emergency alerts for home owner
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllEmergencyWithHomeowner()
    {
        return $this->emergencyRepositoryInterface->getAllEmergencyWithHomeowner();
    }

    /**
     * Get all emergency alerts for security guard
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllEmergencyForSecurity()
    {
        return $this->emergencyRepositoryInterface->getAllEmergencyForSecurity();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveEmergency(Request $request)
    {
        $emergency = $this->emergencyRepositoryInterface->createEmergency($request->getContent());

        $emergency_type_model = $this->getEmergency($emergency->id);

        $sendNotification = \Event::fire(new MessageAlertsWasCreated($emergency, $emergency_type_model, 'emergency'));

        if ($sendNotification) {
            return ['result' => 'success'];
        }

        return ['result' => 'error', 'error' => 'No security account stored in database.'];
    }

    /**
     * Save emergency via chikka
     *
     * @param Request $request
     * @return Illuminate\Http\JsonResponse
     */
    public function saveEmergencyViaChikka(Request $request, ChikkaReply $chikkaReply)
    {

        Storage::prepend('chikka_access.log', json_encode($request->all()));

        //if (strtolower($request->input('message_type')) == 'incoming' || strtolower($request->input('message_type')) == 'send') {
        $r = json_decode($request->message, true);
        $texter = User::where('contact_no', $request->mobile_number)->first();

        if (is_null($r)) {

            $message = $request->message;

            switch (strtolower($message)) {
                case 'yes':
                    $decision = 'Accepted';
                    $homeownerResponse = 1;
                    break;

                case 'no':
                    $decision = 'Denied';
                    $homeownerResponse = 2;
                    break;

                default:
                    $chikkaReply->call($request, false, 'Invalid input. Please reply YES/NO');
                    return ['result' => 'error', 'message' => 'Invalid input.'];
                    break;
            }

            //$notif = $this->notifications->getByChikkaCode($message);
            $notif = $this->notifications->getFirstVisitor($texter->id);

            if (!$notif) {
                $chikkaReply->call($request, false, 'Invalid code or visitor is already accepted/denied.');
                return ['result' => 'error', 'message' => 'Invalid code or visitor is already accepted/denied'];
            }

            $visitor = $this->visitors->getVisitor($notif->visitors_id);

            $fields = array(
                'app_id' => \Config::get('onesignal.' . 'brgyWifi.' . 'app-id'),
                'tags' => array(array('key' => 'userType', 'relation' => '=', 'value' => 2)),
                'contents' => ["en" => $visitor->name . ' has been ' . $decision],
                'data' => ['homeownerResponse' => $homeownerResponse, 'additionalData' => 'approved_denied_guest'],
                'android_group' => 'BRGY Comms',
            );

            $fields = json_encode($fields);

            $curl = (new SendNotification)->call($fields);

            $notificationsResult = $this->notifications->updateNotifcationsViaChikka($notif->id, $homeownerResponse);

            $chikkaReply->call($request);

            return ['result' => 'success'];
        }

        switch ($r['type']) {
            case '1': //save emergency

                if (User::where('contact_no', $request->mobile_number)->first()) {
                    $emergency = $this->emergencyRepositoryInterface->createEmergency($request->message, 1);

                    $emergency_type_model = $this->getEmergency($emergency->id);

                    $sendNotification = \Event::fire(new MessageAlertsWasCreated($emergency, $emergency_type_model, 'emergency'));
                }

                break;

            case '2': //save caution
                if (User::where('contact_no', $request->mobile_number)->first()) {
                    $caution = $this->cautionRepositoryInterface->createCaution($request->message, 1);

                    $caution_type_model = $this->cautionRepositoryInterface->getCaution($caution->id);

                    $sendNotification = \Event::fire(new MessageAlertsWasCreated($caution, $caution_type_model, 'caution'));
                }

                break;

            case '3': //login
                $this->authenticate->authorizeViaChikka(json_decode($request->message, true));
                break;

            case '4': //enter pin code
                if (User::where('contact_no', $request->mobile_number)->first()) {

                    $this->userController->validatePinCodeViaChikka($request);
                }

                break;

            case '5': // security to chikka to homeowner emergency
                $sendNotification = new SendNotification;
                $this->actionTakenController->saveActionTakenViaChikka($request->message, $sendNotification);
                $message = ActionTakenType::find(json_decode($request->message, true)['action_taken_type_id'])->message;
                $contact_no = User::find(json_decode($request->message, true)['home_owner_id'])->contact_no;
                if ($chikka = $chikkaReply->call($request, true, $message, $contact_no)) {
                    return ['result' => 'success'];
                }

                return ['result' => 'error', 'message' => $chikka];

                break;

            case '6': // security to chikka homeowner caution
                $sendNotification = new SendNotification;
                $this->actionTakenController->saveActionTakenViaChikka($request->message, $sendNotification);
                $message = ActionTakenType::find(json_decode($request->message, true)['action_taken_type_id'])->message;
                $contact_no = User::find(json_decode($request->message, true)['home_owner_id'])->contact_no;
                if ($chikka = $chikkaReply->call($request, true, $message, $contact_no)) {
                    return ['result' => 'success'];
                }

                return ['result' => 'error', 'message' => $chikka];
                break;

            case '7': // security to chikka homeowner unidentified
                $sendNotification = new SendNotification;
                $this->actionTakenController->saveActionTakenViaChikka($request->message, $sendNotification);
                $message = ActionTakenType::find(json_decode($request->message, true)['action_taken_type_id'])->message;
                $contact_no = User::find(json_decode($request->message, true)['home_owner_id'])->contact_no;
                if ($chikka = $chikkaReply->call($request, true, $message, $contact_no)) {
                    return ['result' => 'success'];
                }

                return ['result' => 'error', 'message' => $chikka];
                break;

            default:
                $message = json_decode($request->input('message'), true);

                $message['photo'] = 'NA';
                $visitors = $this->storeVisitors($message);
                $chikka_code = rand(1000, 9999);
                $notifications = $this->storeNotifications([
                    'user_id' => $visitors->user_id,
                    'visitors_id' => $visitors->id,
                    'home_owner_id' => $visitors->home_owner_id,
                    'homeowner_address_id' => $message['homeowner_address_id'],
                    'status' => 0,
                    'chikka_code' => $chikka_code,
                ]);

                $user = User::find($visitors->home_owner_id);
                $ref_category = RefCategory::find($message['ref_category_id']);
                $contact_no = $user->contact_no;
                $homeowner_name = $user->first_name . ' ' . $user->last_name;

                $send_message = "Hi " . $homeowner_name . ". You have an unexpected visitor. \n";
                $send_message .= "Name: " . $message['name'] . "\n";
                $send_message .= "Purpose of Visit: " . $ref_category->category_name . "\n";
                $send_message .= "Plate Number: " . $message['plate_number'] . "\n";
                $send_message .= "Car Description: " . $message['car_description'] . "\n";
                $send_message .= "Notes: " . $message['notes'] . "\n\n";
                $send_message .= "GUEST ID: " . $chikka_code . "\n";
                $send_message .= "Do you want to meet this person? Please reply YES/NO <SPACE> <GUEST ID>.";

                if ($chikka = $chikkaReply->call($request, true, $send_message, $contact_no)) {
                    return ['result' => 'success'];
                }

                return ['result' => 'error', 'message' => $chikka];

                break;

                /*echo "Accepted";
        exit(0);*/
        }

        $chikkaReply->call($request);

        return ['result' => 'success'];
        exit(0);
        //}

        echo "Error";
        exit(0);
    }

    public function storeVisitors($payload)
    {
        return $this->visitors->createVisitors($payload);
    }

    public function storeNotifications($payload)
    {
        return $this->notifications->createNotifications($payload);
    }
}
