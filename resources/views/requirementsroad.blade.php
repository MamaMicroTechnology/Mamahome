@extends('layouts.leheader')

@section('content')

<div class="col-md-4 col-md-offset-4">
	<div class="panel panel-default">
		<div class="panel-heading">Select</div>
		<div class="panel-body">
			<ul class="list-group">
				<li class="list-group-item">
					<a href="{{ URL::to('/') }}/projectrequirement?road={{ $todays }}&today=today">Today's Listing ({{ $todays }} projects)</a>
				</li>
				
			</ul>
			 <form method="GET" action="{{ URL::to('/') }}/projectrequirement">
			<select name="quality" class="form-control" onchange="form.submit()" >
			    <option value="">-----Select----</option>
				<option value="Genuine">Genuine</option>
					<option value="Unverified">Unverified</option>
						<option value="Fake">Fake</option>
			</select> 
			</form>
		</div>
		
	</div>
</div>
@endsection