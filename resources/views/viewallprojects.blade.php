<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 1? "layouts.teamheader":"layouts.app");
?>
@extends($ext)
@section('content')
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading" style="background-color: green;"><p style="color: white">Total Projects :{{$projects == "None" ?  0 : count($projects)}}
                 </p>
				  <a onclick="history.back(-1)" class="btn btn-default pull-right" style="margin-top:-30px;" > <i class="fa fa-arrow-circle-left" style="padding:5px;width:50px;"></i></a>
			</div>
			<div class="panel-body" style="overflow-x: scroll;">
				@if(Auth::user()->group_id == 1)
				<form method="GET" action="{{ URL::to('/') }}/viewallProjects">
					<div class="col-md-6">
						<div class="col-md-4">
							<select name="ward" onchange="getSubwards()" id="ward" class="form-control">
								<option value="">--SELECT--</option>
								<option value="All">All</option>
								@foreach($wards as $ward)
								<option value="{{ $ward->id }}">{{ $ward->ward_name }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-4">
							<select name="subward" id="subward" class="form-control">
								<option value="">--SELECT--</option>
							</select>
						</div>
						<div class="col-md-4">
							<input type="submit" class="form-control" value="Fetch">
						</div>
					</div>
				</form>
				@endif
				<form method="GET" action="{{ URL::to('/') }}/{{Auth::user()->group_id == 1 ? 'viewallProjects':'projectDetailsForTL'}}">
					<div class="col-md-4 pull-right">
						<div class="input-group">
							<input type="text" name="phNo" class="form-control" placeholder="Phone number and project_id search">
							<div class="input-group-btn">
								<input type="submit" class="form-control" value="Search">
							</div>
						</div>
					</div>
				</form>
				<table class="table table-hover">
					<thead>
						<th>Project Id</th>
						<th>Project Name</th>
						<th>Construction Type</th>
						<th>Sub-Ward Number</th>
						<th>Project Status</th>
						<th>Quality</th>
						<th>Address</th>
						<th>Floors</th>
						<th>Project Size</th>
						<th>Budget</th>
						<!-- <th>Image</th> -->
						<th>Remarks</th>
						@if(Auth::user()->group_id != 7 &&  Auth::user()->group_id != 17)
						<th>Listed By</th>
						@endif
						<th>Called By</th>
						<th>Listed On</th>
						<th>Last update</th>
						@if(Auth::user()->group_id == 2 )
						<th>Last updated By</th>
						@endif
					</thead>
					<tbody>
						@if($projects != "None")
						@foreach($projects as $project)
						<tr>
							<td>
								<a target="_none" href="{{ URL::to('/') }}/ameditProject?projectId={{ $project->project_id }}">{{ $project->project_id }}</a>
							</td>
							<td>{{ $project->project_name }}</td>
							<td>{{ $project->construction_type }}</td>
							
							<td>
								<a href="{{ URL::to('/')}}/viewsubward?projectid={{$project->project_id}} && subward={{ $project->sub_ward_name }}" data-toggle="tooltip" data-placement="top" title="click here to view map" class="red-tooltip" target="_blank">{{ $project->sub_ward_name }}
                                    </a></td>
							<td>{{ $project->project_status }}</td>
							<td>{{ $project->quality }}</td>
							<td><a href="https://www.google.com/maps/place/{{ $project->siteaddress != null ? $project->siteaddress->address  : ''}}/@{{ $project->siteaddress != null ? $project->siteaddress->latitude : '' }},{{ $project->siteaddress != null ? $project->siteaddress->longitude : '' }}" target="_blank">{{ $project->address }}</a></td>
							<td>B({{ $project->basement}})+G+F({{ $project->ground }})={{ $project->basement + $project->ground + 1 }}</td>

							<td>{{ $project->project_size }}</td>
							<td>{{ $project->budget }}</td>
							
							
							<td>{{ $project->remarks }}</td>
							@if(Auth::user()->group_id != 7 && Auth::user()->group_id != 17)
							<td>{{ $project->name }}</td>
							@endif
							<td>
								@foreach($users as $user)
								@if($project->call_attended_by == $user->id)
								{{ $user->name }}
								@endif
								@endforeach
							</td>
							
							<td>
								{{ date('d/m/Y',strtotime($project->created_at))}}
							</td>
							<td>
								{{ date('d/m/Y', strtotime($project->updated_at)) }}
								<br><small>({{ $project->updated_at->diffForHumans() }})</small>
							</td>
							@if(Auth::user()->group_id == 2 )
							<td>@if($updater != null)
                                   {{ $updater->name }}
                                @endif</td>
                            @endif
							@if(Auth::user()->group_id == 1 || Auth::user()->group_id == 2)
							<td>
								<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete{{ $project->project_id }}">Block</button>
								<!-- Modal -->
							  <div class="modal fade" id="delete{{ $project->project_id }}" role="dialog">
							    <div class="modal-dialog modal-sm">
							      <div class="modal-content">
							        <div class="modal-header">
							          <button type="button" class="close" data-dismiss="modal">&times;</button>
							          <h4 class="modal-title">Block</h4>
							        </div>
							        <div class="modal-body">
							          <p>Are you sure you want to Block this project?</p>
							        </div>
							        <div class="modal-footer">
							        	<a class="btn btn-danger pull-left" href="{{ URL::to('/') }}/deleteProject?projectId={{ $project->project_id }}">Yes</a>
							          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
							        </div>
							      </div>
							    </div>
							  </div>
							</td>
							
							@endif
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
	        if(ward != "All"){
	        	
	        $.ajax({
	            type:'GET',
	            url:"{{URL::to('/')}}/loadsubwards",
	            async:false,
	            data:{ward_id : ward},
	            success: function(response)
	            {
	                document.getElementById('subward').innerHTML = "<option value='' disabled selected>----Select----</option>";
	                for(var i=0; i < response.length; i++)
	                {
	                    document.getElementById('subward').innerHTML += "<option value="+response[i].id+">"+response[i].sub_ward_name+"</option>";
	                }
	            }
	        });    
	        }
	    }
	</script>
	<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
     background-color: #00acd6 

});

</script>
@endsection
