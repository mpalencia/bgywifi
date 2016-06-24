<?php

namespace BrngyWiFi\Modules\MessageAlerts\Repository;

use BrngyWiFi\Modules\MessageAlerts\Models\MessageAlerts;

class EloquentMessageAlertsRepository implements MessageAlertsRepositoryInterface
{
    /**
     * @var MessageAlerts
     */
    private $messageAlerts;

    /**
     * @param MessageAlerts
     */
    public function __construct(MessageAlerts $messageAlerts)
    {
        $this->messageAlerts = $messageAlerts;
    }

    /**
     * Create new message alert
     *
     * @param array $payload
     * @return static
     */
    public function createMessageAlerts($payload)
    {
        return $this->messageAlerts->create($payload);
    }

    /**
     * Update a message alert
     *
     * @param array $id
     * @return static
     */
    public function updateMessageAlerts($id, $photo = null)
    {
        if (!is_null($photo)) {
            return $this->messageAlerts->find($id)->fill(['photo' => $photo['imageName']])->save();
        }

        return $this->messageAlerts->find($id)->fill($data)->save();
    }
}
