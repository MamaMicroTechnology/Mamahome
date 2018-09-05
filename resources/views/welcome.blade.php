<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MAMA MICRO TECHNOLOGY</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 80%;
                margin: 0;
                margin-top:5%; 
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            #login{
                margin-top:-85%;
                size: 10px;
                /*margin-left:-550%;*/
                
     border:3px  ;
     color: white;
     border-radius:10px;
    background-color:#939598;
     margin-right:10px;
     padding:10px 10px 10px 10px;

            
          /*  }
            .content{
                margin-top: 20%;
            }*/
    img{
        margin-top:10%; 
    }

        </style>
    
    </head>
    <body>
        <center> <img src="LOGO.png" ></center>
        <div class="flex-center">
            <div class="content"><br><br>
                <div class="title m-b-md">
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/home') }}" class="btn btn-success btn-lg" role="button">Home</a>
                    @else
                   <center> <a href="{{ route('login') }}"  class="btn btn-defualt btn-sm fa fa-sign-in" id="login" role="button">&nbsp;&nbsp;Login To APS</a></center>
                    @endauth
                    @endif
                </div>
            </div>
        </div>
    </body>
    </html>
    