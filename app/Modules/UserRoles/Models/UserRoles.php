<?php

namespace BrngyWiFi\Modules\UserRoles\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    protected $table = 'user_roles';
    protected $fillable = array('user_id', 'role_id');

    public function role()
    {
        return $this->belongsTo('BrngyWiFi\Modules\UserRoles\Models\UserRoles', 'user_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('BrngyWiFi\Modules\User\Models\User', 'user_id', 'id');
    }
}
