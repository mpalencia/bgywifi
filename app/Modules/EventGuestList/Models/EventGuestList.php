<?php

namespace BrngyWiFi\Modules\EventGuestList\Models;

use Illuminate\Database\Eloquent\Model;

class EventGuestList extends Model
{
    protected $table = 'event_guest_list';

    protected $fillable = array('event_id', 'guest_list_id', 'home_owner_id', 'status');

    public function event()
    {
        return $this->belongsTo('BrngyWiFi\Modules\Event\Models\Event', 'event_id', 'id');
    }

    public function guestList()
    {
        return $this->belongsTo('BrngyWiFi\Modules\GuestList\Models\GuestList', 'guest_list_id', 'id');
    }

    public function guest_list()
    {
        return $this->belongsTo('BrngyWiFi\Modules\GuestList\Models\GuestList', 'guest_list_id', 'id');
    }

    public function homeowner()
    {
        return $this->belongsTo('BrngyWiFi\Modules\User\Models\user', 'home_owner_id', 'id');
    }

    public function homeowner_address_el()
    {
        return $this->belongsTo('BrngyWiFi\Modules\HomeownerAddress\Models\HomeownerAddress', 'home_owner_id', 'home_owner_id')->select(['id', 'home_owner_id', 'latitude', 'longitude']);
    }
}
