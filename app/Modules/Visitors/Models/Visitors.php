<?php

namespace BrngyWiFi\Modules\Visitors\Models;

use Illuminate\Database\Eloquent\Model;

class Visitors extends Model
{
    protected $table = 'visitors';

    protected $fillable = array('user_id', 'ref_category_id', 'home_owner_id', 'name', 'plate_number', 'car_description', 'notes', 'photo');

    public function refCategory()
    {
        return $this->belongsTo('BrngyWiFi\Modules\RefCategory\Models\RefCategory', 'ref_category_id', 'id');
    }
}
