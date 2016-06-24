<?php

namespace BrngyWiFi\Modules\Event\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'event';

    protected $fillable = array('home_owner_id', 'ref_category_id', 'homeowner_address_id', 'name', 'start', 'end', 'status');

    public function eventGuestList()
    {
        return $this->hasMany('BrngyWiFi\Modules\EventGuestList\Models\EventGuestList', 'event_id', 'id');
    }

    public function refCategory()
    {
        return $this->belongsTo('BrngyWiFi\Modules\RefCategory\Models\RefCategory', 'ref_category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('BrngyWiFi\Modules\User\Models\User', 'home_owner_id', 'id');
    }

    public function homeOwnerAddress()
    {
        return $this->belongsTo('BrngyWiFi\Modules\HomeownerAddress\Models\HomeownerAddress', 'homeowner_address_id', 'id');
    }

    /*public function address()
    {
    return $this->hasOne('BrngyWiFi\Modules\HomeownerAddress\Models\HomeownerAddress', 'home_owner_id', 'home_owner_id');
    }*/

    public function address()
    {
        return $this->hasOne('BrngyWiFi\Modules\HomeownerAddress\Models\HomeownerAddress', 'id', 'homeowner_address_id');
    }
}
