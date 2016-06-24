<?php

namespace BrngyWiFi\Modules\Caution\Repository;

use BrngyWiFi\Modules\Caution\Models\Caution;

interface CautionRepositoryInterface
{
    /**
     * Get a certain caution
     *
     * @param integer $id
     * @return static
     */
    public function getCaution($id);

    /**
     * Get all caution
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllCaution();

    /**
     * Get all caution for homeowner
     *
     * @return static
     */
    public function getAllCautionWithHomeowner();

    /**
     * Get all caution for security
     *
     * @return static
     */
    public function getAllCautionForSecurity();

    /**
     * Create new Caution
     *
     * @param array $payload
     * @return static
     */
    public function createCaution($payload, $from_chikka = 0);

    /**
     * Update a Caution
     *
     * @param array $id
     * @return static
     */
    public function updateCaution($id, $data);

    /**
     * Get all active caution
     *
     * @return static
     */
    public function getActiveCautionCount();
}
