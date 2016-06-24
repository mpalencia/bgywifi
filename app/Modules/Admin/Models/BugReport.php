<?php

namespace BrngyWiFi\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class BugReport extends Model
{
    protected $table = 'bug_report';

    protected $fillable = ['bug', 'status'];
}
