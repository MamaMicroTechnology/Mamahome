@extends('layouts.app')
@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Application List</div>
				<div class="panel-body">
					<table class="table table-hover">
						<thead>
							<th>Name</th>
							<th>Email</th>
							<th>Contact No.</th>
                            <th>Type</th>
							<th>Action</th>
						</thead>
						<tbody>
							@foreach($requests as $request)
                            <tr>
                                <td>{{ $request->name }}</td>
                                <td>{{ $request->email }}</td>
                                <td>{{ $request->contactNo }}</td>
                                <td>{{ $request->category }}</td>
                                <td>
                                    <form method="POST" action="{{ URL::to('/') }}/confirmUser">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{ $request->id }}">
                                        <button class="btn btn-xs btn-success">Confirm</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
						</tbody>
					</table>
				</div>
				<div class="panel-footer">
					<center></center>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection