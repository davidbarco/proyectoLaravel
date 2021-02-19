<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4cb597c7f1.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-primary shadow-sm">
            <div class="container">
                <a class="navbar-brand text-white" href="{{ url('/') }}">
                   InstagramLaravel
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        <li class="nav-item">
                               <form action="{{route('user.index')}}" method="GET" class="d-flex" id="buscador" >
                               <input class="form-control mr-2" placeholder="Buscar Usuario..." type="search" id="search">     
                               
                               <input type="submit" value="Buscar" class=" btn btn-success">

                               
                          
                               </form>
                              
                            </li>
                            <li class="nav-item">
                               <a class="text-white nav-link" href="{{ route('home') }}">Inicio</a>
                              
                            </li>
                 

                            <li class="nav-item">
                            
                            <a class="text-white nav-link" href="{{ route('likes') }}">Mis Likes</a>
                            </li>

                            <li class="nav-item">
                            
                            <a class="text-white nav-link" href="{{ route('user.index') }}">Gente</a>
                            </li>

                            <li class="nav-item">
                            
                            <a class="text-white nav-link" href="{{ route('image.create') }}">Subir imagen</a>
                            </li>

                            <li>
                            
                             <!-- mostrar imagen mediante un include -->
                             @include('includes.avatar')
                            </li>
                            


                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right bg-primary" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item text-white" href="{{ route('profile',['id'=>Auth::user()->id]) }}">
                                       Mi perfil
                                    </a>

                                    <a class="dropdown-item text-white" href="{{ route('config')}}">
                                       Configuración
                                    </a>
                                    
                                    
                                    <a class="dropdown-item text-white" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Cerrar Sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                    
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
