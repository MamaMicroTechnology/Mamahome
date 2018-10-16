<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 6? "layouts.leheader":"layouts.app");
?>
@extends($ext)
@section('content')
<div class="container">
    <div class="row">
     
      <table class="table" style="width:100%;"><center><span style="background-color:#9e9e9e;width:60%; color:white;border: 1px solid gray;padding:5px;border-radius: 5px;">No Of project :&nbsp;&nbsp;{{$projectlist1}}</span></center>
        <thead>
          <th>Project Name</th>
          <th>Project Id</th>
          <th>Address</th>
          <th>Status</th>
          <th>Procurement Name</th>
          <th>Procurement Contact No.</th>
          <th>Material Calculation</th>
          <th>Action</th>
          

        </thead>
        <tbody>
          @foreach($projectlist as $project)
          @if($project->quality == 'Unverified' || $project->quality == 'Genuine' || $project->quality == 'Fake')
            <tr>
              <td>{{ $project->project_name }}</td>
              <td>
                <a target="_none" href="{{ URL::to('/') }}/ameditProject?projectId={{ $project->project_id }}">{{ $project->project_id }}</a>
              </td>
              <td style="width:40%;">
                <a href="https://www.google.com/maps/place/{{ $project->siteaddress != null ? $project->siteaddress->address  : ''}}/@{{ $project->siteaddress != null ? $project->siteaddress->latitude : '' }},{{ $project->siteaddress != null ? $project->siteaddress->longitude : '' }}">{{ $project->siteaddress != null ? $project->siteaddress->address : '' }}</a>
              </td>
              <td>{{ $project->project_status }}</td>
              <td>{{ $project->procurementdetails != null ? $project->procurementdetails->procurement_name : '' }}</td>
              <td>{{ $project->procurementdetails != null ? $project->procurementdetails->procurement_contact_no : '' }}</td>
              <td>
                <a style="background-color:#9e9e9e;color:white;" href="{{ URL::to('/') }}/viewProjects?id={{ $project->project_id }} && no={{$project->procurementdetails->procurement_contact_no}}" class="btn btn-success btn-xs" >View</a>
              </td>
              <td>
                <table class="table-group">
               <a href="{{ URL::to('/') }}/edit?projectId={{ $project->project_id }}" class="btn btn-primary btn-xs">Edit</a>
               <a href="{{ URL::to('/') }}/requirements?projectId={{ $project->project_id }}" class="btn btn-success btn-xs" style="margin-top:-49%;margin-left:50%;" >Add Enquiry</a>
             </table>
              </td>
            </tr>
            @endif
          @endforeach
        </tbody>
      </table>
      @if(isset($_GET['quality']))
      {{ $projectlist->appends('quality',$_GET['quality'])->links() }}
      @endif
    </div>
</div>
@endsection
