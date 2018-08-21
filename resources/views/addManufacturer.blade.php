@extends('layouts.app')
@section('content')
    @if(isset($_GET['type']))
    <!-- <center><a href="{{ URL::previous()  }}" class="btn btn-danger">Back</a></center><br> -->
        @if($_GET['type'] == "blocks")
            <form onsubmit="return validateForm();" action="{{ URL::to('/') }}/saveManufacturer" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="type" value="{{ $_GET['type'] }}">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Blocks Manufacturer Details
                            <button type="button" id="getBtn"  class="btn btn-success btn-sm pull-right" onclick="getLocation()">Get Location</button>
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <td>Manufacturer name</td>
                                    <td>:</td>
                                    <td>
                                        <input required placeholder="Manufacturer Name" type="text" name="name" id="name" class="form-control">
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
                                            <label for="tons"><input type="radio" checked="true" name="cement_required" id="tons">Tons</label>&nbsp;&nbsp;
                                            <label for="bags"><input type="radio" name="cement_required" id="bags">Bags</label>
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
                                        <div class="col-md-6 radio">
                                            <label for="tons"><input type="radio" name="m_sand_required" id="tons">Tons</label>&nbsp;&nbsp;
                                            <label for="bags"><input type="radio" checked="true" name="m_sand_required" id="bags">Bags</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input required placeholder="M-Sand Required" min="0" type="number" name="sand_requirement" id="sand_requirement" class="form-control">
                                        </div>
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
                                <tr>
                                    <td style="background-color:#cfedaa; text-align:center" colspan=3>Block Types</td>
                                </tr>
                                <tr>
                                    <td colspan=3>
                                        <table class="table table-hover" id="types">
                                            <tr>
                                                <th style="text-align:center">Block Type</th>
                                                <th style="text-align:center">Block Size</th>
                                                <th style="text-align:center">Price</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select title='Please Select Appropriate Type' required name="blockType[]" id="" class="form-control">
                                                        <option value="">--Select--</option>
                                                        <option value="Concrete">Concrete</option>
                                                        <option value="Cellular">Cellular</option>
                                                        <option value="Light Weight">Light Weight</option>
                                                        <!-- <option value="">All</option> -->
                                                    </select>
                                                </td>
                                                <td>
                                                    <select title='Please Select Appropriate Size' required name="blockSize[]" id="" class="form-control">
                                                        <option value="">--Select--</option>
                                                        <option value="4 inch">4 inch</option>
                                                        <option value="6 inch">6 inch</option>
                                                        <option value="8 inch">8 inch</option>
                                                        <option value="12 inch">12 inch</option>
                                                        <!-- <option value="">All</option> -->
                                                    </select>
                                                </td>
                                                <td>
                                                    <input required min="0" type="number" name="price[]" id="" placeholder="Price" class="form-control">
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
                                <tr>
                                    <td>Blocks Manufacturing Type</td>
                                    <td>:</td>
                                    <td>
                                        <div class="radio">
                                            <label><input required type="radio" name="manufacturing_type" value="Manual" id="manual">Manual</label>
                                        </div>
                                        <div class="radio">
                                            <label><input required type="radio" name="manufacturing_type" value="Machine" id="machine">Machine</label>
                                        </div>
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
                cell3.innerHTML = "<input required min='0' type='number' name='price[]' id='' placeholder='Price' class='form-control'>";
            }
            function myDelete() {
                var table = document.getElementById("types");
                if(table.rows.length >= 3){
                    document.getElementById("types").deleteRow(-1);
                }
            }
            function manufacturingType(arg){
                if(arg == "manual"){
                    document.getElementById('manual').checked = true;
                    var manualimg = document.getElementById('manualImage');
                    var machineimg = document.getElementById('machineImage');
                    manualimg.src = "{{ URL::to('/') }}/manual_checked.png";
                    manualimg.style.backgroundColor = "#dae4ed";
                    manualimg.style.borderRadius = "3px";
                    machineimg.src = "{{ URL::to('/') }}/machine_unchecked.png";
                    machineimg.style.backgroundColor = "";
                    machineimg.style.borderRadius = "";
                    
                }else{
                    var manualimg = document.getElementById('manualImage');
                    var machineimg = document.getElementById('machineImage');
                    document.getElementById('machine').checked = true;
                    manualimg.src = "{{ URL::to('/') }}/manual_unchecked.png";
                    manualimg.style.backgroundColor = "";
                    manualimg.style.borderRadius = "";
                    machineimg.src = "{{ URL::to('/') }}/machine_checked.png";
                    machineimg.style.backgroundColor = "#dae4ed";
                    machineimg.style.borderRadius = "3px";
                }
            }
            function modeOfPayment(arg){
                document.getElementById(arg+'2').click();
                if(document.getElementById(arg+'2').checked == true){
                    document.getElementById(arg).src = arg + "_checked.png";
                    document.getElementById(arg).style.backgroundColor = "#5a6b58";
                }else{
                    document.getElementById(arg).src = arg + "_unchecked.png";
                    document.getElementById(arg).style.backgroundColor = "";
                }
            }
            function validateForm(){
                var count = 0;
                var count2 = 0;
                if(document.getElementById('manual').checked == false){
                    count2++;
                }
                if(document.getElementById('machine').checked == false){
                    count2++;
                }
                if(document.getElementById('rtgs2').checked == false){
                    count++;
                }
                if(document.getElementById('check2').checked == false){
                    count++;
                }
                if(document.getElementById('cash2').checked == false){
                    count++;
                }
                if(count2 == 2){
                    alert("Please Select Manufacturing Type");
                    return false;
                }else if(count == 3){
                    alert("Please Select Payment Mode");
                    return false;
                }
                return true;
            }
        </script>
        @elseif($_GET['type'] == "rmc")
        <form onsubmit="return validateForm();" action="{{ URL::to('/') }}/saveManufacturer" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="type" value="{{ $_GET['type'] }}">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            RMC Manufacturer Details
                            <button type="button" id="getBtn"  class="btn btn-success btn-sm pull-right" onclick="getLocation()">Get Location</button>    
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <td>Name of Plant</td>
                                    <td>:</td>
                                    <td>
                                        <input required placeholder="Name of Plant" type="text" name="name" id="name" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>:</td>
                                    <td>
                                        <input required placeholder="Address" type="text" name="address" id="address" class="form-control">
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Area of Plant</td>
                                    <td>:</td>
                                    <td>
                                        <input required placeholder="Area of Plant" min="0" type="number" name="area" id="area" class="form-control">
                                    </td>
                                </tr> -->
                                <tr>
                                    <td>Production Capacity (In Cubic Meter Per Day)</td>
                                    <td>:</td>
                                    <td>
                                        <input required placeholder="Production Capacity (Per Day)" min="0" type="number" name="capacity" id="capacity" class="form-control">
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Present Utilization (In %)</td>
                                    <td>:</td>
                                    <td>
                                        <input required placeholder="Present Utilization (In %)" min="0" type="number" name="utilization" id="utilization" class="form-control">
                                    </td>
                                </tr> -->
                                <tr>
                                    <td>Quantity Of Cement Bags Required (Tons)</td>
                                    <td>:</td>
                                    <td>
                                        <input required placeholder="Quantity Of Cement Bags Required (Tons)" min="0" type="number" name="cement_requirement" id="cement_requirement" class="form-control">
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Type Of Cement Used</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="cement_used" id="cement_used" placeholder="Cement Used" class="form-control">
                                    </td>
                                </tr> -->
                                <tr>
                                    <td>Prefered Cement Brands</td>
                                    <td>:</td>
                                    <td>
                                        <input required placeholder="Prefered Cement Brands" type="text" name="brand" id="brand" class="form-control">
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Deliverability</td>
                                    <td>:</td>
                                    <td>
                                        <select required name="deliverability" id="deliverability" class="form-control">
                                            <option value="">--Select--</option>
                                            <option value="0-15km">0-15km</option>
                                            <option value="16-20km">16-20km</option>
                                            <option value="21-25km">21-25km</option>
                                            <option value="26km & above">26km & above</option>
                                        </select>
                                        <input required placeholder="Deliverability" type="text" name="deliverability" id="deliverability" class="form-control">
                                    </td>
                                </tr> -->
                                <tr>
                                    <td>M-Sand Required</td>
                                    <td>:</td>
                                    <td>
                                        <div class="col-md-6 radio">
                                            <label for="tons"><input type="radio" name="m_sand_required" id="tons">Tons</label>&nbsp;&nbsp;
                                            <label for="bags"><input type="radio" checked="true" name="m_sand_required" id="bags">Bags</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input required placeholder="M-Sand Required" min="0" type="number" name="sand_requirement" id="sand_requirement" class="form-control">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Aggregates Required (Per Week In Tons)</td>
                                    <td>:</td>
                                    <td>
                                        <input required placeholder="Aggregates Required (Per Week In Tons)" min="0" type="number" name="aggregate_requirement" id="sand_requirement" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>MOQ For Free Pumping (CUM)</td>
                                    <td>:</td>
                                    <td>
                                        <input required type="number" min="1" name="moq" id="moq" placeholder="MOQ For Free Pumping (CUM)" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color:#cfedaa; text-align:center" colspan=3>Grades Manufactured</td>
                                </tr>
                                <tr>
                                    <td colspan=3>
                                        <table class="table table-hover" id="types">
                                            <tr>
                                                <th style="text-align:center">Grade Type</th>
                                                <!-- <th style="text-align:center">Grade Size</th> -->
                                                <th style="text-align:center">Price</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select title='Please Select Appropriate Type' required name="blockType[]" id="" class="form-control">
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
                                                    <input required min="0" type="number" name="price[]" id="" placeholder="Price" class="form-control">
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
                cell1.innerHTML = "<select title='Please Select Appropriate Type' required name='blockType[]' id='' class='form-control'>" +
                                "<option value=''>--Select--</option>" +
                                "<option value='M10'>M10</option>" +
                                "<option value='M15'>M15</option>" +
                                "<option value='M20'>M20</option>" +
                                "<option value='M25'>M25</option>" +
                                "<option value='M30'>M30</option>" +
                                "<option value='M35'>M35</option> </select>";
                cell2.innerHTML = "<input required type='number' min='0' name='price[]' id='' placeholder='Price' class='form-control'>";
            }
            function myDelete() {
                var table = document.getElementById("types");
                if(table.rows.length >= 3){
                    document.getElementById("types").deleteRow(-1);
                }
            }
        </script>
        @endif
    @endif

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
  }
    
    function displayCurrentLocation(position){
      var latitude  = position.coords.latitude;
      var longitude = position.coords.longitude;
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
    swal("{{ session('Success') }}");
</script>
@endif
@endsection