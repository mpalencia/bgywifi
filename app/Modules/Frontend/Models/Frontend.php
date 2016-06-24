<?php

namespace BrngyWiFi\Modules\Frontend\Models;

use Illuminate\Database\Eloquent\Model;

class Frontend extends Model {
	protected $table = 'tbl_users';
	protected $fillable = array('name', 'email', 'password', 'created_at', 'updated_at');
}
