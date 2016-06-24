<?php

namespace BrngyWiFi\Modules\Notifications\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\Notifications\Repository\NotificationsRepositoryInterface;
use BrngyWiFi\Modules\RefCategory\Models\RefCategory;
use BrngyWiFi\Modules\User\Models\User;
use BrngyWiFi\Modules\Visitors\Models\Visitors;
use BrngyWiFi\Modules\Visitors\Repository\VisitorsRepositoryInterface;
use BrngyWiFi\Services\Chikka\ChikkaReply;
use BrngyWiFi\Services\Curl\SendNotification;
use BrngyWiFi\Services\Image\UploadImage;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    /**
     * @var Notifications
     */
    protected $notifications;

    /**
     * @var Visitors
     */
    protected $visitors;

    /**
     * @param Visitors $visitors
     * @param Notifications $notifications
     */
    public function __construct(
        VisitorsRepositoryInterface $visitors,
        NotificationsRepositoryInterface $notifications) {
        $this->visitors = $visitors;
        $this->notifications = $notifications;
    }

    /**
     * Send Notification to Home Owner
     *
     * @param Request $request
     * @param BrngyWiFi\Services\Curl\SendNotification $curl
     * @param BrngyWiFi\Services\Image\UploadImage $image
     * @return Illuminate\Http\JsonResponse
     */
    public function sendMessageToHomeOwner(Request $request, UploadImage $image)
    {

        $request->merge(array('photo' => 'NA'));

        $visitors = $this->storeVisitors($request->input());
        $chikka_code = rand(1000, 9999);
        $notifications = $this->storeNotifications([
            'user_id' => $request->user_id,
            'visitors_id' => $visitors->id,
            'home_owner_id' => $request->home_owner_id,
            'homeowner_address_id' => $request->homeowner_address_id,
            'status' => 0,
            'chikka_code' => $chikka_code]);

        $user = User::find($request->home_owner_id);
        $ref_category = RefCategory::find($request->ref_category_id);
        $contact_no = $user->contact_no;
        $homeowner_name = $user->first_name . ' ' . $user->last_name;

        $send_message = "Hi " . $homeowner_name . ". You have an unexpected visitor. \n";
        $send_message .= "Name: " . $request->name . "\n";
        $send_message .= "Purpose of Visit: " . $ref_category->category_name . "\n";
        $send_message .= "Plate Number: " . $request->plate_number . "\n";
        $send_message .= "Car Description: " . $request->car_description . "\n";
        $send_message .= "Notes: " . $request->notes . "\n\n";
        $send_message .= "GUEST ID: " . $chikka_code . "\n";
        $send_message .= "Do you want to meet this person? Please reply YES/NO <SPACE> <GUEST ID>.";

        (new ChikkaReply)->call($request, true, $send_message, $contact_no);
        return ['result' => 'success', 'visitor' => $visitors];
    }

    public function uploadVisitorPhoto(Request $visitors, SendNotification $curl, UploadImage $image)
    {
        $lastVisitor = $this->visitors->getLastVisitor();

        $fields = array(
            'app_id' => \Config::get('onesignal.' . 'brgyWifi.' . 'app-id'),
            'tags' => array(array('key' => 'userId', 'relation' => '=', 'value' => $lastVisitor[0]['home_owner_id'])),
            'contents' => ["en" => $lastVisitor[0]['name'] . ' is coming to your house. ' . "\n\n" . 'Purpose of Visit: ' . $lastVisitor[0]['ref_category']['category_name']],
            'data' => ['additionalData' => 'unexpected_guest'],
            'android_group' => 'BRGY Comms',
        );

        $photo = $image->upload($visitors, $visitors->id);

        $this->visitors->updateVisitors($photo['visitor_id'], $photo);

        $this->visitors->deleteVisitors($visitors->id);

        $response = $curl->call(json_encode($fields));

        return ['result' => 'success', 'response' => $response];
    }

    /**
     * Send Notification to Security
     *
     * @param Request $request
     * @param BrngyWiFi\Services\Curl\SendNotification $curl
     * @param BrngyWiFi\Services\Image\UploadImage $image
     * @return Illuminate\Http\JsonResponse
     */
    public function sendMessageToSecurity(ResponseFactory $response, Request $request, SendNotification $curl)
    {
        $request = json_decode($request->getContent());

        $decision = ($request->status == 1) ? 'Accepted' : 'Denied';

        $fields = array(
            'app_id' => \Config::get('onesignal.' . 'brgyWifi.' . 'app-id'),
            'tags' => array(array('key' => 'userId', 'relation' => '=', 'value' => $request->user_id)),
            'contents' => ["en" => $request->name . ' has been ' . $decision],
            'data' => ['homeownerResponse' => $request->status, 'additionalData' => 'approved_denied_guest'],
            'android_group' => 'BRGY Comms',
        );

        $fields = json_encode($fields);

        $responsed = $curl->call($fields);

        $notificationsResult = $this->notifications->updateNotifcations($request);

        return $response->make(['isSucess' => $notificationsResult]);
    }

    /**
     * Get all approved unexpected visitors for security guard
     * @return Notifications
     */
    public function getApprovedUnexpectedVisitors($security_guard_id)
    {
        return $this->notifications->getApprovedUnexpectedVisitors($security_guard_id);
    }

    /**
     * Get all denied unexpected visitors for security guard
     * @return Notifications
     */
    public function getDeniedUnexpectedVisitors($security_guard_id)
    {
        return $this->notifications->getDeniedUnexpectedVisitors($security_guard_id);
    }

    /**
     * Get all approved unexpected visitors for homeowner
     * @return Notifications
     */
    public function getApprovedUnexpectedVisitorsByHomeowner($home_owner_id)
    {
        return $this->notifications->getApprovedUnexpectedVisitorsByHomeowner($home_owner_id);
    }

    /**
     * Get all denied unexpected visitors for home owner
     * @return Notifications
     */
    public function getDeniedUnexpectedVisitorsByHomeowner($home_owner_id)
    {
        return $this->notifications->getDeniedUnexpectedVisitorsByHomeowner($home_owner_id);
    }

    /**
     * Get all unexpected visitors in notifications by homeowner_id
     * @return Notifications
     */
    public function getVisitors($homeOwnerId)
    {
        return $this->notifications->getAllVisitors($homeOwnerId);
    }

    public function storeVisitors($payload)
    {
        return $this->visitors->createVisitors($payload);
    }

    public function storeNotifications($payload)
    {
        return $this->notifications->createNotifications($payload);
    }

    public function getVisitorsCount()
    {
        return $this->notifications->getVisitorsCount();
    }
}
