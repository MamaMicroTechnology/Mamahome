@extends('layouts.logisticslayout')
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
                    <table class="table table-responsive">
                        <tbody>
                            <tr>
                                <td style="width:40%"><b>Listed On</b></td>
                                <td>{{ date('d-m-Y h:i:s A',strtotime($rec->created_at)) }}</td>
                            </tr>
                            <tr>
                                <td style="width:40%"><b>Updated On</b></td>
                                <td>{{ date('d-m-Y h:i:s A',strtotime($rec->updated_at)) }}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Project ID</b></td>
                                <td>{{$rec->project_id}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Project Name</b></td>
                                <td>{{$rec->project_name}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Address</b></td>
                                <td>
                                    <a target="_blank" href="https://maps.google.com?q={{$rec->siteaddress != null ? $rec->siteaddress->address : ''}}">{{$rec->siteaddress != null ? $rec->siteaddress->address : ''}}</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Road Width</b></td>
                                <td>{{ $rec->road_width }}</td>
                            </tr>
                            <tr>
                                <td><b>Construction Type</b></td>
                                <td>{{ $rec->construction_type }}</td>
                            </tr>
                            <tr>
                                <td><b>Interested in RMC</b></td>
                                <td>{{ $rec->interested_in_rmc }}</td>
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
                                <td style="width:40%;"><b>Project Type</b></td>
                                <td>
                                    B{{ $rec->basement}} + G + {{ $rec->ground }}= 
                                    {{$rec->project_type}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Project Image</b></td>
                                <td><img class="img img-responsive" src="{{URL::to('/')}}/public/projectImages/{{$rec->image}}" style="height:200px;width:200px" /></td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Contract</b></td>
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
                                <td style="width:40%;"><b>Total Budget (in Cr.)</b></td>
                                <td>{{$rec->budget}} Cr. ({{ $rec->budgetType }})</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Budget (per sq.ft)</b></td>
                                <td>{{ round((10000000 * $rec->budget)/$rec->project_size,3) }}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Remarks</b></td>
                                <td>{{$rec->remarks}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Note</b></td>
                                <td>{{$rec->note}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <h3>Room Types</h3>
                    <table class="table table-responsive">
                         <thead>
                            <th>Floor No.</th>
                            <th>Room Types</th>
                            <th>No.of Houses</th>
                         </thead>
                         <tbody>
                         @foreach($roomtypes as $roomtype)
                            <tr>
                                <td>Floor {{ $roomtype->floor_no }}</td>
                                <td>{{ $roomtype->room_type }}</td>
                                <td>{{ $roomtype->no_of_rooms }}</td>
                            </tr>
                            @endforeach
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
                                <td style="width:40%;"><b>Owner Contact No</b></td>
                                <td>{{$rec->ownerdetails->owner_contact_no}}</td>
                            </tr>
                            <tr>
                                <td style="width:40%;"><b>Owner Email</b></td>
                                <td>{{$rec->ownerdetails->owner_email}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>    
@endsection    
