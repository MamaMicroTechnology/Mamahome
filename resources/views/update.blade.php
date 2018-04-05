<?php
  $user = Auth::user()->group_id;
  $ext = ($user == 4? "layouts.amheader":"layouts.app");
?>
@extends($ext)

@section('content')
<div class="container">
    <div class="row">
      <?php $id = $_GET['projectId']; ?>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  @if($subwards)
                  You're Assigned Ward is  {{$subwards->sub_ward_name}}
                  @else
                  Update Project
                  @endif
                  @if(session('Success'))
                    <p class="alert-success pull-right">{{ session('Success') }}</p>
                  @endif
                </div>
                <div class="panel-body">
                    <center>
                      <label>Project Details</label>
                    </center>
                    @if($projectdetails->quality == NULL)
                      <form method="POST" action="{{ URL::to('/') }}/markProject">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $id }}">
                        <div class="radio">
                          <label><input name="quality" type="radio" value="Fake">Fake</label>
                        </div><div class="radio">
                          <label><input name="quality" type="radio" value="Genuine">Genuine</label>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Save">
                      </form>
                      @else
                      {{ $projectdetails->quality }}
                      @endif
                    <br>
                   <form method="POST" action="{{ URL::to('/') }}/{{ $projectdetails->project_id }}/updateProject" enctype="multipart/form-data">
                    <div id="first">
                    {{ csrf_field() }}
                           <table class="table">
                               <tr>
                                   <td>Project Name</td>
                                   <td>:</td>
                                   <td><input disabled id="pName" value="{{ $projectdetails->project_name }}"  type="text" placeholder="Project Name" class="form-control input-sm" name="pName"></td>
                               </tr>
                               <tr>
                                   <td>Location</td>
                                   <td>:</td>
                                   <td id="x">
                                    <div class="col-sm-6">
                                        <input disabled value="{{ $projectdetails->siteaddress->longitude }}" placeholder="Longitude" class="form-control input-sm"  type="text" name="longitude" value="" id="longitude">
                                    </div>
                                    <div class="col-sm-6">
                                        <input disabled value="{{ $projectdetails->siteaddress->latitude }}" placeholder="latitude" class="form-control input-sm"  type="text" name="latitude" value="" id="latitude">
                                    </div>
                                   </td>
                               </tr>
                               <tr>
                                   <td>Road Name</td>
                                   <td>:</td>
                                   <td><input id="road" value="{{ $projectdetails->road_name }}"  type="text" placeholder="Road Name" class="form-control input-sm" name="rName"></td>
                               </tr>
                               <tr>
                                   <td>Municipal Approval</td>
                                   <td>:</td>
                                   <td><input type="file" accept="image/*" class="form-control input-sm" name="mApprove"></td>
                               </tr>
                               <tr>
                                   <td>Other Approvals</td>
                                   <td>:</td>
                                   <td><input type="file" accept="image/*" class="form-control input-sm" name="oApprove"></td>
                               </tr>
                               <tr>
                                   <td>Project Status</td>
                                   <td>:</td>
                                   <td>
                                       <select id="status"  name="status" class="form-control input-sm">
                                           <option value="">--Select--</option>)
                                           <option  {{ $projectdetails->project_status == "Planning" ? 'selected' : ''}} value="Planning">Planning</option>
                                           <option  {{ $projectdetails->project_status == "Digging" ? 'selected' : ''}} value="Digging">Digging</option>
                                           <option  {{ $projectdetails->project_status == "Foundation" ? 'selected' : ''}} value="Foundation">Foundation</option>
                                           <option  {{ $projectdetails->project_status == "Pillars" ? 'selected' : ''}} value="Pillars">Pillars</option>
                                           <option  {{ $projectdetails->project_status == "Walls" ? 'selected' : ''}} value="Walls">Walls</option>
                                           <option  {{ $projectdetails->project_status == "Roofing" ? 'selected' : ''}} value="Roofing">Roofing</option>
                                           <option  {{ $projectdetails->project_status == "Electrical & Plumbing" ? 'selected' : ''}} value="Electrical & Plumbing">Electrical &amp; Plumbing</option>
                                           <option  {{ $projectdetails->project_status == "Plastering" ? 'selected' : ''}} value="Plastering">Plastering</option>
                                           <option  {{ $projectdetails->project_status == "Flooring" ? 'selected' : ''}} value="Flooring">Flooring</option>
                                           <option  {{ $projectdetails->project_status == "Carpentry" ? 'selected' : ''}} value="Carpentry">Carpentry</option>
                                           <option  {{ $projectdetails->project_status == "Paintings" ? 'selected' : ''}} value="Paintings">Paintings</option>
                                           <option  {{ $projectdetails->project_status == "Fixtures" ? 'selected' : ''}} value="Fixtures">Fixtures</option>
                                           <option  {{ $projectdetails->project_status == "Completion" ? 'selected' : ''}} value="Completion">Completion</option>
                                       </select>
                                   </td>
                               </tr>
                               <tr>
                                   <td>Project Type</td>
                                   <td>:</td>
                                   <td>
                                    <div class="row">
                                        <div class="col-md-3">
                                          <input value="{{ $projectdetails->basement }}" onkeyup="check('basement')" id="basement" name="basement" type="number" autocomplete="off" class="form-control input-sm" placeholder="Basement">
                                        </div>
                                        <div class="col-md-2">
                                          <b style="font-size: 20px; text-align: center">+</b>
                                        </div>
                                      <div class="col-md-3">
                                        <input value="{{ $projectdetails->ground }}" oninput="check('ground')" autocomplete="off" name="ground" id="ground" type="number" class="form-control input-sm" placeholder="Ground">
                                      </div>
                                      <div class="col-md-3">
                                        <p id="total"></p>
                                      </div>
                                    </div>
                                    </td>
                               </tr>
                               <tr>
                                   <td>Project Size</td>
                                   <td>:</td>
                                   <td><input id="pSize" value="{{ $projectdetails->project_size }}"  placeholder="Project Size" type="text" onkeyup="check('pSize')" class="form-control input-sm" name="pSize"></td>
                               </tr>
                               <tr>
                                   <td>Budget (in Cr.)</td>
                                   <td>:</td>
                                   <td>
                                    <div class="col-md-4">
                                      <input id="budget" value="{{ $projectdetails->budget }}"  placeholder="Budget" type="text" class="form-control input-sm" onkeyup="check('budget')" name="budget">
                                    </div>
                                    <div class="col-md-8">
                                      {{ $projectdetails->budget }}Cr. / {{ $projectdetails->project_size }} =  {{ round((10000000 * $projectdetails->budget)/$projectdetails->project_size,3) }}
                                    </div>
                                  </td>
                               </tr>
                               <tr>
                                   <td>Project Image</td>
                                   <td>:</td>
                                   <td>
                                    <input id="img" type="file" accept="image/*" class="form-control input-sm" name="pImage"><br>
                                    <div id="imagediv">
                                      <img height="250" width="250" id="project_img" src="{{ URL::to('/') }}/public/projectImages/{{ $projectdetails->image }}" class="img img-thumbnail">
                                    </div>
                                   </td>
                               </tr>
                               <tr>
                                    <td>Room Types</td>
                                    <td>:</td>
                                    <td>
                                        <table id="bhk" class="table table-responsive">
                                            <tr>
                                                <td>
                                                    <select name="roomType[]" id="" class="form-control">
                                                        <option value="1RK">1RK</option>
                                                        <option value="1BHK">1BHK</option>
                                                        <option value="2BHK">2BHK</option>
                                                        <option value="3BHK">3BHK</option>
                                                        <option value="4BHK">4BHK</option>
                                                        <option value="5BHK">5BHK</option>
                                                        <option value="6BHK">6BHK</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="number[]" class="form-control" placeholder="No. of rooms">
                                                </td>
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
                                   <td><input value="{{ $projectdetails->ownerdetails->owner_name }}" type="text" placeholder="Owner Name" class="form-control input-sm" id="oName" name="oName"></td>
                               </tr>
                               <tr>
                                   <td>Owner Email</td>
                                   <td>:</td>
                                   <td><input value="{{ $projectdetails->ownerdetails->owner_email }}" placeholder="Owner Email" type="email" class="form-control input-sm" onblur="checkmail('oEmail')" id="oEmail" name="oEmail"></td>
                               </tr>
                               <tr>
                                   <td>Owner Contact No.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{ $projectdetails->ownerdetails->owner_contact_no }}" onkeyup="check('oContact')" placeholder="Owner Contact No." type="text" class="form-control input-sm" maxlength="10" minlength="10" name="oContact" id="oContact"></td>
                               </tr>
                           </table>
                       </div>
                       <div id="third" class="hidden">
                           <label>Contractor Details</label>
                           <table class="table">
                               <tr>
                                   <td>Contractor Name</td>
                                   <td>:</td>
                                   <td><input value="{{ $projectdetails->contractordetails->contractor_name }}" id="cName" type="text" placeholder="Contractor Name" class="form-control input-sm" name="cName"></td>
                               </tr>
                               <tr>
                                   <td>Contractor Email</td>
                                   <td>:</td>
                                   <td><input value="{{ $projectdetails->contractordetails->contractor_email }}" placeholder="Contractor Email" type="email" onblur="checkmail('cEmail')" class="form-control input-sm" name="cEmail" id="cEmail"></td>
                               </tr>
                               <tr>
                                   <td>Contractor Contact No.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{ $projectdetails->contractordetails->contractor_contact_no }}" placeholder="Contractor Contact No." onkeyup="check('cContact')" maxlength="10" minlength="10" type="text" class="form-control input-sm" id="cContact" name="cContact"></td>
                               </tr>
                           </table>
                       </div>
                       <div id="fourth" class="hidden">
                           <label>Consultant Details</label>
                           <table class="table">
                               <tr>
                                   <td>Consultant Name</td>
                                   <td>:</td>
                                   <td><input value="{{ $projectdetails->consultantdetails->consultant_name }}" type="text" placeholder="Consultant Name" class="form-control input-sm" id="coName" name="coName"></td>
                               </tr>
                               <tr>
                                   <td>Consultant Email</td>
                                   <td>:</td>
                                   <td><input value="{{ $projectdetails->consultantdetails->consultant_email }}" placeholder="Consultant Email" onblur="checkmail('coEmail')" type="email" class="form-control input-sm" id="coEmail" name="coEmail"></td>
                               </tr>
                               <tr>
                                   <td>Consultant Contact No.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{ $projectdetails->consultantdetails->consultant_contact_no }}" placeholder="Consultant Contact No." maxlength="10" minlength="10" onkeyup="check('coContact')" type="text" class="form-control input-sm" id="coContact" name="coContact"></td>
                               </tr>
                           </table>
                       </div>
                       <div id="fifth" class="hidden">
                           <label>Site Engineer Details</label>
                           <table class="table">
                               <tr>
                                   <td>Site Engineer Name</td>
                                   <td>:</td>
                                   <td><input value="{{ $projectdetails->siteengineerdetails != null ? $projectdetails->siteengineerdetails->site_engineer_name:'' }}" type="text" placeholder="Site Engineer Name" class="form-control input-sm" id="eName" name="eName"></td>
                               </tr>
                               <tr>
                                   <td>Site Engineer Email</td>
                                   <td>:</td>
                                   <td><input value="{{ $projectdetails->siteengineerdetails != null ? $projectdetails->siteengineerdetails->site_engineer_email : '' }}" placeholder="Site Engineer Email" type="email" onblur="checkmail('eEmail')" class="form-control input-sm" id="eEmail" name="eEmail"></td>
                               </tr>
                               <tr>
                                   <td>Site Engineer Contact No.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{ $projectdetails->siteengineerdetails != null ? $projectdetails->siteengineerdetails->site_engineer_contact_no : '' }}" placeholder="Site Engineer Contact No." type="text" maxlength="10" onkeyup="check('eContact')" minlength="10" class="form-control input-sm" name="eContact" id="eContact"></td>
                               </tr>
                           </table>
                       </div> 
                       <div id="sixth" class="hidden">
                           <label>Procurement Details</label>
                           <table class="table">
                               <tr>
                                   <td>Procurement Name</td>
                                   <td>:</td>
                                   <td><input id="prName" value="{{ $projectdetails->procurementdetails->procurement_name }}"  type="text" placeholder="Procurement Name" class="form-control input-sm" id="pName" name="pName"></td>
                               </tr>
                               <tr>
                                   <td>Procurement Email</td>
                                   <td>:</td>
                                   <td><input id="pEmail" value="{{ $projectdetails->procurementdetails->procurement_email }}" placeholder="Procurement Email" type="email" class="form-control input-sm" id="pEmail" name="pEmail"></td>
                               </tr>
                               <tr>
                                   <td>Procurement Contact No.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input id="prPhone" value="{{ $projectdetails->procurementdetails->procurement_contact_no }}"  placeholder="Procurement Contact No." maxlength="10" minlength="10" type="text" class="form-control input-sm" name="pContact" id="pContact"></td>
                               </tr>
                           </table>
                       </div> 
                       <div id="seventh" class="hidden">
                        <table class="table">
                        <tr>
                            <td><b>Quality</b></td>
                            <td>
                                <select class="form-control" name="quality">
                                    <option value="null" disabled selected>--- Select ---</option>
                                    <option {{ $projectdetails->quality == "Genuine" ? 'selected':''}} value="Genuine">Genuine</option>
                                    <option {{ $projectdetails->quality == "Fake" ? 'selected':''}} value="Fake">Fake</option>
                                </select>
                            </td>
                        </tr>
                        
                        </table>
                            <textarea class="form-control" placeholder="Remarks (Optional)" name="remarks">{{ $projectdetails->remarks }}</textarea><br>
                            <label>With / Without Contractor ? </label><select class="form-control" name="contract" id="contract" required>
                                <option value="" disabled selected>--- Select ---</option>
                                <option {{ $projectdetails->contract == "Labour Contractor" ? 'selected' : ''}} value="Labour Contractor">Labour Contractor</option>
                                <option {{ $projectdetails->contract == "Material Contractor" ? 'selected' : ''}} value="Material Contractor">Material Contractor</option>
                            </select><br>
                            <button type="submit" class="form-control btn btn-primary">Submit Data</button>
                       </div>                        
                       <ul class="pager">
                          <li class="previous"><a onclick="pagePrevious()" href="#">Previous</a></li>
                          <li class="next"><a id="next" href="#" onclick="pageNext()">Next</a></li>
                        </ul>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
<!--This line by Siddharth -->
<script type="text/javascript">
  function checklength(arg){
    var a = document.getElementById(arg).value;
    if(a.length !== 10){
      alert("Please Enter 10 digits !!!!");
    }
    return false;
  }

  function checkmail(arg){
    var mail = document.getElementById(arg);
    
    if(mail.value.length > 0 ){
      if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail.value))  {  
        return true;  
      }  
      else{
        alert("Invalid Email Address!");  
        mail.value = '';
       
      }
      return false;
    }
     
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

    return false;
  }
</script>
<!--This line by Siddharth -->

<script type="text/javascript">
  $(function(){
  $('#img').change(function(){
    var input = this;
    var url = $(this).val();
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
     {
        var reader = new FileReader();

        reader.onload = function (e) {
           $('#project_img').attr('src', e.target.result);
        }
       reader.readAsDataURL(input.files[0]);
    }
    else
    {
      $('#project_img').attr('src', '/assets/no_preview.png');
    }
  });

});
</script>

<script>
var x = document.getElementById("demo");
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
        document.getElementById("getBtn").className = "hidden";
    } else {
        document.getElementById("x").innerHTML = "Please try it later.";
    }
}
function showPosition(position) { 
    document.getElementById("longitude").value = position.coords.longitude;
    document.getElementById("latitude").value = position.coords.latitude;
}
var basement;
var ground;
function sum(){
    basement = parseInt(document.getElementById("basement").value);
    ground = parseInt(document.getElementById("ground").value);
    var floor = basement + ground;
    if(document.getElementById("basement").value != "" && document.getElementById("ground").value != "" && document.getElementById("basement").value != NaN && document.getElementById("ground").value != NaN){
      document.getElementById("total").innerHTML = floor;
    }else{
      document.getElementById("total").innerHTML = "";
    }
}
</script>

<script type="text/javascript">
    var current = "first";
    function pageNext(){
      //alert(document.getElementById("pName").value);
        if(current == 'first'){
          if(document.getElementById("pName").value === ""){
            window.alert("You have not entered Project Name");
          }else if(document.getElementById("longitude").value === ""){
            window.alert("Please click on Get Location button");
          }else if(document.getElementById("latitude").value == ""){
            window.alert("Kindly click on Get location button");
          }else if(document.getElementById("road").value == ""){
            window.alert("You have not entered Road Name");
          }else if(document.getElementById("status").value == ""){
            window.alert("Select Project Status");
          }else if(document.getElementById("basement").value == ""){
            window.alert("You have not entered Project Name");
          }else if(document.getElementById("ground").value == ""){
            window.alert("You have not entered Project Name");
          }else if(document.getElementById("pSize").value == ""){
            window.alert("You have not entered Project Size");
          }else if(document.getElementById("budget").value == ""){
            window.alert("You have not entered Budget");
          }else{ 
            document.getElementById("first").className = "hidden";
            document.getElementById("second").className = "";
            current = "second"
          }
        }else if(current == 'second'){
          
        
            document.getElementById("second").className = "hidden";
            document.getElementById("third").className = "";
            current = "third";
          
        }else if(current == 'third'){
           
            document.getElementById("third").className = "hidden";
            document.getElementById("fourth").className = "";
            current = "fourth";
          
        }else if(current == 'fourth'){
          
            document.getElementById("fourth").className = "hidden";
            document.getElementById("fifth").className = "";
            current = "fifth";
          
        }else if(current == 'fifth'){
            document.getElementById("fifth").className = "hidden";
            document.getElementById("sixth").className = "";
            current = "sixth";
        }else if(current == 'sixth'){
           
            document.getElementById("sixth").className = "hidden";
            document.getElementById("seventh").className = "";
            current = "seventh";
          
        }
    }
    function pagePrevious(){
        if(current == 'seventh'){
            document.getElementById("seventh").className = "hidden";
            document.getElementById("sixth").className = "";
            current = "sixth"
        }else if(current == 'sixth'){
            document.getElementById("sixth").className = "hidden";
            document.getElementById("fifth").className = "";
            current = "fifth"
        }
        else if(current == 'fifth'){
            document.getElementById("fifth").className = "hidden";
            document.getElementById("fourth").className = "";
            current = "fourth"
        }
        else if(current == 'fourth'){
            document.getElementById("fourth").className = "hidden";
            document.getElementById("third").className = "";
            current = "third"
        }
        else if(current == 'third'){
            document.getElementById("third").className = "hidden";
            document.getElementById("second").className = "";
            current = "second"
        }else if(current == 'second'){
            document.getElementById("second").className = "hidden";
            document.getElementById("first").className = "";
            current = "first";
        }else{
            document.getElementById("next").className = "disabled";
        }
    }
    function addRow() {
        var table = document.getElementById("bhk");
        var row = table.insertRow(0);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        
        cell1.innerHTML = " <select name=\"roomType[]\" class=\"form-control\">"+
                                                        "<option value=\"1RK\">1RK</option>"+
                                                        "<option value=\"1BHK\">1BHK</option>"+
                                                        "<option value=\"2BHK\">2BHK</option>"+
                                                        "<option value=\"3BHK\">3BHK</option>"+
                                                        "<option value=\"4BHK\">4BHK</option>"+
                                                        "<option value=\"5BHK\">5BHK</option>"+
                                                        "<option value=\"6BHK\">6BHK</option>"+
                                                    "</select>";
        cell2.innerHTML = "<input required name=\"number[]\" type=\"text\" class=\"form-control\" placeholder=\"No. of rooms\">";
        
    }
</script>
@endsection
