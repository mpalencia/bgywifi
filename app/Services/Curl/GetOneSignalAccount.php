<?php namespace BrngyWiFi\Services\Curl;

/**
 * A service class to get onesignal account details
 * Returns curl result
 *
 * @author gab
 * @package BrngyWiFi\Services
 */

class GetOneSignalAccount
{
    public function call()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/players?app_id=" . \Config::get('onesignal.' . 'brgyWifi.' . 'app-id'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
            'Authorization: Basic ' . \Config::get('onesignal.' . 'brgyWifi.' . 'api-key')));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $players = curl_exec($ch);
        curl_close($ch);

        return $this->getWebDevices(json_decode($players, true)['players']);
    }

    private function getWebDevices($players)
    {
        $devices = [];

        return array_values(array_filter(array_map(function ($structure) use ($players, $devices) {
            return ($this->validateDevice($structure['device_type'])) ? $devices[] = $structure['id'] : $devices;
        }, $players)));
    }

    private function validateDevice($devices)
    {
        return in_array($devices, [5, 6, 7, 8, 9]);
    }
}
