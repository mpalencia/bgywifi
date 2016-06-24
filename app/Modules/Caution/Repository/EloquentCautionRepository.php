<?php

namespace BrngyWiFi\Modules\Caution\Repository;

use BrngyWiFi\Modules\Alerts\Models\Alerts;
use BrngyWiFi\Modules\Caution\Models\Caution;

class EloquentCautionRepository implements CautionRepositoryInterface
{
    /**
     * @var Caution
     */
    private $caution;

    /**
     * @param Caution
     */
    public function __construct(Caution $caution)
    {
        $this->caution = $caution;
    }

    /**
     * Get a certain caution
     *
     * @param integer $id
     * @return static
     */
    public function getCaution($id)
    {
        return $this->caution
            ->join('caution_type', 'caution.caution_type_id', '=', 'caution_type.id')
            ->join('users', 'caution.home_owner_id', '=', 'users.id')
            ->join('homeowner_address', 'caution.home_owner_id', '=', 'homeowner_address.home_owner_id')
            ->select('caution.id', 'caution.home_owner_id', 'caution.caution_type_id', 'caution.created_at', 'caution.message', 'users.first_name', 'users.last_name', 'caution_type.description', 'homeowner_address.home_owner_id', 'homeowner_address.address')
            ->where('caution.id', $id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->toArray();
    }

    /**
     * Get all caution
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllCaution()
    {
        return $this->caution->with('cautionType')->get()->toArray();
    }

    /**
     * Get all caution for homeowner
     *
     * @return static
     */
    public function getAllCautionWithHomeowner()
    {
        return $this->caution
            ->with(['cautionType' => function ($query) {
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
                $query->select('id', 'caution_id', 'action_taken_type_id');
                $query->orderBy('updated_at', 'desc');
            }])
            ->select('id', 'home_owner_id', 'caution_type_id', 'homeowner_address_id', 'message', 'created_at')
            ->where('status', 0)
            ->whereNull('end_date')
        //->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d') . ' 24:00:00')))
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Get all caution for security
     *
     * @return static
     */
    public function getAllCautionForSecurity()
    {
        return $this->caution
            ->with(['cautionType' => function ($query) {
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
                $query->select('id', 'caution_id', 'action_taken_type_id');
                $query->orderBy('updated_at', 'desc');
            }])
            ->select('id', 'home_owner_id', 'caution_type_id', 'homeowner_address_id', 'message', 'created_at', 'status', 'from_chikka')
            ->where('status', 0)
            ->whereNull('end_date')
        //->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d') . ' 24:00:00')))
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Create new caution
     *
     * @param array $payload
     * @return static
     */
    public function createCaution($payload, $from_chikka = 0)
    {
        $payload = json_decode($payload, true);

        Alerts::where('home_owner_id', $payload['home_owner_id'])->update(['status' => 1]);

        $payload['from_chikka'] = $from_chikka;

        return $this->caution->create($payload);
    }

    /**
     * Update a caution
     *
     * @param array $id
     * @return static
     */
    public function updateCaution($id, $data)
    {
        return $this->caution->find($id)->fill($data)->save();
    }

    /**
     * Get all active caution
     *
     * @return static
     */
    public function getActiveCautionCount()
    {
        return $this->caution
        //->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d') . ' 24:00:00')))
            ->where('status', 0)
            ->whereNull('end_date')
            ->count();
    }
}
