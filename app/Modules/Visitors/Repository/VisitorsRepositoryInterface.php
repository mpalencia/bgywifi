<?php

namespace BrngyWiFi\Modules\Visitors\Repository;

use BrngyWiFi\Modules\Visitors\Models\Visitors;

interface VisitorsRepositoryInterface
{
    /**
     * Get a certain visitor
     *
     * @param integer $id
     * @return static
     */
    public function getVisitor($id);

    /**
     * Get last visitor
     *
     * @param integer $id
     * @return static
     */
    public function getLastVisitor();

    /**
     * Create new visitor
     *
     * @param array $payload
     * @return static
     */
    public function createVisitors($payload);

    /**
     * Update a visitor
     *
     * @param integer $id
     * @param array $photo
     * @return static
     */
    public function updateVisitors($id);

    /**
     * Delete a visitor
     *
     * @param integer $id
     * @return static
     */
    public function deleteVisitors($id);
}
