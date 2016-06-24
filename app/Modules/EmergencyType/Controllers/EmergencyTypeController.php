<?php

namespace BrngyWiFi\Modules\EmergencyType\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\EmergencyType\Models\EmergencyType;

class EmergencyTypeController extends Controller
{
    public function getAllEmergencyType(EmergencyType $emergencyType)
    {
        return $emergencyType->get()->toArray();
    }
}
