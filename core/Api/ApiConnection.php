<?php

namespace core\Api;

use core\Container;

class ApiConnection
{
    /**
     * Connects to API.
     * Returns API response.
     */
    public static function connectToApi(string $url, string $params)
    {
        $apiKey = (require Container::get('config'))['apiKey'];
        $url = $url . '?' . $params . '&apikey=' . $apiKey;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl));
        curl_close($curl);
        return $response;
    }
}