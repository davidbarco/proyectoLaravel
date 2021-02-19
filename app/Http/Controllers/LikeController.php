<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class LikeController extends Controller
{
    //// restringo el acceso con el middleware, permite que si no hay un usuario logueado, no me deje seguir a esta ruta
    public function __construct(){
        $this->middleware('auth');
    }

    /* metodo para dar like a una publicacion  */
    public function like($image_id){
        
        /* recoger datos del usuario y la imagen */
        $user = Auth::user();

        /* para comprobar si ya le di like a una publicacion y no duplicarlo */
        $isset_like = Like::where('user_id', $user->id)
                            ->where('image_id', $image_id)
                            ->count();


       
                   
                    if($isset_like == 0){
                    /* me creo mi objeto like, importo arriba en el use, el modelo like */
                    $like = new Like();

                    /* seteo las propiedades que tiene mi modelo like. */
                    $like->user_id = $user->id;
                    $like->image_id = (int)$image_id;

                    /* guardo en base de datos */
                    $like->save();

                    return response()->json([
                        'like' => $like
                        ]);

                    /* ahora me creo una ruta en routes web.php */
                }else{
                    return response()->json([
                        'message' => 'el like ya existe'
                        ]);
                }
}

    /* metodo para dar dislike a una publicacion */
    public function disLike($image_id){
              

        
        /* recoger datos del usuario y la imagen */
        $user = Auth::user();

        /* para comprobar si ya le di like a una publicacion y no duplicarlo */
        $like = Like::where('user_id', $user->id)
                            ->where('image_id', $image_id)
                            ->first();


       
                   
                    if($like){
                
                    /* eliminar el like que existe*/
                    $like->delete();

                    return response()->json([
                        'like' => $like,
                        'message'=> 'like eliminado'
                        ]);

                    /* ahora me creo una ruta en routes web.php */
                }else{
                    return response()->json([
                        'message' => 'el like no existe'
                        ]);
                }
    }


    /* metodo para saber los likes que he dado y guardarlos en un array */
    public function index(){
       
        $user = Auth::user();
        $likes = Like::where('user_id', $user->id)->orderBy('id','desc')->paginate(5);
       
        


        return view('like.index', [
            'likes' => $likes
        ]);
    }



}
