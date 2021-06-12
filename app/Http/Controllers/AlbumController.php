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
        $albums = Album::get();
        
        $http = new HttpRequest();
        $response = $http->get('https://moat.ai/api/task/',['Basic' => 'ZGV2ZWxvcGVyOlpHVjJaV3h2Y0dWeQ==']);
       
        $albums = Album::cast_artists_id($albums,$response);
        return view('album.index',['albums' => $albums]);
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

        return view('album.form',['artists' => $response]);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $token)
    {
        $album = Album::find($id);
    
        $http = new HttpRequest();
        $artists = $http->get('https://moat.ai/api/task/',['Basic' => 'ZGV2ZWxvcGVyOlpHVjJaV3h2Y0dWeQ==']);
        
        return view('album.form',['album' => $album, 'token' => $token, 'artists' => $artists]);
    
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
        $album = Album::find($request->get('album'));
        $album->artist_id = $request->get('artist');
        $album->album_name = $request->get('album_name');
        $album->year = $request->get('year');
       
        if($album->save()){
            return response()->json(['success'=>'Album updated!', 'album_id' => $album->id],201);
        
        }

        return response()->json(['error'=>'Cannot create the album. Please contact the support!'],400);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $token)
    {
        if($this->user->role){

            $album = Album::find($id);
            $album->delete();
            return response()->json(['success'=>'Album deleted!','page'=> route('album')],200);
        }

        return response()->json(['error'=>'Only admins can delete a album!'],400);
    }
}
