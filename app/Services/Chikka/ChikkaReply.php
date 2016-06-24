<?php namespace BrngyWiFi\Services\Chikka;

/**
 * A service class to send request to Chikka
 * Returns curl result
 *
 * @author gab
 * @package BrngyWiFi\Services
 */
use Storage;

class ChikkaReply
{
    public function call($request, $is_send = false, $message = 'Notification has been sent.', $contact_no = '')
    {
        $arr_post_body = $this->setPostBody($request, $message);

        $query_string = "";
        foreach ($arr_post_body as $key => $frow) {
            $query_string .= '&' . $key . '=' . $frow;
        }

        if ($is_send) {
            $arr_post_body = $this->setSendPostBody($request, $message, $contact_no);

            $query_string = '';
            foreach ($arr_post_body as $key => $value) {$query_string .= $key . '=' . $value . '&';}
            rtrim($query_string, '&');
        }

        $curl_handler = curl_init();
        curl_setopt($curl_handler, CURLOPT_URL, CHIKKA_URL);
        curl_setopt($curl_handler, CURLOPT_POST, count($arr_post_body));
        curl_setopt($curl_handler, CURLOPT_POSTFIELDS, $query_string);
        curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handler, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl_handler);
        curl_close($curl_handler);
        Storage::prepend('chikka_access.log', 'Result : ' . $response . '  Date: ' . date("Y-m-d H:i:s"));
        if ($response) {
            return true;
        }

        return $response;
    }

    private function setSendPostBody($request, $message, $contact_no)
    {
        return $arr_post_body = array(
            "message_type" => urlencode("SEND"),
            "mobile_number" => urlencode($contact_no),
            "shortcode" => urlencode(BGYWIFI_CHIKKA_SHORT_CODE),
            "message_id" => urlencode($this->generate_msgid(32)),
            'message' => urlencode($message),
            "client_id" => urlencode(BGYWIFI_CHIKKA_CLIENT_ID),
            "secret_key" => urlencode(BGYWIFI_CHIKKA_API_SECRET_KEY),
        );
    }

    private function setPostBody($request, $message)
    {
        return $arr_post_body = array(
            "message_type" => urlencode("REPLY"),
            "mobile_number" => urlencode($request->mobile_number),
            "shortcode" => urlencode(BGYWIFI_CHIKKA_SHORT_CODE),
            "request_id" => urlencode($request->request_id),
            "message_id" => urlencode($this->generate_msgid(32)),
            "message" => urlencode($message),
            "request_cost" => urlencode(VOTES_CHARGED),
            "client_id" => urlencode(BGYWIFI_CHIKKA_CLIENT_ID),
            "secret_key" => urlencode(BGYWIFI_CHIKKA_API_SECRET_KEY),
        );
    }

    private function generate_msgid($length)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0, $length);
    }
}
