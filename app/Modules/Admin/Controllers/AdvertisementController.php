<?php

namespace BrngyWiFi\Modules\Admin\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Session;
use Validator;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin::advertisement');
    }

    /**
     * Upload photo
     *
     * @param File $image
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $image = $request->file('image');

        $validator = Validator::make(['image' => $image], ['image' => 'required|image|max:100'], ['image' => 'Uploaded file is not an image format.']);

        if ($validator->fails()) {
            Session::flash('error', $validator->errors()->first('image'));
            return Redirect::to('admin/advertisement');
        }

        if ($image->isValid()) {

            $destinationPath = 'advertisement'; // upload path

            $extension = $image->getClientOriginalExtension(); // getting image extension

            $fileName = 'advertisement.jpg'; // renameing image

            $image->move($destinationPath, $fileName); // uploading file to given path

            Session::flash('success', 'Uploaded successfully');
            
            return redirect('admin/advertisement');
        }

        Session::flash('error', 'Error in uploading the image. Please make sure the file size and format are correct.');

        return Redirect::to('admin/advertisement');

    }
}
