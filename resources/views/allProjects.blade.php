@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      List of projects under you:<br>
      <table class="table">
        <thead>
          <th>Project Id</th>
          <th>Project Name</th>
          <th>Status</th>
          <th>Procurement Name</th>
          <th>Procurement Contact No.</th>
          <th>Action</th>
        </thead>
        <tbody>
          @foreach($allProjects as $project)
            <tr>
              <td>{{ $project->project_id }}</td>
              <td>{{ $project->project_name }}</td>
              <td>{{ $project->project_status }}</td>
              <td>{{ $project->procurementdetails != null ? $project->procurementdetails->procurement_name:'' }}</td>
              <td>{{ $project->procurementdetails != null ? $project->procurementdetails->procurement_contact_no:'' }}</td>
              <td><a href="{{ URL::to('/') }}/{{ $project->project_id }}/viewDetails" class="btn btn-default input-sm">Details</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
</div>
@endsection