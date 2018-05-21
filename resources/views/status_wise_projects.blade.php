@extends('layouts.app')

@section('content')
<div class="col-md-10 col-md-offset-1" >
        <div class="panel panel-primary"  style="overflow-x:scroll">
            <div class="panel-heading" id="panelhead" style="background-color: rgb(244, 129, 31);">

               <h2>
                   <div class="pull-right"></div>
               <h2>Project Details Of 
                    {{ $status[0] }} Stage
                   <div class="pull-right">{{ $totalListing }} Projects Found</div>
               </h2> 
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
                            <th style="text-align:center">Add Enquiry</th> 
                             <th style="text-align:center">Action</th>
                             <th style="text-align:center">No Of Times Called</th>  
                        </tr>
                    </thead>
                    <tbody id="mainPanel">
                        @foreach($projects as $project)
                       
                        <tr>
                            <td style="text-align:center">{{ $project->sub_ward_name }}</td>
                            <td style="text-align:center"><a href="{{ URL::to('/') }}/admindailyslots?projectId={{$project->project_id}}&&lename={{ $project->name }}">{{ $project->project_id }}</a></td>
                            <td style="text-align:center">{{$project->ownerdetails != null ? $project->ownerdetails->owner_contact_no : ''}}</td>
                            <td style="text-align:center">{{$project->siteengineerdetails != null ? $project->siteengineerdetails->site_engineer_contact_no : ''}}</td>
                            <td style="text-align:center">{{$project->procurementdetails != null ? $project->procurementdetails->procurement_contact_no : ''}}</td>
                            <td style="text-align:center">{{$project->consultantdetails != null ? $project->consultantdetails->consultant_contact_no : ''}}</td>
                            <td style="text-align:center">{{$project->contractordetails != null ? $project->contractordetails->contractor_contact_no : ''}}</td>
                            <td> <a class="btn btn-sm btn-primary " name="addenquiry" href="{{ URL::to('/') }}/requirements?projectId={{ $project->project_id }}" style="color:white;font-weight:bold;background-color: green">Add Enquiry</a></td>
                            <td>
                                <form method="post" action="{{ URL::to('/') }}/confirmedProject">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $project->project_id }}" name="id">
                                     @if( $project->confirmed !== "0" ||  $project->confirmed == "true" || $project->confirmed !== "NULL" )
                                 <button type="button" class="btn btn-danger"  {{ $project->confirmed !== "0" ||  $project->confirmed == "true" ? 'checked': ''}}  name="confirmed" onclick="this.form.submit()">Called</button>
                                @endif
                                        @if( $project->confirmed == "0" ||  $project->confirmed == "false" || $project->confirmed == "NULL" )
                                 <button type="button" class="btn btn-success" {{ $project->confirmed !== "0" ||  $project->confirmed == "true" ? 'checked': ''}}  name="confirmed" onclick="this.form.submit()">Called</button>
                                @endif
                                          
                                      
                                </form>
                                <td>{{  $project->confirmed }}</td>
                            </td>

                            <td><p >{{$project->updated_at}}</p></td> 
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
