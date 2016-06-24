<?php

namespace BrngyWiFi\Modules\Emergency\Repository;

use BrngyWiFi\Modules\Emergency\Models\Emergency;

interface EmergencyRepositoryInterface
{
    /**
     * Get a certain emergency
     *
     * @param array $id
     * @return static
     */
    public function getEmergency($id);

    /**
     * Get all emergency
     *
     * @param array $id
     * @return static
     */
    public function getAllEmergency();

    /**
     * Get all active emergency
     *
     * @return static
     */
    public function getActiveEmergencyCount();

    /**
     * Get all emergency alerts for home owner
     *
     * @param array $id
     * @return static
     */
    public function getAllEmergencyWithHomeowner();

    /**
     * Get all emergency alerts for security guard
     *
     * @param array $id
     * @return static
     */
    public function getAllEmergencyForSecurity();

    /**
     * Create new emergency
     *
     * @param array $payload
     * @return static
     */
    public function createEmergency($payload, $from_chikka = 0);

    /**
     * Update a emergency
     *
     * @param array $id
     * @return static
     */
    public function updateEmergency($id, $data);
}
