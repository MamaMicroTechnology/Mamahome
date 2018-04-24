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
                  <small id="currentTime" class="pull-right">
                    Listed on {{ date('d-m-Y h:i:s A', stetrtotime($projectdetails->created_at)) }}
                  </small><br>
                </div>
                <div class="panel-body">
                    <center>
                      <label>Project Details</label><br>
                       @if(Auth::check())
                        @if(Auth::user()->group_id != 7 && Auth::user()->group_id != 6)
                      <label>{{ $username != null ? 'Listed by '.$username : '' }}</label><br>
                      @endif
                      @endif
                    </center>
                    @if($projectdetails->quality == NULL)
                      <form method="POST" action="{{ URL::to('/') }}/markProject">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $id }}">
                      </form>
                      @else
                      {{ $projectdetails->quality }}
                      @endif
                    <br>
                   <form method="POST" action="{{ URL::to('/') }}/{{ $projectdetails->project_id }}/updateProject" enctype="multipart/form-data">
                    <div id="first">
                    {{ csrf_field() }}
                           <table class="table">
                           @if(Auth::user()->group_id != 7 && Auth::user()->group_id != 6)
                            <tr>
                              <td>Update status</td>
                              <td>:</td>
                              <td>
                                @if($updater != null)
                                  Last update was on {{ date('d-m-Y h:i:s A',strtotime($projectdetails->updated_at)) }} by {{ $updater->name }}
                                @endif
                              </td>
                            </tr>
                            @endif
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
                                        <label>Longitude:</label>
                                        <input disabled value="{{ $projectdetails->siteaddress->longitude }}" placeholder="Longitude" class="form-control input-sm"  type="text" name="longitude" value="" id="longitude">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Latitude:</label>
                                        <input disabled value="{{ $projectdetails->siteaddress->latitude }}" placeholder="Latitude" class="form-control input-sm"  type="text" name="latitude" value="" id="latitude">
                                    </div>
                                   </td>
                               </tr>
                               <tr>
                                   <td>Road Name / Road No.</td>
                                   <td>:</td>
                                   <td><input id="road" value="{{ $projectdetails->road_name }}"  type="text" placeholder="Road Name / Road No." class="form-control input-sm" name="rName"></td>
                               </tr>
                               <tr>
                                   <td>Road Width</td>
                                   <td>:</td>
                                   <td><input id="road" value="{{ $projectdetails->road_width }}"  type="text" placeholder="Road Width" class="form-control input-sm" name="rWidth"></td>
                               </tr>
                               <tr>
                                   <td>Full Address</td>
                                   <td>:</td>
                                   <td><input id="road" value="{{ $projectdetails->siteaddress->address }}" type="text" placeholder="Full Address" class="form-control input-sm" name="address"></td>
                               </tr>
                               <tr>
                                <?php
                                  $type = explode(", ",$projectdetails->construction_type);
                                ?>
                                 <td>Construction Type</td>
                                 <td>:</td>
                                 <td>
                                    <label required class="checkbox-inline">
                                      <input {{ in_array('Residential', $type) ? 'checked': ''}} id="constructionType1" name="constructionType[]" type="checkbox" value="Residential">Residential
                                    </label>
                                    <label required class="checkbox-inline">
                                      <input {{ in_array('Commercial', $type) ? 'checked': ''}} id="constructionType2" name="constructionType[]" type="checkbox" value="Commercial">Commercial
                                    </label>
                                 </td>
                               </tr>
                               <tr>
                                 <td>Interested in RMC</td>
                                 <td>:</td>
                                 <td>
                                     <div class="radio">
                                      <label><input {{ $projectdetails->interested_in_rmc == "Yes" ? 'checked' : '' }} required value="Yes" type="radio" name="rmcinterest">Yes</label>
                                    </div>
                                    <div class="radio">
                                      <label><input {{ $projectdetails->interested_in_rmc == "No" ? 'checked' : '' }} required value="No" type="radio" name="rmcinterest">No</label>
                                    </div>
                                 </td>
                               </tr>
                               <tr>
                                 <td>Type of Contract ? </td>
                                  <td>:</td>
                                  <td>
                                   <select class="form-control" name="contract" id="contract" required>
                                      <option value="" disabled selected>--- Select ---</option>
                                      <option {{ $projectdetails->contract == "Labour Contract" ? 'selected' : ''}} value="Labour Contract">Labour Contract</option>
                                      <option {{ $projectdetails->contract == "Material Contract" ? 'selected' : ''}} value="Material Contract">Material Contract</option>
                                      <option {{ $projectdetails->contract == "None" ? 'selected' : ''}} value="None">None</option>
                                  </select>
                                  </td>
                               </tr>
                               <tr>
                                 <td>Sub Ward</td>
                                 <td>:</td>
                                 <td>{{ $projectward }}</td>
                               </tr>
                               <!-- <tr>
                                   <td>Municipal Approval</td>
                                   <td>:</td>
                                   <td><input type="file" accept="image/*" class="form-control input-sm" name="mApprove"></td>
                               </tr> -->
                               <tr>
                                   <td>Govt. Approvals<br>(Municipal, BBMP, etc)</td>
                                   <td>:</td>
                                   <td>
                                    <input oninput="fileUpload()" id="oApprove" multiple type="file" accept="image/*" class="form-control input-sm" name="oApprove[]">
                                  </td>
                               </tr>
                               <tr>
                                <?php
                                  $statuses = explode(", ", $projectdetails->project_status);
                                ?>
                                   <td>Project Status</td>
                                   <td>:</td>
                                   <td>
                                       <table class="table table-responsive">
                                        <tr>
                                          <td>
                                            <label class="checkbox-inline">
                                              <input {{ in_array('Planning', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Planning">Planning
                                            </label>
                                          </td>
                                          <td>
                                             <label class="checkbox-inline">
                                              <input {{ in_array('Digging', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Digging">Digging
                                            </label>
                                          </td>
                                          <td>
                                             <label class="checkbox-inline">
                                              <input {{ in_array('Foundation', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Foundation">Foundation
                                            </label>
                                          </td>
                                          <td>
                                             <label class="checkbox-inline">
                                              <input {{ in_array('Pillars', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Pillars">Pillars
                                            </label>
                                          </td>
                                          <td>
                                             <label class="checkbox-inline">
                                              <input {{ in_array('Walls', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Walls">Walls
                                            </label>
                                          </td>
                                        </tr>
                                        <tr>
                                         <td>
                                          <label class="checkbox-inline">
                                          <input {{ in_array('Roofing', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Roofing">Roofing
                                        </label>
                                        </td>
                                         <td>
                                          <label class="checkbox-inline">
                                          <input {{ in_array('Electrical', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Electrical">Electrical
                                        </label>
                                        </td>
                                         <td>
                                          <label class="checkbox-inline">
                                          <input {{ in_array('Plumbing', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Plumbing">Plumbing
                                        </label>
                                        </td>
                                         <td>
                                          <label class="checkbox-inline">
                                          <input {{ in_array('Plastering', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Plastering">Plastering
                                        </label>
                                        </td>
                                         <td>
                                          <label class="checkbox-inline">
                                          <input {{ in_array('Flooring', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Flooring">Flooring
                                        </label>
                                        </td>
                                        </tr>
                                        <tr>
                                         <td>
                                          <label class="checkbox-inline">
                                          <input {{ in_array('Carpentry', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Carpentry">Carpentry
                                        </label>
                                        </td>
                                         <td>
                                          <label class="checkbox-inline">
                                          <input {{ in_array('Paintings', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Paintings">Paintings
                                        </label>
                                        </td>
                                         <td>
                                          <label class="checkbox-inline">
                                          <input {{ in_array('Fixtures', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Fixtures">Fixtures
                                        </label>
                                        </td>
                                         <td>
                                          <label class="checkbox-inline">
                                          <input {{ in_array('Completion', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Completion">Completion
                                        </label>
                                        </td>
                                        <td></td>
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
                                          <label>Basement</label>
                                          <input value="{{ $projectdetails->basement }}" onkeyup="check('basement')" id="basement" name="basement" type="number" autocomplete="off" class="form-control input-sm" placeholder="Basement">
                                        </div>
                                        <div class="col-md-2">
                                          <br>
                                          <b style="font-size: 20px; text-align: center">+</b>
                                        </div>
                                      <div class="col-md-3">
                                        <label>Floor</label>
                                        <input value="{{ $projectdetails->ground }}" oninput="check('ground')" autocomplete="off" name="ground" id="ground" type="number" class="form-control input-sm" placeholder="Floor">
                                      </div>
                                      <div class="col-md-3">
                                        <br>
                                        <p id="total">
                                          B({{ $projectdetails->basement }}) + G + {{ $projectdetails->ground }} = {{ $projectdetails->basement + $projectdetails->ground + 1 }}
                                        </p>
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
                                <tr>
                               
                                 <td>Budget Type</td>
                                 <td>:</td>
                                 <td>
                                    <label required class="checkbox-inline">
                                      <input {{ in_array('strulural', $type) ? 'checked': ''}} id="constructionType1" name="budgetType" type="checkbox" value="Residential">Strulural Budget
                                    </label>
                                    <label required class="checkbox-inline">
                                      <input {{ in_array('finishing', $type) ? 'checked': ''}} id="constructionType2" name="budgetType" type="checkbox" value="Commercial">Finishing Budget
                                    </label>
                                 </td>
                               </tr>
                                   <td>Total Budget (in Cr.)</td>
                                   <td>:</td>
                                   <td>
                                    <div class="col-md-4">
                                      <input id="budget" value="{{ $projectdetails->budget }}"  placeholder="Budget" type="text" class="form-control input-sm" onkeyup="check('budget')" name="budget">
                                    </div>
                                    <div class="col-md-8">
                                      Budget (per sq.ft) :
                                      @if($projectdetails->project_size != 0)
                                       {{ round((10000000 * $projectdetails->budget)/$projectdetails->project_size,3) }}
                                      @endif
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
                                     <small id="currentTime" class="pull-right">
                    Updated on {{ date('d-m-Y h:i:s A', strtotime($projectdetails->created_at)) }}</small><br>
                    @if(Auth::check())
                       
                      @endif
                  <br>

                                   </td>
                               </tr>
                               <tr>
                                    <td>Room Types</td>
                                    <td>:</td>
                                    <td>
                                        <table id="bhk" class="table table-responsive">
                                            <tr>
                                              <td>
                                                <select id="floorNo" name="floorNo[]" class="form-control">
                                                  <option value="">--Floor--</option>
                                                    <option value="Ground">Ground</option>
                                                  @for($i = 1;$i<=$projectdetails->project_type;$i++)
                                                    <option value="{{ $i }}">Floor {{ $i }}</option>
                                                  @endfor
                                                </select>
                                              </td>
                                                <td>
                                                    @if($projectdetails->construction_type == "Commercial")
                                                    <input type="text" name="roomType[]" readonly value="Commercial Floor">
                                                    @elseif($projectdetails->construction_type == "Residential")
                                                    <select name="roomType[]" id="" class="form-control">
                                                        <option value="1RK">1RK</option>
                                                        <option value="1BHK">1BHK</option>
                                                        <option value="2BHK">2BHK</option>
                                                        <option value="3BHK">3BHK</option>
                                                    </select>
                                                    @else
                                                    <select name="roomType[]" id="" class="form-control">
                                                        <option value="">--Select--</option>
                                                        <option value="Commercial Floor">Commercial Floor</option>
                                                        <option value="1RK">1RK</option>
                                                        <option value="1BHK">1BHK</option>
                                                        <option value="2BHK">2BHK</option>
                                                        <option value="3BHK">3BHK</option>
                                                    </select>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="text" name="number[]" class="form-control" placeholder="{{ $projectdetails->construction_type == 'Commercial'? "Floor Size" : "No. of House" }}" >
                                                </td>
                                                </tr>
                                            <tr>
                                                <td colspan=3>
                                                    <button onclick="addRow();" type="button" class="btn btn-primary form-control">Add more</button>
                                                </td>
                                            </tr>
                                            @foreach($roomtypes as $roomtype)
                                            <tr>
                                              <td>Floor {{ $roomtype->floor_no }}</td>
                                              <td>{{ $roomtype->room_type }}</td>
                                              <td>{{ $roomtype->no_of_rooms }}</td>
                                              <td>
                                                <button type="button" data-toggle="modal" data-target="#delete{{ $roomtype->id }}" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button>
                                                <!-- Modal -->
                                                <div id="delete{{ $roomtype->id }}" class="modal fade" role="dialog">
                                                  <div class="modal-dialog modal-sm">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Confirm delete</h4>
                                                      </div>
                                                      <div class="modal-body">
                                                        <p>Are you sure you want to delete?</p>
                                                      </div>
                                                      <div class="modal-footer">
                                                        <a class="pull-left btn btn-danger" href="{{ URL::to('/') }}/deleteRoomType?roomId={{ $roomtype->id }}">Yes</a>
                                                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">No</button>
                                                      </div>
                                                    </div>

                                                  </div>
                                                </div>
                                              </td>
                                            </tr>
                                            @endforeach
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
                                   <td><input value="{{ $projectdetails->ownerdetails != null ? $projectdetails->ownerdetails->owner_name : '' }}" type="text" placeholder="Owner Name" class="form-control input-sm" id="oName" name="oName"></td>
                               </tr>
                               <tr>
                                   <td>Owner Email</td>
                                   <td>:</td>
                                   <td><input value="{{ $projectdetails->ownerdetails != null ? $projectdetails->ownerdetails->owner_email : '' }}" placeholder="Owner Email" type="email" class="form-control input-sm" onblur="checkmail('oEmail')" id="oEmail" name="oEmail"></td>
                               </tr>
                               <tr>
                                   <td>Owner Contact No.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input value="{{ $projectdetails->ownerdetails != null ? $projectdetails->ownerdetails->owner_contact_no : '' }}" onkeyup="check('oContact')" placeholder="Owner Contact No." type="text" class="form-control input-sm" maxlength="10" minlength="10" name="oContact" id="oContact"></td>
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
                                <select id="quality" onchange="fake()" class="form-control" name="quality">
                                    <option value="null" disabled selected>--- Select ---</option>
                                    <option {{ $projectdetails->quality == "Genuine" ? 'selected':''}} value="Genuine">Genuine</option>
                                    <option {{ $projectdetails->quality == "Fake" ? 'selected':''}} value="Fake">Fake</option>
                                </select>
                            </td>
                        </tr>
                        
                        </table>
                            <textarea class="form-control" placeholder="Remarks (Optional)" name="remarks">{{ $projectdetails->remarks }}</textarea><br>
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
  function fake(){
    $check = document.getElementById('quality').value;
    if($check == "Fake"){
      document.getElementById('contract').innerHTML = "<option value='None'>Fake</option>";
    }
  }
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
      var opts = "<option value=''>--Floor--</option>";
      if(!isNaN(basement) && !isNaN(ground)){
        var floor    = 'B('+basement+')' + ' + G + ('+ground+') = ';
        sum          = basement+ground+1;
        floor       += sum;
      
        if(document.getElementById("total").innerHTML != null)
        {
          document.getElementById("total").innerHTML = floor;
          for(var i = 1; i<=sum; i++){
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
</script>
<!--This line by Siddharth -->

<script type="text/javascript">
  $(document).ready(function(){
      count();
  });
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
  var ctype1 = document.getElementById('constructionType1');
        var ctype2 = document.getElementById('constructionType2');
        var rmc = document.getElementById('rmc');
        var rmc2= document.getElementById('rmc2');
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
          }else if(document.getElementById("basement").value == ""){
            window.alert("You have not entered basement");
          }else if(document.getElementById("ground").value == ""){
            window.alert("You have not entered floor");
          }else if(document.getElementById("pSize").value == ""){
            window.alert("You have not entered Project Size");
          }else if(document.getElementById("budget").value == ""){
            window.alert("You have not entered Budget");
          }else{
            if(ctype1.checked == true && ctype2.checked == true){
                countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 2;
            }else if(ctype1.checked == true || ctype2.checked == true){
                countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 1;
            }else{
                countinput = document.querySelectorAll('input[type="checkbox"]:checked').length;
            }
            if(countinput == 0){
                window.alert("Select at least one project status");
            }else{
                document.getElementById("first").className = "hidden";
                document.getElementById("second").className = "";
                current = "second";
            }
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
          cell1.innerHTML = "<input name=\"roomType[]\" readonly value='Commercial Floor' id=\"\" class=\"form-control\">";
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
      var countinput;
      if(ctype1.checked == true && ctype2.checked == true){
        countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 2;
      }else if(ctype1.checked == true || ctype2.checked == true){
        countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 1;
      }else{
        countinput = document.querySelectorAll('input[type="checkbox"]:checked').length;
      }
      if(countinput == 5){
        $('input[type="checkbox"]:not(:checked)').attr('disabled',true);
        $('#constructionType1').attr('disabled',false);
        $('#constructionType2').attr('disabled',false);
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
