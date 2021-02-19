
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <h1 class="text-center">Las imagenes que me gustan</h1>
        <hr>

         <!-- ciclo foreach para recorrer los objetos al cual le he dado me gusta -->
          @foreach($likes as $like)
                  
          @include('includes.image',['image'=>$like->image])

          @endforeach


            <!-- enlaces de paginacion -->
            <div class="clearfix"></div>
            <div class="paginations">
                {{$likes->links()}}
            </div>





        </div>



    </div>
</div>
@endsection