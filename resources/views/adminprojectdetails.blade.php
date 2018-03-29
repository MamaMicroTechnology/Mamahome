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
                    <h3>Project Details</h3>
                        <center style="font-size: 15px;"><i><b>*This project is added by {{ $username->name }} ({{ $username->department->dept_name }} department)*</b></i></center>
                    <table class="table table-responsive">
                        <tbody>
                            <tr>
                                <td style="width:40%;"><b>Project ID</b></td>
                                <td>{{$rec->project_id}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Project Name</b></td>
                                <td>{{$rec->project_name}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Road Name</b></td>
                                <td>{{$rec->road_name}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Project Status</b></td>
                                <td>{{$rec->project_status}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Project Size</b></td>
                                <td>{{$rec->project_size}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Project Quality</b></td>
                                <td>{{$rec->quality==null?"Unverified":$rec->Quality}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Basement</b></td>
                                <td>{{$rec->basement}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Ground</b></td>
                                <td>{{$rec->ground}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Project Image</b></td>
                                <td><img class="img img-responsive" src="{{URL::to('/')}}/public/projectImages/{{$rec->image}}" style="height:200px;width:200px" /></td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Contractor</b></td>
                                @if($rec->contract != '')
                                    <td>{{ $rec->contract }}</td>
                                @else
                                    <td> -- Unspecified -- </td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <h3>Procurement Details</h3>
                    <table class="table table-responsive">
                        <tbody>
                            <tr>
                                <td style="width:40%;"><b>Procurement Name</b></td>
                                <td>{{$rec->procurementdetails->procurement_name}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Procurement Contact No</b></td>
                                <td>{{$rec->procurementdetails->procurement_contact_no}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Procurement Email</b></td>
                                <td>{{$rec->procurementdetails->procurement_email}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <h3>Consultant Details</h3>
                    <table class="table table-responsive">
                        <tbody>
                            <tr>
                                <td style="width:40%;"><b>Consultant Name</b></td>
                                <td>{{$rec->consultantdetails->consultant_name}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Consultant Contact No</b></td>
                                <td>{{$rec->consultantdetails->consultant_contact_no}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Consultant Email</b></td>
                                <td>{{$rec->consultantdetails->consultant_email}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <h3>Contractor Details</h3>
                    <table class="table table-responsive">
                        <tbody>
                            <tr>
                                <td style="width:40%;"><b>Contractor Name</b></td>
                                <td>{{$rec->contractordetails->contractor_name}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Contractor Contact No</b></td>
                                <td>{{$rec->contractordetails->contractor_contact_no}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Contractor Email</b></td>
                                <td>{{$rec->contractordetails->contractor_email}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <h3>Owner Details</h3>
                    <table class="table table-responsive">
                        <tbody>
                            <tr>
                                <td style="width:40%;"><b>Owner Name</b></td>
                                <td>{{$rec->ownerdetails->owner_name}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Owner Name</b></td>
                                <td>{{$rec->ownerdetails->owner_contact_no}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Owner Name</b></td>
                                <td>{{$rec->ownerdetails->owner_email}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>    
@endsection    