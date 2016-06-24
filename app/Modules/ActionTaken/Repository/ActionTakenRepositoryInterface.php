<?php

namespace BrngyWiFi\Modules\ActionTaken\Repository;

use BrngyWiFi\Modules\ActionTaken\Models\ActionTaken;

interface ActionTakenRepositoryInterface
{
    /**
     * Create new ActionTaken for emergency
     *
     * @param array $payload
     * @return static
     */
    public function createActionTaken($payload);

    /**
     * Update a ActionTaken
     *
     * @param array $id
     * @return static
     */
    public function updateActionTaken($id, $data);
}
