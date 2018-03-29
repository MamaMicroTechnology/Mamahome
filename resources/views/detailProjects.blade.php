@extends('layouts.app')
@section('content')
<div class="col-md-6 col-md-offset-3">
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
					</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>
{!! $summary !!}
<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">Project Estimation</div>
		<div class="panel-body">
			<table class="table table-responsive">
				{!! $estimation !!}
			</table>
		</div>
	</div>
</div>

@endsection