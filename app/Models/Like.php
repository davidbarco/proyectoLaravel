<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{

    protected $table = "likes";


     /* relacion many to one / de muchos a uno */
     public function user(){
        return $this->belongsTo("App\Models\User", "user_id");
 
    }
     
      /* relacion many to one / de muchos a uno */
      public function image(){
        return $this->belongsTo("App\Models\Image", "image_id");
 
    }


    use HasFactory;
}
