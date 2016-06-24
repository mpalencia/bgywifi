<?php

namespace BrngyWiFi\Modules\Caution\Controllers;

use BrngyWiFi\Events\MessageAlertsWasCreated;
use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\Caution\Repository\CautionRepositoryInterface;
use Illuminate\Http\Request;
use Storage;

class CautionController extends Controller
{
    /**
     * @var CautionRepositoryInterface
     */
    private $cautionRepositoryInterface;

    /**
     * @param Caution
     */
    public function __construct(CautionRepositoryInterface $cautionRepositoryInterface)
    {
        $this->cautionRepositoryInterface = $cautionRepositoryInterface;
    }

    /**
     * Get a certain caution
     *
     * @return \Illuminate\Http\Response
     */
    public function getCaution($id)
    {
        return $this->cautionRepositoryInterface->getCaution($id);
    }

    /**
     * Get all caution
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllCaution()
    {
        return $this->cautionRepositoryInterface->getAllCaution();
    }

    /**
     * Get all caution for homeowner
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllCautionWithHomeowner()
    {
        return $this->cautionRepositoryInterface->getAllCautionWithHomeowner();
    }

    /**
     * Get all caution for security
     *
     * @return static
     */
    public function getAllCautionForSecurity()
    {
        return $this->cautionRepositoryInterface->getAllCautionForSecurity();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveCaution(Request $request)
    {
        $caution = $this->cautionRepositoryInterface->createCaution($request->getContent());

        $caution_type_model = $this->getCaution($caution->id);

        $sendNotification = \Event::fire(new MessageAlertsWasCreated($caution, $caution_type_model, 'caution'));

        if ($sendNotification) {
            return ['result' => 'success'];
        }

        return ['result' => 'error', 'error' => 'No security account stored in database.'];
    }
}
