@extends('layouts.app')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">Activities</div>
	<div class="panel-body" style="height: 500px; max-height: 500; overflow-y: scroll;">
		<table class="table table-hover">
			@foreach($activities as $activity)
			<tr>
				<td>{{ $activity->time }}</td>
				<td>{{ $activity->activity }}</td>
			</tr>
			@endforeach
		</table>
	</div>
</div>
@endsection