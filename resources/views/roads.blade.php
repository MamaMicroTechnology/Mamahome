@extends('layouts.app')

@section('content')

<div class="col-md-4 col-md-offset-4">
	<div class="panel panel-default">
		<div class="panel-heading">Select Road</div>
		<div class="panel-body">
			<ul class="list-group">
				@foreach($roads as $road)
				@if($projectCount[$road] > 0)
				<li class="list-group-item"><a href="{{ URL::to('/') }}/projectlist?road={{ $road }}">{{ $road }} ({{ $projectCount[$road] }} projects)</a></li>
				@endif
				@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection
