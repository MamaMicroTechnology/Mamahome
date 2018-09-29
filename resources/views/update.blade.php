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
                 
                  @else
                  Update Project&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  @endif
                   <a href="javascript:history.back()" class="btn btn-sm btn-danger btn-sm pull-right">Back</a>
                  @if(session('Success'))
                    <p class="alert-success pull-right">{{ session('Success') }}</p>
                  @endif
                 <small id="currentTime">
                    Listed On {{ date('d-m-Y h:i:s A', strtotime($projectdetails->created_at)) }}
                  </small>
                </div>
                <div class="panel-body">
                    <center>
                      <label id="headingPanel">Project Details</label><br>
                       @if(Auth::check())
                        @if(Auth::user()->group_id != 7 && Auth::user()->group_id != 6 && Auth::user()->group_id != 11)
                      <label>{{ $username != null ? 'Listed By '.$username : '' }}</label><br>
                      @endif
                      @endif
                    </center>
                    @if($projectdetails->quality == NULL)
                      <form method="POST" action="{{ URL::to('/') }}/markProject">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $id }}">
                      </form>
                      @else
                      <label style="font-size: 14px">Quality:</label>
                      {{ $projectdetails->quality }}
                      @endif
                    </center>
                      
                   <form method="POST" id="sub" action="{{ URL::to('/') }}/{{ $projectdetails->project_id }}/updateProject" enctype="multipart/form-data">
                    <input type="hidden" name="subward" value="{{$projectdetails->sub_ward_id}}">
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
                                        <input disabled value="{{ $projectdetails->siteaddress != null ? $projectdetails->siteaddress->longitude : ""  }}"  class="form-control input-sm"  type="text" name="longitude" value="" id="longitude">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Latitude:</label>
                                        <input disabled value="{{ $projectdetails->siteaddress != null ? $projectdetails->siteaddress->latitude : " " }}"  class="form-control input-sm"  type="text" name="latitude" value="" id="latitude">
                                    </div>
                                   </td>
                               </tr>
                               <tr>
                                   <td>Road Name/Road No./Landmark</td>
                                   <td>:</td>
                                   <td><input id="road" value="{{ $projectdetails->road_name }}"  type="text" placeholder="Road Name / Road No." class="form-control input-sm" name="rName"></td>
                               </tr>
                               <tr>
                                   <td>Road Width</td>
                                   <td>:</td>
                                   <td><input id="rWidth" onkeyup="check('rWidth')" value="{{ $projectdetails->road_width }}"  type="text" placeholder="Road Width" class="form-control input-sm" name="rWidth" pattern="^[0-9]*$"></td>
                               </tr>
                                 <tr>
                                   <td>Full Address</td>
                                   <td>:</td>
                                   @if($projectdetails->siteaddress ==null)
                                   <td style="color:red;" >This Project Has No SiteAddress, Kindly Contact MAMA MICRO TECHNOLOGY<input  disabled id="road" value=" " type="text" placeholder="Full Address" class="form-control input-sm disable" name="address" ></td>
                                   @else
                                   <td><input  disabled id="road" value="{{ $projectdetails->siteaddress->address }}" type="text" placeholder="Full Address" class="form-control input-sm disable" name="address"></td>
                                   @endif
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
                                    </label><br>
                                  <div id="autoUpdate" class="autoUpdate" style="display:none;">
                                 <label required class="checkbox-inline" style="color:#42c3f3;"><input  id="constructionType1" name="apart[]" type="checkbox" value="Apartments">Apartments </label>

                                    <label required class="checkbox-inline" style="color:#42c3f3;"><input id="constructionType2" name="apart[]" type="checkbox" value="Duplex">Duplex</label> 

                                     <label required class="checkbox-inline" style="color:#42c3f3;"><input id="constructionType2"  name="apart[]" type="checkbox" value="villas">Indepnedent villas</label> 
                        </div>
                                 </td>
                               </tr>
                               <script type="text/javascript">
                                 $(document).ready(function(){
                                      $('#constructionType1').change(function(){
                                      if(this.checked)
                                      $('#autoUpdate').fadeIn('slow');
                                      else
                                      $('#autoUpdate').fadeOut('slow');

                                      });
                                      });
                               </script>
                               <tr>
                                 </td>
                               </tr>
                               <tr>
                                 <td>Interested In RMC ?</td>
                                 <td>:</td>
                                 <td>
                                     
                                      <label><input id="rmc" {{ $projectdetails->interested_in_rmc == "Yes" ? 'checked' : '' }} required value="Yes" type="radio" name="rmcinterest">Yes</label>
                                   <span>&nbsp;&nbsp;&nbsp;  </span>
                                  
                                     <label><input id="rmc2" {{ $projectdetails->interested_in_rmc == "No" ? 'checked' : '' }} required value="No" type="radio" name="rmcinterest">No</label> 
                                   <span>&nbsp;&nbsp;&nbsp;  </span>
                                     <label><input id="rmc3" {{ $projectdetails->interested_in_rmc == "None" ? 'checked' : '' }} required value="None" type="radio" name="rmcinterest">None</label> 
                                   
                                 </td>
                               </tr>
                               <tr>
                                 <td>Interested In Bank Loans ?</td>
                                 <td>:</td>
                                 <td>
                                    
                                      <label><input id="loan1" {{ $projectdetails->interested_in_loan == "Yes" ? 'checked' : '' }} required value="Yes" type="radio" name="loaninterest">Yes</label>
                                    <span>&nbsp;&nbsp;&nbsp;  </span>
                                      <label><input id="loan2" {{ $projectdetails->interested_in_loan == "No" ? 'checked' : '' }} required value="No" type="radio" name="loaninterest">No</label>
                                   <span>&nbsp;&nbsp;&nbsp;  </span>
                                      <label><input id="loan3" {{ $projectdetails->interested_in_loan == "None" ? 'checked' : '' }} required value="None" type="radio" name="loaninterest">None</label>
                                   
                                 </td>
                               </tr>
                              <tr>
                                 <td>Interested In Kitchen Cabinates and Wardrobes ?</td>
                                 <td>:</td>
                                 <td>
                                    
                                      <label><input id="dandw1" {{ $projectdetails->interested_in_doorsandwindows == "Kitchen_Yes" ? 'checked' : '' }} required value="Kitchen_Yes" type="radio" name="dandwinterest">Yes</label>
                                   <span>&nbsp;&nbsp;&nbsp;  </span>
                                      <label><input id="dandw2" {{ $projectdetails->interested_in_doorsandwindows == "Kitchen_No" ? 'checked' : '' }} required value="Kitchen_No" type="radio" name="dandwinterest">No</label>
                                   <span>&nbsp;&nbsp;&nbsp;  </span>
                                      <label><input id="dandw3" {{ $projectdetails->interested_in_doorsandwindows == "Kitchen_None" ? 'checked' : '' }} required value="Kitchen_None" type="radio" name="dandwinterest">None</label>
                                 </td>
                               </tr>
                               <tr>
                                 <td>Interested In Brila Super / Ultratech Products?</td>
                                 <td>:</td>
                                 <td>
                                    
                                      <label><input id="bs1" {{ $projectdetails->brilaultra == "Yes" ? 'checked' : '' }} required value="Yes" type="radio" name="brila">Yes</label>
                                   <span>&nbsp;&nbsp;&nbsp;  </span>
                                      <label><input id="bs2" {{ $projectdetails->brilaultra == "No" ? 'checked' : '' }} required value="No" type="radio" name="brila">No</label>
                                   <span>&nbsp;&nbsp;&nbsp;  </span>
                                      <label><input id="bs3" {{ $projectdetails->brilaultra == "None" ? 'checked' : '' }} required value="None" type="radio" name="brila">None</label>
                                 </td>
                               </tr>
                               <tr>
                                 <td>Interested In Home Automation ?</td>
                                 <td>:</td>
                                 <td>
                                    
                                      <label><input id="home1" {{ $projectdetails->automation == "Yes" ? 'checked' : '' }} required value="Yes" type="radio" name="automation">Yes</label>
                                    <span>&nbsp;&nbsp;&nbsp;  </span>
                                      <label><input id="home2" {{ $projectdetails->automation == "No" ? 'checked' : '' }} required value="No" type="radio" name="automation">No</label>
                                  <span>&nbsp;&nbsp;&nbsp;  </span>
                                      <label><input id="home3" {{ $projectdetails->automation == "None" ? 'checked' : '' }} required value="None" type="radio" name="automation">None</label>
                                   
                                 </td>
                               </tr>
                               <tr>
                                 <td>Interested In Premium Products ?</td>
                                 <td>:</td>
                                 <td>
                                     
                                      <label><input id="premium1" {{ $projectdetails->interested_in_premium == "Yes" ? 'checked' : '' }} required value="Yes" type="radio" name="premium">Yes</label>
                                    <span>&nbsp;&nbsp;&nbsp;  </span>
                                      <label><input id="premium2" {{ $projectdetails->interested_in_premium == "No" ? 'checked' : '' }} required value="No" type="radio" name="premium">No</label>
                                    <span>&nbsp;&nbsp;&nbsp;  </span>
                                      <label><input id="premium3" {{ $projectdetails->interested_in_premium == "None" ? 'checked' : '' }} required value="None" type="radio" name="premium">None</label>
                                    
                                 </td>
                               </tr>
                               <tr>
                                 <td>Type Of &nbsp;
                                  Contract ? </td>
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
              <td>Follow Up?</td>
              <td>:</td>
              <td>
                  <div class="radio">
                                <label><input id="f1" {{ $projectdetails->followup == 'No'?'checked':'' }} type="radio"  name="follow" value="No">No</label>
                              </div>
                              <div class="radio">
                                <label><input  {{ $projectdetails->followup == 'Yes'?'checked':'' }} type="radio" name="follow" value="Yes">Yes</label>
                              </div>
             </td>

          </tr>
          <tr>
            <td> Follow Up Date</td>
            <td>:</td>
            <td ><input style="width:50%;"  type="date" name="follow_up_date" id="date" data-provide="datepicker" class="form-control" /></td>


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
                                          <div class="col-md-3" >
                                            <label class="checkbox-inline">
                                              <input {{ in_array('Planning', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Planning" style="width: 33px;" ><span>&nbsp;&nbsp;&nbsp;</span>Planning
                                            </label>
                                          
                                             <label class="checkbox-inline">
                                              <input {{ in_array('Digging', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Digging">Digging
                                            </label>
                                         
                                             <label class="checkbox-inline">
                                              <input {{ in_array('Foundation', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Foundation">Foundation
                                            </label>
                                         
                                             <label class="checkbox-inline">
                                              <input {{ in_array('Pillars', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Pillars">Pillars
                                            </label>
                                          
                                             <label class="checkbox-inline">
                                              <input {{ in_array('Walls', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Walls">Walls
                                            </label>
                                          </div>
                                       <div class="col-md-3">
                                          <label class="checkbox-inline">
                                          <input {{ in_array('Roofing', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Roofing" style="width: 33px;"><span>&nbsp;&nbsp;&nbsp;</span>Roofing
                                        </label>
                                       
                                          <label class="checkbox-inline">
                                          <input {{ in_array('Electrical', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Electrical">Electrical
                                        </label>
                                      
                                          <label class="checkbox-inline">
                                          <input {{ in_array('Plumbing', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Plumbing">Plumbing
                                        </label>
                                      
                                          <label class="checkbox-inline">
                                          <input {{ in_array('Plastering', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Plastering">Plastering
                                        </label>
                                          <label class="checkbox-inline">
                                          <input {{ in_array('Flooring', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Flooring">Flooring
                                        </label>
                                      </div>

                                        <div class="col-md-3">
                                          <label class="checkbox-inline">
                                          <input {{ in_array('Carpentry', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Carpentry" style="width: 33px;"><span>&nbsp;&nbsp;&nbsp;</span>Carpentry
                                        </label>
                                       
                                          <label class="checkbox-inline">
                                          <input {{ in_array('Paintings', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Paintings">Paintings
                                        </label>
                                       
                                          <label class="checkbox-inline">
                                          <input {{ in_array('Fixtures', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Fixtures">Fixtures
                                        </label>
                                        
                                          <label class="checkbox-inline">
                                          <input {{ in_array('Completion', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Completion">Completion
                                        </label>
                                        
                                          <label class="checkbox-inline">
                                          <input {{ in_array('Closed', $statuses) ? 'checked': ''}} type="checkbox" onchange="count()" name="status[]" value="Closed">Closed
                                        </label>
                                       </div>
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
                                   <td>Plot Size</td>
                                   <td>:</td>
                                   <td>
                                    <div class="row">
                                        <div class="col-md-3">
                                          <label>Length</label>
                                          <input value="{{ $projectdetails->length }}" onkeyup="checkthis('length')" id="length" name="length" type="text" autocomplete="off" class="form-control input-sm" placeholder="Length">
                              
                                        </div>
                                        <div class="col-md-2">
                                          <b style="font-size: 20px; text-align: center">*</b>
                                        </div>
                                      <div class="col-md-3">
                                         <label>Breadth</label>
                                        <input value="{{ $projectdetails->breadth }}" onkeyup="checkthis('breadth');" autocomplete="off" name="breadth" id="breadth" type="text" class="form-control" placeholder="Breadth">
                                      </div>
                                      <div class="col-md-3">
                                        <p id="totalsize">
                                          L({{ $projectdetails->length }}) * B({{ $projectdetails->breadth }}) = {{ $projectdetails->length * $projectdetails->breadth}}
                                        </p>
                                      </div>
                                    </div>
                                    </td>
                               </tr>
                               <tr>
                                   <td>Project Size</td>
                                   <td>:</td>
                                   <td>
                                     <div class="col-md-4 pull-left">
                                    <input id="pSize" value="{{ $projectdetails->project_size }}"  placeholder="Project Size" type="text" onkeyup="check('pSize')" class="form-control input-sm" name="pSize">
                                  </div>
                                  <div class="col-md-8 alert-success pull-right" id="pSizeTag" style="font-size:12px;"></div>
                                  </td>
                               </tr>
                                <tr>
                               
                                 <td>Budget Type</td>
                                 <td>:</td>
                                 <td>
                                    <label required class="checkbox-inline">
                                      <input {{ $projectdetails->budgetType =="Structural" ? 'checked': ''}}  id="constructionType3" name="budgetType" type="radio" value="Structural">Structural Budget
                                    </label>
                                    <label required class="checkbox-inline">
                                      <input {{ $projectdetails->budgetType == "Finishing" ? 'checked': ''}}  id="constructionType4" name="budgetType" type="radio" value="Finishing">Finishing Budget
                                    </label>
                                 </td>
                               </tr>
                               <tr>
                                   <td>Total Budget (In Cr.)</td>
                                   <td>:</td>
                                   <td>
                                    <div class="col-md-4">
                                      <input id="budget" value="{{ $projectdetails->budget }}"  placeholder="Budget In Crores" type="text" class="form-control input-sm" onkeyup="check('budget')" name="budget">
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
                                    <td> <input id="pImage" type="file" oninput="fileuploadimage()" onchange="validateFileType()" accept="image/*" class="form-control input-sm" name="pImage[]" multiple><br>
                                       
                                          @if($projectdetails->updated_by == Null || $projectdetails->updated_by != Null)
                                          <?php
                                               $images = explode(",", $projectdetails->image);
                                               ?>
                                             
                                             <div class="row">

                                                 @for($i = 0; $i < count($images); $i++)
                                                     <div class="col-md-3">
                                                          <img height="350" width="350" id="project_img" src="{{ URL::to('/') }}/public/projectImages/{{ $images[$i] }}" class="img img-thumbnail">
                                                     </div>
                                                 @endfor
                                              </div>
                                            @endif
                                            <br>
                                             @foreach($projectimages as $projectimage)
                                             @if($projectimage->project_id != Null )
                                            
                                                  <?php
                                                     $images = explode(",", $projectimage->image);
                                                    ?>
                                                     Project Status : {{ $projectimage->project_status}}
                                                   <div class="row">
                                                       @for($i = 0; $i < count($images); $i++)
                                                           <div class="col-md-3">
                                                                <img height="350" width="350" id="project_img" src="{{ URL::to('/') }}/public/projectImages/{{ $images[$i] }}" class="img img-thumbnail">
                                                           </div>
                                                       @endfor
                                                    </div>
              
                                                @endif
                                              @endforeach
                                   </td>
                               </tr>
                               <tr>
                                 <td>Image Updated On</td>
                                 <td>:</td>
                                 
                                  @if($projectupdate == null)
                                  <td>{{ date('d-m-Y h:i:s A', strtotime($projectdetails->created_at))}}</td>
                                  @else
                                      <td>{{ date('d-m-Y h:i:s A', strtotime($projectupdate))}}</td>
                                  @endif
                                 
                                 
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
                                                  @for($i = $projectdetails->basement; $i>0; $i--)
                                                    <option value="{{ $i }}">Base {{ $i }}</option>
                                                  @endfor
                                                    <option value="Ground">Ground</option>
                                                   @for($i = 1;$i<=$projectdetails->ground;$i++)
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
                                                        <option value="4BHK">4BHK</option>
                                                        <option value="5BHK">5BHK</option>
                                                    </select>
                                                    @else
                                                    <select name="roomType[]" id="" class="form-control">
                                                        <option value="">--Select--</option>
                                                        <option value="Commercial Floor">Commercial Floor</option>
                                                        <option value="1RK">1RK</option>
                                                        <option value="1BHK">1BHK</option>
                                                        <option value="2BHK">2BHK</option>
                                                        <option value="3BHK">3BHK</option>
                                                        <option value="4BHK">4BHK</option>
                                                        <option value="5BHK">5BHK</option>
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

                                              <td>{{ $roomtype->floor_no }}</td>
                                              <td>{{ $roomtype->room_type }}</td>
                                              <td>{{ $roomtype->no_of_rooms }}</td>
                                              
                                              <td>
                                                <button type="button" data-toggle="modal" data-target="#delete{{ $roomtype->id }}" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button><br><br>
                                          
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
                      

<button type="button" style="width: 100%;font-size: 20px;" class="btn btn-sm">Customer Details</button>
<div class="tab" style="overflow: hidden;
    border: 1px solid #ccc;
    background-color: #337ab7;
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
     color:white;" class="tablinks" onclick="openCity(event, 'contractor')">Contractor Details </button><br>
  <button type="button" style="background-color: inherit;
    
    border: none;
    outline: none;
    cursor: pointer;
    padding: 12px 16px;
    transition: 0.3s;
    font-size: 17px;
     color:white;" class="tablinks" onclick="openCity(event, 'consultant')">Consultant Details</button><br>
  <button type="button" style="background-color: inherit;
    
    border: none;
    outline: none;
    cursor: pointer;
    padding: 12px 16px;
    transition: 0.3s;
    font-size: 17px;
     color:white;" class="tablinks" onclick="openCity(event, 'site')">Site Engineer Details</button><br>
  <button type="button" style="background-color: inherit;
    
    border: none;
    outline: none;
    cursor: pointer;
    padding: 12px 16px;
    transition: 0.3s;
    font-size: 17px;
     color:white;" class="tablinks" onclick="openCity(event, 'procurement')">Procurement Details</button><br>

     <button type="button" style="background-color: inherit;
    
    border: none;
    outline: none;
    cursor: pointer;
    padding: 12px 16px;
    transition: 0.3s;
    font-size: 17px;
     color:white;" class="tablinks" onclick="openCity(event, 'builder')">Builder Details</button>
</div>

<div id="owner" class="tabcontent" style="display: none;padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;">
    <br>
  <center><label>Owner Details</label></center>
  <br>
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
<div id="contractor" class="tabcontent" style="display: none;padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;"><br>
   <center><label>Contractor Details</label></center>
   <br>
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
<div id="consultant" class="tabcontent" style="display: none;padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;"><br>
  <center><label>Consultant Details</label></center><br>
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
<div id="site" class="tabcontent" style="display: none;padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;"><br>
   <center><label>Site Engineer Details</label></center><br>
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
<div id="procurement" class="tabcontent" style="display: none;padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;"><br>
   <center><label>Procurement Details</label></center><br>
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
                      </div><br>


   <div id="builder" class="tabcontent" style="display: none;padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;"><br>
   <center><label>Builder Details</label></center><br>
                          <table class="table">
                               <tr>
                                   <td>Builder Name</td>
                                   <td>:</td>
                                   <td><input id="bName" value="{{ $projectdetails->builders != null ? $projectdetails->builders->builder_name: '' }}"  type="text" placeholder="Builder Name" class="form-control input-sm" id="pName" name="bName"></td>
                               </tr>
                               <tr>
                                   <td>Builder Email</td>
                                   <td>:</td>
                                   <td><input id="pEmail" value="{{ $projectdetails->builders != null ? $projectdetails->builders->builder_email: '' }}" placeholder="Builder Email" type="Email" class="form-control input-sm" id="pEmail" name="bEmail"></td>
                               </tr>
                               <tr>
                                   <td>Builder Contact No.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td><input id="prPhone" value="{{ $projectdetails->builders != null ? $projectdetails->builders->builder_contact_no: '' }}"  placeholder="Builder Contact No." maxlength="10" minlength="10" type="text" class="form-control input-sm" name="bPhone" id="pContact"></td>
                               </tr>
                           </table>
                      </div><br>



                      <tr id="quepanelright-{{$projectdetails->project_id}}">
                                    <td>Questions</td><br>
                                    <td>
                                        <select style="width: 100%" class="form-control" id="select-{{$projectdetails->project_id}}" name="qstn">-->
                                    <option disabled selected>--- Select ---</option>
                                    <option {{ $projectdetails->with_cont == 'NOT INTERESTED'? 'selected':'' }} value="NOT INTERESTED">NOT INTERESTED</option>
                                    <option {{ $projectdetails->with_cont == 'BUSY'? 'selected':'' }} value="BUSY">BUSY</option>
                                    <option {{ $projectdetails->with_cont == 'WRONG NO'? 'selected':'' }} value="WRONG NO">WRONG NO</option>
                                    <option {{ $projectdetails->with_cont == 'PROJECT CLOSED'? 'selected':'' }} value="PROJECT CLOSED">PROJECT CLOSED</option>
                                    <option {{ $projectdetails->with_cont == 'CALL BACK LATER'? 'selected':'' }} value="CALL BACK LATER">CALL BACK LATER</option>
                                    <option {{ $projectdetails->with_cont == 'THEY WILL CALL BACK WHEN REQUIRED'? 'selected':'' }} value="THEY WILL CALL BACK WHEN REQUIRED">THEY WILL CALL BACK WHEN REQUIRED</option>
                                    <option {{ $projectdetails->with_cont == 'CALL NOT ANSWERED'? 'selected':'' }} value="CALL NOT ANSWERED">CALL NOT ANSWERED</option>
                                    <option {{ $projectdetails->with_cont == 'FINISHING'? 'selected':'' }} value="FINISHING">FINISHING</option>
                                    <option {{ $projectdetails->with_cont == 'SWITCHED OFF'? 'selected':'' }} value="SWITCHED OFF">SWITCHED OFF</option>
                                    <option {{ $projectdetails->with_cont == 'SAMPLE REQUEST'? 'selected':'' }} value="SAMPLE REQUEST">SAMPLE REQUEST</option>
                                    <option {{ $projectdetails->with_cont == 'MATERIAL QUOTATION'? 'selected':'' }} value="MATERIAL QUOTATION">MATERIAL QUOTATION</option>
                                    <option {{ $projectdetails->with_cont == 'WILL FOLLOW UP AFTER DISCUSSION WITH OWNER'? 'selected':'' }} value="WILL FOLLOW UP AFTER DISCUSSION WITH OWNER">WILL FOLLOW UP AFTER DISCUSSION WITH OWNER</option>
                                    <option {{ $projectdetails->with_cont == 'DUPLICATE NUMBER'? 'selected':'' }} value="DUPLICATE NUMBER">DUPLICATE NUMBER</option>
                                    <option {{ $projectdetails->with_cont == 'NOT REACHABLE'? 'selected':'' }} value="NOT REACHABLE">NOT REACHABLE</option>
                                    <option {{ $projectdetails->with_cont == 'THEY HAVE REGULAR SUPPLIERS'? 'selected':'' }} value="THEY HAVE REGULAR SUPPLIERS">THEY HAVE REGULAR SUPPLIERS</option>
                                    <option {{ $projectdetails->with_cont == 'CREDIT FACILITY'? 'selected':'' }} value="CREDIT FACILITY">CREDIT FACILITY</option>
                                  </select>
                                    </td>
                                    </tr>
                      <table class="table">
                        <tr>
                            <td>Quality</td>
                            <td>:</td>
                            <td>
                                <select id="quality" onchange="fake()" class="form-control" name="quality">
                                    <option value="null" disabled selected>--- Select ---</option>
                                    <option {{ $projectdetails->quality == "Genuine" ? 'selected':''}} value="Genuine">Genuine</option>
                                    <option {{ $projectdetails->quality == "Fake" ? 'selected':''}} value="Fake">Fake</option>
                                </select>
                            </td>
                        </tr>



                        <tr>
                            <td>Remarks</td>
                            <td>:</td>
                            <td>
                         <textarea style="resize: none;" class="form-control" placeholder="Remarks (Optional)" name="remarks">{{ $projectdetails->remarks }}</textarea>
                          </td>
                        </tr>
                        </table>
                            <button type="button"  onclick="pageNext()" class="form-control btn btn-primary">Submit Data</button>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>
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
  alert();
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
 function checkthis(arg)
  {
    
    
    var input = document.getElementById(arg);
    if(isNaN(input)){
      while(isNaN(document.getElementById(arg).value)){
          var str = document.getElementById(arg).value;
          str     = str.substring(0, str.length - 1);
          document.getElementById(arg).value = str;
      }
    }

    if(arg == 'length' || arg == 'breadth'){
     
      var breadth = parseInt(document.getElementById("breadth").value);
      var length   = parseInt(document.getElementById("length").value);
      if(isNaN(length)){

                length = 0;
               
              }
              if(isNaN(breadth)){

               
                breadth = 0;
              }
      if(!isNaN(breadth) && !isNaN(length)){
              
              var t1 = parseInt(document.getElementById("basement").value);
              var t2 = parseInt(document.getElementById("ground").value);
              sumup  = t1+t2+1;
             
              var Size    = 'L('+length+')' + '*' + 'B('+breadth+') = ';
              sum1   = length*breadth;
              Size    += sum1;
              var total = sumup* sum1;
            
              if(document.getElementById("totalsize").innerHTML != null)
                document.getElementById("totalsize").innerHTML = Size;
              else
                document.getElementById("totalsize").innerHTML = '';
               if(document.getElementById("pSize").value != null){
                var text = 'This Is Recommended Project Size : '+total+' <br> You Can Change If Required!!'
                 document.getElementById("pSizeTag").innerHTML = text;
               }else
                document.getElementById("pSize").value = '';
            }
    }
    return false;
  }
</script>
<!--This line by Siddharth -->

<script type="teinputt/javascript">
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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU"></script>

<script type="text/javascript">
    var current = "first";
    var countinput=0;
    document.getElementById('headingPanel').innerHTML = 'Project Details';
    function pageNext(){
        var ctype1 = document.getElementById('constructionType1');
        var ctype2 = document.getElementById('constructionType2');
        var rmc = document.getElementById('rmc');
        var rmc2= document.getElementById('rmc2');
        var rmc3= document.getElementById('rmc3');
        if(current == 'first')
        { 
          if(document.getElementById("pName").value == ""){
            window.alert("You Have Not Entered Project Name");
          }else if(document.getElementById("road").value == ""){
            window.alert("You have not entered Road Name");
          } else if(document.getElementById('rWidth').value == ""){
            window.alert("You have not entered  Width");
          }else if(ctype1.checked == false && ctype2.checked == false){
            window.alert("Please choose the construction type");
          }else if(rmc.checked == false && rmc2.checked == false && rmc3.checked == false){
            window.alert("Please tell us whether the customer is interested in RMC or not");
          }else if(dandw1.checked == false && dandw2.checked == false && dandw3.checked == false){
            window.alert("Please tell us whether the customer is Interested In Kitchen Cabinates and Wardrobes ?");
          }else if(bs1.checked == false && bs2.checked == false && bs3.checked == false ){
            window.alert("Please tell us whether the customer is Interested In Brila Super / Ultratech Products?");
          }else if(loan1.checked == false && loan2.checked == false && loan3.checked == false ){
            window.alert("Please tell us whether the customer is interested in taking loan or not");
          }else if(dandw1.checked == false && dandw2.checked == false && dandw3.checked == false ){
            window.alert("Please tell us whether the customer is interested in purchasing UPVC doors and windows");
          }else if(home1.checked == false && home2.checked == false && home3.checked == false ){
            window.alert("Please tell us whether the customer is interested in Home Automation");
          }else if(premium1.checked == false && premium2.checked == false && premium3.checked == false ){
            window.alert("Please tell us whether the customer is interested in premium product");
          }else if(document.getElementById("contract").value == ""){

          }else if(document.getElementById("contract").value == ""){
            alert("Please select contract type");
          }else if(ctype1.checked == true && ctype2.checked == true){
                countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 2;
          }else if(ctype1.checked == true || ctype2.checked == true){
              countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 1;
          }else {
              countinput = document.querySelectorAll('input[type="checkbox"]:checked').length;
          }

          if(countinput == 0){
              window.alert("Select at least one project status");
          } else if(document.getElementById("basement").value == ""){
            window.alert("You have not entered Basement value");
          } else if(document.getElementById("ground").value == ""){
            window.alert("You have not entered Floor value");
          }
          else if(document.getElementById("length").value == ""){
            window.alert("You have not entered length value");
          }else if(document.getElementById("breadth").value == ""){
            window.alert("You have not entered breadth value");
          }else if(document.getElementById("pSize").value == ""){
            window.alert("You have not entered Project Size");
          }
          else if(constructionType3.checked == false && constructionType4.checked == false){
            window.alert("Please choose the Budget type");
          }else if(document.getElementById("budget").value == ""){
            window.alert("You have not entered Budget");
          }else if(document.getElementById('prName').value == ''){
                              alert('Please Enter a Procurement Details');
                    document.getElementById('prName').focus();
          }else if(document.getElementById('prPhone').value== ''){
                    alert('Please Enter Procurement Phone Number');
                    document.getElementById('prPhone').focus();
          }else{

                          document.getElementById("sub").submit();
            }
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
      if(isNaN(ground)){

        ground = 0;
       
      }
      if(isNaN(basement)){

       
        basement = 0;
      }
      var opts = "<option value=''>--Floor--</option>";
      if(!isNaN(basement) && !isNaN(ground)){
        var floor    = 'B('+basement+')' + ' + G + ('+ground+') = ';
        sum          = basement+ground+1;
         fsum          = ground+1;
        var base         = basement;
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
                      "<option value='3BHK'>3BHK</option>"+
                      "<option value='4BHK'>4BHK</option>"+
                      "<option value='5BHK'>5BHK</option></select>"+
                      "</td><td>"+
                      "<input type=\"text\" name=\"number[]\" class=\"form-control\" placeholder=\"Floor Size / No. of Houses / No. Of Flats\"></td>";
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
           for(var i = base; i>0; i--){
            opts += "<option value='"+i+"'>Base "+i+"</option>";
          }
          opts += "<option value='Ground'>Ground</option>";
          for(var i = 1; i<fsum; i++){
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
    function checkinput(arg){
      var floorNo = document.getElementsByName('floorNo[]');
      var roomType = document.getElementsByName('roomType[]');
      var floors = [];
      var rooms = [];
      var myIndex = roomType[0].selectedIndex;
      for(var i = 0; i < floorNo.length; i++){
        floors.push(floorNo[i].value);
        rooms.push(roomType[i].value);
      }
      for(var j = 0; j < floors.length; j++){
        if(floors[j] == floors[j + 1]){
          for(i = j+1; i < rooms.length; i++){
            if(rooms[j] == rooms[i]){
              alert("This room type has been already selected");
              roomType[0].options[myIndex].disabled = true;
              roomType[0].selectedIndex = 0;
              break;
            }
          }
        }
      }
    }
    function enableoption(){
      var roomType = document.getElementsByName('roomType[]');
      for(var i = 1; i < 6; i++){
        roomType[0].options[i].disabled = false;
      }
    }
      // var ctype1 = document.getElementById('constructionType1');
      // var ctype2 = document.getElementById('constructionType2');
      // var ctype3 = document.getElementById('constructionType3');
      // var ctype4 = document.getElementById('constructionType4');
      // var countinput;
      // if(ctype1.checked == true && ctype2.checked == true && ctype3.checked == false && ctype4.checked == false){
      //   //   both construction type
      //   countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 2;
      // }else if(ctype1.checked == true && ctype2.checked == true && ctype3.checked == true && ctype4.checked == true){
      //   //   all construction type and budget type
      //   countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 4;
      // }else if(ctype1.checked == true && ctype2.checked == true && (ctype3.checked == true || ctype4.checked == true)){
      //   //   both construction type and either budget type
      //   countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 3;
      // }else if((ctype1.checked == true || ctype2.checked == true) && (ctype3.checked == true || ctype4.checked == true)){
      //   //   
      //   countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 2;
      // }else if(ctype1.checked == true || ctype2.checked == true){
      //   countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 1;
      // }else{
      //   countinput = document.querySelectorAll('input[type="checkbox"]:checked').length;
      // }
      // if(countinput >= 5){
      //   $('input[type="checkbox"]:not(:checked)').attr('disabled',true);
      //   $('#constructionType1').attr('disabled',false);
      //   $('#constructionType2').attr('disabled',false);
      //   $('#constructionType3').attr('disabled',false);
      //   $('#constructionType4').attr('disabled',false);
      // }else if(countinput == 0){
      //     return "none";
      // }else{
      //   $('input[type="checkbox"]:not(:checked)').attr('disabled',false);
      // }

 var numbers = [];
    function count(){
      var status = document.getElementsByName('status[]');
      var selected = "";
      var check = 0;
      // first 3 stages + last stage
      for(var i = 0; i < status.length; i++){
        if(status[i].checked == true)
          check += 1;
      }
      if(check == 0){
        for(var i = 0; i < status.length; i++){
          status[i].disabled = false;
        }
      }
      if(check == 1){
        if(status[0].checked == true || status[1].checked == true || status[2].checked == true || status[status.length - 1].checked == true){
          for(var i = 0; i < status.length; i++){
            if(status[i].checked != true)
              status[i].disabled = true;
          }
        }else if(status[3].checked == true){
          // pillars
          numbers = [3,4,5];
          for(var i = 0; i < status.length; i++){
            var a = numbers.indexOf(i);
            if(a == -1){
              status[i].disabled = true;

            }
          }
        }else if(status[4].checked == true){
          // walls
          numbers = [3,4,5,6,7];
          for(var i = 0; i < status.length; i++){
            var a = numbers.indexOf(i);
            if(a == -1){
              status[i].disabled = true;
            }
          }
        }else if(status[5].checked == true){
          // roofing
          numbers = [4,5,6,7];
          for(var i = 0; i < status.length; i++){
            var a = numbers.indexOf(i);
            if(a == -1){
              status[i].disabled = true;
            }
          }
        }else if(status[6].checked == true){
          // electrical
          numbers = [6,7,9,12];
          for(var i = 0; i < status.length; i++){
            var a = numbers.indexOf(i);
            if(a == -1){
              status[i].disabled = true;
            }
          }
        }else if(status[7].checked == true){
          // plumbing
          numbers = [6,7,8,10,12];
          for(var i = 0; i < status.length; i++){
            var a = numbers.indexOf(i);
            if(a == -1){
              status[i].disabled = true;
            }
          }
        }else if(status[8].checked == true){
          // plastering
          numbers = [6,7,8];
          for(var i = 0; i < status.length; i++){
            var a = numbers.indexOf(i);
            if(a == -1){
              status[i].disabled = true;
            }
          }
        }else if(status[9].checked == true){
          // flooring
          numbers = [9,10,12,13];
          for(var i = 0; i < status.length; i++){
            var a = numbers.indexOf(i);
            if(a == -1){
              status[i].disabled = true;
            }
          }
        }else if(status[10].checked == true){
          // carpentry
          numbers = [10,11,12];
          for(var i = 0; i < status.length; i++){
            var a = numbers.indexOf(i);
            if(a == -1){
              status[i].disabled = true;
            }
          }
        }else if(status[11].checked == true){
          // paintings
          numbers = [6,10,11,12];
          for(var i = 0; i < status.length; i++){
            var a = numbers.indexOf(i);
            if(a == -1){
              status[i].disabled = true;
            }
          }
        }else if(status[12].checked == true){
          // fixtures
          numbers = [10,12];
          for(var i = 0; i < status.length; i++){
            var a = numbers.indexOf(i);
            if(a == -1){
              status[i].disabled = true;
            }
          }
        }else if(status[13].checked == true){
          // plastering
          numbers = [8,11,12,13];
          for(var i = 0; i < status.length; i++){
            var a = numbers.indexOf(i);
            if(a == -1){
              status[i].disabled = true;
            }
          }
        }else{
          for(var i = 0; i < status.length; i++){
            status[i].disabled = false;
          }
        }
      }
      // var ctype1 = document.getElementById('constructionType1');
      // var ctype2 = document.getElementById('constructionType2');
      // var ctype3 = document.getElementById('constructionType3');
      // var ctype4 = document.getElementById('constructionType4');
      // var countinput;
    //   if(ctype1.checked == true && ctype2.checked == true && ctype3.checked == false && ctype4.checked == false){
    //     //   both construction type
    //     countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 2;
    //   }else if(ctype1.checked == true && ctype2.checked == true && ctype3.checked == true && ctype4.checked == true){
    //     //   all construction type and budget type
    //     countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 4;
    //   }else if(ctype1.checked == true && ctype2.checked == true && (ctype3.checked == true || ctype4.checked == true)){
    //     //   both construction type and either budget type
    //     countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 3;
    //   }else if((ctype1.checked == true || ctype2.checked == true) && (ctype3.checked == true || ctype4.checked == true)){
    //     //   
    //     countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 2;
    //   }else if(ctype1.checked == true || ctype2.checked == true){
    //     countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 1;
    //   }else{
    //     countinput = document.querySelectorAll('input[type="checkbox"]:checked').length;
    //   }
    //   if(countinput >= 5){
    //     $('input[type="checkbox"]:not(:checked)').attr('disabled',true);
    //     $('#constructionType1').attr('disabled',false);
    //     $('#constructionType2').attr('disabled',false);
    //     $('#constructionType3').attr('disabled',false);
    //     $('#constructionType4').attr('disabled',false);
    //   }else if(countinput == 0){
    //       return "none";
    //   }else{
    //     $('input[type="checkbox"]:not(:checked)').attr('disabled',false);
    //   }
      // if(document.getElementById('planning').checked == true || document.getElementById('closed').checked == true){
      //   $('input[type="checkbox"]:not(:checked)').attr('disabled',true);
      //   $('#constructionType1').attr('disabled',false);
      //   $('#constructionType2').attr('disabled',false);
      //   $('#constructionType3').attr('disabled',false);
      //   $('#constructionType4').attr('disabled',false);
      // }else{
      //   $('input[type="checkbox"]:not(:checked)').attr('disabled',false);
      // }
    }
    
    function fileUpload(){
      var count = document.getElementById('oApprove').files.length;
      if(count > 5){
        document.getElementById('oApprove').value="";
        alert('You are allowed to upload a maximum of 5 files');
      }
    }
     function fileuploadimage(){ 
      var count = document.getElementById('pImage').files.length;
      if(count > 4){
        document.getElementById('pImage').value="";
        alert('You are allowed to upload a maximum of 4 files');
      }
    }
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

@endsection

