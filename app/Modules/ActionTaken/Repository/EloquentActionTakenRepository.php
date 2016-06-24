<?php

namespace BrngyWiFi\Modules\ActionTaken\Repository;

use BrngyWiFi\Modules\ActionTaken\Models\ActionTaken;

class EloquentActionTakenRepository implements ActionTakenRepositoryInterface
{
    /**
     * @var ActionTaken
     */
    private $actionTaken;

    /**
     * @param ActionTaken
     */
    public function __construct(ActionTaken $actionTaken)
    {
        $this->actionTaken = $actionTaken;
    }

    /**
     * Get all ActionTaken
     *
     * @param integer $id
     * @return static
     */
    public function getAllActionTaken($id)
    {
        $emergencyActionTaken = $this->actionTaken->with('actionTakenType')->where('emergency_id', $id)->get()->toArray();

        if (!empty($emergencyActionTaken)) {
            return $emergencyActionTaken;
        }

        return $this->actionTaken->with('actionTakenType')->where('caution_id', $id)->get()->toArray();
    }

    /**
     * Create new ActionTaken for emergency
     *
     * @param array $payload
     * @return static
     */
    public function createActionTaken($payload)
    {

        return $this->actionTaken->create(json_decode($payload, true));
    }

    /**
     * Update a ActionTaken
     *
     * @param array $id
     * @return static
     */
    public function updateActionTaken($id, $data)
    {
        return $this->actionTaken->find($id)->fill($data)->save();
    }
}
