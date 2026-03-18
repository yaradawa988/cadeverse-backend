<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/myCss.css') }}">
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
   <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
   <style>


.custom-navbar {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }

.custom-nav-item {
    color: white;
}

.custom-nav-item:hover {
    color: #f0f0f0; 
   
}
.custom-nav-item {
    color: black !important;
    font-weight: bold !important;
}

.nav-link {
    color: black !important;
    font-weight: bold !important;
}

.nav-link:hover {
    color:rgb(154, 222, 243) !important;
}

      
.footer {
   
    border: none !important;
    box-shadow: none !important;
    text-align: center;
    width: 100%;
    z-index: 1;
    font-size: 0.5rem;
    margin-top: 2px;
    padding: 10px 0;
}

.footer-content {
   
    color: white;
    text-align: center;
    padding: 5px 0;
}

.footer-content p {
    margin: 0;
    font-size: 1rem;
}

.social-icons {
    margin-top: 10px;
}

.social-icons a {
    font-size: 1.5rem;
    color: white;
    transition: color 0.3s ease;
}

.social-icons a:hover {
    color:rgb(238, 94, 161); 
}
</style>
   </head>
<body>
    <div id="app">
    <nav class="navbar navbar-expand-md navbar-light custom-navbar shadow-sm">
            <div class="container-fluid">
               
                <a class="navbar-brand d-flex align-items-center" href="{{ url('home') }}">
                  
                    <span  style="color:rgb(0, 0, 0);font-weight: bold;" >{{ config('app.name', 'CodeFirs') }}</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                 
                    <ul class="navbar-nav me-auto">

                    </ul>

              
                    <ul class="navbar-nav ms-auto">
                        
                         
                                  
                        <li class="nav-item">
        <a class="nav-link custom-nav-item " style="nav-link :color:rgb(0, 0, 0)" href="{{url('/')}}">Home</a>
      </li>
      @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">login</a>
                                </li>
                            @endif
                    @else
                    <li class="nav-item">
        <a class="nav-link custom-nav-item " style="nav-link :color:rgb(0, 0, 0)" href="{{ route('home') }}">dashboard</a>
      </li>
                 
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ url('profile') }}">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                       logout
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

        <main class="py-1">
            @yield('content')
        </main>
    </div>


   
   
<div class="footer-content">
    <p>Copyright &copy; All rights reserved for us 2025</p>
    <div class="social-icons">
        <a href="https://www.google.com" target="_blank" class="mx-2">
            <i class="fab fa-google"></i>
        </a>
        <a href="https://www.facebook.com" target="_blank" class="mx-2">
            <i class="fab fa-facebook"></i>
        </a>
        <a href="https://www.instagram.com" target="_blank" class="mx-2">
            <i class="fab fa-instagram"></i>
        </a>
    </div>
</div>
</body>
</html>