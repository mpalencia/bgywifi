<?php

namespace BrngyWiFi\Modules\Emergency\Repository;

use BrngyWiFi\Modules\Emergency\Models\Emergency;
use \BrngyWiFi\Modules\Alerts\Models\Alerts;

class EloquentEmergencyRepository implements EmergencyRepositoryInterface
{
    /**
     * @var Emergency
     */
    private $emergency;

    /**
     * @param Emergency
     */
    public function __construct(Emergency $emergency)
    {
        $this->emergency = $emergency;
    }

    /**
     * Get a certain emergency
     *
     * @param array $id
     * @return static
     */
    public function getEmergency($id)
    {
        return $this->emergency
            ->join('emergency_type', 'emergency.emergency_type_id', '=', 'emergency_type.id')
            ->join('users', 'emergency.home_owner_id', '=', 'users.id')
            ->join('homeowner_address', 'emergency.home_owner_id', '=', 'homeowner_address.home_owner_id')
            ->select('emergency.id', 'emergency.home_owner_id', 'emergency.emergency_type_id', 'emergency.created_at', 'users.first_name', 'users.last_name', 'emergency_type.description', 'homeowner_address.home_owner_id', 'homeowner_address.address')
            ->where('status', 0)
            ->where('emergency.id', $id)
            ->get()
            ->toArray();
    }

    /**
     * Get all emergency
     *
     * @param array $id
     * @return static
     */
    public function getAllEmergency()
    {
        return $this->emergency->with('emergencyType')->get()->toArray();
    }

    /**
     * Get all active emergency
     *
     * @return static
     */
    public function getActiveEmergencyCount()
    {
        return $this->emergency->with('homeowner_address')
            ->where('status', 0)
            ->whereNull('end_date')
        //->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d') . ' 24:00:00')))
            ->count();
    }

    /**
     * Get all emergency alerts for home owner
     *
     * @param array $id
     * @return static
     */
    public function getAllEmergencyWithHomeowner()
    {
        return $this->emergency
            ->with(['emergencyType' => function ($query) {
                $query->select('id', 'description');
            }])
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->with('homeowner_address')
            ->with(['actionTaken' => function ($query) {
                $query->with(['actionTakenType' => function ($query) {
                    $query->select('id', 'message');
                }]);
                $query->select('id', 'emergency_id', 'action_taken_type_id');
                $query->orderBy('updated_at', 'desc');
            }])
            ->select('id', 'home_owner_id', 'emergency_type_id', 'homeowner_address_id', 'created_at')
            ->where('status', 0)
            ->whereNull('end_date')
        //->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d') . ' 24:00:00')))
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Get all emergency alerts for security guard
     *
     * @param array $id
     * @return static
     */
    public function getAllEmergencyForSecurity()
    {
        return $this->emergency
            ->with(['emergencyType' => function ($query) {
                $query->select('id', 'description');
            }])
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name', 'last_name', 'contact_no');
            }])
            ->with('homeowner_address')
            ->with(['actionTaken' => function ($query) {
                $query->with(['actionTakenType' => function ($query) {
                    $query->select('id', 'message');
                }]);
                $query->select('id', 'emergency_id', 'action_taken_type_id');
                $query->orderBy('updated_at', 'desc');
            }])
            ->select('id', 'home_owner_id', 'emergency_type_id', 'homeowner_address_id', 'created_at', 'status', 'from_chikka')
            ->where('status', 0)
            ->whereNull('end_date')
        //->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d') . ' 24:00:00')))
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Create new emergency
     *
     * @param array $payload
     * @return static
     */
    public function createEmergency($payload, $from_chikka = 0)
    {
        $payload = json_decode($payload, true);

        Alerts::where('home_owner_id', $payload['home_owner_id'])->update(['status' => 1]);

        $payload['from_chikka'] = $from_chikka;

        return $this->emergency->create($payload);
    }

    /**
     * Update a emergency
     *
     * @param array $id
     * @return static
     */
    public function updateEmergency($id, $data)
    {
        return $this->emergency->find($id)->fill($data)->save();
    }
}
