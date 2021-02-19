 <!-- alerta para cuando usuario haya sido actualizado -->
 @if(session('message'))

<div class="alert alert-success" role="alert">
    {{session('message')}}
</div>

@endif