@extends('layouts.app')
@section('content')
<div class="col-md-10 col-md-offset-1">
	<div class="panel panel-default">
		<div class="panel-heading">Employee List</div>
		<div class="panel-body">
			<table class="table table-hover">
				<th>Employee Id</th>
				<th>Name</th>
				<th>Email</th>
				<th>Department</th>
				<th>Designation</th>
				<th>Report</th>
				<tbody>
					@foreach($users as $user)
						<tr>
							<td>{{ $user->employeeId }}</td>
							<td>{{ $user->name }}</td>
							<td>{{ $user->email }}</td>
							<td>
								{{ $user->dept_name }}
							</td>
							<td>{{ $user->group_name }}</td>
							<td>
					            @if($user->group_name == "Listing Engineer")
					            <a href="{{ URL::to('/') }}/{{ $user->id }}/date">
					                View Report
					            </a>
					            @else
					            <a href="{{ URL::to('/') }}/{{ $user->employeeId }}/attendance">
					                View Report
					            </a>
					            @endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection