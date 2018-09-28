@extends('layouts.app')
@section('content')

    <!-- <center><a href="{{ URL::previous()  }}" class="btn btn-danger">Back</a></center><br> -->
            <form action="{{ URL::to('/') }}/saveUpdatedManufacturer" onsubmit="return validate()" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ isset($_GET['id']) ? $_GET['id'] : '' }}">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="height:50px;background-color:#42c3f3;color:black;">
                      <span class="pull-lect" style="color:white;"> Your Assigned Ward Is {{$ward}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
                           <div id="currentTime" class="pull-right" style="color:#ffffffe3;"></div>
                             
                        </div>
                        <div class="panel-body">
                             <center> <label id="headingPanel"> Manufacturer Details</label></center>
                            <table class="table table-hover">
                                <tr>
                                    <td>Manufacturer Id</td>
                                    <td>:</td>
                                    <td>{{$manufacturer->id}}</td>

                                </tr>
                                <tr>
                                    <td>Manufacturer Type</td>
                                    <td>:</td>
                                    <td>
                                        <select required onchange="hideordisplay(this.value);" name="type" id="type" class="form-control">
                                            <option value="">--Select--</option>
                                            <option {{ $manufacturer->manufacturer_type == "RMC" ? 'selected' : ''}} value="RMC">RMC</option>
                                            <option {{ $manufacturer->manufacturer_type == "Blocks" ? 'selected' : ''}} value="Blocks">Blocks</option>
                                            <!-- <option value="Crusher">Crusher</option> -->
                                        </select>
                                    </td>
                                </tr>
                               <!--  <tr>
                                    <td>Manufacturer Name</td>
                                    <td>:</td>
                                    <td>
                                        <input value="{{ $manufacturer->name }}" required placeholder="Manufacturer Name" type="text" name="name" id="name" class="form-control">
                                    </td>
                                </tr> -->
                                <tr>
                                    <td>Plant Name</td>
                                    <td>:</td>
                                    <td>
                                        <input value="{{ $manufacturer->plant_name }}" required placeholder="Plant Name" type="text" name="plant_name" id="name" class="form-control">

                                    </td>
                                </tr>
                                 <tr>
                                    <td>Production Type</td>
                                    <td>:</td>
                                    <td>
                                 <label required class="checkbox-inline"><input  id="constructionType1" name="production[]" type="checkbox" value="RMC">RMC </label>
                                    <label required class="checkbox-inline"><input id="constructionType2" name="production[]" type="checkbox" value="BLOCKS">BLOCKS</label> 
                                  <label required class="checkbox-inline"><input id="constructionType2" name="production[]" type="checkbox" value="M-SAND">M-SAND</label> 
                                      <label required class="checkbox-inline"><input id="constructionType2" name="production[]" type="checkbox" value="AGGREGATES">AGGREGATES</label> 
                                    </td>
                                </tr>
                               <!--  <tr>
                                    <td>Contact No</td>
                                    <td>:</td>
                                    <td>
                                        <input value="{{ $manufacturer->contact_no }}" required placeholder="Contact No" onblur="checkPhNo(this.value)" type="text" name="phNo" id="phNo" class="form-control">
                                    </td>
                                </tr> -->
                                <tr>
                                    <td>Location</td>
                                    <td>:</td>
                                    <td>
                                        <div class="col-md-6">
                                            <input readonly value="{{ $manufacturer->latitude }}" required placeholder="Latitude" type="text" name="latitude" id="latitude" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <input readonly value="{{ $manufacturer->longitude }}" required placeholder="Longitude" type="text" name="longitude" id="longitude" class="form-control">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>:</td>
                                    <td>
                                        <input value="{{ $manufacturer->address }}" required placeholder="Address" type="text" name="address" id="address" class="form-control">
                                    </td>
                                </tr>

                       <tr>
                                   <td>Manufacturer Image</td>
                                   <td>:</td>
                                    <td> <input id="img" type="file" accept="image/*" class="form-control input-sm" name="pImage[]" multiple><br>
                            
                                          <?php
                                               $images = explode(",", $manufacturer->image);
                                               ?>
                                             
                                             <div class="row">

                                                 @for($i = 0; $i < count($images); $i++)
                                                     <div class="col-md-3">
                                                          <img height="350" width="350" id="project_img" src="{{ URL::to('/') }}/public/Manufacturerimage/{{ $images[$i] }}" class="img img-thumbnail">
                                                     </div>
                                                 @endfor
                                              </div>
                                   </td>
                               </tr>

                             


                                <tr>
                                    <td>Total Area</td>
                                    <td>:</td>
                                    <td>
                                        <input value="{{ $manufacturer->total_area }}" required placeholder="Total Area" min="0" type="number" name="total_area" id="area" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Production Capacity (Per Day)</td>
                                    <td>:</td>
                                    <td>
                                        <input value="{{ $manufacturer->capacity }}" placeholder="Production Capacity (Per Day)" min="0" type="number" name="capacity" id="capacity" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Quantity Of Cement Required <br>(Per Week)</td>
                                    <td>:</td>
                                    <td>
                                        <div class="col-md-6 radio">
                                            <label {{ $manufacturer->cement_requirement_measurement == "tons" ? 'checked' : ''}} for="tons"><input type="radio" value="Tons" checked="true" name="cement_required" id="tons">Tons</label>&nbsp;&nbsp;
                                            <label {{ $manufacturer->cement_requirement_measurement == "bags" ? 'checked' : ''}} for="bags"><input type="radio" value="Bags" name="cement_required" id="bags">Bags</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input value="{{ $manufacturer->cement_requirement }}" placeholder="Cement Required" min="0" type="number" name="cement_requirement" id="cement_requirement" class="form-control">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>M-Sand Required</td>
                                    <td>:</td>
                                    <td>
                                        <input value="{{ $manufacturer->sand_requirement }}"  placeholder="M-Sand Required" min="0" type="number" name="sand_requirement" id="sand_requirement" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Aggregates Required</td>
                                    <td>:</td>
                                    <td>
                                        <input value="{{ $manufacturer->aggregates_required }}" placeholder="Aggregates Required" min="0" type="number" name="aggregate_requirement" id="aggregate_requirement" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Prefered Cement Brands</td>
                                    <td>:</td>
                                    <td>
                                        <input value="{{ $manufacturer->prefered_cement_brand }}" placeholder="Prefered Cement Brands" type="text" name="brand" id="brand" class="form-control">
                                    </td>
                                </tr>
                                <tr id="blockTypes1" class="{{ $manufacturer->manufacturer_type == 'Blocks' ? '' : 'hidden' }}">
                                    <td style="background-color:#cfedaa; text-align:center" colspan=3>Block Types</td>
                                </tr>
                                <tr id="blockTypes2" class="{{ $manufacturer->manufacturer_type == 'Blocks' ? '' : 'hidden' }}">
                                    <td colspan=3>
                                        <table class="table table-hover" id="types">
                                            <tr>
                                                <th style="text-align:center">Block Type</th>
                                                <th style="text-align:center">Block Size</th>
                                                <th style="text-align:center">Price</th>
                                            </tr>
                                            @foreach($manufacturer->manufacturerProduct as $products)
                                            <input type="hidden" name="product_id1[]" value="{{ $products->id }}">
                                            <tr>
                                                <td>
                                                    <select title='Please Select Appropriate Type' name="blockType[]" id="bt" class="form-control">
                                                        <option value="">--Select--</option>
                                                        <option {{ $products->block_type == "Concrete" ? 'selected' : ''}} value="Concrete">Concrete</option>
                                                        <option {{ $products->block_type == "Cellular" ? 'selected' : ''}} value="Cellular">Cellular</option>
                                                        <option {{ $products->block_type == "Light Weight" ? 'selected' : ''}} value="Light Weight">Light Weight</option>
                                                        <!-- <option value="">All</option> -->
                                                    </select>
                                                </td>
                                                <td>
                                                    <select title='Please Select Appropriate Size' name="blockSize[]" id="bs" class="form-control">
                                                        <option value="">--Select--</option>
                                                        <option {{ $products->block_size == "4 inch" ? 'selected' : ''}} value="4 inch">4 inch</option>
                                                        <option {{ $products->block_size == "6 inch" ? 'selected' : ''}} value="6 inch">6 inch</option>
                                                        <option {{ $products->block_size == "8 inch" ? 'selected' : ''}} value="8 inch">8 inch</option>
                                                        <option {{ $products->block_size == "12 inch" ? 'selected' : ''}} value="12 inch">12 inch</option>
                                                        <!-- <option value="">All</option> -->
                                                    </select>
                                                </td>
                                                <td>
                                                    <input value="{{ $products->price }}" min="0" type="number" name="price[]" id="bp" placeholder="Price" class="form-control">
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
                                <tr id="grades1" class="{{ $manufacturer->manufacturer_type == 'RMC' ? '': 'hidden' }}">
                                    <td style="background-color:#cfedaa; text-align:center" colspan=3>Grades Manufactured</td>
                                </tr>
                                <tr id="grades2" class="{{ $manufacturer->manufacturer_type == 'RMC' ? '': 'hidden' }}">
                                    <td colspan=3>
                                        <table class="table table-hover" id="types1">
                                            <tr>
                                                <th style="text-align:center">Grade Type</th>
                                                <!-- <th style="text-align:center">Grade Size</th> -->
                                                <th style="text-align:center">Price</th>
                                            </tr>
                                            @foreach($manufacturer->manufacturerProduct as $products)
                                            <input type="hidden" name="product_id2[]" value="{{ $products->id }}">
                                            <tr>
                                                <td>
                                                    <select title='Please Select Appropriate Type' name="grade[]" id="gt" class="form-control">
                                                        <option value="">--Select--</option>
                                                        <option {{ $products->block_type == "M10" ? 'selected' : '' }} value="M10">M10</option>
                                                        <option {{ $products->block_type == "M15" ? 'selected' : '' }} value="M15">M15</option>
                                                        <option {{ $products->block_type == "M20" ? 'selected' : '' }} value="M20">M20</option>
                                                        <option {{ $products->block_type == "M25" ? 'selected' : '' }} value="M20">M25</option>
                                                        <option {{ $products->block_type == "M30" ? 'selected' : '' }} value="M20">M30</option>
                                                        <option {{ $products->block_type == "M35" ? 'selected' : '' }} value="M20">M35</option>
                                                        <!-- <option value="">All</option> -->
                                                    </select>
                                                </td>
                                                <td>
                                                    <input value="{{ $products->price }}" min="0" type="number" name="gradeprice[]" id="gp" placeholder="Price" class="form-control">
                                                </td>
                                            </tr>
                                            @endforeach
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
                                <tr id="mfType" class="{{ $manufacturer->manufacturer_type == 'Blocks' ? '' : 'hidden' }}">
                                    <td>Blocks Manufacturing Type</td>
                                    <td>:</td>
                                    <td>
                                        <div class="radio">
                                            <label><input {{ $manufacturer->type == "Manual" ? 'checked' : '' }} type="radio" name="manufacturing_type" value="Manual" id="manual">Manual</label>
                                        </div>
                                        <div class="radio">
                                            <label><input {{ $manufacturer->type == "Machine" ? 'checked' : '' }} type="radio" name="manufacturing_type" value="Machine" id="machine">Machine</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr id="moq" class="{{ $manufacturer->manufacturer_type == 'RMC' ? '' : 'hidden' }}">
                                    <td>MOQ For Free Pumping (CUM)</td>
                                    <td>:</td>
                                    <td>
                                        <input value="{{ $manufacturer->moq }}" type="number" min="1" name="moq" id="moq2" placeholder="MOQ For Free Pumping (CUM)" class="form-control">
                                    </td>
                                </tr>
                            </table>
                            <div class="tab"  id="second" style="overflow: hidden;
    border: 1px solid #ccc;
    background-color:#42c3f3;
   ">
  <button type="button" style="background-color: inherit;
    
    border: none;
    outline: none;
    cursor: pointer;
    padding: 12px 16px;
    transition: 0.3s;
    font-size: 17px;
     color:white;"  class="tablinks" onclick="openCity(event, 'owner')">Owner Details</button><br>
      <button type="button" style="background-color: inherit;
    
    border: none;
    outline: none;
    cursor: pointer;
    padding: 12px 16px;
    transition: 0.3s;
    font-size: 17px;
     color:white;" class="tablinks" onclick="openCity(event, 'contractor')">Manager Details  </button><br>
  <button type="button" style="background-color: inherit;
    
    border: none;
    outline: none;
    cursor: pointer;
    padding: 12px 16px;
    transition: 0.3s;
    font-size: 17px;
     color:white;" class="tablinks" onclick="openCity(event, 'consultant')">Sales Contact Details</button><br>

  <button type="button" style="background-color: inherit;
    
    border: none;
    outline: none;
    cursor: pointer;
    padding: 12px 16px;
    transition: 0.3s;
    font-size: 17px;
     color:white;" class="tablinks" onclick="openCity(event, 'procurement')">Procurement Details</button><br>

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
                                   <td><input value="{{$manufacturer->owner !=null ? $manufacturer->owner->name :'' }}"  type="text" placeholder="Owner Name" class="form-control input-sm" name="oName" id="oName"></td>
                               </tr>
                               <tr>
                                   <td>Owner Email</td>
                                   <td>:</td>
                                   <td><input value="{{$manufacturer->owner !=null ? $manufacturer->owner->email :'' }}"  onblur="checkmail('oEmail')" placeholder="Owner Email" type="email"  class="form-control input-sm" name="oEmail" id="oEmail"></td>
                               </tr>
                               <tr>
                                   <td>Owner Contact No 1.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{$manufacturer->owner !=null ? $manufacturer->owner->contact :''}}"  onblur="checklength('oContact');" onkeyup="check('oContact','1')" maxlength="10"  minlength="10" placeholder="Owner Contact No." type="text" class="form-control input-sm" name="oContact" id="oContact"></td>
                               </tr>
                               <tr>
                                   <td>Owner Contact No 2.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{$manufacturer->owner !=null ? $manufacturer->owner->contact1 :'' }}"  onblur="checklength('oContact');" onkeyup="check('oContact','1')" maxlength="10"  minlength="10" placeholder="Owner Contact No." type="text" class="form-control input-sm" name="oContact1" id="oContact"></td>
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
                                   <td><input value="{{$manufacturer->manager !=null ? $manufacturer->manager->name :'' }}"  type="text" placeholder="Manager Name" class="form-control input-sm" name="cName" id="cName"></td>
                               </tr>
                               <tr>
                                   <td>Manager Email</td>
                                   <td>:</td>
                                   <td><input value="{{$manufacturer->manageer !=null ? $manufacturer->manager->email:''}}" placeholder="Manager Email" type="email" class="form-control input-sm" name="cEmail" id="cEmail" onblur="checkmail('cEmail')" ></td>
                               </tr>
                               <tr>
                                   <td>Manager Contact No 1.</td>
                                   <td>: <p class="pull-right">+91</p></td>
<td><input value="{{ $manufacturer->manager !=null ? $manufacturer->manager->contact :'' }}" onblur="checklength('cPhone');" id="cContact" onkeyup="check('cPhone','1')" placeholder="Manager Contact No." type="text" maxlength="10" class="form-control input-sm" name="cContact"></td>
                               </tr>
                               <tr>
                                   <td>Manager Contact No 2.</td>
                                   <td>: <p class="pull-right">+91</p></td>
<td><input value="{{ $manufacturer->manager !=null ? $manufacturer->manager->contact1 :'' }}" onblur="checklength('cPhone');" id="cContact" onkeyup="check('cPhone','1')" placeholder="Manager Contact No." type="text" maxlength="10" class="form-control input-sm" name="cContact1"></td>
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
                                   <td><input value="{{$manufacturer->sales !=null ? $manufacturer->sales->name : '' }}"  type="text" placeholder="Sales Contact Name" class="form-control input-sm" name="coName"></td>
                               </tr>
                               <tr>
                                   <td>Sales Contact Email</td>
                                   <td>:</td>
                                   <td><input value="{{ $manufacturer->sales !=null ? $manufacturer->sales->email :'' }}" placeholder="Sales Contact Email" type="email" class="form-control input-sm" name="coEmail" id="coEmail" onblur="checkmail('coEmail')"></td>
                               </tr>
                               <tr>
                                   <td>Sales Contact Contact No 1.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{ $manufacturer->sales !=null ?  $manufacturer->sales->contact :'' }}" onblur="checklength('coContact');" placeholder="Sales Contact Contact No." type="text" class="form-control input-sm" name="coContact" maxlength="10" id="coContact" onkeyup="check('coContact','1')"></td>
                               </tr>
                               <tr>
                                   <td>Sales Contact Contact No 2.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{$manufacturer->sales !=null ?  $manufacturer->sales->contact1 : ''}}" onblur="checklength('coContact');" placeholder="Sales Contact Contact No." type="text" class="form-control input-sm" name="coContact1" maxlength="10" id="coContact" onkeyup="check('coContact','1')"></td>
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
                                   <td><input id="prName" required type="text" placeholder="Procurement Name" class="form-control input-sm" name="prName" value="{{$manufacturer->proc !=null ? $manufacturer->proc->name :''}}"></td>
                               </tr>
                               <tr>
                                   <td>Procurement Email</td>
                                   <td>:</td>
                                   <td><input value="{{$manufacturer->proc !=null ? $manufacturer->proc->email :''}}" placeholder="Procurement Email" type="email" class="form-control input-sm" name="pEmail" id="pEmail" onblur="checkmail('pEmail')" ></td>
                               </tr>
                               <tr>
                                   <td>Procurement Contact No 1.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{$manufacturer->proc !=null ? $manufacturer->proc->contact :''}}" required  minlength=10 onblur="checklength('prPhone');" required placeholder="Procurement Contact No." type="text" class="form-control input-sm" name="prPhone" maxlength="10" id="prPhone" onkeyup="check('prPhone','1')"></td>
                               </tr>
                               <tr>
                                   <td>Procurement Contact No 2.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{$manufacturer->proc !=null ? $manufacturer->proc->contact1 : ''}}"   minlength=10 onblur="checklength('prPhone');" placeholder="Procurement Contact No." type="text" class="form-control input-sm" name="prPhone1" maxlength="10" id="prPhone" onkeyup="check('prPhone','1')"></td>
                               </tr>

                           </table>
</div>

                        <table class="table table-responsive" >
                          <tr>

                            <td>Remarks</td>
                            <td>:</td>
                            <td>
                          <textarea style="resize: none;" class="form-control" placeholder="Remarks (Optional)"  name="remarks" value="{{$manufacturer->remarks}}">{{$manufacturer->remarks}}</textarea>
                          </td>
                        </tr>
                        </table>
                                            @endforeach

                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-success form-control">Save</button>
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
@endif
@endsection