<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    protected $user;
    protected $artists = [];

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

     /**
     * Display home dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $http = new Client();
        $http_request = $http->request('GET','https://moat.ai/api/task/',[
            'headers' => ['Basic' => 'ZGV2ZWxvcGVyOlpHVjJaV3h2Y0dWeQ==']
        ]);

      
        $response = collect(json_decode($http_request->getBody(), true));
        
        $response->each(function ($item, $key) {

            $this->artists[] = ['id'=> $item[0]['id'],
                                'name'=> $item[0]['name'], 
                                'twitter' => $item[0]['twitter']];
            
        });
        
        return view('home.index',['artists' => $this->artists]);
        //return $this->user;
    }
}
