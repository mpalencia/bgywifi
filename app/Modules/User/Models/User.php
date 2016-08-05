<?php

namespace BrngyWiFi\Modules\User\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;

    protected $table = 'users';

    protected $fillable = array('first_name', 'last_name',
        'username',
        'password',
        'email',
        'pin_code',
        'contact_no',
        'notification',
        'alert',
        'main_account_id',
    );

    public function role()
    {
        return $this->hasOne('BrngyWiFi\Modules\UserRoles\Models\UserRoles', 'user_id');
    }

    public function homeOwnerAddress()
    {
        return $this->hasMany('BrngyWiFi\Modules\HomeownerAddress\Models\HomeownerAddress', 'home_owner_id', 'id');
    }

    public function emergency()
    {
        return $this->hasMany('BrngyWiFi\Modules\Emergency\Models\Emergency', 'home_owner_id', 'id');
    }

    public function caution()
    {
        return $this->hasMany('BrngyWiFi\Modules\Caution\Models\Caution', 'home_owner_id', 'id');
    }

    public function issues()
    {
        return $this->hasMany('BrngyWiFi\Modules\SuggestionComplaints\Models\SuggestionComplaints', 'home_owner_id', 'id');
    }

    public function homeOwnerAddressPrimary()
    {
        return $this->hasOne('BrngyWiFi\Modules\HomeownerAddress\Models\HomeownerAddress', 'home_owner_id');
    }

    public function notifications()
    {
        return $this->hasMany('BrngyWiFi\Modules\Notifications\Models\Notifications', 'home_owner_id', 'id');
    }

    public function notifications2()
    {
        return $this->hasMany('BrngyWiFi\Modules\Notifications\Models\Notifications', 'approved_by', 'id');
    }

    public function visitors()
    {
        return $this->hasMany('BrngyWiFi\Modules\Visitors\Models\Visitors', 'home_owner_id', 'id');
    }
}
