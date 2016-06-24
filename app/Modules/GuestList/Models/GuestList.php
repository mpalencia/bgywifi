<?php

namespace BrngyWiFi\Modules\GuestList\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuestList extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'guest_list';

    protected $fillable = array('event_id', 'home_owner_id', 'guest_name', 'status');
}
