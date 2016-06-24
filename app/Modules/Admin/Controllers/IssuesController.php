<?php

namespace BrngyWiFi\Modules\Admin\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\IssuesActionTaken\Models\IssuesActionTaken;
use BrngyWiFi\Modules\SuggestionComplaints\Models\SuggestionComplaints;
use BrngyWiFi\Services\Curl\SendNotification;
use Illuminate\Http\Request;

class IssuesController extends Controller
{
    public function __construct(SuggestionComplaints $issues)
    {
        $this->issues = $issues;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['issues'] = $this->issues
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->with(['issuesActionTaken' => function ($query) {
                $query->with(['admin' => function ($query) {
                    $query->select('id', 'first_name', 'last_name');
                }]);
                $query->select('id', 'issue_id', 'action_taken', 'security_guard_id', 'created_at');
                $query->orderBy('updated_at', 'desc');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Admin::issues', $data);
    }

    public function updateIssueActionTaken(Request $request, SendNotification $curl)
    {
        $validator = \Validator::make($request->all(), [
            'action_taken' => 'required',
        ]);

        if ($validator->fails()) {
            return array('msg' => json_encode($validator->errors()->first()), 'msgCode' => 0);
        }

        switch ($request->input('issue_type')) {
            case 1:
                $issue_type = 'Suggestion';
                break;
            case 2:
                $issue_type = 'Complaint';
                break;
            default:
                $issue_type = 'Issue';
                break;
        }

        if (IssuesActionTaken::create($request->all())) {

            $fields = array(
                'app_id' => \Config::get('onesignal.' . 'brgyWifi.' . 'app-id'),
                'tags' => array(array('key' => 'userId', 'relation' => '=', 'value' => $request->home_owner_id)),
                'contents' => ["en" => $request->action_taken . "\n\n" . 'Type: ' . $issue_type],
                'data' => ['additionalData' => 'issue_action_taken'],
                'android_group' => 'BRGY Comms',
            );

            $fields = json_encode($fields);

            $responsed = $curl->call($fields);

            return array('msg' => 'Homeowner has been notified', 'msgCode' => 1);
        }

        return array('msg' => "There's an error in updating alert.", 'msgCode' => 0);
    }

    public function updateIssue($id, SendNotification $curl)
    {
        $issue_action_taken = $this->issues->find($id);

        if ($this->issues->where('id', $id)->update(['resolved' => 1, 'end_date' => date('Y-m-d H:i:s')])) {

            switch ($issue_action_taken->issue_type) {
                case 1:
                    $issue_type = 'Suggestion';
                    break;
                case 2:
                    $issue_type = 'Complaint';
                    break;
                default:
                    $issue_type = 'Issue';
                    break;
            }

            $fields = array(
                'app_id' => \Config::get('onesignal.' . 'brgyWifi.' . 'app-id'),
                'tags' => array(array('key' => 'userId', 'relation' => '=', 'value' => $issue_action_taken->home_owner_id)),
                'contents' => ["en" => 'Issue has been marked as resolved' . "\n\n" . 'Type: ' . $issue_type],
                'data' => ['additionalData' => 'issue_action_taken'],
                'android_group' => 'BRGY Comms',
            );

            $fields = json_encode($fields);

            $responsed = $curl->call($fields);

            return array('msg' => "Issue has been marked as resolved", 'msgCode' => 1);
        }

        return array('msg' => "There's an error in updating issue.", 'msgCode' => 0);
    }

    public function reopenIssue($id)
    {
        if ($this->issues->where('id', $id)->update(['resolved' => 0, 'end_date' => null])) {
            return array('msg' => "Issue has been re-opened", 'msgCode' => 1);
        }

        return array('msg' => "There's an error in re-opening issue.", 'msgCode' => 0);
    }
}
