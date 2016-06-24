<?php namespace BrngyWiFi\Modules\User\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Http\Requests\LoginRequest;
use Auth;
use \BrngyWiFi\Modules\User\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller {
	public function login(LoginRequest $request){
		//dd(Hash::make('password'));
		if (Auth::attempt(['username' => $request->username, 'password' => $request->password])){
        	return json_encode(array('result'=>'success'));
        }else{
        	return json_encode(array('result'=>'error','dialog'=>'Invalid Username/Password'));
        }
		
	}
	public function logout(){
		Auth::logout();
		return redirect('/');
	}
}
