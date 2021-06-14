<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Hash;

class UserController extends Controller
{
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('register.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request_data = $request->all();

        $validator = Validator::make($request_data,[
            'full_name' => 'required',
            'username' => 'required|unique:users|min:3',
            'password' => 'required|min:6',
            'role' => 'integer'
        ]);

        if($validator->passes()){
            
            if(User::create([
                'full_name' => $request->full_name,
                'username' => $request->username,
                'password' => bcrypt($request_data['password']),
                'role' => isset($request->role) ? 1 : 0
            ])){

                return response()->json(['success'=>'Your account has successfully created. Go to login page!',
                                        'login_page'=> route('login')],201);
            
            }

            return response()->json(['error'=>'Cannot create your account. Please contact the support!'],400);

        }

        return response()->json(['error'=>$validator->errors()->all()], 400);
        
    }
}