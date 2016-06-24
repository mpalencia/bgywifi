<?php

namespace BrngyWiFi\Modules\Messages\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $table = 'messages';
    protected $fillable = array('message', 'from_user_id', 'to_user_id', 'category', 'status', 'created_at', 'updated_at');

    public function to_user()
    {
        return $this->belongsTo('BrngyWiFi\Modules\User\Models\User', 'to_user_id', 'id');
    }

    public function from_user()
    {
        return $this->belongsTo('BrngyWiFi\Modules\User\Models\User', 'from_user_id', 'id');
    }
}
