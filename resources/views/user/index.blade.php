@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @include('includes.message')

            <!-- foreach, para mostrar las imagenes que tenemos -->
            @foreach($users as $user)

            <!-- include de la tarjeta de una imagen -->
            <!-- para mostrar el perfil del usuario -->
            <div class="data-user row  mb-5">

                @if ($user->image)
                <div class="container-avatar profiles  col-md-4">

                    <img class="avatar" src="{{ route('user.avatar',['filename'=>$user->image]) }}" alt="">

                </div>
                @endif

                <div class="user-info col-md-8">
                    <div class="usuarios d-flex">
                        <div class="nombreNick">
                            <h4 class="nombreUsuario mr-3">{{'@'.$user->nick}}</h4>
                        </div>
                        <div class="editarPerfil">
                            <a class="EditarPerfilN" href="{{ route('profile',['id'=>$user->id]) }}"><strong>Ver Perfil</strong></a>
                        </div>
                    </div>

                    <h1>{{$user->name.' '.$user->surname}}</h1>

                    <p>{{'se unió: '.$user->created_at}}</p>
                  
                </div>
                
            </div>
            <hr>
            @endforeach

            <!-- enlaces de paginacion -->
            <div class="clearfix"></div>
            <div class="paginations">
                {{$users->links()}}
            </div>

        </div>



    </div>
</div>
@endsection