@extends('layouts.app')
@section('content')
<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-primary">
		<div class="panel-heading">Projects</div>
		<div class="panel-body">
			<table class="table table-hover">
				@foreach($projects as $project)
					<tr>
						<td>{{ $project->project_id }}</td>
						<td>{{ $project->project_name }}</td>
						<td>{{ $project->project_status }}</td>
						<td>{{ $project->siteaddress->address }}</td>
						<td>{{ $project->budget }} Cr.</td>
						<td>
							@if($project->quality != null)
								{{ $project->quality }}
							@else
								Quality Not Specified
							@endif
						</td>
						<td>Ground: {{ $project->ground }}</td>
						<td>Basement: {{ $project->basement }}</td>
						<td>Size: {{ $project->project_size }}</td>
						<td>Status: {{ $project->project_status }}</td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>
<div class="col-md-8 col-md-offset-2">
	<table class="table table-responsive" border="1">
		{!! $table !!}
	</table>
</div>

@endsection