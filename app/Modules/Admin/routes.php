<?php

Route::group(array('module' => 'Admin', 'middleware' => 'guest', 'namespace' => 'BrngyWiFi\Modules\Admin\Controllers'), function () {
    /* Login */
    Route::get('/admin', 'LoginController@index');
    Route::post('/admin/login', 'LoginController@login');
    Route::get('/admin/logout', 'LoginController@logout');

    /* Visitors */
    Route::get('/admin/visitors/{view?}/{id?}', 'VisitorController@visitors');
    Route::get('/admin/visitors', 'VisitorController@visitors');
});

Route::group(array('module' => 'Admin', 'namespace' => 'BrngyWiFi\Modules\Admin\Controllers'), function () {
    Route::get('/getAlertsCount', 'DashboardController@getAlertsCount');
    Route::get('/getTotalAlerts', 'DashboardController@getTotalAlerts');
    Route::get('/getAllAlertCount', 'DashboardController@getAllAlertCount');
    Route::get('/getEventCount', 'DashboardController@getEventCount');
    Route::get('/getEventsLongLat', 'DashboardController@getEventsLongLat');
    Route::get('/admin/getUnidentified', 'AlertsController@getUnidentified');
    Route::get('/admin/getEmergencies', 'AlertsController@getEmergencies');
    Route::get('/admin/getCautions', 'AlertsController@getCautions');
    Route::get('/admin/getUnidentifiedUpdate/{unidentified_id}', 'AlertsController@getUnidentifiedUpdate');
    Route::get('/admin/getEmergencyUpdate/{emergency_id}', 'AlertsController@getEmergencyUpdate');
    Route::get('/admin/getCautionUpdate/{caution_id}', 'AlertsController@getCautionUpdate');
});

Route::group(array('module' => 'Admin', 'middleware' => 'auth', 'namespace' => 'BrngyWiFi\Modules\Admin\Controllers'), function () {

    Route::post('/user/delete', 'AdminController@deleteUser');
    Route::post('/user/get', 'AdminController@getUser');
    Route::post('/user/getAddress/{address_id}', 'AdminController@getUserAddress');

    /* Residentials CRUD */
    Route::get('/residentials', 'ResidentialController@users');
    Route::get('/residentials/addressList/{home_owner_id}', 'ResidentialController@addressList');
    Route::post('/residential/add', 'ResidentialController@addResidential');
    Route::post('/residential/edit', 'ResidentialController@editResidential');
    Route::post('/residential/editAddress', 'ResidentialController@editResidentialAddress');
    Route::post('/residential/postAddress', 'ResidentialController@postResidentialAddress');
    Route::post('/residential/deleteAddress/{address_id}', 'ResidentialController@deleteResidentialAddress');

    /* Security CRUD */
    Route::get('/securities', 'SecurityController@users');
    Route::post('/security/add', 'SecurityController@addSecurity');
    Route::post('/security/edit', 'SecurityController@editSecurity');

    /* Dashboard */
    Route::get('/dashboard', 'DashboardController@dashboard');
    Route::get('/getEmergency', 'DashboardController@getEmergency');
    Route::get('/getCaution', 'DashboardController@getCaution');
    Route::get('/getIssues', 'DashboardController@getIssues');
    Route::get('/getUnidentifiedAlerts', 'DashboardController@getUnidentifiedAlerts');

    /* Events */
    Route::get('/admin/events/{view?}/{id?}', 'EventController@events');
    Route::get('/admin/events', 'EventController@events');
    Route::post('/event/delete', 'EventController@deleteEvent');

    /* Messages */
    Route::get('/admin/messages', 'MessagesController@messages');
    Route::post('/admin/message/send', 'MessagesController@send');
    Route::post('/admin/message/delete', 'MessagesController@deleteMessage');

    /* Alerts */
    Route::get('/admin/alerts', 'AlertsController@index');

    Route::put('/admin/reopenEmergency/{emergency_id}', 'AlertsController@reopenEmergency');
    Route::put('/admin/reopenCaution/{caution_id}', 'AlertsController@reopenCaution');

    Route::post('/admin/updateAlertType', 'AlertsController@updateAlertType');

    /* Issues/Suggestions/Complaints */
    Route::get('/admin/issues', 'IssuesController@index');
    Route::post('/admin/issueActionTaken', 'IssuesController@updateIssueActionTaken');
    Route::put('/admin/updateIssue/{issue_id}', 'IssuesController@updateIssue');
    Route::put('/admin/reopenIssue/{issue_id}', 'IssuesController@reopenIssue');

    /* Activity Logs */
    Route::get('/admin/activity_logs', 'ActivityLogsController@index');

    /* Reports */
    Route::get('/admin/reports', 'ReportsController@index');
    Route::post('/admin/reports/generate', 'ReportsController@generateReport');

    Route::post('/admin/actionTaken', 'AlertsController@updateActionTaken');

    /*Admin Settings*/
    Route::resource('/admin/profile_settings', 'AdminController');
    Route::resource('/admin/account_settings', 'AccountController');

    /*
     * Advertisement
     */
    Route::get('/admin/advertisement', 'AdvertisementController@index');
    Route::post('/admin/advertisement/upload', 'AdvertisementController@upload');

    /*
     * Bug Report
     */
    Route::resource('/admin/bug-report', 'BugReportController');
    Route::put('/admin/bug-report/updateBugReport/{bug_report_id}', 'BugReportController@updateBugReport');

});
