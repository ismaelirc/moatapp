<?php

namespace App\Http\Controllers;

use JWTAuth;
use Validator;
use DB;
use App\Models\Album;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\AlbumFormRequest;
use App\Classes\HttpRequest;

class AlbumController extends Controller
{
    protected $user;
    protected $artists = [];
    private $table_name = 'albums';

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($token, $artist_id = false)
    {
        
        $query = DB::table($this->table_name);

        if($artist_id){
            $query->where('artist_id',$artist_id);
        }
        
        $albums = $query->get();
        
        $http = new HttpRequest('https://moat.ai/api/task/',
                                ['Basic' => 'ZGV2ZWxvcGVyOlpHVjJaV3h2Y0dWeQ=='],
                                'post');
        $artists = $http->get();
        
        $albums = Album::cast_artists_id($albums,$artists);
        return view('album.index',['albums' => $albums]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $http = new HttpRequest('https://moat.ai/api/task/',
                                ['Basic' => 'ZGV2ZWxvcGVyOlpHVjJaV3h2Y0dWeQ=='],
                                'post');

        $artists = $http->get();

        return view('album.form',['artists' => $artists]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlbumFormRequest $request)
    {
        $request_data = $request->all();

        //make sure the artists is in the list
        $http = new HttpRequest('https://moat.ai/api/task/',
                                ['Basic' => 'ZGV2ZWxvcGVyOlpHVjJaV3h2Y0dWeQ=='],
                                'post');
        $artists = $http->get();
        $valid_artist = Album::is_valid_artist($request['artist'],$artists);
       
        if($valid_artist){
            return response()->json(['error' => 'The artist must be in the list provided!'],400);
        }

        $validator = $request->validated();

        if($validator){
            
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
    
        $http = new HttpRequest('https://moat.ai/api/task/',
                                ['Basic' => 'ZGV2ZWxvcGVyOlpHVjJaV3h2Y0dWeQ=='],
                                'post');
        $artists = $http->get();
        
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

        $http = new HttpRequest('https://moat.ai/api/task/',
                                ['Basic' => 'ZGV2ZWxvcGVyOlpHVjJaV3h2Y0dWeQ=='],
                                'post');
        $artists = $http->get();
        $valid_artist = Album::is_valid_artist($request->get('artist'),$artists);
       
        if($valid_artist){
            return response()->json(['error' => 'The artist must be in the list provided!'],400);
        }
       
        if($album->save()){
            return response()->json(['success'=>'Album updated!', 'album_id' => $album->id],201);
        
        }

        return response()->json(['error'=>'Cannot updated the album. Please contact the support!'],400);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  string  $token
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
