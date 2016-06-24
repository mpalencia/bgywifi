<?php

namespace BrngyWiFi\Modules\Admin\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\Admin\Models\BugReport;
use Illuminate\Http\Request;

class BugReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bugs = BugReport::orderBy('created_at', 'desc')->get();

        return view('Admin::bug_report', ['bugs' => $bugs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (BugReport::create($request->all())) {
            return array('msg' => 'Successfully saved.', 'msgCode' => 1);
        }

        return array('msg' => 'Failed.', 'msgCode' => 0);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        BugReport::find($id)->update($request->all());

        return redirect('admin/bug-report');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateBugReport($id, Request $request)
    {
        if (BugReport::find($id)->update($request->all())) {
            return array('msg' => 'Successfully updated.', 'msgCode' => 1);
        }

        return array('msg' => 'Failed.', 'msgCode' => 0);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
