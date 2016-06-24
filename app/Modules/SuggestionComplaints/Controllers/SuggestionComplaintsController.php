<?php

namespace BrngyWiFi\Modules\SuggestionComplaints\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\SuggestionComplaints\Repository\SuggestionComplaintsRepositoryInterface;
use Illuminate\Http\Request;

class SuggestionComplaintsController extends Controller
{
    /**
     * @var SuggestionComplaintsRepositoryInterface
     */
    protected $suggestionComplaintsRepositoryInterface;

    public function __construct(SuggestionComplaintsRepositoryInterface $suggestionComplaintsRepositoryInterface)
    {
        $this->suggestionComplaintsRepositoryInterface = $suggestionComplaintsRepositoryInterface;
    }

    /**
     * Create Suggestions or Complaints
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createSuggestionOrComplaints(Request $request)
    {
        if ($this->suggestionComplaintsRepositoryInterface->createSuggestionOrComplaints($request->getContent())) {
            return ['result' => 'success'];
        }

        return ['result' => 'error'];
    }

    /**
     * Get all Suggestions or Complaints by home owner id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAllSuggestionOrComplaints($homeOwnerId)
    {
        return $this->suggestionComplaintsRepositoryInterface->getAllSuggestionOrComplaints($homeOwnerId);
    }

    /**
     * Get all Suggestions or Complaints for security guard
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAllSuggestionOrComplaintsForSecurity()
    {
        return $this->suggestionComplaintsRepositoryInterface->getAllSuggestionOrComplaintsForSecurity();
    }
}
