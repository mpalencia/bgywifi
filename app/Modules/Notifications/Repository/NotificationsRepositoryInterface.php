<?php

namespace BrngyWiFi\Modules\Notifications\Repository;

use BrngyWiFi\Modules\Notifications\Models\Notifications;

interface NotificationsRepositoryInterface
{
    /**
     * Create new notification
     *
     * @param array $payload
     * @return static
     */
    public function createNotifications($payload);

    /**
     * Update a certain notification
     *
     * @param integer $id
     * @return static
     */
    public function updateNotifcations($id);

    /**
     * Update a certain notification via chikka
     *
     * @param int $notif_id
     * @param int $status
     * @return static
     */
    public function updateNotifcationsViaChikka($notif_id, $status);

    /**
     * Get all approved unexpected visitors
     *
     * @return static
     */
    public function getApprovedUnexpectedVisitors($securityGuardId);

    /**
     * Get all denied unexpected visitors
     *
     * @return static
     */
    public function getDeniedUnexpectedVisitors($securityGuardId);

    /**
     * Get all unexpected guests
     *
     * @return static
     */
    public function getVisitorsCount();

    /**
     * Get a notification via chikka code
     *
     * @return static
     */
    public function getByChikkaCode($chikka_code);
}
