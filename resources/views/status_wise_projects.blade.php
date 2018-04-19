@extends('layouts.app')

@section('content')
<div class="col-md-10" >
        <div class="panel panel-primary" style="overflow-x:scroll">
            <div class="panel-heading" id="panelhead">
               <h2>Project Details</h2> 
                
            </div>
            <div class="panel-body">
                <table class='table table-responsive table-striped' style="color:black" border="1">
                    <thead>
                        <tr>
                            <th style="text-align:center">Ward No.</th>
                            <th style="text-align:center">Project-ID</th>
                            <th style="text-align:center">Owner Contact Number</th>

                            <th style="text-align:center">Site Engineer Contact Number</th>
                            <th style="text-align:center">Procurement Contact Number</th>
                            <th style="text-align:center">Consultant Contact Number</th>
                            <th style="text-align:center">Contractor Contact Number</th>
                            <th style="text-align:center">project status</th>

                            <!-- <th style="text-align:center">Listing Engineer</th> -->
                            <!--<th style="text-align:center">Verification</th>-->
                        </tr>
                    </thead>
                    <tbody id="mainPanel">
                        @foreach($projects as $project)
                        <tr>
                            <td style="text-align:center">{{ $project->sub_ward_name }}</td>
                            <td style="text-align:center"><a href="{{ URL::to('/') }}/admindailyslots?projectId={{$project->project_id}}&&lename={{ $project->name }}">{{ $project->project_id }}</a></td>
                            
                            <td style="text-align:center">{{$project->owner_contact_no}}</td>
                            <td style="text-align:center">{{$project->site_engineer_contact_no}}</td>
                            <td style="text-align:center">{{$project->procurement_contact_no}}</td>
                            <td style="text-align:center">{{$project->consultant_contact_no}}</td>
                            <td style="text-align:center">{{$project->contractor_contact_no}}</td>
                             <td style="text-align:center">{{$project->project_status}}</td>
                            <!-- <td style="text-align:center" id="listname-{{$project->project_id}}">
                                {{$project->name}}
                                <input type="hidden" id="hiddeninp-{{$project->project_id}}" value="{{$project->listing_engineer_id}}" />
                            </td>
 -->                            <!--<td style="text-align:center"><a onclick="" class="btn btn-sm btn-danger">Verify</a></td>-->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <center>
                        {{$projects->links()}}
                </center>
            </div>
        </div>
    </div>


@endsection