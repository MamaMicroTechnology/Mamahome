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
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/signature-pad.css">
    
</head>
<body>
<!-- @if(SESSION('Success'))
<div class="text-center alert alert-success">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
{{ session('Success') }}
</div>
@endif
@if(session('Error'))
<div class="alert text-center alert-danger alert-dismissable">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
{{ session('Error') }}
</div>
@endif -->
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
                    <!-- <a class="navbar-brand" href="{{ url('/') }}">
                        <img style="height: 25px; width: 170px;" src="{{ URL::to('/') }}/mhlogo.png">
                    </a> -->

                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="{{ URL::to('/') }}/home" style="font-size:1.1em;font-family:Times New Roman;"><b>Home</b></a></li>
                       <!--  <li><a href="{{ URL::to('/') }}/chat" style="font-size:1.1em;font-family:Times New Roman;"><b>Chat</b></a></li> -->
                        <li><a href="{{ URL::to('/') }}/letraining" style="font-size:1.1em;font-family:Times New Roman;"><b>Training Video</b></a></li>
                        <li> <a href="{{ URL::to('/') }}/enquirywise" style="font-size:1.1em;font-family:Times New Roman;"><b>Assigned Enquiry </b></a></li>  
                        <li><a href="{{ URL::to('/') }}/eqpipeline" style="font-size:1.1em;font-family:Times New Roman;"><b>Enquiry Pipelined</b></a></li>
                        <li> <a href="{{ URL::to('/') }}/kra" style="font-size:1.1em;font-family:Times New Roman;"><b>KRA</b></a></li>
                       <li> <a href="{{ URL::to('/')}}/reports" style="font-size:1.1em;font-family:Times New Roman;"><b>My Report</b></a></li>
                      <li style="padding-top: 10px;padding-left:10px;"> 
                      
                      @if($log != 0)
                      <button id="getBtn" disabled  class="btn btn-success btn-sm " onclick="getLocation()">Field Login</button>
                      @else
                       <button id="getBtn" class="btn btn-success btn-sm " onclick="getLocation()">Field Login</button>
                      @endif
                    </li>
                    <li style="padding-top: 10px;padding-left: 10px;"> 
                        <button class="btn btn-danger btn-sm" onclick="submitleheader()">Field Logout</button>
                    </li>
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

                                   
                                    <!--<li><a href="{{ URL::to('/')}}/completed">Completed</a></li> -->
                                    @endif
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
                <form method="POST"  action="{{ URL::to('/') }}/recordtime" >
                            {{ csrf_field() }}
                                    <input  class="hidden" type="text" name="longitude" value="{{ old('longitude') }}" id="longitude"> 
                                    <input  class="hidden" type="text" name="latitude" value="{{ old('latitude') }}" id="latitude">
                                    <input class="hidden" id="address" type="text" placeholder="Full Address" class="form-control input-sm" name="address" value="{{ old('address') }}">
                        <button id="sub" class="hidden"  onsubmit="show()" type="submit" >Submit</button>
                </form> 
                <form method="POST"  action="{{ URL::to('/') }}/logouttime" >
                  {{ csrf_field() }}
                                    <input  class="hidden" type="text" name="longitude" value="{{ old('longitude') }}" id="long"> 
                                    <input  class="hidden" type="text" name="latitude" value="{{ old('latitude') }}" id="lat">
                                    <input class="hidden" id="ads" type="text" placeholder="Full Address" class="form-control input-sm" name="address" value="{{ old('address') }}">
                    <button id="log" class="hidden"  type="submit" >Submit</button>
                </form>             
        
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ URL::to('/') }}/js/signature_pad.umd.js"></script>
    <script src="{{ URL::to('/') }}/js/app2.js"></script>
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
    <script type="text/javascript">
        function recordthis() {


        }
    </script>
    <!-- get location -->
<script src="https://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" charset="utf-8">
  function submitleheader(){
    // document.getElementById("getBtn").className = "hidden";
    var ans = confirm('Are You Sure You Want To Logout ?');
        if(ans)
        {
      console.log("Entering getLocation()");
      if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(
        displayCurrentLocationforlogout,
        displayError1,
        { 
          maximumAge: 3000, 
          timeout: 5000, 
          enableHighAccuracy: true 
        });
    }else{
      alert("Oops.. No Geo-Location Support !");
    } 
      //console.log("Exiting getLocation()");
  }


    // logout
    function displayCurrentLocationforlogout(position){
      //console.log("Entering displayCurrentLocation");
      var latitude  = position.coords.latitude;
      var longitude = position.coords.longitude;
    
      document.getElementById("long").value = longitude;
      document.getElementById("lat").value  = latitude;
      //console.log("Latitude " + latitude +" Longitude " + longitude);

      getAddressFromLatLangforlogout(latitude,longitude);
      //console.log("Exiting displayCurrentLocation");
    }
   
  function  displayError1(error){
    console.log("Entering ConsultantLocator.displayError1()");
    var errorType = {
      0: "Unknown error",
      1: "Permission denied by user",
      2: "Position is not available",
      3: "Request time out"
    };
    var errorMessage = errorType[error.code];
    if(error.code == 0  || error.code == 2){
      errorMessage = errorMessage + "  " + error.message;
    }
    alert("Error Message " + errorMessage);
    console.log("Exiting ConsultantLocator.displayError1()");
  }
  function getAddressFromLatLangforlogout(lat,lng){
    //console.log("Entering getAddressFromLatLangforlogout()");
   
    var geocoder = new google.maps.Geocoder();
    var latLng = new google.maps.LatLng(lat, lng);
    
    geocoder.geocode( { 'latLng': latLng}, function(results, status) {
        // console.log("After getting address");
        // console.log(results);
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[0]) {
        // console.log(results);

        document.getElementById("ads").value = results[0].formatted_address;
        // document.getElementById("sub").form.submit();
        document.getElementById("log").form.submit();

      }
    }else{
        alert("Geocode was not successful for the following reason: " + status);
     }
    });
    //console.log("Entering getAddressFromLatLangforlogout()");
  }
  // logout end
}
  function getLocation(){
      // document.getElementById("getBtn").className = "hidden";
      console.log("Entering getLocation()");
      if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(
        displayCurrentLocation,
        displayError,
        { 
          maximumAge: 3000, 
          timeout: 5000, 
          enableHighAccuracy: true 
        });
    }else{
      alert("Oops.. No Geo-Location Support !");
    } 
      //console.log("Exiting getLocation()");
  }
    
    function displayCurrentLocation(position){
      //console.log("Entering displayCurrentLocation");
      var latitude  = position.coords.latitude;
      var longitude = position.coords.longitude;
    
      document.getElementById("longitude").value = longitude;
      document.getElementById("latitude").value  = latitude;
      //console.log("Latitude " + latitude +" Longitude " + longitude);

      getAddressFromLatLang(latitude,longitude);
      //console.log("Exiting displayCurrentLocation");
    }
   
  function  displayError(error){
    console.log("Entering ConsultantLocator.displayError()");
    var errorType = {
      0: "Unknown error",
      1: "Permission denied by user",
      2: "Position is not available",
      3: "Request time out"
    };
    var errorMessage = errorType[error.code];
    if(error.code == 0  || error.code == 2){
      errorMessage = errorMessage + "  " + error.message;
    }
    alert("Error Message " + errorMessage);
    console.log("Exiting ConsultantLocator.displayError()");
  }
  function getAddressFromLatLang(lat,lng){
    //console.log("Entering getAddressFromLatLang()");
   
    var geocoder = new google.maps.Geocoder();
    var latLng = new google.maps.LatLng(lat, lng);
    
    geocoder.geocode( { 'latLng': latLng}, function(results, status) {
        // console.log("After getting address");
        // console.log(results);
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[0]) {
        // console.log(results);

        document.getElementById("address").value = results[0].formatted_address;
        document.getElementById("sub").form.submit();

      }
    }else{
        alert("Geocode was not successful for the following reason: " + status);
     }
    });
    //console.log("Entering getAddressFromLatLang()");
  }
  
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU"></script>
</body>
</html>
@if(session('Success'))
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #5cb85c;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Success</h4>
        </div>
        <div class="modal-body">
          <p style="text-align:center;">{!! session('Success') !!}</p>
        </div>
        <div class="modal-footer">
          <button type="button" style="background-color: #c9ced6;" class="btn btn-default" data-dismiss="modal" onClick="window.location.reload()">Close</button>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
  $(document).ready(function(){
      $("#myModal").modal('show');
  });
</script>
@endif
@if(session('Error'))
  <div class="modal fade" id="error" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #5cb85c;color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Success</h4>
        </div>
        <div class="modal-body">
          <p style="text-align:center;">{!! session('Error') !!}</p>
        </div>
        <div class="modal-footer">
          <button type="button" style="background-color: #c9ced6;" class="btn btn-default" data-dismiss="modal" onClick="window.location.reload()">Close</button>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
  $(document).ready(function(){
      $("#error").modal('show');
  });
</script>
@endif
@if(session('Late'))
  <div class="modal fade" id="late" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #f27d7d;color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Late Login</h4>
        </div>
        <div class="modal-body">
        
          <p style="text-align:center;">{!! session('Late') !!}</p>
           
        </div>
        <div class="modal-footer">
          <button type="button" style="background-color: #c9ced6;" class="btn btn-default" data-dismiss="modal" onClick="window.location.reload()">Close</button>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
  $(document).ready(function(){
      $("#late").modal('show');
  });
</script>
@endif
