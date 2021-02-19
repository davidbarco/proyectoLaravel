@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @include('includes.message')



            <div class="card pub_image pub_image_detail">
                <div class="card-header">

                    @if ($image->user->image)
                    <div class="container-avatar">

                        <img class="avatar" src="{{ route('user.avatar',['filename'=>$image->user->image]) }}" alt="">

                    </div>
                    @endif

                    <div class="data-user">

                        {{$image->user->name.' '.$image->user->surname}}

                    </div>

                </div>

                <div class="card-body">
                    <div class="image-container">

                        <img src="{{ route('image.file',['filename'=> $image->image_path]) }}" alt="">

                    </div>

                    <div class="like">
                        <!-- comprobar si el usuario le dio like a la imagen -->
                        <?php $user_like = false; ?>
                        @foreach($image->likes as $like)
                        @if($like->user->id == Auth::user()->id)
                        <?php $user_like = true; ?>
                        @endif
                        @endforeach
                        @if($user_like)


                        <i data-id="{{$image->id}}" class="fas fa-heart red"></i>


                        @else

                        <i data-id="{{$image->id}}" class="far fa-heart corazon"></i>

                        @endif
                    </div>

                    <!-- si el usuario es el dueño de la imagen, le aparecen los botones de  editar o borrar  -->
                    @if(Auth::user() && Auth::user()->id == $image->user->id)
                    <div class="actions">
                        <a href="{{route('image.edit',['id'=>$image->id])}}" class="btn btn-sm btn-primary">Editar</a>
                       
                        <!-- Button to Open the Modal -->
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal">
                            Eliminar
                        </button>

                        <!-- The Modal -->
                        <div class="modal" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">¿Estas seguro?</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        si eliminas esta imagen nunca podras recuperarla, ¿estas seguro de borrarla?
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                                        <a href="{{route('image.delete', ['id'=>$image->id])}}" class="btn btn-danger">Borrar Definitivamente</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endif


                    <div class="description">
                        <p>{{count($image->likes)}} me gusta</p>
                        <span class="nickname">{{'@'.$image->user->nick}}</span>
                        <span class="creado">{{' | '.$image->created_at}}</span>
                        <p> {{$image->description}}</p>
                    </div>

                    <div class="comments">


                        <h2>comentarios ( {{count($image->comments)}} )</h2>
                        <hr>
                        <!-- en la accion del formulario, el nombre de la ruta -->
                        <form action="{{ route('comment.save')}}" method="post">
                            @csrf

                            <input type="hidden" name="image_id" value="{{$image->id}}">
                            <p>
                                <textarea class="form-control {{$errors->has('content') ? 'is-invalid' : ''}}" name="content" id="" cols="10" rows="3"></textarea>

                                <!-- condicional cuando hay error del contenido al enviarse vacio -->
                                @if($errors->has('content'))
                                <span class="invalid-feedback" role="alert">

                                    <strong>{{$errors->first('content')}}</strong>

                                </span>

                                @endif
                                <!-- fin condicional -->

                            </p>


                            <button class="btn btn-primary" type="submit">Enviar</button>


                        </form>
                        <hr>
                        <!-- listar los comentarios -->
                        @foreach($image->comments as $comment)

                        <div class="comment">

                            <span class="nickname">{{'@'.$comment->user->nick}}</span>
                            <span class="creado">{{' | '.$comment->created_at}}</span>
                            <p> {{$comment->content}}</p>
                            <!-- condicion para que se muestre el boton de eliminar, cuando el usuario logueado sea el dueño del comentario o foto -->
                            @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                            <a class="btn btn-sm btn-danger" href="{{ route('comment.delete',['id'=>$comment->id])}}">Eliminar</a>
                            @endif
                            <hr>


                        </div>
                        @endforeach

                    </div>



                </div>
            </div>

        </div>



    </div>
</div>
@endsection