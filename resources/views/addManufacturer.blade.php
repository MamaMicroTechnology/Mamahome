@extends('layouts.app')
@section('content')

    <!-- <center><a href="{{ URL::previous()  }}" class="btn btn-danger">Back</a></center><br> -->
            <form action="{{ URL::to('/') }}/saveManufacturer" onsubmit="return validate()" method="post">
                {{ csrf_field() }}
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Manufacturer Details
                            <button type="button" id="getBtn"  class="btn btn-success btn-sm pull-right" onclick="getLocation()">Get Location</button>
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <td>Manufacturer Type</td>
                                    <td>:</td>
                                    <td>
                                        <select required onchange="hideordisplay(this.value);" name="type" id="type" class="form-control">
                                            <option value="">--Select--</option>
                                            <option value="RMC">RMC</option>
                                            <option value="Blocks">Blocks</option>
                                            <!-- <option value="Crusher">Crusher</option> -->
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Manufacturer Name</td>
                                    <td>:</td>
                                    <td>
                                        <input required placeholder="Manufacturer Name" type="text" name="name" id="name" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Plant Name</td>
                                    <td>:</td>
                                    <td>
                                        <input required placeholder="Plant Name" type="text" name="plant_name" id="name" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Contact No</td>
                                    <td>:</td>
                                    <td>
                                        <input required placeholder="Contact No" onblur="checkPhNo(this.value)" type="text" name="phNo" id="phNo" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Location</td>
                                    <td>:</td>
                                    <td>
                                        <div class="col-md-6">
                                            <input required placeholder="Latitude" type="text" name="latitude" id="latitude" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <input required placeholder="Longitude" type="text" name="longitude" id="longitude" class="form-control">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>:</td>
                                    <td>
                                        <input required placeholder="Address" type="text" name="address" id="address" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Area</td>
                                    <td>:</td>
                                    <td>
                                        <input required placeholder="Total Area" min="0" type="number" name="area" id="area" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Production Capacity (Per Day)</td>
                                    <td>:</td>
                                    <td>
                                        <input placeholder="Production Capacity (Per Day)" min="0" type="number" name="capacity" id="capacity" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Quantity Of Cement Required <br>(Per Week)</td>
                                    <td>:</td>
                                    <td>
                                        <div class="col-md-6 radio">
                                            <label for="tons"><input type="radio" value="Tons" checked="true" name="cement_required" id="tons">Tons</label>&nbsp;&nbsp;
                                            <label for="bags"><input type="radio" value="Bags" name="cement_required" id="bags">Bags</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input placeholder="Cement Required" min="0" type="number" name="cement_requirement" id="cement_requirement" class="form-control">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>M-Sand Required</td>
                                    <td>:</td>
                                    <td>
                                        <input required placeholder="M-Sand Required" min="0" type="number" name="sand_requirement" id="sand_requirement" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Aggregates Required</td>
                                    <td>:</td>
                                    <td>
                                        <input required placeholder="Aggregates Required" min="0" type="number" name="aggregate_requirement" id="aggregate_requirement" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Prefered Cement Brands</td>
                                    <td>:</td>
                                    <td>
                                        <input placeholder="Prefered Cement Brands" type="text" name="brand" id="brand" class="form-control">
                                    </td>
                                </tr>
                                <tr id="blockTypes1" class="hidden">
                                    <td style="background-color:#cfedaa; text-align:center" colspan=3>Block Types</td>
                                </tr>
                                <tr id="blockTypes2" class="hidden">
                                    <td colspan=3>
                                        <table class="table table-hover" id="types">
                                            <tr>
                                                <th style="text-align:center">Block Type</th>
                                                <th style="text-align:center">Block Size</th>
                                                <th style="text-align:center">Price</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select title='Please Select Appropriate Type' name="blockType[]" id="bt" class="form-control">
                                                        <option value="">--Select--</option>
                                                        <option value="Concrete">Concrete</option>
                                                        <option value="Cellular">Cellular</option>
                                                        <option value="Light Weight">Light Weight</option>
                                                        <!-- <option value="">All</option> -->
                                                    </select>
                                                </td>
                                                <td>
                                                    <select title='Please Select Appropriate Size' name="blockSize[]" id="bs" class="form-control">
                                                        <option value="">--Select--</option>
                                                        <option value="4 inch">4 inch</option>
                                                        <option value="6 inch">6 inch</option>
                                                        <option value="8 inch">8 inch</option>
                                                        <option value="12 inch">12 inch</option>
                                                        <!-- <option value="">All</option> -->
                                                    </select>
                                                </td>
                                                <td>
                                                    <input min="0" type="number" name="price[]" id="bp" placeholder="Price" class="form-control">
                                                </td>
                                            </tr>
                                        </table>
                                            <div class="btn-group">
                                                <button type="button" onclick="myFunction()" class="btn btn-warning btn-sm">
                                                    &nbsp; <span class="glyphicon glyphicon-plus"></span>&nbsp;
                                                </button>
                                                <button type="button" onclick="myDelete()" class="btn btn-danger btn-sm">
                                                    &nbsp; <span class="glyphicon glyphicon-minus"></span>&nbsp;
                                                </button>
                                            </div>
                                    </td>
                                </tr>
                                <tr id="grades1" class="hidden">
                                    <td style="background-color:#cfedaa; text-align:center" colspan=3>Grades Manufactured</td>
                                </tr>
                                <tr id="grades2" class="hidden">
                                    <td colspan=3>
                                        <table class="table table-hover" id="types1">
                                            <tr>
                                                <th style="text-align:center">Grade Type</th>
                                                <!-- <th style="text-align:center">Grade Size</th> -->
                                                <th style="text-align:center">Price</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select title='Please Select Appropriate Type' name="grade[]" id="gt" class="form-control">
                                                        <option value="">--Select--</option>
                                                        <option value="M10">M10</option>
                                                        <option value="M15">M15</option>
                                                        <option value="M20">M20</option>
                                                        <option value="M20">M25</option>
                                                        <option value="M20">M30</option>
                                                        <option value="M20">M35</option>
                                                        <!-- <option value="">All</option> -->
                                                    </select>
                                                </td>
                                                <td>
                                                    <input min="0" type="number" name="gradeprice[]" id="gp" placeholder="Price" class="form-control">
                                                </td>
                                            </tr>
                                            
                                        </table>
                                            <div class="btn-group">
                                                <button type="button" onclick="myFunction1()" class="btn btn-warning btn-sm">
                                                    &nbsp; <span class="glyphicon glyphicon-plus"></span>&nbsp;
                                                </button>
                                                <button type="button" onclick="myDelete1()" class="btn btn-danger btn-sm">
                                                    &nbsp; <span class="glyphicon glyphicon-minus"></span>&nbsp;
                                                </button>
                                            </div>
                                    </td>
                                </tr>
                                <tr id="mfType" class="hidden">
                                    <td>Blocks Manufacturing Type</td>
                                    <td>:</td>
                                    <td>
                                        <div class="radio">
                                            <label><input type="radio" name="manufacturing_type" value="Manual" id="manual">Manual</label>
                                        </div>
                                        <div class="radio">
                                            <label><input type="radio" name="manufacturing_type" value="Machine" id="machine">Machine</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr id="moq" class="hidden">
                                    <td>MOQ For Free Pumping (CUM)</td>
                                    <td>:</td>
                                    <td>
                                        <input type="number" min="1" name="moq" id="moq2" placeholder="MOQ For Free Pumping (CUM)" class="form-control">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-success form-control">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        <script>
            function myFunction() {
                var table = document.getElementById("types");
                var row = table.insertRow(-1);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                cell1.innerHTML = "<select title='Please Select Appropriate Type' required name='blockType[]' id='' class='form-control'>" +
                                "<option value=''>--Select--</option>" +
                                "<option value='Concrete'>Concrete</option>" +
                                "<option value='Cellular'>Cellular</option>" +
                                "<option value='Light Weight'>Light Weight</option>" +
                            "</select>"
                cell2.innerHTML = "<select title='Please Select Appropriate Size' required name='blockSize[]' id='' class='form-control'>" +
                                        "<option value=''>--Select--</option>" +
                                        "<option value='4 inch'>4 inch</option>" +
                                        "<option value='6 inch'>6 inch</option>" +
                                        "<option value='8 inch'>8 inch</option>" +
                                    "</select>";
                cell3.innerHTML = "<input min='0' type='number' required name='price[]' id='' placeholder='Price' class='form-control'>";
            }
            function myDelete() {
                var table = document.getElementById("types");
                if(table.rows.length >= 3){
                    document.getElementById("types").deleteRow(-1);
                }
            }

            function myFunction1() {
                var table = document.getElementById("types1");
                var row = table.insertRow(-1);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                cell1.innerHTML = "<select title='Please Select Appropriate Type' required name='grade[]' id='' class='form-control'>" +
                                "<option value=''>--Select--</option>" +
                                "<option value='M10'>M10</option>" +
                                "<option value='M15'>M15</option>" +
                                "<option value='M20'>M20</option>" +
                                "<option value='M25'>M25</option>" +
                                "<option value='M30'>M30</option>" +
                                "<option value='M35'>M35</option> </select>";
                cell2.innerHTML = "<input type='number' min='0' required name='gradeprice[]' id='' placeholder='Price' class='form-control'>";
            }
            function myDelete1() {
                var table = document.getElementById("types1");
                if(table.rows.length >= 3){
                    document.getElementById("types1").deleteRow(-1);
                }
            }

          function hideordisplay(arg){
              if(arg == "Blocks"){
                document.getElementById('blockTypes1').className = "";
                document.getElementById('blockTypes2').className = "";
                document.getElementById('mfType').className = "";
                document.getElementById('grades1').className = "hidden";
                document.getElementById('grades2').className = "hidden";
                document.getElementById('moq').className = "hidden";
              }else if(arg=="RMC"){
                document.getElementById('blockTypes1').className = "hidden";
                document.getElementById('blockTypes2').className = "hidden";
                document.getElementById('mfType').className = "hidden";
                document.getElementById('grades1').className = "";
                document.getElementById('grades2').className = "";
                document.getElementById('moq').className = "";
              }else{
                document.getElementById('blockTypes1').className = "hidden";
                document.getElementById('blockTypes2').className = "hidden";
                document.getElementById('mfType').className = "hidden";
                document.getElementById('grades1').className = "hidden";
                document.getElementById('grades2').className = "hidden";
                  console.log(arg);
              }
          }
          function checkPhNo(x){
            var phoneno = /^[6-9][0-9]\d{8}$/;
            if(x != "" && !x.match(phoneno))
            {
                alert('Please Enter 10 Digits Phone Number');
                document.getElementById("phNo").value = '';
                document.getElementById("phNo").focus();
                return false;
            }
          }
            function validate(){
                var type = document.getElementById('type').value;
                if(type=="RMC"){
                    if(document.getElementById('gt').value == ''){
                        swal("Error",'Please Select Grade Type','error');
                        return false;
                    }
                    if(document.getElementById('gp').value == ''){
                        swal("Error",'Please Enter Grade Price','error');
                        return false;
                    }
                    if(document.getElementById('moq2').value == ''){
                        swal("Error",'Please Enter MOQ','error');
                        return false;
                    }
                }
                if(type=="Blocks"){
                    if(document.getElementById('bt').value==''){
                        swal("Error",'Please Select Block Type','error');
                        return false;
                    }
                    if(document.getElementById('bs').value==''){
                        swal("Error",'Please Enter Block Size','error');
                        return false;
                    }
                    if(document.getElementById('bp').value==''){
                        swal("Error",'Please Enter Block Price','error');
                        return false;
                    }
                    if(document.getElementById('manual').checked == false && document.getElementById('machine').checked == false){
                        swal("Error",'Please Select Manufacturing Mode','error');
                        return false;
                    }
                }
                return true;
            }
        </script>
<script type="text/javascript" charset="utf-8">
    function getLocation(){
        document.getElementById("getBtn").className = "hidden";
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
    }
    
    function displayCurrentLocation(position){
      var latitude  = position.coords.latitude;
      var longitude = position.coords.longitude;
      document.getElementById('latitude').value=latitude;
      document.getElementById('longitude').value=longitude;
      getAddressFromLatLang(latitude,longitude);
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
        var geocoder = new google.maps.Geocoder();
        var latLng = new google.maps.LatLng(lat, lng);
        geocoder.geocode( { 'latLng': latLng}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    document.getElementById("address").value = results[0].formatted_address;
                }
            }else{
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU"></script>
@if(session('Success'))
<script>
    swal("success","{{ session('Success') }}","success");
</script>
@endif
@endsection