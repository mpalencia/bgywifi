<?php

namespace BrngyWiFi\Modules\SuggestionComplaints\Repository;

use BrngyWiFi\Modules\SuggestionComplaints\Models\SuggestionComplaints;

class EloquentSuggestionComplaintsRepository implements SuggestionComplaintsRepositoryInterface
{
    /**
     * @var SuggestionComplaints
     */
    private $suggestionComplaints;

    /**
     * @param SuggestionComplaints
     */
    public function __construct(SuggestionComplaints $suggestionComplaints)
    {
        $this->suggestionComplaints = $suggestionComplaints;
    }

    /**
     * Create new visitor
     *
     * @param array $payload
     * @return static
     */
    public function createSuggestionOrComplaints($payload)
    {
        return $this->suggestionComplaints->create(json_decode($payload, true));
    }

    /**
     * Get all active issues
     *
     * @return static
     */
    public function getActiveIssueCount()
    {
        return $this->suggestionComplaints->with('homeowner_address')
        //->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d') . ' 24:00:00')))
            ->where('resolved', 0)
            ->count();
    }

    /**
     * Update a visitor
     *
     * @param array $id
     * @return static
     */
    public function getAllSuggestionOrComplaints($homeOwnerId)
    {
        return $this->suggestionComplaints
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->with(['issuesActionTaken' => function ($query) {
                $query->select('id', 'issue_id', 'action_taken', 'created_at');
                $query->orderBy('updated_at', 'desc');
            }])
            ->select('id', 'home_owner_id', 'issue_type', 'message', 'created_at')
            ->where('home_owner_id', $homeOwnerId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Get all Suggestions or Complaints by home owner id
     *
     * @param array $id
     * @return static
     */
    public function getAllSuggestionOrComplaintsForSecurity()
    {
        return $this->suggestionComplaints
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->with(['homeownerAddress' => function ($query) {
                $query->where('primary', '=', 1);

            }])
            ->with(['issuesActionTaken' => function ($query) {
                $query->select('id', 'issue_id', 'action_taken', 'created_at');
                $query->orderBy('updated_at', 'desc');
            }])
            ->select('id', 'home_owner_id', 'created_at', 'resolved', 'message')
            ->where('resolved', 0)
        //->whereBetween('created_at', array(new \DateTime(date('Y-m-d') . ' 00:00:00'), new \DateTime(date('Y-m-d') . ' 24:00:00')))
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }
}
