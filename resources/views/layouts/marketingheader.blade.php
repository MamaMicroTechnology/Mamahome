<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MamaHome</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        body{
            font-family: "Times New Roman";
        }
        #go {
          transform: translate(-50%, 0%);
          color: white;
          border: 0;
          background: #71c341;
          width: 100px;
          height: 30px;
          border-radius: 6px;
          font-size: 2rem;
          transition: background 0.2s ease;
          outline: none;
        }
        #go:hover {
          background: #8ecf68;
        }
        #go:active {
          background: #5a9f32;
        }
        
        .message {
          position: absolute;
          top: -200px;
          left: 50%;
          transform: translate(-50%, 0%);
          width: 300px;
          background: white;
          border-radius: 8px;
          padding: 30px;
          text-align: center;
          font-weight: 300;
          color: #2c2928;
          opacity: 0;
          transition: top 0.3s cubic-bezier(0.31, 0.25, 0.5, 1.5), opacity 0.2s ease-in-out;
        }
        .message .check {
          position: absolute;
          top: 0;
          left: 50%;
          transform: translate(-50%, -50%) scale(4);
          width: 120px;
          height: 110px;
          background: #71c341;
          color: white;
          font-size: 3.8rem;
          padding-top: 10px;
          border-radius: 50%;
          opacity: 0;
          transition: transform 0.2s 0.25s cubic-bezier(0.31, 0.25, 0.5, 1.5), opacity 0.1s 0.25s ease-in-out;
        }
        .message .scaledown {
          transform: translate(-50%, -50%) scale(1);
          opacity: 1;
        }
        .message p {
          font-size: 1.1rem;
          margin: 25px 0px;
          padding: 0;
        }
        .message p:nth-child(2) {
          font-size: 2.3rem;
          margin: 40px 0px 0px 0px;
        }
        .message #ok {
          position: relative;
          color: white;
          border: 0;
          background: #71c341;
          width: 100%;
          height: 50px;
          border-radius: 6px;
          font-size: 1.2rem;
          transition: background 0.2s ease;
          outline: none;
        }
        .message #ok:hover {
          background: #8ecf68;
        }
        .message #ok:active {
          background: #5a9f32;
        }
        
        .comein {
          top: 150px;
          opacity: 1;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img style="height: 25px; width: 170px;" src="{{ URL::to('/') }}/logo.png">
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if(Auth::check())
                        <li><a href="{{ URL::to('/home') }}">Home</a></li>
                        <!-- <a href="{{ URL::to('/') }}/kra" class="form-control btn btn-primary">KRA</a><br><br> -->
                        @endif
                    </ul>
                
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a href="{{ URL::to('/')}}/profile">Profile</a></li>
                                    <li><a href="{{ URL::to('/')}}/changePassword">Change Password</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('authlogout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @if(session('Success'))
    <script>
    $( document ).ready(function(){go(50)});
        $('#ok').click(function(){go(500)});
        
        function go(nr) {
          $('.bb').fadeToggle(200);
          $('.message').toggleClass('comein');
          $('.check').toggleClass('scaledown');
          $('#go').fadeToggle(nr);
        }
    </script>
    @endif
</body>
</html>
