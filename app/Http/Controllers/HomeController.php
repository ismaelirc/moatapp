<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use App\Classes\HttpRequest;

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

        $http = new HttpRequest();
        $response = $http->get('https://moat.ai/api/task/',['Basic' => 'ZGV2ZWxvcGVyOlpHVjJaV3h2Y0dWeQ==']);
       
        $response->each(function ($item, $key) {

            $this->artists[] = ['id'=> $item[0]['id'],
                                'name'=> $item[0]['name'], 
                                'twitter' => $item[0]['twitter']];
            
        });
        
        return view('home.index',['artists' => $this->artists]);
        //return $this->user;
    }
}