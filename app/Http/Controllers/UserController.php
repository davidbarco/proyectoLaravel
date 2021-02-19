<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\User;

class UserController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }



    //
    /* metodo configuracion de usuario */
    public function config(){

        return view('user.config');
    }


    /* metodo para desde configuarion, actualizar los datos del usuario */
    public function update(Request $request){

        /* conseguir el usuario identificado */
        $user = \Auth::user();

        /* conseguir el id del usuario identificado */
        $id = $user->id;


        /* hacer validaciones del formulario configuracion o editar usuario */
        $validate = $this->validate($request, [

            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255', 'unique:users,nick,' . $id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id]
        ]);


        /* recoger los datos del formulario despues de validados */
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        /* asignar nuevos valores al objeto del usuario */
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        /* subir la imagen */
        $image_path = $request->file('image_path');
        if ($image_path) {

            /* poner un nombre unico */
            $image_path_name = time() . $image_path->getClientOriginalName();


            /* guardar en la carpeta storage (storage/app/users) */
            Storage::disk('users')->put($image_path_name, File::get($image_path));

            /* setear la imagen del archivo. */
            $user->image = $image_path_name;
        }

        /* ejecutar consulta y cambios en la base de datos, actualizar */
        $user->update();

        /*redireccionar despues de actualizar el usuario*/
        return redirect()->route('config')->with(['message' => 'usuario actualizado correctamente']);
    }


    /* metodo para mostrar la imagen del usuario */
    public function getImage($filename){

        $file = Storage::disk('users')->get($filename);

        return new Response($file, 200);
    }

    /* metodo para el perfil del usuario */
    public function profile($id){

        $user = User::find($id);
        
        return view('user.profile',[
            'user' => $user
        ]);
        

    }

    /* metodo para sacar todos los usuarios de la base de datos */
    public function index($search = null){
        
        if(!empty($search)){
            /* busco por el nick, por el nombre o por el surname */
            $users= User::where('nick','LIKE','%'.$search.'%')->orWhere('name','LIKE','%'.$search.'%')->orWhere('surname','LIKE','%'.$search.'%')->orderBy('id','desc')->paginate(5);
        }else{
            /* con el metodo all , me devuelve todos los usuarios de la base de datos */
            $users= User::orderBy('id','desc')->paginate(5);
        }
        return view('user.index', [
            'users' => $users
        ]);


    }

}
