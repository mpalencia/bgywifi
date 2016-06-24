<?php

namespace BrngyWiFi\Modules\IssuesActionTaken\Models;

use Illuminate\Database\Eloquent\Model;

class IssuesActionTaken extends Model
{
    protected $table = 'issues_action_taken';

    protected $fillable = array('home_owner_id', 'security_guard_id', 'issue_id', 'action_taken');

    public function homeOwner()
    {
        return $this->belongsTo('BrngyWiFi\Modules\User\Models\User', 'home_owner_id', 'id');
    }

    public function issuesActionTaken()
    {
        return $this->belongsTo('BrngyWiFi\Modules\SuggestionComplaints\Models\SuggestionComplaints', 'issue_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo('BrngyWiFi\Modules\User\Models\User', 'security_guard_id', 'id');
    }
}
