@extends('layouts.aeheader')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form method="POST" action="{{ URL::to('/') }}/addBuilderProject" enctype="multipart/form-data">
                {{ csrf_field() }}
                <!-- Modal content-->
                <div class="panel panel-primary">
                  <div class="panel-heading">Add Project
                  <button type="button" class="btn btn-warning btn-sm pull-right" onclick="getLocation()">Get Location</button>
                  </div>
                  <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">Builder Name</div>
                        <div class="col-md-8">
                            <select name="builderId" class="form-control input-sm">
                                <option value="">--Select--</option>
                                @foreach($builders as $builder)
                                <option value="{{ $builder->builder_id }}">{{ $builder->builder_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">Project Name</div>
                        <div class="col-md-8"><input name="projectName" type="text" class="form-control input-sm" placeholder="Project Name"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">Project Manager</div>
                        <div class="col-md-8"><input name="projectManager" type="text" class="form-control input-sm" placeholder="Project Manager"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">Project Manager Contact No.</div>
                        <div class="col-md-8"><input name="pmContact" type="text" class="form-control input-sm" placeholder="Project Manager Contact No."></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">Project Manager Email</div>
                        <div class="col-md-8"><input name="pmEmail" type="email" class="form-control input-sm" placeholder="Project Manager Email"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">Site Engineer</div>
                        <div class="col-md-8"><input name="siteEngineer" type="text" class="form-control input-sm" placeholder="Site Engineer"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">Site Engineer Contact No.</div>
                        <div class="col-md-8"><input name="seContact" type="text" class="form-control input-sm" placeholder="Site Engineer Contact No."></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">Site Engineer Email</div>
                        <div class="col-md-8"><input name="seMail" type="email" class="form-control input-sm" placeholder="Site Engineer Email"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">Project Location</div>
                        <div class="col-md-8"><input id="address" name="location" type="text" class="form-control input-sm" placeholder="Project Location"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">Ward</div>
                        <div class="col-md-8">
                            <select name="ward" id="ward" onchange="getSubwards()" class="form-control input-sm">
                                <option value="">--Select--</option>
                                @foreach($wards as $ward)
                                <option value="{{ $ward->id }}">{{ $ward->ward_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">Sub Ward</div>
                        <div class="col-md-8">
                            <select name="subward" class="form-control input-sm" id="subward">
                                
                            </select>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">Project Approximate Value</div>
                        <div class="col-md-8"><input name="value" type="text" class="form-control input-sm" placeholder="Project Approximate Value"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">Total Size</div>
                        <div class="col-md-8"><input name="size" type="text" class="form-control input-sm" placeholder="Total Size"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">No. of floors</div>
                        <div class="col-md-8"><input name="floors" type="text" class="form-control input-sm" placeholder="No. of floors"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">Project Status</div>
                        <div class="col-md-8">
                            <select id="status" required name="status" class="form-control input-sm">
                               <option value="">--Select--</option>
                               <option value="Planning">Planning</option>
                               <option value="Digging">Digging</option>
                               <option value="Foundation">Foundation</option>
                               <option value="Pillars">Pillars</option>
                               <option value="Walls">Walls</option>
                               <option value="Roofing">Roofing</option>
                               <option value="Electrical & Plumbing">Electrical &amp; Plumbing</option>
                               <option value="Plastering">Plastering</option>
                               <option value="Flooring">Flooring</option>
                               <option value="Carpentry">Carpentry</option>
                               <option value="Paintings">Paintings</option>
                               <option value="Fixtures">Fixtures</option>
                               <option value="Completion">Completion</option>
                           </select>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">Posession Date</div>
                        <div class="col-md-8"><input name="pDate" type="date" class="form-control input-sm"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">Project Website</div>
                        <div class="col-md-8"><input name="web" type="text" class="form-control input-sm" placeholder="Project Website"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">Referal image</div>
                        <div class="col-md-8"><input name="rfImage" type="file" class="form-control input-sm" placeholder="Project Status"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">Remarks</div>
                        <div class="col-md-8"><input name="remarks" type="text" class="form-control input-sm" placeholder="Remarks"></div>
                    </div><br>
                  </div>
                  <div class="panel-footer">
                     <div class="row">
                        <div class="col-md-6"><input type="submit" value="Save" class="form-control btn btn-success"></div>
                        <div class="col-md-6"><input type="reset" value="Clear" class="form-control btn btn-danger"></div>
                    </div>
                  </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class='b'></div>
<div class='bb'></div>
<div class='message'>
  <div class='check'>
    &#10004;
  </div>
  <p>
    Error
  </p>
  <p>
    @if(session('error'))
    {{ session('error') }}
    @endif
  </p>
  <button id='ok'>
    OK
  </button>
</div>

<script src="https://maps.google.com/maps/api/js?sensor=true"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU"></script>
<script>
function getSubwards()
    {
        var ward = document.getElementById("ward").value;
        $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/getSubWards",
            async:false,
            data:{ward : ward},
            success: function(response)
            {
                document.getElementById('subward').innerHTML = "<option value='null' disabled selected>----Select----</option>";
                for(var i=0; i < response[0].length; i++)
                {
                    document.getElementById('subward').innerHTML += "<option value="+response[0][i].sub_ward_name+">"+response[0][i].sub_ward_name+"</option>";
                }
            }
        });    
    }
function getLocation(){
    //   document.getElementById("getBtn").className = "hidden";
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
    //   document.getElementById("longitude").value = longitude;
    //   document.getElementById("latitude").value  = latitude;
      //console.log("Latitude " + latitude +" Longitude " + longitude);
      getAddressFromLatLang(latitude,longitude);
      //console.log("Exiting displayCurrentLocation");
    }
    function getAddressFromLatLang(lat,lng){
    //console.log("Entering getAddressFromLatLang()");
    var geocoder = new google.maps.Geocoder();
    var latLng = new google.maps.LatLng(lat, lng);
    geocoder.geocode( { 'latLng': latLng}, function(results, status) {
        // console.log("After getting address");
        // console.log(results);
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[1]) {
        //console.log(results[1]);
        document.getElementById("address").value = results[1].formatted_address;
      }
    }else{
        alert("Geocode was not successful for the following reason: " + status);
     }
    });
    //console.log("Entering getAddressFromLatLang()");
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
</script>
@endsection