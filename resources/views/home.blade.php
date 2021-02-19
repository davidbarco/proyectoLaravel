@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @include('includes.message')

            <!-- foreach, para mostrar las imagenes que tenemos -->
            @foreach($images as $image)
           
            <!-- include de la tarjeta de una imagen -->
            @include('includes.image',['image'=>$image])
            @endforeach

            <!-- enlaces de paginacion -->
            <div class="clearfix"></div>
            <div class="paginations">
                {{$images->links()}}
            </div>

        </div>



    </div>
</div>
@endsection