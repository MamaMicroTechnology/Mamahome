@extends('layouts.app')
@section('content')

<div class="col-sm-6 col-sm-offset-3">
	<div class="panel panel-primary">
		<div class="panel-heading">Contractors</div>
		<div class="panel-body">
			<table class="table table-hover">
				<thead>
					<th>Contractor Name</th>
					<th>Contact No.</th>
					<th>No of projects</th>
					<th>View</th>
				</thead>
				<tbody>
					@foreach($conName as $contractor)
					<tr>
						<td>{{ $contractor->contractor_name }}</td>
						<td>{{ $contractor->contractor_contact_no }}</td>
						<td>{{ $projects[$contractor->contractor_contact_no]}}</td>
						<td><a href="{{ URL::to('/') }}/viewProjects?no={{ $contractor->contractor_contact_no }}">View Projects</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="panel-footer">
			<center>
				{{ $conName->links() }}
			</center>
		</div>
	</div>
</div>
@endsection