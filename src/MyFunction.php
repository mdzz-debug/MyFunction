<?php

namespace mdzz\MyFunction\MyFunction;

class MyFunction
{
    /**
     * Curl request
     * @param string $url Request url
     * @param string $method GET|POST|PUT|DELETE
     * @param array|string $data Request data
     * @param array $headers Request headers
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

}