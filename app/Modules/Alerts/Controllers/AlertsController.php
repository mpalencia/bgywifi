<?php

namespace BrngyWiFi\Modules\Alerts\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\Alerts\Models\Alerts;
use Illuminate\Http\Request;

class AlertsController extends Controller
{
    public function getUnidentifiedWithHomeOwner()
    {
        return Alerts::with(['user' => function ($query) {
            $query->select('id', 'first_name', 'last_name');
        }])
            ->with('homeowner_address')
            ->with(['actionTaken' => function ($query) {
                $query->with(['actionTakenType' => function ($query) {
                    $query->select('id', 'message');
                }]);
                $query->select('id', 'unidentified_id', 'action_taken_type_id');
                $query->orderBy('updated_at', 'desc');
            }])
            ->select('id', 'home_owner_id', 'homeowner_address_id', 'created_at')
            ->where('status', 0)
        //->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d') . ' 24:00:00')))
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    public function getUnidentifiedForSecurity()
    {
        return Alerts::with(['user' => function ($query) {
            $query->select('id', 'first_name', 'last_name', 'contact_no');
        }])
            ->with('homeowner_address')
            ->with(['actionTaken' => function ($query) {
                $query->with(['actionTakenType' => function ($query) {
                    $query->select('id', 'message');
                }]);
                $query->select('id', 'unidentified_id', 'action_taken_type_id');
                $query->orderBy('updated_at', 'desc');
            }])
            ->select('id', 'home_owner_id', 'homeowner_address_id', 'status', 'from_chikka', 'created_at')
            ->where('status', 0)
        //->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d') . ' 24:00:00')))
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
    public function update(Request $request, $id)
    {
        //
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
