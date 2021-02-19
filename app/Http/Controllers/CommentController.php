<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    //metodo para que solo me de acceso cuando haya un usuario logueado
    public function __construct()
    {
        $this->middleware('auth');
    }


    /* metodo para guardar los comentarios de la publicacion  */
    public function save(Request $request){


        /* hacemos las validaciones */
        $validate = $this->validate($request,[

         'image_id' => ['required','integer'],     
         'content' => ['required','string'],   
            
        ]);

        /* recogo el id de la imagen */
        $image_id = $request->input("image_id");

        /* recogo el  contenido del comentario que pongo en el textarea con nombre 'content' . */
        $content = $request->input('content');

        /* recogo el id del usuario logueado */
        $user = Auth::user();

        /* asigno los valores a mi nuevo objeto a guardar */
        $comment = new Comment();

        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        /* guardo en base de datos */
        $comment->save();

        /* redireccion a la pagina del detalle */
        return redirect()->route('image.detail', ['id' => $image_id])->with([
            'message' => 'Has publicado tu comentario correctamente'
        ]);

       

           

    }

    /*metodo para eliminar el comentario cuando soy el dueño del comentario  */
    public function delete($id){


        /* recoger datos del usuario identificado */
        $user = Auth::user();

        /* conseguir onjeto del comentario */
        $comment = Comment::find($id);


        /* comprobar si soy el dueño del comentario o de la publicacion */
        if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){

            $comment->delete();

             /* redireccion a la pagina del detalle */
        return redirect()->route('image.detail', ['id' => $comment->image->id])->with([
            'message' => 'Has borrado tu comentario correctamente'
        ]);
        }else{
            return redirect()->route('image.detail', ['id' => $comment->image->id])->with([
                'message' => 'error, comentario no eliminado'
            ]);
        }



    }


}
