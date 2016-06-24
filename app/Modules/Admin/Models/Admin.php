<?php

namespace BrngyWiFi\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model {
	protected $table = 'tbl_users';
	protected $fillable = array('name', 'email', 'password', 'created_at', 'updated_at');
}
