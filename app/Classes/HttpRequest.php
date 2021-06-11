<?php 
/**
   * Http Request component
   * 
   * @package    App
   * @subpackage Clasees
   * @author     Ismael Ricardo Costa <ismaelirc@gmail.com>
   */

namespace App\Classes;

use GuzzleHttp\Client;

class HttpRequest {

    public function __construct() {}

    /**
     * Do GET request
     * @param url URL to send the request 
     * @param header All headers neededrty
     * @return Array Artist list
     */
    public function get($url, $header) {

        $http = new Client();
        $http_request = $http->request('GET','https://moat.ai/api/task/',[
            'headers' => $header
        ]);

        $response = collect(json_decode($http_request->getBody(), true));

        return $response;
    }
}