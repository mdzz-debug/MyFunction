<?php

namespace mdzz\MF;

use mdzz\MF\package\BaseMf;

class Http extends BaseMf
{
    /**
     * Curl request
     * @param string $url Request url
     * @param string $method GET|POST|PUT|DELETE, default GET
     * @param array|string $data Request data, default []
     * @param array $headers Request headers, default []
     * @return bool|string Request result
     */
    public static function curlRequest($url, $method = 'GET', $data = [], $headers = [])
    {
        if ($method == 'GET' && !empty($data)) {
            $url .= '?' . http_build_query($data);
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        if (!empty($headers)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        if (in_array(strtoupper($method), ['POST', 'PUT', 'DELETE'])) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    /**
     * Echo JSON
     * @param int $code JSON code
     * @param array $data JSON data
     * @param string $msg JSON message
     * @param int $flag JSON encode flag
     * @return void Echo JSON
     */
    public static function echoJson($code = 0, $data = [], $msg = '', $flag = 320)
    {
        echo json_encode([
            'code' => $code,
            'data' => $data,
            'msg' => $msg
        ], $flag);
    }

}