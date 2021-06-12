<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
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
       
        return view('home.index',['artists' => $response,'token' => JWTAuth::getToken()]);
        
    }
}