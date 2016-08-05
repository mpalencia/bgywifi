<?php

namespace BrngyWiFi\Modules\Notifications\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $table = 'notifications';

    protected $fillable = array('user_id', 'visitors_id', 'home_owner_id', 'homeowner_address_id', 'status', 'chikka_code', 'approved_by');

    public function visitors()
    {
        return $this->belongsTo('BrngyWiFi\Modules\Visitors\Models\Visitors', 'visitors_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('BrngyWiFi\Modules\User\Models\User', 'home_owner_id', 'id');
    }

    public function approved()
    {
        return $this->belongsTo('BrngyWiFi\Modules\User\Models\User', 'approved_by', 'id');
    }

    public function homeOwnerAddress()
    {
        return $this->belongsTo('BrngyWiFi\Modules\HomeownerAddress\Models\HomeownerAddress', 'homeowner_address_id', 'id');
    }
}
