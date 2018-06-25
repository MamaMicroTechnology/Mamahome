@extends('layouts.app')
@section('content')

<div class="col-sm-6 col-sm-offset-3">
	<div class="panel panel-primary">
		<div class="panel-heading">Contractors
			@if(isset($_GET['phone']))
			<div class="alert-success pull-right">&nbsp;&nbsp;Search Result&nbsp;&nbsp;</div>
			@endif
		</div>
		<div class="panel-body">
			<form method="GET" action="{{ URL::to('/') }}/contractor_with_no_of_projects">
				<div class="input-group col-md-6 pull-right">
					<input type="text" name="phone" class="form-control" placeholder="Phone No.">
					<div class="input-group-btn">
						<input type="submit" value="Seaarch" class="btn btn-success">
					</div>
				</div>
			</form>
			<table class="table table-hover">
				<thead>
					<th>Contractor Name</th>
					<th>Contact No.</th>
					<th>No of projects</th>
					<th>View</th>
				</thead>
				<tbody>
					@if(!isset($_GET['phone']))
					@foreach($conName as $contractor)
					<tr>
						<td>{{ $contractor->contractor_name }}</td>
						<td>{{ $contractor->contractor_contact_no }}</td>
						<td>{{ $projects[$contractor->contractor_contact_no]}}</td>
						<td><a href="{{ URL::to('/') }}/viewProjects?no={{ $contractor->contractor_contact_no }}">View Projects</a></td>
					</tr>
					@endforeach
					@else
					<tr>
						<td><a href="{{ URL::to('/') }}/viewProjects?no={{ $_GET['phone'] }}">View Projects</a></td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
		<div class="panel-footer">
			<center>
				@if(!isset($_GET['phone']))
				{{ $conName->links() }}
				@endif
			</center>
		</div>
	</div>
</div>
@endsection