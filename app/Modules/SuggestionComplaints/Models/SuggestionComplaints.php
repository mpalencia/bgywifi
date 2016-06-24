<?php

namespace BrngyWiFi\Modules\SuggestionComplaints\Models;

use Illuminate\Database\Eloquent\Model;

class SuggestionComplaints extends Model
{
    protected $table = 'suggestion_complaints';

    protected $fillable = array('home_owner_id', 'message', 'issue_type', 'resolved', 'end_date', 'created_at');

    public function user()
    {
        return $this->belongsTo('BrngyWiFi\Modules\User\Models\User', 'home_owner_id', 'id');
    }

    public function issuesActionTaken()
    {
        return $this->hasMany('BrngyWiFi\Modules\IssuesActionTaken\Models\IssuesActionTaken', 'issue_id', 'id');
    }

    public function homeownerAddress()
    {
        return $this->belongsTo('BrngyWiFi\Modules\HomeownerAddress\Models\HomeownerAddress', 'home_owner_id', 'home_owner_id')->select(['home_owner_id', 'address', 'latitude', 'longitude']);
    }
}
