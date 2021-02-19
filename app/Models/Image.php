<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

   /* indicar cual va a ser la tabla de la base de datos que va a modificar este modelo */
   protected $table = "images";

   /* relacion one to many / de uno a muchos */
   public function comments(){
       return $this->hasMany("App\Models\Comment")->orderBy('id', 'desc');

   }

    /* relacion one to many / de uno a muchos */
    public function likes(){
        return $this->hasMany("App\Models\Like");
 
    }

    /* relacion many to one / de muchos a uno */
    public function user(){
        return $this->belongsTo("App\Models\User", "user_id");
 
    }
 


    use HasFactory;
}