@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      List of projects under you:<br>
      <table class="table">
        <thead>
          <th>Project Name</th>
          <th>Address</th>
          <th>Status</th>
          <th>Procurement Name</th>
          <th>Procurement Contact No.</th>
          <th>Action</th>
        </thead>
        <tbody>
          @foreach($projectlist as $project)
            <tr>
              <td>{{ $project->project_name }}</td>
              <td>
                <a href="https://www.google.com/maps/place/{{ $project->siteaddress->address }}/@{{ $project->siteaddress->latitude }},{{ $project->siteaddress->longitude }}">{{ $project->siteaddress->address }}</a>
              </td>
              <td>{{ $project->project_status }}</td>
              <td>{{ $project->procurementdetails->procurement_name }}</td>
              <td>{{ $project->procurementdetails->procurement_contact_no }}</td>
              <td>
                 @if($pageName == "Update")
                <a href="{{ URL::to('/') }}/edit?projectId={{ $project->project_id }}" class="btn btn-default input-sm">Edit</a>
              @else
                <a href="{{ URL::to('/') }}/requirements?projectId={{ $project->project_id }}" class="btn btn-default input-sm">View</a>
              @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
</div>
@endsection