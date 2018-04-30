@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  @if(!$subwards)
                  No Subward assigned
                  @else
                  Your Assigned Ward is  {{$subwards->sub_ward_name}}
                  @endif
                  @if(session('Success'))
                    <div class="alert-success pull-right">{{ session('Success')}} </div>
                  @endif
                  @if(session('Error'))
                    <div class="alert-danger pull-right">{{ session('Error')}} </div>
                  @endif
                  <center id="currentTime" class="pull-right"></center>
                </div>
                @if($subwards)
                <div class="panel-body">
                    <center>
                    <label id="headingPanel"></label>
                    <br>
                        <button id="getBtn"  class="btn btn-success btn-sm" onclick="getLocation()">Get Location</button>
                    </center><br>
                   <form method="POST" onsubmit="validateform()" action="{{ URL::to('/') }}/addProject" enctype="multipart/form-data">
                    <div id="first">
                    {{ csrf_field() }}
                           <table class="table">
                               <tr>
                                   <td>Project Name</td>
                                   <td>:</td>
                                   <td><input id="pName" required type="text" placeholder="Project Name" class="form-control input-sm" name="pName" value="{{ old('pName') }}" ></td>
                               </tr>
                               <tr>
                                   <td>Location</td>
                                   <td>:</td>
                                   <td id="x">
                                    <div class="col-sm-6">
                                      <label>Longitude:</label>
                                        <input placeholder="Longitude" class="form-control input-sm" required readonly type="text" name="longitude" value="{{ old('longitude') }}" id="longitude">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Latitude:</label>
                                        <input placeholder="Latitude" class="form-control input-sm" required readonly type="text" name="latitude" value="{{ old('latitude') }}" id="latitude">
                                    </div>
                                   </td>
                               </tr>
                               <tr>
                                   <td>Road Name/Road No.</td>
                                   <td>:</td>
                                   <td><input id="road" required type="text" placeholder="Road Name / Road No." class="form-control input-sm" name="rName" value="{{ old('rName') }}"></td>
                               </tr>
                               <tr>
                                   <td>Road Width</td>
                                   <td>:</td>
                                   <td><input id="rWidth"  required type="text" placeholder="Road Width" onclick="pageNext();" class="form-control input-sm" name="rWidth" value="{{ old('rWidth') }}" required></td>
                               </tr>
                               <tr class="{{ $errors->has('address') ? ' has-error' : '' }}">
                                   <td>Full Address</td>
                                   <td>:</td>
                                   <td><input readonly id="address" required type="text" placeholder="Full Address" class="form-control input-sm" name="address" value="{{ old('address') }}"></td>
                               </tr>
                               <tr>
                                 <td>Construction Type</td>
                                 <td>:</td>
                                 <td>
                                    <label required class="checkbox-inline"><input id="constructionType1" name="constructionType[]" type="checkbox" value="Residential">Residential</label>
                                    <label required class="checkbox-inline"><input id="constructionType2" name="constructionType[]" type="checkbox" value="Commercial">Commercial</label> 
                                 </td>
                               </tr>
                               <tr>
                                 <td>Interested in RMC</td>
                                 <td>:</td>
                                 <td>
                                     <div class="radio">
                                      <label><input required value="Yes" id="rmc" type="radio" name="rmcinterest">Yes</label>
                                    </div>
                                    <div class="radio">
                                      <label><input required value="No" id="rmc2" type="radio" name="rmcinterest">No</label>
                                    </div>
                                 </td>
                               </tr>
                               <tr>
                                <td>Type of Contract ? </td>
                                <td>:</td>
                                <td>
                                  <select class="form-control" name="contract" id="contract" class="requiredn">
                                    <option   value="" disabled selected>--- Select ---</option>
                                    <option    value="Labour Contract">Labour Contract</option>
                                    <option  value="Material Contract">Material Contract</option>
                                </select>
                              </td>





                               <!-- <tr>
                                   <td>Municipal Approval</td>
                                   <td>:</td>
                                   <td><input type="file" accept="image/*" class="form-control input-sm" name="mApprove"></td>
                               </tr> -->
                               <tr>
                                   <td>Govt. Approvals<br>(Municipal, BBMP, etc)</td>
                                   <td>:</td>
                                   <td><input oninput="fileUpload()" id="oApprove" multiple type="file" accept="image/*" class="form-control input-sm" name="oApprove[]"></td>
                               </tr>
                               <tr>
                                   <td>Project Status</td>
                                   <td>:</td>
                                   <td>
                                      <table class="table table-responsive">
                                        <tr>
                                          <td>
                                            <label class="checkbox-inline">
                                              <input type="checkbox" onchange="count()" name="status[]" value="Planning">Planning
                                            </label>
                                          </td>
                                          <td>
                                             <label class="checkbox-inline">
                                              <input type="checkbox" onchange="count()" name="status[]" value="Digging">Digging
                                            </label>
                                          </td>
                                          <td>
                                             <label class="checkbox-inline">
                                              <input type="checkbox" onchange="count()" name="status[]" value="Foundation">Foundation
                                            </label>
                                          </td>
                                          <td>
                                             <label class="checkbox-inline">
                                              <input type="checkbox" onchange="count()" name="status[]" value="Pillars">Pillars
                                            </label>
                                          </td>
                                          <td>
                                             <label class="checkbox-inline">
                                              <input type="checkbox" onchange="count()" name="status[]" value="Walls">Walls
                                            </label>
                                          </td>
                                        </tr>
                                        <tr>
                                         <td>
                                          <label class="checkbox-inline">
                                          <input type="checkbox" onchange="count()" name="status[]" value="Roofing">Roofing
                                        </label>
                                        </td>
                                         <td>
                                          <label class="checkbox-inline">
                                          <input type="checkbox" onchange="count()" name="status[]" value="Electrical">Electrical
                                        </label>
                                        </td>
                                         <td>
                                          <label class="checkbox-inline">
                                          <input type="checkbox" onchange="count()" name="status[]" value="Plumbing">Plumbing
                                        </label>
                                        </td>
                                         <td>
                                          <label class="checkbox-inline">
                                          <input type="checkbox" onchange="count()" name="status[]" value="Plastering">Plastering
                                        </label>
                                        </td>
                                         <td>
                                          <label class="checkbox-inline">
                                          <input type="checkbox" onchange="count()" name="status[]" value="Flooring">Flooring
                                        </label>
                                        </td>
                                        </tr>
                                        <tr>
                                         <td>
                                          <label class="checkbox-inline">
                                          <input type="checkbox" onchange="count()" name="status[]" value="Carpentry">Carpentry
                                        </label>
                                        </td>
                                         <td>
                                          <label class="checkbox-inline">
                                          <input type="checkbox" onchange="count()" name="status[]" value="Paintings">Paintings
                                        </label>
                                        </td>
                                         <td>
                                          <label class="checkbox-inline">
                                          <input type="checkbox" onchange="count()" name="status[]" value="Fixtures">Fixtures
                                        </label>
                                        </td>
                                         <td>
                                          <label class="checkbox-inline">
                                          <input type="checkbox" onchange="count()" name="status[]" value="Completion">Completion
                                        </label>
                                        </td>
                                         <td>
                                          <label class="checkbox-inline">
                                          <input type="checkbox" onchange="count()" name="status[]" value="Closed">Closed
                                        </label>
                                        </td>
                                        </tr>
                                      </table>
                                   </td>
                               </tr>
                               <tr>
                                   <td>Project Type</td>
                                   <td>:</td>
                                   <td>
                                    <div class="row">
                                        <div class="col-md-3">
                                          <input value="{{ old('basement') }}" onkeyup="check('basement')" id="basement" name="basement" type="text" autocomplete="off" class="form-control input-sm" placeholder="Basement" id="email">
                                        </div>
                                        <div class="col-md-2">
                                          <b style="font-size: 20px; text-align: center">+</b>
                                        </div>
                                      <div class="col-md-3">
                                        <input value="{{ old('ground') }}" onkeyup="check('ground');" autocomplete="off" name="ground" id="ground" type="text" class="form-control" placeholder="Floor">
                                      </div>
                                      <div class="col-md-3">
                                        <p id="total"></p>
                                      </div>
                                    </div>
                                    </td>
                               </tr>
                               <tr>
                                   <td>Project Size (Approx.)</td>
                                   <td>:</td>
                                   <td><input value="{{ old('pSize') }}" id="pSize" required placeholder="Project Size in Sq. Ft." type="text" class="form-control input-sm" name="pSize" onkeyup="check('pSize')"></td>
                               </tr>
                                 <tr>
                                 <td>Budget Type</td>
                                 <td>:</td>
                                 <td>
                                    <label required class="checkbox-inline"><input id="constructionType3" name="budgetType" type="checkbox" value="Structural">Structural</label>
                                    <label required class="checkbox-inline"><input id="constructionType4" name="budgetType" type="checkbox" value="Finishing">Finishing </label> 
                                 </td>
                               </tr>
                               <tr>
                                   <td>Budget (Approx.)</td>
                                   <td>:</td>
                                   <td><input value="{{ old('budget') }}" id="budget" required placeholder="Budget in Crores" type="text" onkeyup="check('budget')" class="form-control input-sm" name="budget"></td>
                               </tr>
                               <tr>
                                   <td>Project Image</td>
                                   <td>:</td>
                                   <td><input id="pImage" required type="file" accept="image/*" class="form-control input-sm" name="pImage" onchange="validateFileType()" multiple><p id="errormsg"></p></td>
                               </tr>
                               <tr>
                                    <td>Room Types</td>
                                    <td>:</td>
                                    <td>
                                        <table id="bhk" class="table table-responsive">
                                            <tr id="selection">
                                                
                                            </tr>
                                            <tr>
                                                <td colspan=3>
                                                    <button onclick="addRow();" type="button" class="btn btn-primary form-control">Add more</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                               </tr>
                           </table>
                       </div>
                       <div id="second" class="hidden">
                           <label>Owner Details</label>
                           <table class="table">
                               <tr>
                                   <td>Owner Name</td>
                                   <td>:</td>
                                   <td><input value="{{ old('oName') }}" type="text" placeholder="Owner Name" class="form-control input-sm" name="oName" id="oName"></td>
                               </tr>
                               <tr>
                                   <td>Owner Email</td>
                                   <td>:</td>
                                   <td><input value="{{ old('oEmail') }}" onblur="checkmail('oEmail')" placeholder="Owner Email" type="email" class="form-control input-sm" name="oEmail" id="oEmail"></td>
                               </tr>
                               <tr>
                                   <td>Owner Contact No.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{ old('oContact') }}" onblur="checklength('oContact');" onkeyup="check('oContact')" maxlength="10"  minlength="10" placeholder="Owner Contact No." type="text" class="form-control input-sm" name="oContact" id="oContact"></td>
                               </tr>
                           </table>
                       </div>
                       <div id="third" class="hidden">
                           <label>Contractor Details</label>
                           <table class="table">
                               <tr>
                                   <td>Contractor Name</td>
                                   <td>:</td>
                                   <td><input value="{{ old('cName') }}" type="text" placeholder="Contractor Name" class="form-control input-sm" name="cName" id="cName"></td>
                               </tr>
                               <tr>
                                   <td>Contractor Email</td>
                                   <td>:</td>
                                   <td><input value="{{ old('cEmail') }}" placeholder="Contractor Email" type="email" class="form-control input-sm" name="cEmail" id="edName" onblur="checkmail('cEmail')" ></td>
                               </tr>
                               <tr>
                                   <td>Contractor Contact No.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{ old('cContact') }}" onblur="checklength('cPhone');" id="cContact" onkeyup="check('cPhone')" placeholder="Contractor Contact No." type="text" maxlength="10" class="form-control input-sm" name="cContact"></td>
                               </tr>
                           </table>
                       </div>
                       <div id="fourth" class="hidden">
                           <label>Consultant Details</label>
                           <table class="table">
                               <tr>
                                   <td>Consultant Name</td>
                                   <td>:</td>
                                   <td><input value="{{ old('coName') }}"  type="text" placeholder="Consultant Name" class="form-control input-sm" name="coName"></td>
                               </tr>
                               <tr>
                                   <td>Consultant Email</td>
                                   <td>:</td>
                                   <td><input value="{{ old('coEmail') }}"  placeholder="Consultant Email" type="email" class="form-control input-sm" name="coEmail" id="coEmail" onblur="checkmail('coEmail')"></td>
                               </tr>
                               <tr>
                                   <td>Consultant Contact No.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{ old('coContact') }}" onblur="checklength('coContact');" placeholder="Consultant Contact No." type="text" class="form-control input-sm" name="coContact" maxlength="10" id="coContact" onkeyup="check('coContact')"></td>
                               </tr>
                           </table>
                       </div>
                       <div id="fifth" class="hidden">
                           <label>Site Engineer Details</label>
                           <table class="table">
                               <tr>
                                   <td>Site Engineer Name</td>
                                   <td>:</td>
                                   <td><input value="{{ old('eName') }}"  type="text" placeholder="Site Engineer Name" class="form-control input-sm" name="eName" id="eName"></td>
                               </tr>
                               <tr>
                                   <td>Site Engineer Email</td>
                                   <td>:</td>
                                   <td><input value="{{ old('eEmail') }}"  placeholder="Site Engineer Email" type="email" class="form-control input-sm" name="eEmail" id="eEmail" onblur="checkmail('eEmail')"></td>
                               </tr>
                               <tr>
                                   <td>Site Engineer Contact No.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{ old('eContact') }}" onblur="checklength('eContact');"  placeholder="Site Engineer Contact No." type="text" class="form-control input-sm" name="eContact" id="eContact" maxlength="10" onkeyup="check('eContact')"></td>
                               </tr>
                           </table>
                       </div> 
                       <div id="sixth" class="hidden">
                           <label>Procurement Details</label>
                           <table class="table">
                               <tr>
                                   <td>Procurement Name</td>
                                   <td>:</td>
                                   <td><input id="prName" required type="text" placeholder="Procurement Name" class="form-control input-sm" name="prName" value="{{ old('prName') }}"></td>
                               </tr>
                               <tr>
                                   <td>Procurement Email</td>
                                   <td>:</td>
                                   <td><input value="{{ old('pEmail') }}" placeholder="Procurement Email" type="email" class="form-control input-sm" name="pEmail" id="pEmail" onblur="checkmail('pEmail')"></td>
                               </tr>
                               <tr>
                                   <td>Procurement Contact No.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{ old('pContact') }}" required  minlength=10 onblur="checklength('prPhone');" required placeholder="Procurement Contact No." type="text" class="form-control input-sm" name="prPhone" maxlength="10" id="prPhone" onkeyup="check('prPhone')"></td>
                               </tr>
                           </table>
                       </div> 
                       <div id="seventh" class="hidden">
                            <textarea class="form-control" placeholder="Remarks (Optional)" name="remarks"></textarea><br>
                            <br>
                            <button type="submit" class="form-control btn btn-primary">Submit Data</button>
                       </div>                        
                       <ul class="pager">
                          <li class="previous"><a onclick="pagePrevious()" href="#">Previous</a></li>
                          <li class="next"><a id="next" href="#" onclick="pageNext()">Next</a></li>
                        </ul>
                   </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!--This line by Siddharth -->
<script type="text/javascript">
  // window.onload = function(){
  //   var current = new Date();
  //   document.getElementById("currentTime").innerHTML = current.toLocaleTimeString();
  // }
  function doDate()
  {
      var str = "";

      var days = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
      var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

      var now = new Date();

      str += "Today is: " + days[now.getDay()] + ", " + now.getDate() + " " + months[now.getMonth()] + " " + now.getFullYear() + " " + now.getHours() +":" + now.getMinutes() + ":" + now.getSeconds();
      document.getElementById("currentTime").innerHTML = str;
  }

  setInterval(doDate, 1000);
  function validateFileType(){
    var fileName = document.getElementById("pImage").value;
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
          document.getElementById('errormsg').innerHTML = "";
    }else{
          document.getElementById('errormsg').innerHTML = "Only <b>'.JPG'</b> , <b>'.JPEG'</b> and <b>'.PNG'</b> files are allowed!";
          document.getElementById("pImage").value = '';
          return false;
         }   
  }
  function checklength(arg)
  {
    var x = document.getElementById(arg);
    if(x.value)
    {
        if(x.value.length != 10)
        {
            alert('Please Enter 10 Digits in Phone Number');
            document.getElementById(arg).value = '';
            return false;
        }
        else
        {
            if(arg=='oContact')
            {
                var y = document.getElementById('oContact').value;
                $.ajax({
                    type:'GET',
                    url: '{{URL::to('/')}}/checkDupPhoneOwner',
                    data: {arg: y},
                    async: false,
                    success:function(response)
                    {
                        if(response > 0)
                        {
                            if(!confirm("Phone Number Already Exists.\n Click 'ok' if you want to add the same number?"))
                            {
                                document.getElementById('oContact').value="";
                            }
                        }
                    }
                });
            }
            if(arg=='coContact')
            {
                var y = document.getElementById('coContact').value;
                $.ajax({
                    type:'GET',
                    url: '{{URL::to('/')}}/checkDupPhoneConsultant',
                    data: {arg: y},
                    async: false,
                    success:function(response)
                    {
                        if(response > 0)
                        {
                            if(!confirm("Phone Number Already Exists.\n Click 'ok' if you want to add the same number?"))
                            {
                                document.getElementById('coContact').value="";
                                // alert('Phone Number '+ y +' Already Present in Database. Are you sure you want to add the same number?');
                            }
                        }
                    }
                });
            }
            if(arg=='cPhone')
            {
                var y = document.getElementById('cPhone').value;
                $.ajax({
                    type:'GET',
                    url: '{{URL::to('/')}}/checkDupPhoneContractor',
                    data: {arg: y},
                    async: false,
                    success:function(response)
                    {
                        if(response > 0)
                        {
                            if(!confirm("Phone Number Already Exists.\n Click 'ok' if you want to add the same number?"))
                            {
                                document.getElementById('cPhone').value="";
                            }
                            // alert('Phone Number '+y+' Already Stored in Database. Are you sure you want to add the same number?');
                        }
                    }
                });
            }
            if(arg=='eContact')
            {
                var y = document.getElementById('eContact').value;
                $.ajax({
                    type:'GET',
                    url: '{{URL::to('/')}}/checkDupPhoneSite',
                    data: {arg: y},
                    async: false,
                    success:function(response)
                    {
                        if(response > 0)
                        {
                            if(!confirm("Error : Phone Number Already Exists.\n Click 'ok' if you want to add the same number?"))
                            {
                                document.getElementById('eContact').value="";
                                // alert('Phone Number '+ y +' Already Present in Database. Are you sure you want to add the same number?');
                            }
                        }
                    }
                });
            }
            if(arg=='prPhone')
            {
                var y = document.getElementById('prPhone').value;
                $.ajax({
                    type:'GET',
                    url: '{{URL::to('/')}}/checkDupPhoneProcurement',
                    data: {arg: y},
                    async: false,
                    success:function(response)
                    {
                        if(response > 0)
                        {
                            if(!confirm("Error : Phone Number Already Exists.\n Click 'ok' if you want to add the same number?"))
                            {
                                document.getElementById('prPhone').value="";
                                // alert('Phone Number '+ y +' Already Present in Database. Are you sure you want to add the same number?');
                            }
                        }
                    }
                });
            }
        }        
    }
    return false;
  }
  
    function checkPhone(arg, table)
    {
        var temp;
        $.ajax({
            type: 'GET',
            url: '{{URL::to('/')/checkDupPhone',
            data: {arg: arg, table:table},
            async: false,
            success:function(response)
            {
                console.log(response);
                temp = false;
            }
        });
        return temp;
    }
  
  function check(arg){
    var input = document.getElementById(arg).value;
    if(input){
    if(isNaN(input)){
      while(isNaN(document.getElementById(arg).value)){
      var str = document.getElementById(arg).value;
      str     = str.substring(0, str.length - 1);
      document.getElementById(arg).value = str;
      }
    }
    else{
      input = input.trim();
      document.getElementById(arg).value = input;
    }
    if(arg == 'ground' || arg == 'basement'){
      var basement = parseInt(document.getElementById("basement").value);
      var ground   = parseInt(document.getElementById("ground").value);
      if(!isNaN(basement) && !isNaN(ground)){
        var floor    = 'B('+basement+')' + ' + G + ('+ground+') = ';
        sum          = basement+ground+1;
        floor       += sum;
      
        if(document.getElementById("total").innerHTML != null)
          document.getElementById("total").innerHTML = floor;
        else
          document.getElementById("total").innerHTML = '';
      }
    }
  }
    return false;
  }
</script>
<!--This line by Siddharth -->
<!-- get location -->
<script src="https://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" charset="utf-8">
  function getLocation(){
      document.getElementById("getBtn").className = "hidden";
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
      }
    }else{
        alert("Geocode was not successful for the following reason: " + status);
     }
    });
    //console.log("Entering getAddressFromLatLang()");
  }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU"></script>

<script type="text/javascript">
    var current = "first";
    document.getElementById('headingPanel').innerHTML = 'Project Details';
    function pageNext(){
        var ctype1 = document.getElementById('constructionType1');
        var ctype2 = document.getElementById('constructionType2');
        var rmc = document.getElementById('rmc');
        var rmc2= document.getElementById('rmc2');
        if(current == 'first')
        { 
          if(document.getElementById("pName").value == ""){
            window.alert("You have not entered Project Name");
          }else if(document.getElementById("longitude").value == ""){
            window.alert("Please click on Get Location button");
          }else if(document.getElementById("latitude").value == ""){
            window.alert("Kindly click on Get location button");
          }else if(document.getElementById("road").value == ""){
            window.alert("You have not entered Road Name");
          } else if(document.getElementById('rWidth').value == ""){
            window.alert("You have not entered  Width");
          }else if(ctype1.checked == false && ctype2.checked == false){
            window.alert("Please choose the construction type");
          }else if(rmc.checked == false && rmc2.checked == false){
            window.alert("Please tell us whether the customer is interested in RMC or not");
          }else if(document.getElementById("contract").value == ""){
            alert("Please select contract type");
          }else if(ctype1.checked == true && ctype2.checked == true){
                countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 2;
            }else if(ctype1.checked == true || ctype2.checked == true){
                countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 1;
            }else{
                countinput = document.querySelectorAll('input[type="checkbox"]:checked').length;
            }
            if(countinput == 0){
                window.alert("Select at least one project status");
            
            } else if(document.getElementById("basement").value == ""){
            window.alert("You have not entered Basement value");
          } else if(document.getElementById("ground").value == ""){
            window.alert("You have not entered Floor value");
          }else if(document.getElementById("pSize").value == ""){
            window.alert("You have not entered Project Size");
          }
          else if(constructionType3.checked == false && constructionType4.checked == false){
            window.alert("Please choose the Budget type");
          }else if(document.getElementById("budget").value == ""){
            window.alert("You have not entered Budget");
          }else if (document.getElementById("pImage").value == ""){
            window.alert("You have not chosen a file to upload");
          }
            else {
                document.getElementById("first").className = "hidden";
                document.getElementById("second").className = "";
                document.getElementById('headingPanel').innerHTML = 'Owner Details';
                current = "second";
            }
           
          
        }
     else if(current == 'second'){
            if(document.getElementById("contract").value == "Material Contract"){
                if(document.getElementById("oName").value == "" || document.getElementById("oContact").value == ""){
                    window.alert("Please enter owner details");
                }else{
                    document.getElementById("second").className = "hidden";
                    document.getElementById("third").className = "";
                    document.getElementById('headingPanel').innerHTML = 'Contractor Details';
                    current = "third";
                }
            }else{
              document.getElementById("second").className = "hidden";
              document.getElementById("third").className = "";
              document.getElementById('headingPanel').innerHTML = 'Contractor Details';
              current = "third";    
            }
        }else if(current == 'third'){
            if(document.getElementById("contract").value == "Labour Contract"){
                if(document.getElementById("cName").value == "" || document.getElementById("cContact").value == ""){
                    window.alert("Please enter contractor details");
                }else{
                    document.getElementById("third").className = "hidden";
                    document.getElementById("fourth").className = "";
                    document.getElementById('headingPanel').innerHTML = 'Consultant Details';
                    current = "fourth";
                }
            }else{
                document.getElementById("third").className = "hidden";
                document.getElementById("fourth").className = "";
                document.getElementById('headingPanel').innerHTML = 'Consultant Details';
                current = "fourth";
            }
        }else if(current == 'fourth'){
            document.getElementById("fourth").className = "hidden";
            document.getElementById("fifth").className = "";
            document.getElementById('headingPanel').innerHTML = 'Site Engineer Details';
            current = "fifth";
        }else if(current == 'fifth'){
            document.getElementById("fifth").className = "hidden";
            document.getElementById("sixth").className = "";
            document.getElementById('headingPanel').innerHTML = 'Procurement Details';
            current = "sixth";
        }else if(current == 'sixth'){  
          if(document.getElementById('prName').value == ''){
            alert('Please Enter a Name');
            document.getElementById('prName').focus();
          }else if(document.getElementById('prPhone').value== ''){
            alert('Please Enter Phone Number');
            document.getElementById('prPhone').focus();
          }else if(document.getElementById("prName").value == ""){
            window.alert("Please Enter Procurement Name");
          }else if(document.getElementById("pContact") == ""){
            window.alert("Please enter phone number");
          }else { 
            document.getElementById("sixth").className = "hidden";
            document.getElementById("seventh").className = "";
            document.getElementById('headingPanel').innerHTML = 'Remarks';
            current = "seventh";
            document.getElementById("next").className = "hidden";
          }
         
        } 
    }
    function pagePrevious(){
        document.getElementById("next").className = "";
        if(current == 'seventh'){
            document.getElementById("seventh").className = "hidden";
            document.getElementById("sixth").className = "";
            document.getElementById('headingPanel').innerHTML = 'Procurement Details';
            current = "sixth"
        }else if(current == 'sixth'){
            document.getElementById("sixth").className = "hidden";
            document.getElementById("fifth").className = "";
            document.getElementById('headingPanel').innerHTML = 'Site Engineer Details';
            current = "fifth"
        }
        else if(current == 'fifth'){
            document.getElementById("fifth").className = "hidden";
            document.getElementById("fourth").className = "";
            document.getElementById('headingPanel').innerHTML = 'Consultant Details';
            current = "fourth"
        }
        else if(current == 'fourth'){
            document.getElementById("fourth").className = "hidden";
            document.getElementById("third").className = "";
            document.getElementById('headingPanel').innerHTML = 'Contractor Details';
            current = "third"
        }
        else if(current == 'third'){
            document.getElementById("third").className = "hidden";
            document.getElementById("second").className = "";
            document.getElementById('headingPanel').innerHTML = 'Owner Details';
            current = "second"
        }else if(current == 'second'){
            document.getElementById("second").className = "hidden";
            document.getElementById("first").className = "";
            document.getElementById('headingPanel').innerHTML = 'Project Details';
            current = "first";
        }else{
            document.getElementById("next").className = "disabled";
        }
    }
</script>

<script type="text/javascript">
 function checkmail(arg){
    var mail = document.getElementById(arg);
    if(mail.value.length > 0 ){
      if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail.value))  {  
        return true;  
      }  
      else{
        alert("Invalid Email Address!");  
        mail.value = ''; 
        mail.focus(); 
      }
    }
     return false;
  }

  function check(arg){
    var input = document.getElementById(arg).value;
    if(isNaN(input)){
      while(isNaN(document.getElementById(arg).value)){
      var str = document.getElementById(arg).value;
      str     = str.substring(0, str.length - 1);
      document.getElementById(arg).value = str;
      }
    }
    else{
      input = input.trim();
      document.getElementById(arg).value = input;
    }
    //For ground and basement generation
    if(arg == 'ground' || arg == 'basement'){
      var basement = parseInt(document.getElementById("basement").value);
      var ground   = parseInt(document.getElementById("ground").value);
      var opts = "<option value=''>--Floor--</option><option value='Ground'>Ground</option>";
      if(!isNaN(basement) && !isNaN(ground)){
        var floor    = 'B('+basement+')' + ' + G + ('+ground+') = ';
        sum          = basement+ground+1;
        floor       += sum;
        
        if(document.getElementById("total").innerHTML != null)
        {
          document.getElementById("total").innerHTML = floor;
          var ctype1 = document.getElementById('constructionType1');
          var ctype2 = document.getElementById('constructionType2');
          if(ctype1.checked == true && ctype2.checked == true){
            // both residential and commercial
            var sel = "<td><select class=\"form-control\" name=\"floorNo[]\" id=\"floorNo\">"+
                      "</select></td>"+
                      "<td><select name=\"roomType[]\" value='Commercial Floor' id=\"\" class=\"form-control\">"+
                      "<option value='Commercial Floor'>Commercial Floor</option>"+
                      "<option value='1RK'>1RK</option>"+
                      "<option value='1BHK'>1BHK</option>"+
                      "<option value='2BHK'>2BHK</option>"+
                      "<option value='3BHK'>3BHK</option></select>"+
                      "</td><td>"+
                      "<input type=\"text\" name=\"number[]\" class=\"form-control\" placeholder=\"Floor Size / No. of Houses\"></td>";
            document.getElementById('selection').innerHTML = sel;
          }else if(ctype1.checked == true && ctype2.checked == false){
            // residential only
            var sel = "<td><select class=\"form-control\" name=\"floorNo[]\" id=\"floorNo\">"+
                      "</select></td>"+
                      "<td><select name=\"roomType[]\" value='Commercial Floor' id=\"\" class=\"form-control\">"+
                      "<option value='1RK'>1RK</option>"+
                      "<option value='1BHK'>1BHK</option>"+
                      "<option value='2BHK'>2BHK</option>"+
                      "<option value='3BHK'>3BHK</option></select>"+
                      "</td><td>"+
                      "<input type=\"text\" name=\"number[]\" class=\"form-control\" placeholder=\"No. of Houses\"></td>";
            document.getElementById('selection').innerHTML = sel;
          }else if(ctype1.checked == false && ctype2.checked == true){
            // commercial only
            var sel = "<td><select class=\"form-control\" name=\"floorNo[]\" id=\"floorNo\">"+
                      "</select></td>"+
                      "<td><input name=\"roomType[]\" readonly value='Commercial Floor' id=\"\" class=\"form-control\">"+
                      "</td><td>"+
                      "<input type=\"text\" name=\"number[]\" class=\"form-control\" placeholder=\"Floor Size\"></td>";
            document.getElementById('selection').innerHTML = sel;
          }
          for(var i = 1; i<sum; i++){
            opts += "<option value='"+i+"'>Floor "+i+"</option>";
          }
          document.getElementById("floorNo").innerHTML = opts;
        }
        else
          document.getElementById("total").innerHTML = '';
      }
    }

    return false;
  }
  function addRow() {
        var table = document.getElementById("bhk");
        var row = table.insertRow(0);
        var cell3 = row.insertCell(0);
        var cell1 = row.insertCell(1);
        var cell2 = row.insertCell(2);
        var ctype1 = document.getElementById('constructionType1');
        var ctype2 = document.getElementById('constructionType2');
        var existing = document.getElementById('floorNo').innerHTML;
        if(ctype1.checked == true && ctype2.checked == false){
          cell3.innerHTML = "<select name='floorNo[]' class='form-control'>"+existing+"</select>";
          cell1.innerHTML = " <select name=\"roomType[]\" class=\"form-control\">"+
                                                          "<option value=\"1RK\">1RK</option>"+
                                                          "<option value=\"1BHK\">1BHK</option>"+
                                                          "<option value=\"2BHK\">2BHK</option>"+
                                                          "<option value=\"3BHK\">3BHK</option>"+
                                                      "</select>";
          cell2.innerHTML = "<input name=\"number[]\" type=\"text\" class=\"form-control\" placeholder=\"No. of houses\">";
        }
        if(ctype1.checked == false && ctype2.checked == true){
          cell3.innerHTML = "<select name='floorNo[]' class='form-control'>"+existing+"</select>";
          cell1.innerHTML = "<input name=\"roomType[]\" value='Commercial Floor' id=\"\" class=\"form-control\">";
          cell2.innerHTML = "<input type=\"text\" name=\"number[]\" class=\"form-control\" placeholder=\"Floor Size\"></td>";
        }
        if(ctype1.checked == true && ctype2.checked == true){
          // both residential and commercial
          cell3.innerHTML = "<select name='floorNo[]' class='form-control'>"+existing+"</select>";
          cell1.innerHTML = " <select name=\"roomType[]\" class=\"form-control\">"+
                                                          "<option value=\"Commercial Floor\">Commercial Floor</option>"+
                                                          "<option value=\"1RK\">1RK</option>"+
                                                          "<option value=\"1BHK\">1BHK</option>"+
                                                          "<option value=\"2BHK\">2BHK</option>"+
                                                          "<option value=\"3BHK\">3BHK</option>"+
                                                      "</select>";
          cell2.innerHTML = "<input name=\"number[]\" type=\"text\" class=\"form-control\" placeholder=\"No. of houses\">";
        }
    }
    function count(){
      var ctype1 = document.getElementById('constructionType1');
      var ctype2 = document.getElementById('constructionType2');
      var ctype3 = document.getElementById('constructionType3');
      var ctype4 = document.getElementById('constructionType4');
      var countinput;
      if(ctype1.checked == true && ctype2.checked == true && ctype3.checked == false && ctype4.checked == false){
        //   both construction type
        countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 2;
      }else if(ctype1.checked == true && ctype2.checked == true && ctype3.checked == true && ctype4.checked == true){
        //   all construction type and budget type
        countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 4;
      }else if(ctype1.checked == true && ctype2.checked == true && (ctype3.checked == true || ctype4.checked == true)){
        //   both construction type and either budget type
        countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 3;
      }else if((ctype1.checked == true || ctype2.checked == true) && (ctype3.checked == true || ctype4.checked == true)){
        //   
        countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 2;
      }else if(ctype1.checked == true || ctype2.checked == true){
        countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 1;
      }else{
        countinput = document.querySelectorAll('input[type="checkbox"]:checked').length;
      }
      if(countinput >= 5){
        $('input[type="checkbox"]:not(:checked)').attr('disabled',true);
        $('#constructionType1').attr('disabled',false);
        $('#constructionType2').attr('disabled',false);
        $('#constructionType3').attr('disabled',false);
        $('#constructionType4').attr('disabled',false);
      }else if(countinput == 0){
          return "none";
      }else{
        $('input[type="checkbox"]:not(:checked)').attr('disabled',false);
      }
    }
    function fileUpload(){
      var count = document.getElementById('oApprove').files.length;
      if(count > 5){
        document.getElementById('oApprove').value="";
        alert('You are allowed to upload a maximum of 5 files');
      }
    }
</script>
@endsection