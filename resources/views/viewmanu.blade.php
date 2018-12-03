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
                    <b style="color:white;font-size:1.4em">Manufacturer Details</b>
                    <a href="{{ URL::to('/') }}/updateManufacturerDetails?id={{ $project->id }}" class="btn btn-warning btn-sm pull-right">Edit</a>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive table-striped table-hover">
                    <tbody>
                        <tr>
                            <td style="width:40%"><b>Listed On: </b></td>
                            
                            <td>{{ date('d-m-Y h:i:s A',strtotime($project->created_at)) }}</td>
                        </tr>
                       
                         @if(Auth::check())
                        @if(Auth::user()->department_id != 2)
                        <tr>
                            <td><b>Listed By : </b></td>
                            <td>
                                {{ $project->user != null ? $project->user->name : '' }}
                            </td>
                        </tr>
                       <!--  <tr>
                            <td style="width:40%"><b>Call Attended By : </b></td>
                            <td>{{ $project->user != null ? $project->user->name : '' }}</td>
                        </tr> -->
                        @endif
                        @endif
                        <tr>
                            <td style="width:40%"><b>Updated On : </b></td>
                            <td>{{ date('d-m-Y h:i:s A',strtotime($project->updated_at)) }}</td>
                        </tr>
                        
                        <tr>
                            <td><b>Plant Name : </b></td>
                            <td>{{ $project->plant_name }}</td>
                        </tr>
                        <tr>
                            <td><b>Manufacturer Type: <b></td>
                            <td>{{ $project->manufacturer_type }}</td>
                        </tr>
                        <tr>
                            <td><b>Manufacturer Quality: <b></td>
                            <td>{{ $project->quality }}</td>
                        </tr>
                         <tr>
                            <td><b>Manufacturer Capacity: <b></td>
                            <td>{{ $project->capacity }}</td>
                        </tr>
                          <tr>
                            <td><b>Manufacturer Cement Requirement : <b></td>
                            <td>{{ $project->cement_requirement  }}</td>
                        </tr>
                          <tr>
                            <td><b>Manufacturer Prefered Cement Brands : <b></td>
                            <td>{{ $project->prefered_cement_brand   }}</td>
                        </tr>
                         <tr>
                            <td><b>Manufacturer Sample Request : <b></td>
                            <td>{{ $project->sample   }}</td>
                        </tr>
                            
                       <tr>
                            <td><b>Address : </b></td>
                            <td>
                                <a target="_blank" href="https://maps.google.com?q={{$project->address }}">{{$project->address}}</a>
                            </td>
                        </tr>
                      
                        <tr>
                            <td style="width:40%"><b>Sub-ward : </b></td>
                            <td><a href="{{ URL::to('/')}}/viewsubward?manu_id={{$project->id}} && subward={{ $project->subward != null ?$project->subward->sub_ward_name:'' }}" data-toggle="tooltip" data-placement="top" title="click here to view map" class="red-tooltip" target="_blank">{{ $project->subward != null?$project->subward->sub_ward_name:'' }}
                                    </a></td>
                        </tr>
                       
                       
                       <tr> 
                            <td><b>Total_Area  : </b></td>
                            <td>
                                {{ $project->total_area  }}  
                            </td>
                        </tr>
                       
                        <tr>
                            <td><b>Project Image : </b></td>
                            <td>
                               <?php
                                               $images = explode(",", $project->image);
                                               ?>
                                             <div class="row">
                                                 @for($i = 0; $i < count($images); $i++)
                                                     <div class="col-md-3">
                                                          <img height="350" width="350"  src="{{ URL::to('/') }}/public/Manufacturerimage/{{ $images[$i] }}" class="img img-thumbnail">
                                                     </div>
                                                 @endfor
                                              </div>
                            </td>
                            </td>
                        </tr>
                        
                        <tr>
                            <td><b>Remarks : </b></td>
                            <td>
                                {{ $project->remarks }}
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
                             <td>{{ $project->owner != null ? $project->owner->name : '' }}</td>
                              <td>{{ $project->owner != null ? $project->owner->contact : '' }}</td>
                           <td>{{ $project->owner != null ? $project->owner->email : '' }}</td>
                           
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
               <b style="color:white">Manager Details</b> 
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <th>Manager Name</th>
                         <th>Manager Contact</th>
                         <th>Manager Email</th>
                    </thead>    
                    <tbody>
                        <tr>
                            <td>{{ $project->Manager != null ? $project->Manager->name : '' }}</td>
                            <td>{{ $project->Manager != null ? $project->Manager->contact: '' }}</td>
                            <td>{{ $project->Manager != null ? $project->Manager->email : '' }}</td>
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
               <b style="color:white">Sales Engineer Details</b> 
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <th>Sales Engineer Name</th>
                       <th>Sales Engineer Contact</th>
                       <th>Sales Engineer Email</th>
                    </thead>    
                    <tbody>
                        <tr>
                            <td>{{ $project->sales != null ? $project->sales->name : '' }}</td>
                              <td>{{ $project->sales != null ? $project->sales->contact : '' }}</td>
                            <td>{{ $project->sales != null ? $project->sales->email : '' }}</td>
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
                            <td>{{ $project->proc != null ? $project->proc->name : '' }}</td>
                            <td>{{ $project->proc != null ? $project->proc->contact : '' }}</td>
                            <td>{{ $project->proc != null ? $project->proc->email : '' }}</td>
                        </tr>
                    </tbody>
                </table>        
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
     background-color: #00acd6 

});
</script> 
@endsection    
