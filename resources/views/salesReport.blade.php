@extends('layouts.app')
@section('content')

<div class="col-md-2">
	<div class="panel panel-default">
		<div class="panel-heading">Sales Engineer</div>
		<div class="panel-body">
			<ul class="list-group">
				@foreach($users as $user)
					@if(Auth::user()->group_id == 1)
						<a class="list-group-item" href="{{ URL::to('/') }}/salesreports?userId={{ $user->employeeId }}">{{ $user->name }}</a>
					@else
						<a class="list-group-item" href="{{ URL::to('/') }}/tlsalesreports?userId={{ $user->employeeId }}">{{ $user->name }}</a>
					@endif
				@endforeach
			</ul>
		</div>
	</div>
</div>

@if(isset($_GET['userId']))
<div class="col-md-10">
	<div class="panel panel-danger">
		<div class="panel-heading">Report of {{ $name }}
			<div class="pull-right">
				@if(Auth::user()->group_id == 1)
					<form action="{{ URL::to('/') }}/salesreports">
					@else
					<form action="{{ URL::to('/') }}/tlsalesreports">
					@endif
					<div class="input-group">
						<input type="hidden" value="{{ $_GET['userId'] }}" name="userId">
						<input type="date" class="form-control input-sm" name="date">
						<div class="input-group-btn">
							<button class="btn btn-primary btn-sm">Get</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="panel-body">
			<table class="table-hover table">
				<tr>
					<td>Ward Assigned</td>
					<td>{{ $subward }}</td>
					<td>No. Of Calls Made</td>
					<td>{{ $calls }}</td>
				</tr>
				<tr>
					<td>Marked For Follow Ups</td>
					<td>{{ $followups }}</td>
					<td>Total No. Of Order Initiated</td>
					<td>{{ $ordersinitiate }}</td>
				</tr>
				<tr>
					<td>Total No. Of Order Confirmed</td>
					<td>{{ $ordersConfirmed }}</td>
					<td>Genuine & Fake Projects Marked</td>
					<td>
						Genuine: {{ $genuine }}<br>
						Fake: {{ $fake }}
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
@endif
@endsection