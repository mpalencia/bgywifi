<?php

namespace BrngyWiFi\Modules\RefCategory\Repository;

use BrngyWiFi\Modules\RefCategory\Models\RefCategory;

class EloquentRefCategoryRepository implements RefCategoryRepositoryInterface
{
    /**
     * @var RefCategory
     */
    private $refCategory;

    /**
     * @param RefCategory
     */
    public function __construct(RefCategory $refCategory)
    {
        $this->refCategory = $refCategory;
    }

    /**
     * Get all ref category
     *
     * @param array $id
     * @return static
     */
    public function getAllRefCategory()
    {
        return $this->refCategory->get()->toArray();
    }

    /**
     * Create new ref category
     *
     * @param array $payload
     * @return static
     */
    public function createRefCategory($payload)
    {
        return $this->refCategory->create($payload);
    }

    /**
     * Update a ref category
     *
     * @param array $id
     * @return static
     */
    public function updateRefCategory($id, $data)
    {
        return $this->refCategory->find($id)->fill($data)->save();
    }
}
