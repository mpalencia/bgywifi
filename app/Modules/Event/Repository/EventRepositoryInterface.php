<?php

namespace BrngyWiFi\Modules\Event\Repository;

use BrngyWiFi\Modules\Event\Models\Event;

interface EventRepositoryInterface
{
    /**
     * Get all events by status active and date now
     *
     * @param array $payload
     * @return static
     */
    public function getEvents();

    /**
     * Get all events by user id
     *
     * @param int $id
     * @return static
     */
    public function getEventsByUserId($id);

    /**
     * Get all events by status active and date now
     *
     * @param array $payload
     * @return static
     */

    public function getEventsByHomeOwnerId($id);

    /**
     * Get all events by incoming guests and needs approval
     *
     * @param array $payload
     * @return static
     */
    public function getIncomingGuestEvents($refCategoryId, $homeOwnerId);

    /**
     * Get event and guests
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory;
     */
    public function getEventAndGuests($event_id);

    /**
     * Get a certain event
     *
     * @param array $payload
     * @return static
     */
    public function getEventById($id);

    /**
     * Create new event
     *
     * @param array $payload
     * @return static
     */
    public function createEvent($payload);

    /**
     * Update a certain event
     *
     * @param array $payload
     * @return static
     */
    public function updateEvent($id, $payload);
}
