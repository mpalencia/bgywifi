<?php

namespace BrngyWiFi\Modules\RefCategory\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\RefCategory\Repository\RefCategoryRepositoryInterface;

class RefCategoryController extends Controller
{
    /**
     * @var RefCategory
     */
    protected $refCategory;

    /**
     * @param RefCategory $refCategory
     */
    public function __construct(RefCategoryRepositoryInterface $refCategory)
    {
        $this->refCategory = $refCategory;
    }

    /**
     * Get all Ref Category Name
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAllRefCategory()
    {
        return $this->refCategory->getAllRefCategory();
    }
}
