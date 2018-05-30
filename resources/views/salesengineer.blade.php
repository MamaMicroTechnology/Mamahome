@extends('layouts.app')
@section('content')   
    <div class="col-md-12">     
    <div class="col-md-12" >

    <div class="panel panel-default" style="overflow: scroll;">
            <div class="panel-heading" style="background-color:#158942;color:white;font-size:1.4em;">Project List  <p class="pull-right">Count&nbsp;:&nbsp;{{(Count($projects)) }} </p></div>  
         <div class="panel-body" id="page">
       <table class="table table-hover table-striped">
                <thead>
                  <th>Project Name</th>
                  <th>Project Id</th>
                  <th style="width:15%">Address</th>
                 <th>Procurement Name</th>
                  <th>Contact No.</th>
                  <th>Action</th>
                 <th> Customer History</th>
                
               </thead>
                <tbody>
             <?php $ii=0; ?>
            @foreach($projects as $project)
                <tr>
                    <td id="projname-{{$project->project_id}}">{{ $project->project_name }}</td>
                                    <td style="text-align:center"><a href="{{ URL::to('/') }}/admindailyslots?projectId={{$project->project_id}}&&lename={{ $project->name }}">{{ $project->project_id }}</a></td>
                    <td id="projsite-{{$project->project_id}}">
                                        {{ $project->siteaddress != null ? $project->siteaddress->address : '' }}
                                    </td>
                    <td id="projproc-{{$project->project_id}}">
                                        {{ $project->procurementdetails != NULL?$project->procurementdetails->procurement_name:'' }}
                                    </td>
                    <td id="projcont-{{$project->project_id}}"><address>{{ $project->procurementdetails != NULL?$project->procurementdetails->procurement_contact_no:'' }}</address></td>
                    <!-- <td>{{ Count($projects)   }}</td> -->
                  
                     <td><form method="post" action="{{ URL::to('/') }}/confirmedProject" >
                                      {{ csrf_field() }}
                                      <input type="hidden" value="{{ $project->project_id }}" name="id">
                                      <div class="btn-group">
                                      <button  type="button" data-toggle="modal" data-target="#myModal{{ $project->project_id }}" class="btn btn-sm btn-warning " style="color:white;font-weight:bold;padding: 6px;width:80px;" id="viewdet({{$project->project_id}})">Edit</button>
                                      <a class="btn btn-sm btn-success " name="addenquiry" href="{{ URL::to('/') }}/requirements?projectId={{ $project->project_id }}" style="color:white;font-weight:bold;padding: 6px;">Add Enquiry</a>
                                      
                                      @if( $project->confirmed !== "0" ||  $project->confirmed == "true" )
                                   <button  type="button" id="demo"  style="padding: 5.5px;background-color:#e57373" class="btn btn-sm " {{ $project->confirmed !== "0" ||  $project->confirmed == "true" ? 'checked': ''}}  name="confirmed" onclick="this.form.submit()">Called
                                   <span class="badge">&nbsp;{{  $project->confirmed }}&nbsp;</span>
                                   </button>
                                  @endif
                                          @if( $project->confirmed == "0" ||  $project->confirmed == "false" )
                                   <button style="padding: 5.5px;background-color: #aed581;" id="demo"  type="button" class="btn  btn-sm "  {{ $project->confirmed !== "0" ||  $project->confirmed == "true" ? 'checked': ''}}  name="confirmed" onclick="this.form.submit()">Called
                                    <span class="badge">&nbsp;{{  $project->confirmed }}&nbsp;</span>
                                   </button></div>
                                  @endif
                              </form>
                      </td>

                    <td>
                      <button style="padding: 5.5px;background-color: #757575 ;color: white" data-toggle="modal" data-target="#myModal1{{ $project->project_id }}"   type="button" class="btn  btn-sm "  >
                                   History </button>

                    </td>   
                   
                  </tr>
@endforeach

</tbody>
</table>
@foreach($projects as $project)
   <form method="POST" action="{{ URL::to('/') }}/{{ $project->project_id }}/updateProject" enctype="multipart/form-data" id="sub" >
    {{ csrf_field() }}
<!-- The Modal -->
 <div class="modal fade" id="myModal{{ $project->project_id }}">
  <div class="modal-dialog modal-lg"  style="width:60%">
   <div class="modal-content">

<!-- Modal Header -->
    <div class="modal-header" style="background-color:rgb(245, 127, 27);padding:0px;">
        <button type="button" class="close" data-dismiss="modal">×</button>      
      <ul class="nav nav-tabs">
        <li class="nav-item nav-link active">
           <a class="nav-link active" data-toggle="tab" href="#home{{ $project->project_id }}" style="color:green;font-size: 20px;">Project Details</a>
        </li>
         <li class="nav-item">
           <a class="nav-link" data-toggle="tab" href="#menu1{{ $project->project_id }}" style="color:green;font-size: 20px;">Customer Details </a>
        </li>
         
                </ul>
    </div>
                                  
    <!-- Modal body -->
    <div class="modal-body">
      <div class="container mt-3">
                                <!-- Tab panes -->
        <div class="tab-content">
          <div id="home{{ $project->project_id }}" class="container tab-pane active"><br>
          <table class="table" style="width: 55%;">
               <tr>
                   <td>Project Name</td>
                   <td>:</td>
                   <td style=" padding: 10px;" ><input style="width: 50%;" id="pName"  class=" form-control" required type="text" placeholder="Project Name" name="pName" value="{{ $project->project_name }}" ></td>
               </tr>
               <tr>
                   <td>Location</td>
                   <td>:</td>
                   <td  id="x">
                    <div class="col-sm-6">
                      <label>Longitude:</label>
                        <input style="width: 70%;"  placeholder="Longitude" class="form-control " required readonly type="text" name="longitude" value="{{ $project->siteaddress != null ? $project->siteaddress->latitude : '' }}" id="longitude">
                    </div>
                    <div class="col-sm-6">
                        <label>Latitude:</label>
                        <input style="width: 70%;"  placeholder="Latitude" class="form-control " required readonly type="text" name="latitude" value="{{ $project->siteaddress != null ? $project->siteaddress->latitude : '' }}" id="latitude">
                    </div>
                   </td>
               </tr>  
               <tr>
                   <td>Road Name/Road No.</td>
                   <td>:</td>
                   <td style=" padding: 10px;" ><input id="road" style="width: 50%;"  required type="text" placeholder="Road Name / Road No." class=" form-control " name="rName" value="{{ $project->road_name }}"></td>
               </tr>
               <tr>
                   <td>Road Width</td>
                   <td>:</td>
                   <td style="padding: 10px;"><input style="width: 50%;"  id="rWidth"  required type="text" placeholder="Road Width"  class="form-control " name="rWidth" value="{{ $project->road_width }}" required></td>
               </tr>
               <tr class="{{ $errors->has('address') ? ' has-error' : '' }}">
                   <td>Full Address</td>
                   <td>:</td>
                   <td style="padding: 10px;"><input style="width: 50%;"  readonly id="address" required type="text" placeholder="Full Address" class="form-control " name="address" value="{{ $project->siteaddress != null ? $project->siteaddress->address : '' }}"></td>
               </tr>
               <?php
                  $type = explode(", ",$project->construction_type);
                ?>
               <tr>
                 <td>Construction Type</td>
                 <td>:</td>
                 <td style="padding: 20px;">
                    <label required class="checkbox-inline"><input {{ in_array('Residential', $type) ? 'checked': ''}}  id="constructionType1" name="constructionType[]" type="checkbox" value="Residential">Residential</label>
                    <label required class="checkbox-inline"><input {{ in_array('Commercial', $type) ? 'checked': ''}} id="constructionType2" name="constructionType[]" type="checkbox" value="Commercial">Commercial</label> 
                 </td>
               </tr>
               <tr>
                 <td>Interested in RMC</td>
                 <td>:</td>
                 <td style="padding: 20px;">
                     <div class="radio">
                      <label><input required value="Yes" id="rmc" {{ $project->interested_in_rmc == "Yes" ? 'checked' : '' }} type="radio" name="rmcinterest">Yes</label>
                    </div>
                    <div class="radio">
                      <label><input required value="No" {{ $project->interested_in_rmc == "No" ? 'checked' : '' }} id="rmc2" type="radio" name="rmcinterest">No</label>
                    </div>
                 </td>
               </tr>
        
               <tr>
                <td>Type of Contract ? </td>
                <td>:</td>
                <td style="padding: 10px;">
                  <select style="width: 50%;"  class="form-control" name="contract" id="contract" required>
                      <option value="" disabled selected>--- Select ---</option>
                      <option {{ $project->contract == "Labour Contract" ? 'selected' : ''}} value="Labour Contract">Labour Contract</option> 
                      <option {{ $project->contract == "Material Contract" ? 'selected' : ''}} value="Material Contract">Material Contract</option>
                      <option {{ $project->contract == "None" ? 'selected' : ''}} value="None">None</option>
                  </select>                              </td>

               </tr>
              <tr>
              <td><b>Follow Up?</b></td>
              <td>:</td>
              <td>
                  <div class="radio">
                                <label><input {{ $project->followup == 'No'?'checked':'' }} type="radio" name="follow" value="No">No</label>
                              </div>
                              <div class="radio">
                                <label><input {{ $project->followup == 'Yes'?'checked':'' }} type="radio" name="follow" value="Yes">Yes</label>
                              </div>
             </td>

          </tr>
          <tr>
            <td><b> Follow up date</b></td>
            <td>:</td>
            <td ><input style="width:50%;"  type="date" name="follow_up_date" id="fdate" class="form-control" /></td>


          </tr>


               <tr>
                   <td>Govt. Approvals<br>(Municipal, BBMP, etc)</td>
                   <td>:</td>
                   <td style="padding: 10px;"><input style="width: 50%;"  oninput="fileUpload()" id="oApprove" multiple type="file" accept="image/*" class="form-control" name="oApprove[]"></td>
               </tr>
               
               <tr>
                <?php
                  $statuses = explode(", ", $project->project_status);
                ?>
                   <td>Project Status</td>
                   <td>:</td>
                   <td style="padding: 10px;">
                       <table class="table table-responsive" style="width: 90%;" >
                        <tr>
                          <td>
                            <label class="checkbox-inline">
                              <input {{ in_array('Planning', $statuses) ? 'checked': ''}} type="checkbox"  name="status[]" value="Planning">Planning
                            </label>
                          </td>
                          <td>
                             <label class="checkbox-inline">
                              <input {{ in_array('Digging', $statuses) ? 'checked': ''}} type="checkbox"  name="status[]" value="Digging">Digging
                            </label>
                          </td>
                          <td>
                             <label class="checkbox-inline">
                              <input {{ in_array('Foundation', $statuses) ? 'checked': ''}} type="checkbox"  name="status[]" value="Foundation">Foundation
                            </label>
                          </td>
                          <td>
                             <label class="checkbox-inline">
                              <input {{ in_array('Pillars', $statuses) ? 'checked': ''}} type="checkbox"  name="status[]" value="Pillars">Pillars
                            </label>
                          </td>
                          <td>
                             <label class="checkbox-inline">
                              <input {{ in_array('Walls', $statuses) ? 'checked': ''}} type="checkbox"  name="status[]" value="Walls">Walls
                            </label>
                          </td>
                        </tr>
                        <tr>
                         <td>
                          <label class="checkbox-inline">
                          <input {{ in_array('Roofing', $statuses) ? 'checked': ''}} type="checkbox"  name="status[]" value="Roofing">Roofing
                        </label>
                        </td>
                         <td>
                          <label class="checkbox-inline">
                          <input {{ in_array('Electrical', $statuses) ? 'checked': ''}} type="checkbox"  name="status[]" value="Electrical">Electrical
                        </label>
                        </td>
                         <td>
                          <label class="checkbox-inline">
                          <input {{ in_array('Plumbing', $statuses) ? 'checked': ''}} type="checkbox"  name="status[]" value="Plumbing">Plumbing
                        </label>
                        </td>
                         <td>
                          <label class="checkbox-inline">
                          <input {{ in_array('Plastering', $statuses) ? 'checked': ''}} type="checkbox"  name="status[]" value="Plastering">Plastering
                        </label>
                        </td>
                         <td>
                          <label class="checkbox-inline">
                          <input {{ in_array('Flooring', $statuses) ? 'checked': ''}} type="checkbox"  name="status[]" value="Flooring">Flooring
                        </label>
                        </td>
                        </tr>
                        <tr>
                         <td>
                          <label class="checkbox-inline">
                          <input {{ in_array('Carpentry', $statuses) ? 'checked': ''}} type="checkbox"  name="status[]" value="Carpentry">Carpentry
                        </label>
                        </td>
                         <td>
                          <label class="checkbox-inline">
                          <input {{ in_array('Paintings', $statuses) ? 'checked': ''}} type="checkbox"  name="status[]" value="Paintings">Paintings
                        </label>
                        </td>
                         <td>
                          <label class="checkbox-inline">
                          <input {{ in_array('Fixtures', $statuses) ? 'checked': ''}} type="checkbox"  name="status[]" value="Fixtures">Fixtures
                        </label>
                        </td>
                         <td>
                          <label class="checkbox-inline">
                          <input {{ in_array('Completion', $statuses) ? 'checked': ''}} type="checkbox"  name="status[]" value="Completion">Completion
                        </label>
                        </td>
                         <td>
                          <label class="checkbox-inline">
                          <input {{ in_array('Closed', $statuses) ? 'checked': ''}} type="checkbox"  name="status[]" value="Closed">Closed
                        </label>
                        </td>
        
                        </tr>
                      </table>
                   </td>
               </tr>
               <tr>
                   <td>Project Type</td>
                   <td style="padding:10px;" >:</td>
                   <td>
                    <div class="row">
                        <div class="col-md-3">
                          <label>Basement</label>
                          <input value="{{ $project->basement }}" onkeyup="check('basement')" id="basement" name="basement" type="number" autocomplete="off" class="form-control " placeholder="Basement">
                        </div>
                        <div class="col-md-2">
                          <br>
                          <b style="font-size: 20px; text-align: center">+</b>
                        </div>
                      <div class="col-md-3">
                        <label>Floor</label>
                        <input value="{{ $project->ground }}" oninput="check('ground')" autocomplete="off" name="ground" id="ground" type="number" class="form-control " placeholder="Floor">
                      </div>
                      <div class="col-md-3">
                        <br>
                        <p id="total">
                          B({{ $project->basement }}) + G + {{ $project->ground }} = {{ $project->basement + $project->ground + 1 }}
                        </p>
                      </div>
                    </div>
                    </td>
               </tr>
                 <tr>
               
                 <td>Budget Type</td>
                 <td style="padding:10px">:</td>
                 <td style="padding: 10px;">
                    <label required class="checkbox-inline">
                      <input onclick="dis()" {{ $project->budgetType =="Structural" ? 'checked': ''}}  id="constructionType3" name="budgetType" type="radio" value="{{ $project->budgetType }}" id="a">Structural Budget
                    </label>
                    <label required class="checkbox-inline">
                      <input id="b" {{ $project->budgetType == "Finishing" ? 'checked': ''}}  id="constructionType4" name="budgetType" type="radio" value="{{ $project->budgetType }}">Finishing Budget
                    </label>
                 </td>
               </tr>
               <tr>
                   <td>Project Size (Approx.)</td>
                   <td style="padding:10px">:</td>
                   <td style="padding: 10px;"><input style="width: 50%;"  value="{{ $project->project_size }}" id="pSize" required placeholder="Project Size in Sq. Ft." type="text" class=" form-control" name="pSize" onkeyup="check('pSize')"></td>
               </tr>
               <tr>
                   <td>Total Budget (in Cr.)</td>
                   <td style="padding:10px">:</td>
                   <td >
                    <div class="col-md-4">
                      <input id="budget" style="width: 70%;"  value="{{ $project->budget }}"  placeholder="Budget" type="text"
                       class="form-control" onkeyup="check('budget')" name="budget">
                    </div>
                    <div class="col-md-8">
                      Budget (per sq.ft) :
                      @if($project->project_size != 0)
                       {{ round((10000000 * $project->budget)/$project->project_size,3) }}
                      @endif
                    </div>
                  </td>
               </tr>
               <tr>
                   <td>Project Image</td>
                   <td>:</td>
                   <td style="padding: 10px;">
                    <input id="img" type="file"  style="width: 50%;"  accept="image/*" class=" form-control" name="pImage" multiple><br>
                    <div id="imagediv">
                      <img height="250" width="250" id="project_img" src="{{ URL::to('/') }}/public/projectImages/{{ $project->image }}" class="img img-thumbnail">
                    </div>
                   </td></tr>
                   <tr>
                 <td>Updated On</td>
                 <td>:</td>
                 <td style="padding: 10px;">{{ date('d-m-Y h:i:s A', strtotime($project->created_at))}}</td>
               </tr>
              <tr>
                  <td>Room Types</td>
                  <td>:</td>
                  <td>
                      <table id=" " class="table table-responsive">
                          <tr>
                            <td>
                              <select id="floorNo" name="floorNo[]" class="form-control">
                                <option value="">--Floor--</option>
                                  <option value="Ground">Ground</option>
                                @for($i = 1;$i<=$project->project_type;$i++)
                                  <option value="{{ $i }}">Floor {{ $i }}</option>
                                @endfor
                              </select>
                            </td>
                              <td>
                                  @if($project->construction_type == "Commercial")
                                  <input type="text" name="roomType[]" readonly value="Commercial Floor" class="form-control">
                                  @elseif($project->construction_type == "Residential")
                                  <select name="roomType[]" id="" class="form-control">
                                      <option value="1RK">1RK</option>
                                      <option value="1BHK">1BHK</option>
                                      <option value="2BHK">2BHK</option>
                                      <option value="3BHK">3BHK</option>
                                  </select>
                                  @else
                                  <select name="roomType[]" id="" class="form-control ">
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
                                  <input type="text" style="width: 50%;"  name="number[]" class="form-control input-sm" placeholder="{{ $project->construction_type == 'Commercial'? "Floor Size" : "No. of House" }}" >
                              </td>
                              </tr>
                          <tr>
                              <td colspan=3>
                                  <button onclick="addRow('{{ $project->project_id }}');" type="button" class="btn btn-primary form-control">Add more</button>
                              </td>
                          </tr>
                          @foreach($roomtypes as $roomtype)
                          @if($roomtype->project_id == $project->project_id)
                          <tr>
                            <td>Floor {{ $roomtype->floor_no }}</td>
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
                          @endif
                          @endforeach
                      </table>
                  </td>
               </tr>
              
           </table>
     </div>
    
    <div id="menu1{{ $project->project_id }}" class="container tab-pane fade"><br>
    <label>Owner Details</label>
           <table class="table" border="" style="width:40%;">
              <tr>
                   <td>Owner Name</td>
                   <td>:</td>
                   <td style="padding: 10px;"><input value="{{ $project->ownerdetails != null ? $project->ownerdetails->owner_name : '' }}" type="text" placeholder="Owner Name" class="form-control input-sm" id="oName" name="oName"></td>
               </tr>
               <tr>
                   <td>Owner Email</td>
                   <td>:</td>
                   <td style="padding: 10px;"><input value="{{ $project->ownerdetails != null ? $project->ownerdetails->owner_email : '' }}" placeholder="Owner Email" type="email" class="form-control input-sm" onblur="checkmail('oEmail')" id="oEmail" name="oEmail"></td>
               </tr>
               <tr>
                   <td>Owner Contact No.</td>
                   <td>: <p class="pull-right">+91</p></td>
                   <td style="padding: 10px;"><input value="{{ $project->ownerdetails != null ? $project->ownerdetails->owner_contact_no : '' }}" onkeyup="check('oContact')" placeholder="Owner Contact No." type="text" class="form-control input-sm" maxlength="10" minlength="10" name="oContact" id="oContact"></td>
               </tr>
              </table>
             <label>Contractor Details</label>
           <table class="table"  border=""  style="width:40%;">
               <tr>
                   <td>Contractor Name</td>
                   <td >:</td>
                   <td style="padding:10px;"><input value="{{ $project->contractordetails!= null ? $project->contractordetails->contractor_name :'' }}"  id="cName" type="text" placeholder="Contractor Name" class="form-control input-sm" name="cName"></td>
               </tr>
               <tr>
                   <td>Contractor Email</td>
                   <td>:</td>
                   <td style="padding: 10px; "><input value="{{ $project->contractordetails!= null ? $project->contractordetails->contractor_email :'' }}"  placeholder="Contractor Email" type="email" onblur="checkmail('cEmail')" class="form-control input-sm" name="cEmail" id="cEmail"></td>
               </tr>
               <tr>
                   <td>Contractor Contact No.</td>
                   <td>: <p class="pull-right">+91</p></td>
                   <td style="padding: 10px;"><input  value="{{ $project->contractordetails!= null ? $project->contractordetails->contractor_contact_no  :'' }}" placeholder="Contractor Contact No." onkeyup="check('cContact')" maxlength="10" minlength="10" type="text" class="form-control input-sm" id="cContact" name="cContact"></td>
               </tr>
           </table>
           <label>Consultant Details</label>
           <table  border=""  class="table" style="width: 40%;">
               <tr>
                   <td>Consultant Name</td>
                   <td>:</td>
                   <td style="padding: 10px;"><input value="{{ $project->consultantdetails!= null ? $project->consultantdetails->consultant_name :'' }}"  type="text" placeholder="Consultant Name" class="form-control input-sm" id="coName" name="coName"></td>
               </tr>
               <tr>
                   <td>Consultant Email</td>
                   <td>:</td>
                   <td style="padding: 10px;"><input value="{{ $project->consultantdetails!= null ? $project->consultantdetails->consultant_email :'' }}"  placeholder="Consultant Email" onblur="checkmail('coEmail')" type="email" class="form-control input-sm" id="coEmail" name="coEmail"></td>
               </tr>
               <tr>
                   <td>Consultant Contact No.</td>
                   <td>: <p class="pull-right">+91</p></td>
                   <td style="padding: 10px;"><input value="{{ $project->consultantdetails!= null ? $project->consultantdetails->consultant_contact_no:'' }}"  placeholder="Consultant Contact No." maxlength="10" minlength="10" onkeyup="check('coContact')" type="text" class="form-control input-sm" id="coContact" name="coContact"></td>
               </tr>
           </table>

                                  <label>Site Engineer Details</label>
                                 <table  border=""  class="table" style="width: 40%;">
                                     <tr>
                                         <td>Site Engineer Name</td>
                                         <td>:</td>
                                         <td style="padding: 10px;"><input value="{{ $project->siteengineerdetails != null ? $project->siteengineerdetails->site_engineer_name:'' }}"  type="text" placeholder="Site Engineer Name" class="form-control input-sm" name="eName" id="eName"></td>
                                     </tr>
                                     <tr>
                                         <td>Site Engineer Email</td>
                                         <td>:</td>
                                         <td style="padding: 10px;"><input value="{{ $project->siteengineerdetails != null ? $project->siteengineerdetails->site_engineer_email : '' }}"  placeholder="Site Engineer Email" type="email" class="form-control input-sm" name="eEmail" id="eEmail" onblur="checkmail('eEmail')"></td>
                                     </tr>
                                     <tr>
                                         <td>Site Engineer Contact No.</td>
                                         <td>: <p class="pull-right">+91</p></td>
                                         <td style="padding: 10px;"><input value="{{ $project->siteengineerdetails != null ? $project->siteengineerdetails->site_engineer_contact_no : '' }}"onblur="checklength('eContact');"  placeholder="Site Engineer Contact No." type="text" class="form-control input-sm" name="eContact" id="eContact" maxlength="10" onkeyup="check('eContact')"></td>
                                     </tr>
                                 </table>
                                  <label>Procurement Details</label>
           <table  border="" class="table" style="width: 40%;">
               <tr>
                   <td>Procurement Name</td>
                   <td>:</td>
                   <td style="padding: 10px;"><input id="prName" value="{{ $project->procurementdetails != null ? $project->procurementdetails->procurement_name : '' }}"  type="text" placeholder="Procurement Name" class="form-control input-sm" id="pName" name="pName"></td>
               </tr>
               <tr>
                   <td>Procurement Email</td>
                   <td>:</td>
                   <td style="padding: 10px;"><input id="pEmail" value="{{ $project->procurementdetails != null ? $project->procurementdetails->procurement_email : '' }}"  placeholder="Procurement Email" type="email" class="form-control input-sm" id="pEmail" name="pEmail"></td>
               </tr>
               <tr>
                   <td>Procurement Contact No.</td>
                   <td>: <p class="pull-right">+91</p></td>
                   <td style="padding: 10px;"><input id="prPhone" procurement_email value="{{ $project->procurementdetails != null ? $project->procurementdetails->procurement_contact_no: '' }}"    placeholder="Procurement Contact No." maxlength="10" minlength="10" type="text" class="form-control input-sm" name="pContact" id="pContact"></td>
               </tr>
           </table>
            <table class="table" style="width: 40%;">
        <tr>
            <td style="padding: 10px;"><b>Quality</b></td>
            <td style="padding: 10px;">
                <select  id="quality" onchange="fake()" class="form-control" name="quality">
                    <option value="null" disabled selected>--- Select ---</option>
                    <option {{ $project->quality == "Genuine" ? 'selected':''}} value="Genuine">Genuine</option>
                    <option {{ $project->quality == "Fake" ? 'selected':''}} value="Fake">Fake</option>
                </select>
            </td>
        </tr>
        
        </table>
            <textarea style="width: 40%;" class="form-control" placeholder="Remarks (Optional)" name="remarks"></textarea><br>
            <br>
                            
        <button style="width:10%;" type="submit" id="subid" class=" form-control btn btn-primary">Submit Data</button>
</div>






                       <!-- <div id="menu2{{ $project->project_id }}" class="container tab-pane fade"><br>
                                     <table class="">
                                       <tr>
                                       <td style="padding: 10px;">No Of Times Called</td>
                                       <td>:</td>
                                       <td style="padding: 10px;">{{ $project->confirmed }}</td>
                                       </tr>
                                        <tr>
                                       <td style="padding: 10px;" > Project Updated by</td>
                                       <td>:</td>
                                       <td style="padding: 10px;">{{ $project->updated_at }}</td>
                                       </tr>
                                        <tr>
                                       <td> Enquirys</td>
                                       <td>:</td>
                                        <td >
                                               <div style="width:80%; max-height:70px; overflow:auto">
                                        @if($project->project_id == $requirements[$ii][0])
                                          @for($j = 0; $j < count($requirements[$ii][1]); $j++)
                                         
                                          <a href="{{ URL::to('/') }}/editenq?reqId={{ $requirements[$ii][1][$j] }}">  {{ $requirements[$ii][1][$j] }}<br></a>
                                            
                                          @endfor
                                          <?php $ii++ ?>
                                          @endif  
                                          </div>
                                          </td>
                                        </tr>
                                         <tr>
                                       <td style="padding: 10px;" > Last Called By</td>
                                       <td>:</td>
                                       <td style="padding: 10px;">{{ $project->updated_at }}</td>
                                       </tr>
                                      
                                     </table>
                                    </div>
 -->
                    </div>
                </div>
            </div>


        <!-- Modal footer -->
        <div class="modal-footer" style="background-color: green;padding:5px;">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
</form>
<!-- Modal -->
  <div class="modal fade" id="myModal1{{ $project->project_id }}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header  " style="background-color:#868e96;padding:5px; " >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"> Customer History <span class="pull-right"> Project_Id: {{ $project-> project_id }}</span></h4>
        </div>
        <div class="modal-body">
           <table class="">
                                       
                                        <tr>
                                       <td style="padding: 10px;" > Project Created by</td>
                                       <td>:</td>
                                       <td style="padding: 10px;">{{ date('d-m-Y', strtotime( $project->created_at)) }}</td>
                                        <td>
                                              {{ date('h:i:s A', strtotime($project->created_at)) }}
                                            </td>
                                       </tr>
                                        <tr>
                                       <td style="padding: 10px;" > Project Updated by</td>
                                       <td>:</td>
                                       <td style="padding: 10px;">{{ date('d-m-Y', strtotime(  $project->updated_at)) }}</td>
                                        <td>
                                              {{ date('h:i:s A', strtotime($project->updated_at)) }}
                                            </td>
                                       </tr>
                                        
                                        
                                         <tr>
                                       
                                     <td>  <table class="table table-responsive table-hover">
                                       <tbody>
                                       <thead>
                                          <!-- <th>User_id</th> -->
                                          <th>SlNo</th>
                                          <th>Called Date</th>
                                          <th>Called Time</th>
                                         <th> &nbsp;&nbsp; Name </th>
                                       </thead>
                                       <tbody>
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <label>Call History</label>
                                         <?php $i=1 ?>
                                          @foreach($his as $call)
                                          @if($call->project_id == $project->project_id)
                                          <tr>
                                           <!--  <td>
                                              {{ $call->user_id }}
                                            </td> -->
                                           
                                            <td>{{ $i++ }}</td>
                                            <td>
                                              {{ date('d-m-Y', strtotime($call->called_Time)) }}
                                            </td>
                                            <td>
                                              {{ date('h:i:s A', strtotime($call->called_Time)) }}
                                            </td>
                                            <td>
                                             {{$call->username}}
                                            </td>
                                          </tr>
                                      @endif
                                       @endforeach
                                      </tbody>
                                       </table>
                                       </td>
                                       </tr>
                                      
                                     </table>
        </div>
        <div class="modal-footer" style="padding:1px;">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
    </div>
@endforeach
                                </div>
                                        <div class="panel-footer">
                                                  @if(Auth::user()->group_id == 7)
                                        <center>{{ $projects->links() }}</center>
                                                  @else
                                                  <center>
                                                       <ul class="pagination">
                                                          {{ $projects->links() }}
                                                      </ul> 
                                                  </center>
                                                  @endif
                                         </div>
  </div>
 </div>
  </div>
    </div>  
<script type="text/javascript">

//  Reuben

function updatemat(arg)
    {
      var x = confirm('Are You Sure ?');
      if(x)
      {
        var e = document.getElementById('mat-'+arg).value;
        $.ajax({
          type: 'get',
          url: "{{URL::to('/')}}/"+arg+"/updatemat",
          data: {opt: e},
          async: false,
          success: function(response)
          {
            location.reload(true);
          }
        });         
      }
      return false;
    }

// Ends Reuben's line
  
  
    function view(arg){
        document.getElementById('hidepanelright').style.display = 'initial';//Make the whole panel visible
        var x = parseInt(arg);
        document.getElementsByName('addenquiry').id = x;
        document.getElementById('seldetprojname').innerHTML = document.getElementById('projname-'+arg).innerHTML;
        document.getElementById('seldetprojsite').innerHTML = document.getElementById('projsite-'+arg).innerHTML;
        document.getElementById('seldetprojproc').innerHTML = document.getElementById('projproc-'+arg).innerHTML;
        document.getElementById('seldetprojcont').innerHTML = document.getElementById('projcont-'+arg).innerHTML;
        for(var i =0; i<100000; i++)
        {
            if(document.getElementById('table-'+i))
            {
                document.getElementById('table-'+i).style.display = 'initial';
            }
        }
        for(var i=0; i<100000; i++){
            if(i != x)
            {
               if(document.getElementById('table-'+i))
                   document.getElementById('table-'+i).style.display = 'none';
            }
        }
        return false;
    }
    
    function confirmthis(arg)
    {
      var x = confirm('Are You Sure ?');
      if(x){
        var e = document.getElementById("select-"+arg);
        var opt = e.options[e.selectedIndex].value;
        $.ajax({
          type: 'get',
          url: "{{URL::to('/')}}/"+arg+"/confirmthis",
          data: {opt: opt},
          async: false,
          success: function(response)
          {
            location.reload(true);
          }
        });
      }
      return false;
    }

    function checkdate(arg)
    {
      var today        = new Date();
      var day        = (today.getDate().length ==1?"0"+today.getDate():today.getDate()); //This line by Siddharth
      var month        = parseInt(today.getMonth())+1;
      month            = (today.getMonth().length == 1 ? "0"+month : "0"+month);
      var e        = parseInt(month);  //This line by Siddharth
      var year       = today.getFullYear();
      var current_date = new String(year+'-'+month+'-'+day);
      //Extracting individual date month and year and converting them to integers
      var val = document.getElementById(arg).value;
      var c   = val.substring(0, val.length-6);
      c       = parseInt(c);
      var d   = val.substring(5, val.length-3);
      d       = parseInt(d);
      var f   = val.substring(8, val.length);
      f       = parseInt(f);
      var select_date = new String(c+'-'+d+'-'+f);
      if (c < year) {
        alert('Previous dates not allowed');
        document.getElementById(arg).value = null; 
        document.getElementById(arg).focus();
        return false;   
      }
      else if(c === year && d < e){
        alert('Previous dates not allowed');
        document.getElementById(arg).value = null;
        document.getElementById(arg).focus(); 
        return false; 
      }
      else if(c === year && d === e && f < day){
        alert('Previous dates not allowed');
        document.getElementById(arg).value = null;
        document.getElementById(arg).focus(); 
        return false; 
      }
      else{
        return false;
      }
      //document.getElementById('rDate').value = current_date;    
      }

    function confirmstatus(arg)
    {
      var x = confirm('Are You Sure To Confirm Status ?');
      if(x)
      {
        $.ajax({
          type: 'get',
          url: "{{URL::to('/')}}/"+arg+"/confirmstatus",
          data: {opt: arg},
          async: false,
          success: function(response)
          {
            location.reload(true);
          }
        });
      }
      return false;
    }

    function updatestatus(arg)
    {
      var x = confirm('Are You Sure ?');
      if(x)
      {
        var e = document.getElementById('statusproj-'+arg);
        var opt = e.options[e.selectedIndex].value;
        $.ajax({
          type: 'get',
          url: "{{URL::to('/')}}/"+arg+"/updatestatus",
          data: {opt: opt},
          async: false,
          success: function(response)
          {
            location.reload(true);
          }
        });         
      }
      return false;
    }

    function updatelocation(arg)
    {
      var text = document.getElementById('location-'+arg).value;
      var x = confirm('Do You Want To Save The Changes ?');
      if(x)
      {
        var newtext = document.getElementById('location-'+arg).value; 
        $.ajax({
          type: 'get',
          url: "{{URL::to('/')}}/"+arg+"/updatelocation",
          async: false,
          data: {newtext: newtext},
          success: function(response)
          {
            location.reload(true);
          }
        });
      }
      else
      {
        document.getElementById('location-'+arg).value = text;
      }
    }
    
    function updateOwner(arg)
    {
        var x = confirm('Save Changes ?');
        if(x)
        {
            var id = parseInt(arg);
            var name = document.getElementById('ownername-'+arg).value;
            var phone = document.getElementById('ownerphone-'+arg).value;
            var email = document.getElementById('owneremail-'+arg).value;
            
            $.ajax({
               type: 'GET',
               url: "{{URL::to('/')}}/updateOwner",
               data: {name:name, phone:phone, email:email, id:id},
               async: false,
               success: function(response)
               {
                   console.log(response);
               }
            });
        }
    }
        function updateConsultant(arg)
    {
        var x = confirm('Save Changes ?');
        if(x)
        {
            var id = parseInt(arg);
            var name = document.getElementById('consultantname-'+arg).value;
            var phone = document.getElementById('consultantphone-'+arg).value;
            var email = document.getElementById('consultantemail-'+arg).value;
            alert(id);
            $.ajax({
               type: 'GET',
               url: "{{URL::to('/')}}/updateConsultant",
               data: {name:name, phone:phone, email:email, id:id},
               async: false,
               success: function(response)
               {
                   console.log(response);
               }
            });
        }
    }
    function updateContractor(arg)
    {
        var x = confirm('Save Changes ?');
        if(x)
        {
            var id = parseInt(arg);
            var name = document.getElementById('contractorname-'+arg).value;
            var phone = document.getElementById('contractorphone-'+arg).value;
            var email = document.getElementById('contractoremail-'+arg).value;
            
            $.ajax({
               type: 'GET',
               url: "{{URL::to('/')}}/updateContractor",
               data: {name:name, phone:phone, email:email, id:id},
               async: false,
               success: function(response)
               {
                   console.log(response);
               }
            });
        }
    }
    function updateProcurement(arg)
    {
        var x = confirm('Save Changes ?');
        if(x)
        {
            var id = parseInt(arg);
            var name = document.getElementById('procurementname-'+arg).value;
            var phone = document.getElementById('procurementphone-'+arg).value;
            var email = document.getElementById('procurementemail-'+arg).value;
            
            $.ajax({
               type: 'GET',
               url: "{{URL::to('/')}}/updateProcurement",
               data: {name:name, phone:phone, email:email, id:id},
               async: false,
               success: function(response)
               {
                   console.log(response);
               }
            });
        }
    }
    function addrequirement(){
        var id = document.getElementsByName('addenquiry').id;
        window.location.href="{{ URL::to('/') }}/inputview?projectId="+id;
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
<!--This line by Siddharth -->
<script type="text/javascript">
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

  function addRow(arg) {
        var table = document.getElementById("bhk"+arg);
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

<script>
  
  function displayDate(){
    document.getElementById('demo').innerHTML=Date();

  }

</script>

<script>
function myfunction(){
  document.getElementByName('form').submit();
}  
</script>

<script>
function dis(){

    if (document.getElementById("a").checked){
        document.getElementById('b').disabled=true;
}


</script>


  
  @endsection
