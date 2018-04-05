@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
               <b style="color:white">Project Details
                <a href="{{ URL::to('/') }}/ameditProject?projectId={{ $details->project_id }}" class="btn btn-warning btn-sm pull-right">Edit</a>
               </b> 
            </div>
            <div class="panel-body">
                <table class="table table-responsive table-striped table-hover">
                    <tbody>
                        <tr>
                            <td style="width:40%"><b>Project Id</b></td>
                            <td>{{ $details->project_id }}</td>
                        </tr>
                        <tr>
                            <td><b>Project Name</b></td>
                            <td>{{ $details->project_name }}</td>
                        </tr>
                        <tr>
                            <td><b>Status</b></td>
                            <td>{{ $details->project_status }}</td>
                        </tr>
                        <tr>
                            <td><b>Owner Name</b></td>
                            <td>{{ $details->ownerdetails->owner_name }}</td>
                        </tr>
                        <tr>
                            <td><b>Owner Email</b></td>
                            <td>{{ $details->ownerdetails->owner_email }}</td>
                        </tr>
                        <tr>
                            <td><b>Owner Contact</b></td>
                            <td>{{ $details->ownerdetails->owner_contact_no }}</td>
                        </tr>
                        <tr>
                            <td><b>Basement</b></td>
                            <td>{{ $details->basement }}</td>
                        </tr>
                        <tr>
                            <td><b>Ground</b></td>
                            <td>{{ $details->ground }}</td>
                        </tr>
                            <tr>
                            <td><b>Project Type</b></td>
                            <td>{{ $details->project_type }}</td>
                        </tr>
                            <tr>
                            <td><b>Project Size</b></td>
                            <td>{{ $details->project_size }}</td>
                        </tr>
                        <tr>
                            <td><b>Listing Engineer</b></td>
                            <td>
                                <?php echo $_GET['lename']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Road</b></td>
                            <td>{{ $details->road_name }}</td>
                        </tr>
                        <tr>
                            <td><b>Address</b></td>
                            <td>{{ $details->siteaddress->address }}</td>
                        </tr>
                        <tr>
                            <td><b>Project Image</b></td>
                            <td>
                                <img height="300" width="300" class="img img-responsive" src="{{ URL::to('/') }}/public/projectImages/{{ $details->image }}">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Municipality Approval</b></td>
                            <td>
                                @if($details->municipality_approval != "N/A")
                                <img height="300" width="300" class="img img-responsive" src="{{ URL::to('/') }}/public/projectImages/{{ $details->municipality_approval }}">
                                @else
                                N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><b>Other Approval</b></td>
                            <td>
                                @if($details->other_approvals != "N/A")
                                <img height="300" width="300" class="img img-responsive" src="{{ URL::to('/') }}/public/projectImages/{{ $details->other_approvals }}">
                                @else
                                N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><b>Budget (Cr.)</b></td>
                            <td>
                                {{ $details->budget }} Cr.
                            </td>
                        </tr>
                        <tr>
                            <td><b>Type of Contract</b></td>
                            <td>
                                @if($details->contract == "With Material Contractor")
                                    Material Contract
                                @elseif($details->contract == "With Labour Contractor")
                                    Labour Contract
                                @else
                                    {{ $details->contract }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><b>Remarks</b></td>
                            <td>
                                {{ $details->remarks }}
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
                            <td>{{ $details->procurementdetails->procurement_name }}</td>
                            <td>{{ $details->procurementdetails->procurement_contact_no }}</td>
                            <td>{{ $details->procurementdetails->procurement_email }}</td>
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
                            <td>{{ $details->siteengineerdetails->site_engineer_name }}</td>
                            <td>{{ $details->siteengineerdetails->site_engineer_contact_no }}</td>
                            <td>{{ $details->siteengineerdetails->site_engineer_email }}</td>
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
               <b style="color:white">Contractor Details</b> 
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <th>Contractor Name</th>
                        <th>Contractor Email</th>
                        <th>Contractor Contact</th>
                    </thead>    
                    <tbody>
                        <tr>
                            <td>{{ $details->contractordetails->contractor_name }}</td>
                            <td>{{ $details->contractordetails->contractor_email }}</td>
                            <td>{{ $details->contractordetails->contractor_contact_no }}</td>
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
               <b style="color:white">Constultant Details</b> 
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <th>Constultant Name</th>
                        <th>Constultant Email</th>
                        <th>Constultant Contact</th>
                    </thead>    
                    <tbody>
                        <tr>
                            <td>{{ $details->consultantdetails->consultant_name }}</td>
                            <td>{{ $details->consultantdetails->consultant_email }}</td>
                            <td>{{ $details->consultantdetails->consultant_contact_no }}</td>
                        </tr>
                    </tbody>
                </table>        
            </div>
        </div>
    </div>
</div>
        
        

@endsection