@extends('layouts.app')

@section('content')

<div class="col-md-4 col-md-offset-4">
	<div class="panel panel-default">
		<div class="panel-heading">Select Road
			<form>
				
			</form>
		</div>
		<div class="panel-body">
			<ul class="list-group">
				<li class="list-group-item">
					<a href="{{ URL::to('/') }}/projectlist?road={{ $todays }}&today=today">Today's Listing ({{ $todays }} projects)</a>
				</li>
				@foreach($roads as $road)
			
				
				<li class="list-group-item"><a href="{{ URL::to('/') }}/projectlist?road={{ $road->road_name }}">{{ $road->road_name }}({{ $projectcount[$roadname] }} projects)</a></li>
				
			
				@endforeach
			</ul>
		</div>
		{{ $roads->links()  }}
	</div>
</div>
@endsection
