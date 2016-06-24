<?php

namespace BrngyWiFi\Modules\MessageAlerts\Models;

use Illuminate\Database\Eloquent\Model;

class MessageAlerts extends Model
{
    protected $table = 'message_alerts';

    protected $fillable = array('home_owner_id', 'action_taken_id', 'resolved');

    public function user()
    {
        return $this->belongsTo('BrngyWiFi\Modules\Users\Models\Users', 'home_owner_id', 'id');
    }

    public function action_taken()
    {
        return $this->belongsTo('BrngyWiFi\Modules\ActionTaken\Models\ActionTaken', 'action_taken_id', 'id');
    }
}
