@extends('layouts.app')
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
						<th>Image</th>
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
							<td><button class="btn btn-primary btn-xs"data-toggle="modal" data-target="#viewimage{{ $project->project_id }}">View Image</button>
								<div id="viewimage{{$project->project_id }}" class="modal fade" role="dialog">
								  <div class="modal-dialog" style="width: 40%;height: 30%">

								    <!-- Modal content-->
								    <div class="modal-content">
								      <div class="modal-header" style="background-color: green;color:white;">
								        <button type="button" class="close" data-dismiss="modal" style="color:white;">&times;</button>
								        <h4 class="modal-title">Image</h4>
								      </div>
								      <div class="modal-body">
								      	 <?php
								      	 $images = explode(",", $project->image);
                                               ?>
                                                 @for($i = 0; $i < count($images); $i++)
                                                 
                                                          <img height="350" width="500" id="project_img" src="{{ URL::to('/') }}/public/projectImages/{{ $images[$i] }}" ><br/><br>
                                                  
                                                 @endfor
                                                 <br>
                                              @if($projectimages != null)
                                            <p>Updated images</p>
                                             @endif
                                             @foreach($projectimages as $project)
                                             <p>Status : {{$project->project_status }}</p>
                                             <?php
										      	 $images = explode(",", $project->image);
		                                               ?>
                                                 @for($i = 0; $i < count($images); $i++)
                                                
                                                          <img height="350" width="500" id="project_img" src="{{ URL::to('/') }}/public/projectImages/{{ $images[$i] }}" ><br/><br>
                                                 
                                                 @endfor
                                                 <br>
                                                 @endforeach

								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								      </div>
								    </div>

								  </div>
							</div>
							</td>
							
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
								<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete{{ $project->project_id }}">Delete</button>
								<!-- Modal -->
							  <div class="modal fade" id="delete{{ $project->project_id }}" role="dialog">
							    <div class="modal-dialog modal-sm">
							      <div class="modal-content">
							        <div class="modal-header">
							          <button type="button" class="close" data-dismiss="modal">&times;</button>
							          <h4 class="modal-title">Delete</h4>
							        </div>
							        <div class="modal-body">
							          <p>Are you sure you want to delete this project?</p>
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
	</script>
	<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
     background-color: #00acd6 

});

</script>
@endsection
