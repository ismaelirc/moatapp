<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;
  
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'artist_id',
       'album_name',
       'year'
   ];

   /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
   protected $hidden = [];

   /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
   protected $casts = [];

   /**
    * Cast the artist ID in album to artist name.
    *
    * @return array
    */
   protected function cast_artists_id($albums, $artists){

        foreach($albums as $a){

            $index = ($a->artist_id) - 1;
            $a->artist_name = $artists[$index]['name'];
           
        }

        return $albums;
   }

   protected function is_valid_artist($artist_id,$artists){
    
        if(($valid = array_search($artist_id,array_column($artists,'id')) === false)){
            return true;
        }

        return false;
   }

}