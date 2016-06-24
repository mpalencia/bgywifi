<?php

namespace BrngyWiFi\Modules\Frontend\Controllers;

use Illuminate\Http\Request;
use BrngyWiFi\Http\Requests;
use DB;
use BrngyWiFi\Http\Controllers\Controller;
use \BrngyWiFi\Modules\Frontend\Models\Frontend;

class FrontendController extends Controller {

    public function __construct(){
        $this->middleware('guest');
    }
    public function index(){
        return view('Frontend::home');
    }

}
