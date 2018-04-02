@extends('layouts.app')
@section('content')
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Project Details</div>
			<div class="panel-body" style="overflow-x: scroll;">
				<form method="GET" action="/viewallProjects">
					<div class="col-md-6">
						<div class="col-md-4">
							<select name="ward" onchange="getSubwards()" id="ward" class="form-control">
								<option>--SELECT--</option>
								@foreach($wards as $ward)
								<option value="{{ $ward->id }}">{{ $ward->ward_name }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-4">
							<select name="subward" id="subward" class="form-control">
								
							</select>
						</div>
						<div class="col-md-4">
							<input type="submit" class="form-control" value="Fetch">
						</div>
					</div>
				</form>
				<table class="table table-hover">
					<thead>
						<th>Project Id</th>
						<th>Project Name</th>
						<th>Road</th>
						<th>Municipal Approval</th>
						<th>Project Status</th>
						<th>Quality</th>
						<th>Address</th>
						<th>Basement</th>
						<th>Ground</th>
						<th>Project Size</th>
						<th>Budget</th>
						<th>Image</th>
						<th>Remarks</th>
						<th>Listed By</th>
						<th>Called By</th>
						<th>Last update</th>
					</thead>
					<tbody>
						@if($projects != "None")
						@foreach($projects as $project)
						<tr>
							<td>
								<a target="_none" href="{{ URL::to('/') }}/ameditProject?projectId={{ $project->project_id }}">{{ $project->project_id }}</a>
							</td>
							<td>{{ $project->project_name }}</td>
							<td>{{ $project->road_name }}</td>
							<td>{{ $project->municipality_approval }}</td>
							<td>{{ $project->project_status }}</td>
							<td>{{ $project->quality }}</td>
							<td>{{ $project->siteaddress->address }}</td>
							<td>{{ $project->basement }}</td>
							<td>{{ $project->ground }}</td>
							<td>{{ $project->project_size }}</td>
							<td>{{ $project->budget }}</td>
							<td>
								<a href="{{ URL::to('/') }}/public/projectImages/{{ $project->image }}">{{ $project->image }}</a></td>
							<td>{{ $project->remarks }}</td>
							<td>
								@foreach($users as $user)
								@if($project->listing_engineer_id == $user->id)
								{{ $user->name }}
								@endif
								@endforeach
							</td>
							<td>
								@foreach($users as $user)
								@if($project->call_attended_by == $user->id)
								{{ $user->name }}
								@endif
								@endforeach
							</td>
							<td>
								{{ date('d/M/Y', strtotime($project->updated_at)) }}
								<br><small>({{ $project->updated_at->diffForHumans() }})</small>
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		function getSubwards()
	    {
	        var ward = document.getElementById("ward").value;
	        $.ajax({
	            type:'GET',
	            url:"{{URL::to('/')}}/loadsubwards",
	            async:false,
	            data:{ward_id : ward},
	            success: function(response)
	            {
	                document.getElementById('subward').innerHTML = "<option value='null' disabled selected>----Select----</option>";
	                for(var i=0; i < response.length; i++)
	                {
	                    document.getElementById('subward').innerHTML += "<option value="+response[i].id+">"+response[i].sub_ward_name+"</option>";
	                }
	            }
	        });    
	    }
	</script>
@endsection