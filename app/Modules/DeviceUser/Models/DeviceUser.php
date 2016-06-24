<?php

namespace BrngyWiFi\Modules\DeviceUser\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceUser extends Model
{
    protected $table = 'device_user';

    protected $hidden = array('created_at', 'updated_at');

    protected $fillable = array('home_owner_id', 'email', 'mobile_no');
}
