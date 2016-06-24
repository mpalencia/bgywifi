<?php

namespace BrngyWiFi\Modules\Caution\Models;

use Illuminate\Database\Eloquent\Model;

class Caution extends Model
{
    protected $table = 'caution';

    protected $fillable = array('home_owner_id', 'caution_type_id', 'homeowner_address_id', 'message', 'from_chikka');

    public function cautionType()
    {
        return $this->belongsTo('BrngyWiFi\Modules\CautionType\Models\CautionType', 'caution_type_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('BrngyWiFi\Modules\User\Models\User', 'home_owner_id', 'id');
    }

    public function homeownerAddress()
    {
        return $this->belongsTo('BrngyWiFi\Modules\HomeownerAddress\Models\HomeownerAddress', 'home_owner_id', 'home_owner_id')->select(['home_owner_id', 'address', 'latitude', 'longitude']);
    }

    public function homeowner_address()
    {
        return $this->belongsTo('BrngyWiFi\Modules\HomeownerAddress\Models\HomeownerAddress', 'homeowner_address_id', 'id')->select(['id', 'home_owner_id', 'address', 'latitude', 'longitude']);
    }

    public function actionTaken()
    {
        return $this->hasMany('BrngyWiFi\Modules\ActionTaken\Models\ActionTaken', 'caution_id', 'id');
    }

    public function actionTakenType()
    {
        return $this->belongsTo('BrngyWiFi\Modules\ActionTakenType\Models\ActionTakenType', 'action_taken_type_id', 'id');
    }
}
