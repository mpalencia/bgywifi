<?php

namespace BrngyWiFi\Modules\Visitors\Repository;

use BrngyWiFi\Modules\Visitors\Models\Visitors;

class EloquentVisitorsRepository implements VisitorsRepositoryInterface
{
    /**
     * @var Visitors
     */
    private $visitors;

    /**
     * @param Visitors
     */
    public function __construct(Visitors $visitors)
    {
        $this->visitors = $visitors;
    }

    /**
     * Get a certain visitor
     *
     * @param integer $id
     * @return static
     */
    public function getVisitor($id)
    {
        return $this->visitors->find($id);
    }

    /**
     * Get last visitor
     *
     * @return static
     */
    public function getLastVisitor()
    {
        return $this->visitors->with('refCategory')->orderBy('created_at', 'desc')->limit(1)->get()->toArray();
    }

    /**
     * Create new visitor
     *
     * @param array $payload
     * @return static
     */
    public function createVisitors($payload)
    {
        return $this->visitors->create($payload);
    }

    /**
     * Update a visitor
     *
     * @param integer $id
     * @param array $photo
     * @return static
     */
    public function updateVisitors($id, $photo = null)
    {
        if (!is_null($photo)) {
            return $this->visitors->find($id)->fill(['photo' => $photo['imageName']])->save();
        }

        return false;
    }

    /**
     * Delete a visitor
     *
     * @param integer $id
     * @return static
     */
    public function deleteVisitors($id)
    {
        return $this->visitors->where('id', $id)->delete();
    }
}
