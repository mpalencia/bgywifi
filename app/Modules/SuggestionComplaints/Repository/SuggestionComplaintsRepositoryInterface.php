<?php

namespace BrngyWiFi\Modules\SuggestionComplaints\Repository;

use BrngyWiFi\Modules\SuggestionComplaints\Models\SuggestionComplaints;

interface SuggestionComplaintsRepositoryInterface
{
    /**
     * Create new visitor
     *
     * @param array $payload
     * @return static
     */
    public function createSuggestionOrComplaints($payload);

    /**
     * Get all active issues
     *
     * @return static
     */
    public function getActiveIssueCount();

    /**
     * Update a visitor
     *
     * @param array $id
     * @return static
     */
    public function getAllSuggestionOrComplaints($homeOwnerId);

    /**
     * Get all Suggestions or Complaints by home owner id
     *
     * @param array $id
     * @return static
     */
    public function getAllSuggestionOrComplaintsForSecurity();
}
