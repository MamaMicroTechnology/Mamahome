@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <b>List of projects under you:</b><br>
      <table class="table">
        <thead>
          <th>Project Name</th>
          <th>Address</th>
          <th>Status</th>
          <th>Procurement Name</th>
          <th>Procurement Contact No.</th>
          <th></th>
          <th>Action</th>
        </thead>
        <tbody>
          @foreach($projectlist as $project)
          @if($project->quality == Unverified || $project->quality == 'Genuine')
            <tr>
              <td>{{ $project->project_name }}</td>
              <td>
                <a href="https://www.google.com/maps/place/{{ $project->siteaddress != null ? $project->siteaddress->address  : ''}}/@{{ $project->siteaddress != null ? $project->siteaddress->latitude : '' }},{{ $project->siteaddress != null ? $project->siteaddress->longitude : '' }}">{{ $project->siteaddress != null ? $project->siteaddress->address : '' }}</a>
              </td>
              <td>{{ $project->project_status }}</td>
              <td>{{ $project->procurementdetails != null ? $project->procurementdetails->procurement_name : '' }}</td>
              <td>{{ $project->procurementdetails != null ? $project->procurementdetails->procurement_contact_no : '' }}</td>
              <td>{{ $project->room_types }}</td>
              <td>
              @if($pageName == "Update")
                <a href="{{ URL::to('/') }}/edit?projectId={{ $project->project_id }}" class="btn btn-success input-sm">Edit</a>
              @else
                <a href="{{ URL::to('/') }}/requirements?projectId={{ $project->project_id }}" class="btn btn-primary input-sm">Add Enquiry</a>
              @endif
              </td>
            </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>
</div>
@endsection
