<?php

namespace App\Http\Controllers;

use JWTAuth;
use Validator;
use App\Models\Album;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use App\Classes\HttpRequest;

class AlbumController extends Controller
{
    protected $user;
    protected $artists = [];

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('album.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $http = new HttpRequest();
        $response = $http->get('https://moat.ai/api/task/',['Basic' => 'ZGV2ZWxvcGVyOlpHVjJaV3h2Y0dWeQ==']);
       
        $response->each(function ($item, $key) {

            $this->artists[] = ['id'=> $item[0]['id'],
                                'name'=> $item[0]['name'], 
                                'twitter' => $item[0]['twitter']];
            
        });

        return view('album.form',['artists' => $this->artists]);
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
            'album_name' => 'required|min:3',
            'year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
            'artist' => 'required|integer'
        ]);

        if($validator->passes()){
            
            $album = Album::create([
                'artist_id' => $request->artist,
                'album_name' => $request->album_name,
                'year' => $request->year
            ]);

            if($album){
                return response()->json(['success'=>'Album save!', 'album_id' => $album->id],201);
            
            }

            return response()->json(['error'=>'Cannot create the album. Please contact the support!'],400);

        }

        return response()->json(['error'=>$validator->errors()->all()], 400);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        return $request->input('album_name');
        /*
        $equipamento->tipo = $request->input('tipo');
        $equipamento->modelo = $request->input('modelo');
        $equipamento->fabricante = $request->input('fabricante');
        $equipamento->update();
        */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
