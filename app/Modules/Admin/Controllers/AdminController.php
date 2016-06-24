<?php

namespace BrngyWiFi\Modules\Admin\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \BrngyWiFi\Modules\Admin\Models\Admin;
use \BrngyWiFi\Modules\HomeOwnerAddress\Models\HomeOwnerAddress;
use \BrngyWiFi\Modules\User\Models\User;

class AdminController extends Controller
{

    private $user;

    public function dashboard()
    {
        return view('Admin::dashboard');
    }

    public function deleteUser(Request $request)
    {
        $deletedRows = User::where('id', $request->input('id'))->delete();
        if ($deletedRows) {
            $output = array('msg' => 'Record has been deleted.', 'msgCode' => 1);
        } else {
            $output = array('msg' => 'Record not found.', 'msgCode' => 0);
        }
        return $output;
    }
    public function getUser(Request $request)
    {
        $checkUser = User::with('homeOwnerAddress')->where(array('id' => $request->input('id')))->first();
        if (is_null($checkUser)) {
            $output = array('msg' => 'Record account not found.', 'msgCode' => 0);
        } else {
            $output = $checkUser;
        }
        return $output;
    }

    public function getUserAddress($id)
    {
        if (!$output = HomeOwnerAddress::find($id)) {
            $output = array('msg' => 'Record account not found.', 'msgCode' => 0);
        }

        return $output;
    }
    public function show($id)
    {

    }
    public function edit($id)
    {
        $admin = User::findOrFail($id);

        return view('Admin::profile_settings', array('admin' => $admin));
    }

    public function update($id, Request $request)
    {
        $validator = \Validator::make($request->all(), ['first_name' => 'required', 'last_name' => 'required']);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if (User::find($id)->fill($request->all())->save()) {
            \Session::flash('success_flash_message', 'Your profile has been successfully updated!');
        }

        return redirect()->back();
    }

    public function updateUserProfile(Request $request)
    {
        $checkUser = User::with('homeOwnerAddress')->where(array('id' => $request->input('id')))->first();
        if (is_null($checkUser)) {
            $output = array('msg' => 'Record account not found.', 'msgCode' => 0);
        } else {
            $output = $checkUser;
        }
        return $output;
    }
}
