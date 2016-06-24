<?php

namespace BrngyWiFi\Modules\ActionTaken\Models;

use Illuminate\Database\Eloquent\Model;

class ActionTaken extends Model
{
    protected $table = 'action_taken';

    protected $fillable = array('home_owner_id', 'security_guard_id', 'emergency_id', 'caution_id', 'unidentified_id', 'action_taken_type_id', 'status', 'from_chikka');

    public function homeOwner()
    {
        return $this->belongsTo('BrngyWiFi\Modules\User\Models\User', 'home_owner_id', 'id');
    }

    public function emergency()
    {
        return $this->belongsTo('BrngyWiFi\Modules\Emergency\Models\Emergency', 'emergency_id', 'id');
    }

    public function caution()
    {
        return $this->belongsTo('BrngyWiFi\Modules\Caution\Models\Caution', 'caution_id', 'id');
    }

    public function actionTakenType()
    {
        return $this->belongsTo('BrngyWiFi\Modules\ActionTakenType\Models\ActionTakenType', 'action_taken_type_id', 'id');
    }

    public function security()
    {
        return $this->belongsTo('BrngyWiFi\Modules\User\Models\User', 'security_guard_id', 'id');
    }
}
