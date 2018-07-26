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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script type="text/javascript" src="{{asset('js/gmaps.js')}}"></script>
    <script src="{{ URL::to('/') }}/js/jscolor.js"></script>

    <!-- <link rel="stylesheet" href="http://twitter.github.com/bootstrap/1.3.0/bootstrap.min.css" /> -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/some.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/app.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="{{ URL::to('/') }}/css/countdown.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    body{
        font-family: "Times New Roman";
    }
        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }
        
        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 15px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }
        
        .sidenav a:hover {
            color: #f1f1f1;
        }
        
        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }
        
        #main {
            transition: margin-left .5s;
            padding: 16px;
        }
        
        @media screen and (max-height: 450px) {
          .sidenav {padding-top: 15px;}
          .sidenav a {font-size: 18px;}
        }
    /*******************************Calendar Top Navigation*********************************/
div#calendar{
    margin:0px auto;
    padding:0px;
    width: 602px;
    font-family:Helvetica, "Times New Roman", Times, serif;
  }
   
  div#calendar div.box{
      position:relative;
      top:0px;
      left:0px;
      width:100%;
      height:40px;
      background-color:   #787878 ;      
  }
   
  div#calendar div.header{
      line-height:40px;  
      vertical-align:middle;
      position:absolute;
      left:11px;
      top:0px;
      width:582px;
      height:40px;   
      text-align:center;
  }
   
  div#calendar div.header a.prev,div#calendar div.header a.next{ 
      position:absolute;
      top:0px;   
      height: 17px;
      display:block;
      cursor:pointer;
      text-decoration:none;
      color:#FFF;
  }
   
  div#calendar div.header span.title{
      color:#FFF;
      font-size:18px;
  }
   
   
  div#calendar div.header a.prev{
      left:0px;
  }
   
  div#calendar div.header a.next{
      right:0px;
  }
   
   
   
   
  /*******************************Calendar Content Cells*********************************/
  div#calendar div.box-content{
      border:1px solid #787878 ;
      border-top:none;
  }
  div#calendar ul.label{
      float:left;
      margin: 0px;
      padding: 0px;
      margin-top:5px;
      margin-left: 5px;
  }
  div#calendar ul.label li{
      margin:0px;
      padding:0px;
      margin-right:5px;  
      float:left;
      list-style-type:none;
      width:80px;
      height:40px;
      line-height:40px;
      vertical-align:middle;
      text-align:center;
      color:#000;
      font-size: 15px;
      background-color: transparent;
  }
  div#calendar ul.dates{
      float:left;
      margin: 0px;
      padding: 0px;
      margin-left: 5px;
      margin-bottom: 5px;
  }
  /** overall width = width+padding-right**/
  div#calendar ul.dates li{
      margin:0px;
      padding:0px;
      margin-right:5px;
      margin-top: 5px;
      vertical-align:middle;
      float:left;
      list-style-type:none;
      width:80px;
      height:80px;
      font-size:12px;
      background-color: #DDD;
      color:#000;
      text-align:center; 
  }
   
  :focus{
      outline:none;
  }
   
  div.clear{
      clear:both;
  }
  
  /*Image modal*/
       /* Style the Image Used to Trigger the Modal */
.myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.imgModal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.imgModal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}

/* Caption of Modal Image (Image Text) - Same Width as the Image */
#caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation - Zoom in the Modal */
.imgModal-content, #caption {
    animation-name: zoom;
    animation-duration: 0.6s;
}

@keyframes zoom {
    from {transform:scale(0)}
    to {transform:scale(1)}
}

/* The Close Button */
.imgClose {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.imgClose:hover,
.imgClose:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}
</style>
<style>


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
                    @if(Auth::check())
                        <a href="#" class="navbar-brand" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</a>
                    @endif
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if(Auth::check())
                        <li><a href="{{ URL::to('/') }}/home" style="font-size:1.1em"><b>Home</b></a></li>
                        <!-- <li><a href="{{ URL::to('/') }}/chat" style="font-size:1.1em"><b>Chat <span class="badge">&nbsp;{{ $chatcount }}&nbsp;</span></b></a></li> -->
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
                                    <li><a href="{{ URL::to('/') }}/profile ">Profile</a></li>
                                    @if(Auth::user()->department_id == 2 && Auth::user()->group_id == 7)
                                    <li><a href="{{ URL::to('/') }}/salescompleted ">Completed</a></li>
                                    @endif
                                    @if(Auth::user()->department_id == 0 && Auth::user()->group_id == 1)
                                    <li><a href="{{ URL::to('/') }}/admincompleted?id={{ Auth::user()->id }}">Completed</a></li>
                                    @endif
                                   <!--  <li><a href="{{ URL::to('/')}}/changePassword">Change Password</a></li> -->
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
@if(Auth::check())
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" onclick="closeNav()">&times;</a>
    <a href="{{ URL::to('/getprojectsize') }}">Listed Project & Sizes</a>
    <a href="{{ URL::to('/projection') }}">Monthly Sales Projection</a>
    <a href="{{ URL::to('/stage') }}">Monthly Sales Target</a>
    <a href="{{ URL::to('/daily') }}">Daily Sales Target</a>
    <a href="{{ URL::to('/yearly') }}">Yearly Sales Projection</a>
    <a href="{{ URL::to('/fiveyears') }}">Five Years Sales Projection</a>
    <a href="{{ URL::to('/countryProjection') }}">One Year Country Projection</a>
    <!-- <a href="{{ URL::to('/fiveYearsCountryProjection') }}">Five Years Country Projection</a> -->
    <a href="{{ URL::to('/expenditure') }}">Expenditure</a>
    <a href="{{ URL::to('/five_years_expenditure') }}">Five Years Expenditure</a>
    <a href="{{ URL::to('/extensionPlanner') }}">Extension Planner</a>
</div>
@endif  
@yield('content')
    </div>
    
    <!-- Scripts -->
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        }
        
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft= "0";
        }
        </script>
    <script>
        // Get the modal
        var modal = document.getElementById('myModal');
        
        // Get the image and insert it inside the modal - use its "alt" text as a caption
        function display(arg){
            var img = document.getElementById(arg);
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");
            img.onclick = function(){
                modal.style.display = "block";
                modalImg.src = this.src;
                captionText.innerHTML = this.alt;
            }
        }
        
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("imgClose")[0];
        
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() { 
            modal.style.display = "none";
        }
        </script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ URL::to('/') }}/js/countdown.js"></script>
</body>
</html>
