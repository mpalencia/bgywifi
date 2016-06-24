<?php

Route::group(array('module'=>'Frontend','namespace' => 'BrngyWiFi\Modules\Frontend\Controllers'), function() {
    Route::get('/','FrontendController@index');
});
