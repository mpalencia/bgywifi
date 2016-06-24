<?php namespace BrngyWiFi\Services\Curl;

/**
 * A service class to send notification to home owner via onesignal
 * Returns curl result
 *
 * @author gab
 * @package BrngyWiFi\Services
 */

class SendNotification
{
	public function call($fields)
	{
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, \Config::get('onesignal.'.'brgyWifi.'.'onesignal'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                               'Authorization: Basic '. \Config::get('onesignal.'.'brgyWifi.'.'api-key')));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
	}
}