<?php

namespace BrngyWiFi\Modules\HomeownerAddress\Models;

use Illuminate\Database\Eloquent\Model;

class HomeownerAddress extends Model
{
    protected $table = 'homeowner_address';

    protected $fillable = array('home_owner_id', 'address', 'latitude', 'longitude', 'primary');

    protected $hidden = ['id'];

    public function user()
    {
        return $this->belongsTo('BrngyWiFi\Modules\User\Models\User', 'home_owner_id', 'id');
    }
}
