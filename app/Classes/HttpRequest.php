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

    protected $artists;
    private $url;
    private $header;
    private $method;

     /**
     * 
     * @param url URL to send the request 
     * @param header All headers neededrty
     * @param method Http method to use
     */
    public function __construct($url, $header, $method) {
        
        $this->url = $url;
        $this->header = $header;
        $this->method = $method;
    }

    /**
     * Do GET request
     * 
     * @return Array Artist list
     */
    public function get() {

        $http = new Client();
        $http_request = $http->request($this->method,$this->url,[
            'headers' => $this->header
        ]);

        $response = collect(json_decode($http_request->getBody(), true));

        $response->each(function ($item, $key) {

            $this->artists[] = ['id'=> $item[0]['id'],
                                'name'=> $item[0]['name'], 
                                'twitter' => $item[0]['twitter']];
            
        });

        return $this->artists;
    }
}