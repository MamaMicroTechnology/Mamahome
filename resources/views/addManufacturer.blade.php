@extends('layouts.app')
@section('content')

    <!-- <center><a href="{{ URL::previous()  }}" class="btn btn-danger">Back</a></center><br> -->
            <form action="{{ URL::to('/') }}/saveManufacturer" onsubmit="return validate()" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-default">
               <div class="panel-heading" style="background-color:#42c3f3;padding:20px;">
                  @if(Auth::user()->group_id == 22)
                     <select class="form-control" style="width:20%" name="tlward" required>
                       <option value="">Select SubWard</option>
                       @foreach($tlwards as $wa)
                       <option value="{{$wa->id}}">{{$wa->sub_ward_name}}</option>
                       @endforeach
                     </select>
                  @elseif(Auth::user()->group_id == 6)
                 <p style="color:#ffffffe3;" class="pull-left">  Your Assigned Ward Is  {{$subwards->sub_ward_name}}</p>
                  @elseif(Auth::user()->group_id == 6 || Auth::user()->group_id == 1)
                 Your Assigned Ward Is  {{$subwards->sub_ward_name}}
                     @elseif(Auth::user()->group_id == 23)
                           @if(count($subwards) != 0)
                           Your Assigned Ward Is  {{$subwards->sub_ward_name}}
                             @else
                               Ward is Not Assigned
                           @endif  
                  @elseif(Auth::user()->group_id == 11)
                   <select class="form-control" style="width:20%" name="tlward">
                       <option value="">Select SubWard</option>
                       @foreach($acc as $w)
                       <option value="{{$w->id}}">{{$w->sub_ward_name}}</option>
                       @endforeach
                     </select>
                 @else 
                 Senior TL
                  @endif
                            <div id="currentTime" class="pull-right" style="color:white;margin-top:-5px;"></div>
                            
                        </div>
                        <div class="panel-body">
               <center> <label id="headingPanel"> Manufacturer Details</label></center><br>
               <center> <button type="button" id="getBtn"  class="btn btn-success btn-sm " onclick="getLocation()">Get Location</button></center><br>
                            <table class="table table-hover">
                                <tr>
                                    <td>Manufacturer Type</td>
                                    <td>:</td>
                                    <td>
                                        <select required onchange="hideordisplay(this.value);" name="type" id="type" class="form-control">
                                            <option value="">--Select--</option>
                                            <option value="RMC">RMC</option>
                                            <option value="Blocks">BLOCKS</option>
                                            <option value="M-Sand">M-SAND</option>
                                            <option value="AGGRGATES">AGGREGATES</option>
                                            <option value="Fabricators">Fabricators</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Production Type</td>
                                    <td>:</td>
                                    <td>
                                 <label required class="checkbox-inline"><input id="constructionType1" name="production[]" type="checkbox" value="RMC">RMC </label>
                                    <label required class="checkbox-inline"><input id="constructionType2" name="production[]" type="checkbox" value="BLOCKS">BLOCKS</label> 
                                  <label required class="checkbox-inline"><input id="constructionType2" name="production[]" type="checkbox" value="M-SAND">M-SAND</label> 
                                      <label required class="checkbox-inline"><input id="constructionType2" name="production[]" type="checkbox" value="AGGREGATES">AGGREGATES</label> 
                                        <label required class="checkbox-inline"><input id="constructionType2" name="production[]" type="checkbox" value="Fabricators">FABRICATORS</label> 
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
                                   <td>Manufacturer Images</td>
                                   <td>:</td>
                                   <td><input id="pImage" oninput="fileuploadimage()" required type="file" accept="image/*" class="form-control input-sm" name="pImage[]" onchange="validateFileType()" multiple><p id="errormsg"></p></td>
                               </tr>
                              

                                <tr>
                                    <td>Address</td>
                                    <td>:</td>
                                    <td>
                                        <input required placeholder="Address" type="text" name="address" id="address" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Area(Sqft)</td>
                                    <td>:</td>
                                    <td>
                                        <input required placeholder="Total Area" min="0" type="number" name="total_area" id="area" class="form-control">
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
                                        <input  placeholder="M-Sand Required" min="0" type="number" name="sand_requirement" id="sand_requirement" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Aggregates Required</td>
                                    <td>:</td>
                                    <td>
                                        <input placeholder="Aggregates Required" min="0" type="number" name="aggregate_requirement" id="aggregate_requirement" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Intrested Cement Brands</td>
                                    <td>:</td>
                                    <td>
                                        <input placeholder="Intrested Cement Brands" type="text" name="brand" id="brand" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Existing Brand and Quanty  <br>(Per Week)</td>
                                    <td>:</td>
                                    <td>
                                        <div class="col-md-6 ">
                                            <input type="text"  checked="true" name="exbrand" id="tons" class="form-control" placeholder="Existing Brands">
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <input placeholder="Brand Quantity" min="0" type="number" name="brandquantity" id="cement_requirement" class="form-control">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                 <td>Sample Requrest ?</td>
                                 <td>:</td>
                                 <td>
                                     
                                      <label ><input required value="Yes" id="rmc" type="radio" name="sample"><span>&nbsp;</span>Yes</label>
                                      <span>&nbsp;&nbsp;&nbsp;  </span>
                                      <label ><input required value="No" id="rmc2" type="radio" name="sample"><span>&nbsp;</span>No</label> 
                                      <span>&nbsp;&nbsp;&nbsp;  </span>
                                      <label><input checked="checked" value="None" id="rmc3" type="radio" name="sample"><span>&nbsp;</span>None</label>
                                 </td>
                               </tr>
                                <tr>
                            <td>Other Materials</td>
                            <td>:</td>
                            <td>
                          <textarea style="resize: none;" class="form-control" placeholder="Remarks (Optional)"  name="other"></textarea>
                          </td>
                        </tr>
                               <tr>
                                 <td>Add mixtures and GGBS ?</td>
                                 <td>:</td>
                                 <td>
                                     
                                      <label ><input required value="Yes" id="rmc" type="radio" name="ggbs"><span>&nbsp;</span>Yes</label>
                                      <span>&nbsp;&nbsp;&nbsp;  </span>
                                      <label ><input required value="No" id="rmc2" type="radio" name="ggbs"><span>&nbsp;</span>No</label> 
                                      <span>&nbsp;&nbsp;&nbsp;  </span>
                                      <label><input checked="checked" value="None" id="rmc3" type="radio" name="ggbs"><span>&nbsp;</span>None</label>
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
                                                    <input min="1" type="number" name="price[]" id="bp" placeholder="Price" class="form-control">
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
                                                    <input min="1" type="number" name="gradeprice[]" id="gp" placeholder="Price" class="form-control">
                                                </td>
                                            </tr>
                                            
                                        </table>
                                            <div class="btn-group">
                                                <button type="button" onclick="addRMC()" class="btn btn-warning btn-sm">
                                                    &nbsp; <span class="glyphicon glyphicon-plus"></span>&nbsp;
                                                </button>
                                                <button type="button" onclick="RMC()" class="btn btn-danger btn-sm">
                                                    &nbsp; <span class="glyphicon glyphicon-minus"></span>&nbsp;
                                                </button>
                                            </div>
                                    </td>
                                </tr>




                             <tr id="fab1" class="hidden">
                                    <td style="background-color:#cfedaa; text-align:center" colspan=3> Fabricators Manufactured</td>
                                </tr>
                                <tr id="fab2" class="hidden">
                                    <td colspan=3>
                                        <table class="table table-hover" id="fabc">
                                            <tr>
                                                <th style="text-align:center"> Fabricators Type</th>
                                                <!-- <th style="text-align:center">Grade Size</th> -->
                                                <th style="text-align:center">Price</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select title='Please Select Appropriate Type' name="fab[]" id="gt" class="form-control">
                                                        <option value="">--Select--</option>
                                                        <option value="metal">Metal</option>
                                                        <option value="wood">Wood</option>
                                                        <option value="upvc">UPVC</option>
                                                      
                                                    </select>
                                                </td>
                                                <td>
                                                    <input min="1" type="number" name="fabprice[]" id="gp" placeholder="Price" class="form-control">
                                                </td>
                                            </tr>
                                            
                                        </table>
                                            <div class="btn-group">
                                                <button type="button" onclick="addfab()" class="btn btn-warning btn-sm">
                                                    &nbsp; <span class="glyphicon glyphicon-plus"></span>&nbsp;
                                                </button>
                                                <button type="button" onclick="fab()" class="btn btn-danger btn-sm">
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
                            <div class="tab"  id="second" style="overflow: hidden;
    border: 1px solid #ccc;
    background-color:#42c3f3;
   ">
  <button style="background-color: inherit;
    
    border: none;
    outline: none;
    cursor: pointer;
    padding: 12px 16px;
    transition: 0.3s;
    font-size: 17px;
     color:white;"  class="tablinks" onclick="openCity(event, 'owner')">Owner Details</button><br>
      <button style="background-color: inherit;
    
    border: none;
    outline: none;
    cursor: pointer;
    padding: 12px 16px;
    transition: 0.3s;
    font-size: 17px;
     color:white;" class="tablinks" onclick="openCity(event, 'contractor')">Manager Details  </button><br>
  <button style="background-color: inherit;
    
    border: none;
    outline: none;
    cursor: pointer;
    padding: 12px 16px;
    transition: 0.3s;
    font-size: 17px;
     color:white;" class="tablinks" onclick="openCity(event, 'consultant')">Sales Contact Details</button><br>
<!--   <button style="background-color: inherit;
    
    border: none;
    outline: none;
    cursor: pointer;
    padding: 12px 16px;
    transition: 0.3s;
    font-size: 17px;
     color:white;" class="tablinks" onclick="openCity(event, 'site')">Site Engineer Details</button><br> -->
  <button style="background-color: inherit;
    
    border: none;
    outline: none;
    cursor: pointer;
    padding: 12px 16px;
    transition: 0.3s;
    font-size: 17px;
     color:white;" class="tablinks" onclick="openCity(event, 'procurement')">Procurement Details</button><br>
<!-- 
<button style="background-color: inherit;
    
    border: none;
    outline: none;
    cursor: pointer;
    padding: 12px 16px;
    transition: 0.3s;
    font-size: 17px;
     color:white;" class="tablinks" onclick="openCity(event, 'Builder')">Builder Details</button>
</div> -->
</div>

<div id="owner" class="tabcontent" style="display: none;padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;">
    <br>
  <center><label>Owner Details</label></center>
  <br>
                           <table class="table" border="1">
                               <tr>
                                   <td>Owner Name</td>
                                   <td>:</td>
                                   <td><input value="{{ old('oName') }}" type="text" placeholder="Owner Name" class="form-control input-sm" name="oName" id="oName"></td>
                               </tr>
                               <tr>
                                   <td>Owner Email</td>
                                   <td>:</td>
                                   <td><input value="{{ old('oEmail') }}" onblur="checkmail('oEmail')" placeholder="Owner Email" type="email"  class="form-control input-sm" name="oEmail" id="oEmail"></td>
                               </tr>
                               <tr>
                                   <td>Owner Contact No 1.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{ old('oContact') }}" onblur="checklength('oContact');" onkeyup="check('oContact','1')" maxlength="10"  minlength="10" placeholder="Owner Contact No 1." type="text" class="form-control input-sm" name="oContact" id="oContact"></td>
                               </tr>
                                <tr>
                                   <td>Owner Contact No 2.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{ old('oContact') }}" onblur="checklength('oContact');" onkeyup="check('oContact','1')" maxlength="10"  minlength="10" placeholder="Owner Contact No 2." type="text" class="form-control input-sm" name="oContact1" id="oContact"></td>
                               </tr>
                           </table>
</div>
<div id="contractor" class="tabcontent" style="display: none;padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;"><br>
   <center><label>Manager Details</label></center>
   <br>
                           <table class="table"  border="1">
                               <tr>
                                   <td>Manager Name</td>
                                   <td>:</td>
                                   <td><input value="{{ old('cName') }}" type="text" placeholder="Manager Name" class="form-control input-sm" name="cName" id="cName"></td>
                               </tr>
                               <tr>
                                   <td>Manager Email</td>
                                   <td>:</td>
                                   <td><input value="{{ old('cEmail') }}" placeholder="Manager Email" type="email" class="form-control input-sm" name="cEmail" id="cEmail" onblur="checkmail('cEmail')" ></td>
                               </tr>
                               <tr>
                                   <td>Manager Contact No 1.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{ old('cContact') }}" onblur="checklength('cPhone');" id="cContact" onkeyup="check('cPhone','1')" placeholder="Manager Contact No." type="text" maxlength="10" class="form-control input-sm" name="cContact"></td>
                               </tr>
                                <tr>
                                   <td>Manager Contact No 2.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{ old('cContact') }}" onblur="checklength('cPhone');" id="cContact" onkeyup="check('cPhone','1')" placeholder="Manager Contact No." type="text" maxlength="10" class="form-control input-sm" name="cContact1"></td>
                               </tr>
                           </table>
</div>

<div id="consultant" class="tabcontent" style="display: none;padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;"><br>
  <center><label>Sales Contact Details</label></center><br>
                           <table class="table"  border="1">
                               <tr>
                                   <td>Sales Contact Name</td>
                                   <td>:</td>
                                   <td><input value="{{ old('coName') }}" type="text" placeholder="Sales Contact Name" class="form-control input-sm" name="coName"></td>
                               </tr>
                               <tr>
                                   <td>Sales Contact Email</td>
                                   <td>:</td>
                                   <td><input value="{{ old('coEmail') }}" placeholder="Sales Contact Email" type="email" class="form-control input-sm" name="coEmail" id="coEmail" onblur="checkmail('coEmail')"></td>
                               </tr>
                               <tr>
                                   <td>Sales Contact Contact No 1.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{ old('coContact') }}" onblur="checklength('coContact');" placeholder="Sales Contact Contact No." type="text" class="form-control input-sm" name="coContact" maxlength="10" id="coContact" onkeyup="check('coContact','1')"></td>
                               </tr>
                               <tr>
                                   <td>Sales Contact Contact No 2.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{ old('coContact') }}" onblur="checklength('coContact');" placeholder="Sales Contact Contact No." type="text" class="form-control input-sm" name="coContact1" maxlength="10" id="coContact" onkeyup="check('coContact','1')"></td>
                               </tr>
                           </table>

</div>
<div id="procurement" class="tabcontent" style="display: none;padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;"><br>
   <center><label>Procurement Details</label></center><br>
                           <table class="table"  border="1">
                               <tr>
                                   <td>Procurement Name</td>
                                   <td>:</td>
                                   <td><input id="prName" required type="text" placeholder="Procurement Name" class="form-control input-sm" name="prName" value="{{ old('prName') }}"></td>
                               </tr>
                               <tr>
                                   <td>Procurement Email</td>
                                   <td>:</td>
                                   <td><input value="{{ old('pEmail') }}" placeholder="Procurement Email" type="email" class="form-control input-sm" name="pEmail" id="pEmail" onblur="checkmail('pEmail')" ></td>
                               </tr>
                               <tr>
                                   <td>Procurement Contact No 1.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{ old('pContact') }}" required  minlength=10 onblur="checklength('prPhone');" required placeholder="Procurement Contact No." type="text" class="form-control input-sm" name="prPhone" maxlength="10" id="prPhone" onkeyup="check('prPhone','1')"></td>
                               </tr>
                                <tr>
                                   <td>Procurement Contact No 2.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{ old('pContact') }}"   minlength=10 onblur="checklength('prPhone');" placeholder="Procurement Contact No." type="text" class="form-control input-sm" name="prPhone1" maxlength="10" id="prPhone1" onkeyup="check('prPhone','1')"></td>
                               </tr>
                           </table>
</div>

                        <table class="table table-responsive" >
                          <tr>
                            <td>Remarks</td>
                            <td>:</td>
                            <td>
                          <textarea style="resize: none;" class="form-control" placeholder="Remarks (Optional)"  name="remarks"></textarea>
                          </td>
                        </tr>
                        </table>

                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-success form-control" onclick="pageNext()">Save</button>
                        </div>
                    </div>
                </div>
            </form>

<script>
    function pageNext(){
      if(document.getElementById('type').value == ""){
        swal("You Have Not Selected Manufacturing Type");
      }else if(document.getElementById('name').value == ""){
        swal("You Have Not Entered the Plant Name")
      }else if(document.getElementById('longitude').value == ""){
        swal("Please click The Location Button")
      }
      else if(document.getElementById('area').value == ""){
        swal("You Have Not Entered the Total Area")
      }
      else if(document.getElementById('prName').value == ""){
        swal("You Have Not Entered the Procurement Name")
      }
      else if(document.getElementById('prPhone').value == ""){
        swal("You Have Not Entered the Procurement Number")
      }
    }
</script>

<script type="text/javascript">
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "None";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

     
</script>



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
                cell3.innerHTML = "<input min='1' type='number' required name='price[]' id='' placeholder='Price' class='form-control'>";
            }
            function myDelete() {
                var table = document.getElementById("types");
                if(table.rows.length >= 3){
                    document.getElementById("types").deleteRow(-1);
                }
            }

            function addRMC() {
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
                cell2.innerHTML = "<input type='number' min='1' required name='gradeprice[]' id='' placeholder='Price' class='form-control'>";
            }
            function RMC() {
                var table = document.getElementById("types1");
                if(table.rows.length >= 3){
                    document.getElementById("types1").deleteRow(-1);
                }
            }

 function addfab() {
                var table = document.getElementById("fabc");
                var row = table.insertRow(-1);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                cell1.innerHTML = "<select title='Please Select Appropriate Type' required name='fab[]' id='' class='form-control'>" +
                                "<option value=''>--Select--</option>" +
                                "<option value='metal'>Metal</option>" +
                                "<option value='wood'>Wood</option>" +
                                "<option value='steel'>Steel</option> </select>";
                cell2.innerHTML = "<input type='number' min='1' required name='fabprice[]' id='' placeholder='Price' class='form-control'>";
            }
            function fab() {
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
                document.getElementById('fab1').className = "hidden";
                document.getElementById('fab2').className = "hidden";

                document.getElementById('grades2').className = "hidden";
                document.getElementById('moq').className = "hidden";
              }else if(arg=="RMC"){
                document.getElementById('blockTypes1').className = "hidden";
                document.getElementById('blockTypes2').className = "hidden";
                document.getElementById('mfType').className = "hidden";
                document.getElementById('grades1').className = "";
                document.getElementById('grades2').className = "";
                    document.getElementById('fab1').className = "hidden";
                document.getElementById('fab2').className = "hidden";
                document.getElementById('moq').className = "";
              }else if(arg=="Fabricators"){
                    document.getElementById('blockTypes1').className = "hidden";
                document.getElementById('blockTypes2').className = "hidden";
                document.getElementById('mfType').className = "hidden";
                document.getElementById('grades1').className = "hidden";
                document.getElementById('fab1').className = "";
                document.getElementById('fab2').className = ""
              }else{
                document.getElementById('blockTypes1').className = "hidden";
                document.getElementById('blockTypes2').className = "hidden";
                document.getElementById('mfType').className = "hidden";
                document.getElementById('grades1').className = "hidden";
                document.getElementById('grades2').className = "hidden";
                document.getElementById('fab1').className = "hidden";
                document.getElementById('fab2').className = "hidden"
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
                if(document.getElementById('latitude').value == ''){
                    swal("Error",'Please Fetch The Location Using Fetch Location Button');
                    return false;
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
<script type="text/javascript">
   function doDate()
  {
      var str = "";

      var days = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
      var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

      var now = new Date();

      str += "Today Is: " + days[now.getDay()] + ", " + now.getDate() + " " + months[now.getMonth()] + " " + now.getFullYear() + " " + now.getHours() +":" + now.getMinutes() + ":" + now.getSeconds();
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
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU"></script>
@if(session('Success'))
<script>
    swal("success","{{ session('Success') }}","success");
</script>
<script type="text/javascript">
    function fileuploadimage(){ 
      var count = document.getElementById('pImage').files.length;
      if(count > 4){
        document.getElementById('pImage').value="";
        alert('You are allowed to upload a maximum of 4 files');
      }
    }
</script>

@endif
@endsection
