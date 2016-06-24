<?php

namespace BrngyWiFi\Modules\CautionType\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\CautionType\Models\CautionType;

class CautionTypeController extends Controller
{
    public function getAllCautionType(CautionType $cautionType)
    {
        return $cautionType->get()->toArray();
    }
}
