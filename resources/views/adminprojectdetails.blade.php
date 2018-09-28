<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 4? "layouts.amheader":"layouts.app");
?>
@extends($ext)
@section('content')
    <div class="col-md-12">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary" style="overflow-x:scroll">
                <div class="panel-heading text-center">
                    <b style="color:white;font-size:1.4em">Project Details</b>
                    <a href="{{ URL::to('/') }}/ameditProject?projectId={{ $rec->project_id }}" class="btn btn-warning btn-sm pull-right">Edit</a>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive table-striped table-hover">
                    <tbody>
                        <tr>
                            <td style="width:40%"><b>Listed On: </b></td>
                            
                            <td>{{ date('d-m-Y h:i:s A',strtotime($rec->created_at)) }}</td>
                        </tr>
                       
                         @if(Auth::check())
                        @if(Auth::user()->department_id != 2)
                        <tr>
                            <td><b>Listed By : </b></td>
                            <td>
                                {{ $listedby != null ? $listedby->name : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:40%"><b>Call Attended By : </b></td>
                            <td>{{ $callAttendedBy != null ? $callAttendedBy->name: '' }}</td>
                        </tr>
                        @endif
                        @endif
                        <tr>
                            <td style="width:40%"><b>Updated On : </b></td>
                            <td>{{ date('d-m-Y h:i:s A',strtotime($rec->updated_at)) }}</td>
                        </tr>
                        
                        <tr>
                            <td><b>Project Name : </b></td>
                            <td>{{ $rec->project_name }}</td>
                        </tr>
                        <tr>
                            <td><b>Road Name/Road No./Landmark : <b></td>
                            <td>{{ $rec->road_name }}</td>
                        </tr>
                        <tr>
                            <td><b>Road Width : <b></td>
                            <td>{{ $rec->road_width}}</td>
                        </tr>
                       <tr>
                            <td><b>Address : </b></td>
                            <td>
                                <a target="_blank" href="https://maps.google.com?q={{$rec->siteaddress != null ? $rec->siteaddress->address : ''}}">{{$rec->siteaddress != null ? $rec->siteaddress->address : ''}}</a>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Construction Type : </b></td>
                            <td>{{ $rec->construction_type }}</td>
                        </tr>
                        <tr>
                            <td><b>Interested in RMC ? : </b></td>
                            <td>{{ $rec->interested_in_rmc }}</td>
                        </tr>
                        <tr>
                            <td><b>Interested In Bank Loans ? :</b></td>
                            <td>{{ $rec->interested_in_loan }}</td>
                        </tr>
                         <tr>
                            <td><b>Interested in UPVC Doors and Windows ? : </b></td>
                            <td>{{ $rec->interested_in_doorsandwindows }}</td>
                        </tr>
                         <tr>
                            <td><b>Interested in Home Automation ? : </b></td>
                            <td>{{ $rec->automation }}</td>
                        </tr>
                        <tr>
                            <td><b>Interested In Kitchen Cabinates and Wardrobes ? : </b></td>
                            <td>{{ $details->interested_in_doorsandwindows }}</td>
                        </tr>
                        <tr>
                            <td><b>Interested In Brila Super / Ultratech Products? : </b></td>
                            <td>{{ $details->brilaultra }}</td>
                        </tr>
                         <tr>
                            <td><b>Interested in Premium Products ? : </b></td>
                            <td>{{ $rec->interested_in_premium }}</td>
                        </tr>
                        <tr>
                            <td><b>Type of Contract : </b></td>
                            <td>
                                @if($rec->contract == "With Material Contractor")
                                    Material Contract
                                @elseif($rec->contract == "With Labour Contractor")
                                    Labour Contract
                                @else
                                    {{ $rec->contract }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:40%"><b>Sub-ward : </b></td>
                            <td>{{ $subward }}</td>
                        </tr>
                        <tr>
                            @if($rec->municipality_approval == "N/A")
                            <td><b>Govt. Approvals(Municipal, BBMP, etc) : </b></td>
                            <td>None</td>
                            @else
                            <td><b>Govt. Approvals(Municipal, BBMP, etc) : </b></td>
                            <td><img height="350" width="350"  src="{{ URL::to('/') }}/public/projectImages/{{ $rec->municipality_approval }}" class="img img-thumbnail"></td>
                            @endif
                        </tr>
                         <tr>
                            <td><b>Project Status : </b></td>
                            <td>{{ $rec->project_status }}</td>
                        </tr>
                        <tr>
                            <td><b>Project Type : </b></td>
                            <td>B{{ $rec->basement }} + G + {{ $rec->ground }} = {{ $rec->basement + $rec->ground + 1 }}</td>
                        </tr>
                         <tr>
                            <td><b>Project Size : </b></td>
                            <td>{{ $rec->project_size }}</td>
                        </tr>
                        <tr>
                            <td><b>Plot Size : </b></td>
                            <td>L({{ $rec->length }}) * B ({{ $rec->breadth }}) = {{ $rec->plotsize }}</td>
                        </tr>
                       <tr> 
                            <td><b>Budget (Cr.) : </b></td>
                            <td>
                                {{ $rec->budget }} Cr.              [  {{  $rec->budgetType   }}  ]
                            </td>
                        </tr>
                        <tr>
                                <td style="width:40%;"><b>Budget (per sq.ft) :</b></td>
                                <td>
                                    @if($rec->project_size != 0)
                                        {{ round((10000000 * $rec->budget)/$rec->project_size,3) }}
                                    @endif
                                </td>
                        </tr>
                        <tr>
                            <td><b>Project Image : </b></td>
                            <td>
                               <?php
                                               $images = explode(",", $rec->image);
                                               ?>
                                             <div class="row">
                                                 @for($i = 0; $i < count($images); $i++)
                                                     <div class="col-md-3">
                                                          <img height="350" width="350"  src="{{ URL::to('/') }}/public/projectImages/{{ $images[$i] }}" class="img img-thumbnail">
                                                     </div>
                                                 @endfor
                                              </div>
                            </td>
                            </td>
                        </tr>
                        
                        <tr>
                                 <td><b>Image Updated On : </b></td>
                                
                                  @if($projectupdate == null)
                                  <td>{{ date('d-m-Y h:i:s A', strtotime($rec->created_at))}}</td>
                                  @else
                                      <td>{{ date('d-m-Y h:i:s A', strtotime($projectupdate))}}</td>
                                  @endif
                               </tr>
                        <tr>
                        <tr>
                            <td style="width:40%"><b>Followup Started : </b></td>
                            <td>{{ $rec->followup }} @if($followupby) (marked by {{ $followupby->name }}) @endif</td>
                        </tr>
                        <tr>
                            <td><b>Remarks : </b></td>
                            <td>
                                {{ $rec->remarks }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>
        </div>
    </div>
</div>
                

<div class="col-md-12">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default" style="border-color:orange">
            <div class="panel-heading" style="background-color:orange">
               <b style="color:white">Room Types</b> 
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <th>Floor No.</th>
                        <th>Room Type</th>
                        <th>No. Of House</th>
                    </thead>
                    <tbody>
                        @foreach($roomtypes as $roomtype)
                        <tr>
                            <td>{{ $roomtype->floor_no }}</td>
                            <td>{{ $roomtype->room_type }}</td>
                            <td>{{ $roomtype->no_of_rooms }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>        
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default" style="border-color:green">
            <div class="panel-heading" style="background-color:green">
               <b style="color:white">Owner Details</b> 
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <th>Owner Name</th>
                        <th>Owner Contact</th>
                        <th>Owner Email</th>
                    </thead>
                    <tbody>
                        <tr>
                             <td>{{ $rec->ownerrec != null ? $rec->ownerrec->owner_name : '' }}</td>
                              <td>{{ $rec->ownerrec != null ? $rec->ownerrec->owner_contact_no : '' }}</td>
                           <td>{{ $rec->ownerrec != null ? $rec->ownerrec->owner_email : '' }}</td>
                           
                        </tr>
                    </tbody>
                </table>        
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default" style="border-color:orange">
            <div class="panel-heading" style="background-color:orange">
               <b style="color:white">Contractor Details</b> 
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <th>Contractor Name</th>
                         <th>Contractor Contact</th>
                         <th>Contractor Email</th>
                    </thead>    
                    <tbody>
                        <tr>
                            <td>{{ $rec->contractordetails != null ? $rec->contractordetails->contractor_name : '' }}</td>
                            <td>{{ $rec->contractordetails != null ? $rec->contractordetails->contractor_contact_no : '' }}</td>
                            <td>{{ $rec->contractordetails != null ? $rec->contractordetails->contractor_email : '' }}</td>
                        </tr>
                    </tbody>
                </table>        
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default" style="border-color:green">
            <div class="panel-heading" style="background-color:green">
               <b style="color:white">Constultant Details</b> 
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <th>Constultant Name</th>
                       <th>Constultant Contact</th>
                       <th>Constultant Email</th>
                    </thead>    
                    <tbody>
                        <tr>
                            <td>{{ $rec->consultantdetails != null ? $rec->consultantdetails->     consultant_name : '' }}</td>
                              <td>{{ $rec->consultantdetails != null ? $rec->consultantdetails->consultant_contact_no : '' }}</td>
                            <td>{{ $rec->consultantdetails != null ? $rec->consultantdetails->consultant_email : '' }}</td>
                        </tr>
                    </tbody>
                </table>        
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default" style="border-color:orange">
            <div class="panel-heading" style="background-color:orange">
               <b style="color:white">Site Engineer Details</b> 
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <th>Site Engineer Name</th>
                        <th>Site Engineer Contact</th>
                        <th>Site Engineer Email</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $rec->siteengineerdetails != null ? $rec->siteengineerdetails->site_engineer_name : '' }}</td>
                            <td>{{ $rec->siteengineerdetails != null ? $rec->siteengineerdetails->site_engineer_contact_no : '' }}</td>
                            <td>{{ $rec->siteengineerdetails != null ? $rec->siteengineerdetails->site_engineer_email : '' }}</td>
                        </tr>
                    </tbody>
                </table>        
            </div>
        </div>
    </div>
</div>  
<div class="col-md-12">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default" style="border-color:green">
            <div class="panel-heading" style="background-color:green">
               <b style="color:white">Procurement Details</b> 
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <th>Procurement Name</th>
                        <th>Procurement Contact</th>
                        <th>Procurement Email</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $rec->procurementdetails != null ? $rec->procurementdetails->procurement_name : '' }}</td>
                            <td>{{ $rec->procurementdetails != null ? $rec->procurementdetails->procurement_contact_no : '' }}</td>
                            <td>{{ $rec->procurementdetails != null ? $rec->procurementdetails->procurement_email : '' }}</td>
                        </tr>
                    </tbody>
                </table>        
            </div>
        </div>
    </div>
</div>   
@endsection    
