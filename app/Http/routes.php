<?php

Route::group(['middleware' => 'cors'], function () {

    /*
     * Authorize Token
     */
    Route::post('api-token-auth', 'BrngyWiFi\Http\Controllers\AuthenticateController@authorize');
    Route::post('createLog', 'BrngyWiFi\Http\Controllers\LogsController@createLog');

    Route::group(['middleware' => 'APIJWT.auth'], function () {

        /*
         * Token Validation
         */
        Route::get('isAuthenticated', 'BrngyWiFi\Http\Controllers\AuthenticateController@isAuthenticated');

        /*
         * User
         */
        Route::group(array('module' => 'User', 'namespace' => 'BrngyWiFi\Modules\User\Controllers'), function () {
            Route::get('users', 'UserController@getHomeOwnerUsers');
            Route::get('user/{id}', 'UserController@getUserBytId');
            Route::get('userAddress/{id}', 'UserController@getUserAddressById');
            Route::post('validatePinCode/{home_owner_id}', 'UserController@validatePinCode');
            Route::post('validatePinCodeBeforeUpdate/{home_owner_id}', 'UserController@validatePinCodeBeforeUpdate');
            Route::put('updateUser/{home_owner_id}', 'UserController@updateUser');
            Route::post('forgotPassword', 'UserController@forgotPassword');
            Route::put('changePassword/{home_owner_id}', 'UserController@changePassword');
        });

        /*
         * HomeownerAddress
         */
        Route::group(array('module' => 'HomeownerAddress', 'namespace' => 'BrngyWiFi\Modules\HomeownerAddress\Controllers'), function () {
            Route::get('getAllHomeownerAddress/{home_owner_id}', 'HomeownerAddressController@getAllHomeownerAddress');
        });

        /*
         * User Roles
         */
        Route::group(array('module' => 'UserRoles', 'namespace' => 'BrngyWiFi\Modules\UserRoles\Controllers'), function () {
            Route::get('getAllSecurity', 'UserRolesController@getAllSecurity');
        });

        /*
         * Event
         */
        Route::group(['module' => 'Event', 'namespace' => 'BrngyWiFi\Modules\Event\Controllers'], function () {
            Route::resource('events', 'EventController');
            Route::get('getEvent/{event_id}', 'EventController@getEvent');
            Route::get('getEventsByUserId/{home_owner_id}', 'EventController@getEventsByUserId');
            Route::get('getEventsByHomeOwnerId/{home_owner_id}', 'EventController@getEventsByHomeOwnerId');
            Route::get('getIncomingGuestEvents/{ref_category_id}/{home_owner_id}', 'EventController@getIncomingGuestEvents');
            Route::get('getEventAndGuests/{event_id}', 'EventController@getEventAndGuests');
        });

        /*
         * Event Guest List
         */
        Route::group(['module' => 'EventGuestList', 'namespace' => 'BrngyWiFi\Modules\EventGuestList\Controllers'], function () {
            Route::resource('eventGuestList', 'EventGuestListController');
            Route::get('getEventGuestListByEventId/{event_id}/{home_owner_id}', 'EventGuestListController@getEventGuestListByEventId');
            Route::get('getEventGuestList/{event_id}/{home_owner_id}', 'EventGuestListController@getEventGuestList');
            Route::get('getNotificationsEventGuestList/{home_owner_id}', 'EventGuestListController@getNotificationsEventGuestList');

            Route::post('sendIncomingVisitorsToHomeOwner/{home_owner_id}/{event_id}', 'EventGuestListController@sendIncomingVisitorsToHomeOwner');

            Route::get('getAllGuestsAndVisitors', 'EventGuestListController@getAllGuestsAndVisitors');
            Route::get('getIncomingGuestsByEvents/{event_id}/{home_owner_id}', 'EventGuestListController@getIncomingGuestsByEvents');
            Route::put('updateAllEventGuestListStatus/{home_owner_id}', 'EventGuestListController@updateAllEventGuestListStatus');
        });

        /*
         * Notifications
         */
        Route::group(['module' => 'Notifications', 'namespace' => 'BrngyWiFi\Modules\Notifications\Controllers'], function () {
            Route::post('notifications/sendMessageToHomeOwner', 'NotificationsController@sendMessageToHomeOwner');
            Route::post('notifications/sendMessageToSecurity', 'NotificationsController@sendMessageToSecurity');

            Route::get('visitors/{home_owner_id}', 'NotificationsController@getVisitors');
            Route::get('notifications/getApprovedUnexpectedVisitors/{security_guard_id}', 'NotificationsController@getApprovedUnexpectedVisitors');
            Route::get('notifications/getDeniedUnexpectedVisitors/{security_guard_id}', 'NotificationsController@getDeniedUnexpectedVisitors');

            Route::get('notifications/getApprovedUnexpectedVisitorsByHomeowner/{home_owner_id}', 'NotificationsController@getApprovedUnexpectedVisitorsByHomeowner');
            Route::get('notifications/getDeniedUnexpectedVisitorsByHomeowner/{home_owner_id}', 'NotificationsController@getDeniedUnexpectedVisitorsByHomeowner');

            Route::post('notifications/uploadVisitorPhoto', 'NotificationsController@uploadVisitorPhoto');

            Route::post('notifications/saveUnexpectedVisitorViaChikka', 'NotificationsController@saveUnexpectedVisitorViaChikka');

            Route::get('notifications/getVisitorsCount', 'NotificationsController@getVisitorsCount');
        });

        /*
         * GuestList
         */
        Route::group(['module' => 'GuestList', 'namespace' => 'BrngyWiFi\Modules\GuestList\Controllers'], function () {
            Route::resource('guestList', 'GuestListController');
            Route::get('getAllGuests/{home_owner_id}', 'GuestListController@getAllGuests');
            Route::post('postGuestList/{event_id}', 'GuestListController@saveGuestList');
        });

        /*
         * RefCategory
         */
        Route::group(['module' => 'RefCategory', 'namespace' => 'BrngyWiFi\Modules\RefCategory\Controllers'], function () {
            Route::get('getAllRefCategory', 'RefCategoryController@getAllRefCategory');
        });

        /*
         * Messages
         */
        Route::group(['module' => 'Messages', 'namespace' => 'BrngyWiFi\Modules\Messages\Controllers'], function () {
            Route::get('/messages', 'MessagesController@messages');
            Route::get('/getAllMessagesByHomeowner/{home_owner_id}', 'MessagesController@getAllMessagesByHomeowner');
            Route::post('/message/send', 'MessagesController@send');
            Route::post('/message/delete', 'MessagesController@deleteMessage');
        });

        /*
         * Unidetified Alerts
         */
        Route::group(['module' => 'Alerts', 'namespace' => 'BrngyWiFi\Modules\Alerts\Controllers'], function () {
            Route::get('getUnidentifiedWithHomeOwner', 'AlertsController@getUnidentifiedWithHomeOwner');
            Route::get('getUnidentifiedForSecurity', 'AlertsController@getUnidentifiedForSecurity');
        });

        /*
         * Emergency Type
         */
        Route::group(['module' => 'EmergencyType', 'namespace' => 'BrngyWiFi\Modules\EmergencyType\Controllers'], function () {
            Route::get('getAllEmergencyType', 'EmergencyTypeController@getAllEmergencyType');
        });

        /*
         * Emergency
         */
        Route::group(['module' => 'Emergency', 'namespace' => 'BrngyWiFi\Modules\Emergency\Controllers'], function () {
            Route::get('getAllEmergency', 'EmergencyController@getAllEmergency');
            Route::get('getAllEmergencyWithHomeowner', 'EmergencyController@getAllEmergencyWithHomeowner');
            Route::get('getAllEmergencyForSecurity', 'EmergencyController@getAllEmergencyForSecurity');
            Route::post('saveEmergency', 'EmergencyController@saveEmergency');
            Route::post('saveEmergencyViaChikka', 'EmergencyController@saveEmergencyViaChikka');
        });

        /*
         * Caution Type
         */
        Route::group(['module' => 'CautionType', 'namespace' => 'BrngyWiFi\Modules\CautionType\Controllers'], function () {
            Route::get('getAllCautionType', 'CautionTypeController@getAllCautionType');
        });

        /*
         * Caution
         */
        Route::group(['module' => 'Caution', 'namespace' => 'BrngyWiFi\Modules\Caution\Controllers'], function () {
            Route::get('getAllCaution', 'CautionController@getAllCaution');
            Route::get('getAllCautionWithHomeowner', 'CautionController@getAllCautionWithHomeowner');
            Route::get('getAllCautionForSecurity', 'CautionController@getAllCautionForSecurity');
            Route::post('saveCaution', 'CautionController@saveCaution');
            Route::post('saveCautionViaChikka', 'CautionController@saveCautionViaChikka');
        });

        /*
         * Device User
         */
        Route::group(['module' => 'DeviceUser', 'namespace' => 'BrngyWiFi\Modules\DeviceUser\Controllers'], function () {
            Route::get('getAllDeviceUser', 'DeviceUserController@getAllDeviceUser');
            Route::get('getAllDeviceUserByHomeowner/{home_owner_id}', 'DeviceUserController@getAllDeviceUserByHomeowner');
            Route::post('saveDeviceUser', 'DeviceUserController@saveDeviceUser');
            Route::post('updateDeviceUser/{home_owner_id}', 'DeviceUserController@updateDeviceUser');
            Route::delete('deleteDeviceUser/{device_user_id}', 'DeviceUserController@deleteDeviceUser');
        });

        /*
         * ActionTaken
         */
        Route::group(['module' => 'ActionTaken', 'namespace' => 'BrngyWiFi\Modules\ActionTaken\Controllers'], function () {
            Route::get('getAllActionTaken/{alarm_id}', 'ActionTakenController@getAllActionTaken');
            Route::post('saveActionTaken', 'ActionTakenController@saveActionTaken');
        });

        /*
         * SuggestionOrComplaints
         */
        Route::group(['module' => 'SuggestionComplaints', 'namespace' => 'BrngyWiFi\Modules\SuggestionComplaints\Controllers'], function () {
            Route::get('getAllSuggestionOrComplaints/{home_owner_id}', 'SuggestionComplaintsController@getAllSuggestionOrComplaints');
            Route::get('getAllSuggestionOrComplaintsForSecurity', 'SuggestionComplaintsController@getAllSuggestionOrComplaintsForSecurity');
            Route::post('createSuggestionOrComplaints', 'SuggestionComplaintsController@createSuggestionOrComplaints');
        });

        /*
         * Advertisement
         */
        /*Route::group(['module' => 'Advertisement', 'namespace' => 'BrngyWiFi\Modules\Advertisement\Controllers'], function () {
        Route::get('getAdImage', 'AdvertisementController@getAdImage');
        });*/

        Route::get('getNotificationsCount/{home_owner_id}', function ($home_owner_id) {
            $unexpectedVisitors = \BrngyWiFi\Modules\Notifications\Models\Notifications::where('home_owner_id', $home_owner_id)->where('status', 0)->whereBetween('updated_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d') . ' 24:00:00')))->get()->count();
            $emergency = \BrngyWiFi\Modules\Emergency\Models\Emergency::where('status', 0)->whereNull('end_date')->get()->count();
            $caution = \BrngyWiFi\Modules\Caution\Models\Caution::where('status', 0)->whereNull('end_date')->get()->count();
            $unidentified = \BrngyWiFi\Modules\Alerts\Models\Alerts::where('status', 0)->get()->count();

            $messages = \BrngyWiFi\Modules\Messages\Models\Messages::where(['status' => 0, 'to_user_id' => $home_owner_id])->get()->count();

            return array('authorizations' => $unexpectedVisitors, 'alerts' => $caution + $emergency + $unidentified, 'messages' => $messages);
        });

    });
});
