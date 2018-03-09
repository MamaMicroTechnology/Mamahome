@extends('layouts.app')

@section('content')

<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading">Reports</div>
		<div class="panel-body">
			<table class="table table-hover">
				<thead>
					<th>Emp. Id</th>
					<th>Name</th>
					<th>Action</th>
				</thead>
				<tbody>
					@foreach($users as $user)
						<tr>
							<td>{{ $user->employeeId }}</td>
							<td>{{ $user->name }}</td>
							<td><a href="{{ URL::to('/') }}/{{ $user->id }}/date" class="btn btn-primary btn-xs">View</a></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="panel-footer">
			{{ $users->links() }}
		</div>
	</div>
</div>

@endsection