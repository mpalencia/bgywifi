<?php namespace BrngyWiFi\Services\Curl;

use BrngyWiFi\Services\Curl\GetOneSignalAccount;

/**
 * A service class to send notification to web admin via onesignal
 * Returns curl result
 *
 * @author gab
 * @package BrngyWiFi\Services
 */

class SendWebNotification
{
    private $details;
    private $devices;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function call()
    {

        $fields = array(
            'app_id' => "71f1f939-b1a5-44e7-bac8-872f9ab48d0c",
            'include_player_ids' => (new GetOneSignalAccount())->call(),
            'contents' => ["en" => $this->details],
            'isAndroid' => false,
            'isIos' => false,
            'isWP' => false,
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, \Config::get('onesignal.' . 'brgyWifi.' . 'onesignal'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
            'Authorization: Basic ' . \Config::get('onesignal.' . 'brgyWifi.' . 'api-key')));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

}
