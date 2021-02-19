<div class="card pub_image">
                <div class="card-header">

                    @if ($image->user->image)
                    <div class="container-avatar">

                        <img class="avatar" src="{{ route('user.avatar',['filename'=>$image->user->image]) }}" alt="">

                    </div>
                    @endif

                    <div class="data-user">
                        <a href="{{ route('profile',['id'=>$image->user->id]) }}">
                        {{$image->user->name.' '.$image->user->surname}}
                        
                        </a>

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
                             <?php $user_like= true; ?>
                         @endif
                     @endforeach
                        @if($user_like)
                      

                          <i data-id="{{$image->id}}" class="fas fa-heart red"></i>
                       
                       
                        @else
                     
                        <i data-id="{{$image->id}}" class="far fa-heart corazon"></i>
                     
                     @endif
                        </div>
                   

                    <div class="description">
                     <p>{{count($image->likes)}} me gusta</p>
                      
                     
                        <span class="nickname">{{'@'.$image->user->nick}}</span>
                        <span class="creado">{{' | '.$image->created_at}}</span>
                        <p> {{$image->description}}</p>
                    </div>
                     <div class="comments">

                         <a href="{{ route('image.detail', ['id'=>$image->id])}}" class="btn btn-sm  btn-primary btn-comments">
                             comentarios ( {{count($image->comments)}} )
                         </a>


                     </div>

                  

                </div>
            </div>
