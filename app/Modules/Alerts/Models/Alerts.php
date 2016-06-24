<?php

namespace BrngyWiFi\Modules\Alerts\Models;

use Illuminate\Database\Eloquent\Model;

class Alerts extends Model
{
    protected $table = 'alerts';

    protected $fillable = array('home_owner_id', 'homeowner_address_id', 'status', 'from_chikka');

    public function user()
    {
        return $this->belongsTo('BrngyWiFi\Modules\User\Models\User', 'home_owner_id', 'id');
    }

    public function homeowner_address()
    {
        return $this->belongsTo('BrngyWiFi\Modules\HomeownerAddress\Models\HomeownerAddress', 'homeowner_address_id', 'id')->select(['id', 'home_owner_id', 'address', 'latitude', 'longitude']);
    }

    public function actionTaken()
    {
        return $this->hasMany('BrngyWiFi\Modules\ActionTaken\Models\ActionTaken', 'unidentified_id', 'id');
    }

    public function actionTakenType()
    {
        return $this->belongsTo('BrngyWiFi\Modules\ActionTakenType\Models\ActionTakenType', 'action_taken_type_id', 'id');
    }
}
