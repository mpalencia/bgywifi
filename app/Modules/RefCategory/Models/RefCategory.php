<?php

namespace BrngyWiFi\Modules\RefCategory\Models;

use Illuminate\Database\Eloquent\Model;

class RefCategory extends Model
{
    protected $table = 'ref_category';

    public $hidden = array('created_at', 'updated_at');

    protected $fillable = array('id', 'category_name');
}
