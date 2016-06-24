<?php

namespace BrngyWiFi\Modules\Admin\Controllers;

use Auth;
use BrngyWiFi\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \BrngyWiFi\Modules\Admin\Models\Admin;

class LoginController extends Controller
{

    private $user;
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {

        if (Auth::check()) {
            return redirect("dashboard");
        } else {
            return view("Admin::admin");
        }
    }

    public function login(Request $request)
    {

        if ($request->username == '') {
            return json_encode(array('msgCode' => 0, 'msg' => 'Please enter your Username.'));
        }

        if ($request->password == '') {
            return json_encode(array('msgCode' => 0, 'msg' => 'Please enter your Password.'));
        }

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return json_encode(array('msgCode' => 1, 'msg' => 'Success'));
        } else {
            return json_encode(array('msgCode' => 0, 'msg' => 'Invalid Username/Password!'));
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/admin');
    }
}
