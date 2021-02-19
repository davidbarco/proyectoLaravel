<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    // restringo el acceso con el middleware, permite que si no hay un usuario logueado, no me deje seguir a esta ruta
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* metodo para subir imagen  */
    public function create()
    {

        return view('image.create');
    }

    /* metodo para guardar la imagen */
    public function save(Request $request)
    {

        /* validacion */
        $validate = $this->validate($request, [
            'description' => ['required'],
            'image_path' => ['required', 'mimes:jpg,jpeg,png,gif'],

        ]);


        /* recogiendo los datos */
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        /* asignar valores al objeto */
        $user = Auth::user();
        $image = new Image();
        $image->user_id = $user->id;
        $image->description = $description;

        /* subir fichero o imagen */
        if ($image_path) {

            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        $image->save();

        return redirect()->route('home')->with([
            'message' => 'la foto ha sido subida correctamente!!'
        ]);
    }

    /* metodo que me devuelva las imagenes guardadas */
    public function getImage($filename)
    {

        $file = Storage::disk('images')->get($filename);

        return new Response($file, 200);
    }


    /* metodo para ver el detalle de cada publicacion o imagen */
    public function detail($id)
    {
        $image = Image::find($id);

        return view('image.detail', [
            'image' => $image
        ]);
    }

    /* metodo para eliminar publicacion */
    /* 1) le paso el id de la imagen por parametro*/
    public function delete($id){

        /* conseguir el objeto del usuario identificado */
        $user = Auth::user();
        /* id de la imagen */
        $image = Image::find($id);

        /* para borrar una publicacion, tambien debo borrar los comentario y los likes, porque van asociados a la publicacion */
        $comment = Comment::where('image_id', $id)->get();
        $like = Like::where('image_id', $id)->get();

        /* condicion para borrar publicaciones si solo soy el dueño */
        if ($user && $image && $image->user->id == $user->id) {

            /* eliminar comentarios */
            if ($comment && count($comment) >= 1) {

                foreach ($comment as $comments) {
                    $comments->delete();
                }
            };


            /* eliminar los likes */
            if ($like && count($like) >= 1) {

                foreach ($like as $likes) {
                    $likes->delete();
                }
            };

            /* eliminar ficheros de la imagen */
            Storage::disk('images')->delete($image->image_path);

            /* eliminar la publicacion o el registro de la imagen */
            $image->delete();
            $message = array('message'=> 'la imagen se ha borrado correctamente');
        }else{
            $message = array('message'=> 'la imagen no se ha borrado.');
        }
        return redirect()->route('home')->with($message);
    }

    /* metodo para editar una publicacion o imagen a actualizar */
    public function edit($id){
       $user = Auth::user();
       $image = Image::find($id);

       if($user && $image && $image->user->id == $user->id){
             return view('image.edit',[
                 'image' => $image
             ]);
       }else{
           return redirect()->route('home');
       }
       
    }

    /* metodo para despues de estar en la pagina de editar publicacion, actualizar */
    public function update(Request $request){

        /* validacion */
        $validate = $this->validate($request, [
            'description' => ['required'],
            'image_path' => ['mimes:jpg,jpeg,png,gif'],

        ]);

/* recoger datos */
        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        /*  conseguir objeto image y setearlo */
        $image = Image::find($image_id);
        $image->description= $description;

        /* subir fichero o imagen */
        if ($image_path) {

            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        /* actualizar registro */
        $image->update();

        return redirect()->route('image.detail', ['id'=> $image_id])->with([
            'message' => 'la foto ha sido actualizada correctamente!!'
        ]);



    }



}
