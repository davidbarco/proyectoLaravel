@if(Auth::user()->image)
<div class="container-avatar">

<img class="avatar" src="{{ route('user.avatar', [Auth::user()->image]) }}" alt="">

</div>

@endif