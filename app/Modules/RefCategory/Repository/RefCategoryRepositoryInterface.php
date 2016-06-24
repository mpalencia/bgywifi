<?php

namespace BrngyWiFi\Modules\RefCategory\Repository;

use BrngyWiFi\Modules\RefCategory\Models\RefCategory;

interface RefCategoryRepositoryInterface
{
    /**
     * Get all ref category
     *
     * @param array $id
     * @return static
     */
    public function getAllRefCategory();

    /**
     * Create new visitor
     *
     * @param array $payload
     * @return static
     */
    public function createRefCategory($payload);

    /**
     * Update a visitor
     *
     * @param array $id
     * @return static
     */
    public function updateRefCategory($id, $data);
}
