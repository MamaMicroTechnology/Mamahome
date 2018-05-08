@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">{{ $user->name }}'s Report (before 12) &nbsp; Ward Name :	{{ $logintimes->allocatedWard }} <p class="pull-right">{{ date('d-M-Y',strtotime($date)) }}
			
				</p></div>
				<div class="panel-body table-responsive">
					<table class="table">
						<tr>
							<th>Login To Ward</th>
							<td>:</td>
							<td>{{ $logintimes->login_time_in_ward }}
							</td>
						</tr>
						<tr>
							<th>First Listing</th>
							<td>:</td>
							<td>{{ $logintimes->firstListingTime }}</td>
						</tr>
						<tr>
							<th>First Update</th>
							<td>:</td>
							<td>{{ $logintimes->firstUpdateTime }}</td>
						</tr>
						<tr>
							<th>Allocated Ward(s)</th>
							<td>:</td>
							<td>{{ $logintimes->allocatedWard }}</td>
						</tr>
						<tr>
							<th>No. of projects listed(till 12)</th>
							<td>:</td>
							<td>{{ $logintimes->noOfProjectsListedInMorning }}</td>
						</tr>
						<tr>
							<th>No. of projects updated(till 12)</th>
							<td>:</td>
							<td>{{ $logintimes->noOfProjectsUpdatedInMorning }}</td>
						</tr>
						<tr>
							<th>Meter Image(Morning)</th>
							<td>:</td>
							<td>
							    @if($logintimes->morningMeter != NULL)
								<a href="{{ URL::to('/') }}/public/meters/{{ $logintimes->morningMeter }}">View</a>
								@endif
							</td>
						</tr>
						<tr>
							<th>Data Image(Morning)</th>
							<td>:</td>
							<td>
								@if($logintimes->morningData != NULL)
								<a href="{{ URL::to('/') }}/public/data/{{ $logintimes->morningData }}">View</a>
								@endif
							</td>
						</tr>
						<tr>
        					<td>Morning Meter Reading</td>
        					<td>:</td>
        					<td>
        					    @if($logintimes->morningMeter != NULL)
        					    {{ $logintimes->gtracing }}
        						@endif
        					</td>
        				</tr>
						<tr>
							<th>Km from home to work</th>
							<td>:</td>
							<td>{{ $logintimes->kmfromhtw }}</td>
						</tr>
						<tr>
							<th>Remarks (Morning)</th>
							<td>:</td>
							<td>{{ $logintimes->morningRemarks }}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">{{ $user->name }}'s Report (after 12)</div>
				<div class="panel-body table-responsive">
					<table class="table">
						<tr>
							<th>Last Listing Time</th>
							<td>:</td>
							<td>{{ $logintimes->lastListingTime }}</td>
						</tr>
						<tr>
							<th>Last Update Time</th>
							<td>:</td>
							<td>{{ $logintimes->lastUpdateTime }}</td>
						</tr>
						<tr>
							<th>Ward Tracing Image</th>
							<td>:</td>
							<td>
							@if($logintimes->evening_ward_tracing_image != NULL)
							<a href="{{ URL::to('/') }}/public/uploads/{{ $logintimes->evening_ward_tracing_image }}">View</a>
							@endif
							</td>
						</tr>
						<tr>
							<th>Meter Image(Evening)</th>
							<td>:</td>
							<td>
								@if($logintimes->eveningMeter != NULL)
								<a href="{{ URL::to('/') }}/public/meters/{{ $logintimes->eveningMeter }}">View</a>
								@endif
							</td>
						</tr>
						<tr>
							<th>Data Image(Evening)</th>
							<td>:</td>
							<td>
								@if($logintimes->eveningData != NULL)
								<a href="{{ URL::to('/') }}/public/data/{{ $logintimes->eveningData }}">View</a>
								@endif
							</td>
						</tr>
						<!--<tr>-->
						<!--	<th>Google Tracing Image</th>-->
						<!--	<td>:</td>-->
						<!--	<td>-->
						<!--		@if($logintimes->evening_ward_tracing_image != NULL)-->
						<!--		<a href="{{ URL::to('/') }}/public/uploads/{{ $logintimes->evening_ward_tracing_image }}">View</a>-->
						<!--		@endif-->
						<!--	</td>-->
						<!--</tr>-->
						<tr>
							<th>KM from tacking sw (Ward to home)</th>
							<td>:</td>
							<td>{{ $logintimes->km_from_w_to_h }}</td>
						</tr>
						<tr>
							<th>Tracking from work to home</th>
							<td>:</td>
							<td>
								@if($logintimes->tracing_image_w_to_h)
								<a href="{{ URL::to('/') }}/public/uploads/{{ $logintimes->tracing_image_w_to_h }}">View</a>
								@endif
							</td>
						</tr>
						<tr>
							<th>Evening Remarks</th>
							<td>:</td>
							<td>{{ $logintimes->eveningRemarks }}</td>
						</tr>
						<tr>
							<th>Evening meter reading</th>
							<td>:</td>
							<td>{{ $logintimes->afternoonMeter }}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
	<div class="col-md-4 col-md-offset-1">
		<table class="table table-hover" border=1>
			<center><label for="Points">{{ $user->name }}'s Points For {{ isset($_GET['date']) ? date('d-m-Y',strtotime($_GET['date'])) : 'Today' }}</label></center>
			<thead>
				<th>Reason For Earning Point</th>
				<th>Points Earned</th>
			</thead>
			<tbody>
				@foreach($points_indetail as $points)
				<tr>
					<td>
						{!! $points->reason !!}
						@if($points->confirmation == 0)
						<a href="{{ URL::to('/') }}/approvePoint?id={{ $points->id }}" class="btn btn-primary btn-xs pull-right">Approve</a>
						@endif
					</td>
					<td style="text-align: right">{{ $points->type == "Add" ? "+".$points->point : "-".$points->point }}</td>
				</tr>
				@endforeach
				<tr>
					<td colspan=2>
						<button type="button" class="btn btn-info btn-sm form-control" data-toggle="modal" data-target="#myModal">Add More Point</button>
					</td>
				</tr>
				<tr>
					<td style="text-align: right;"><b>Total</b></td>
					<td style="text-align: right">{{ $total }}</td>
				</tr>
			</tbody>
		</table>
	</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">Remarks & Grades
				@if($logintimes->AmGrade != NULL || $logintimes->AmRemarks != NULL)
				<button id="editbtn" class="btn btn-xs btn-primary pull-right" onclick="edit()">Edit</button>
				@endif
				</div>
				<div id="display" class="panel-body">
					<form method="POST" action="{{ URL::to('/')}}/{{ $user->id }}/{{ $logintimes->id }}/giveGrade">
					<table class="table">
					<tr>
						<td>Total Projecs Listed</td>
						<td>:</td>
						<td>{{ $logintimes->TotalProjectsListed }}</td>
					</tr>
					<tr>
						<td>Total Projects Updated</td>
						<td>:</td>
						<td>{{ $logintimes->totalProjectsUpdated }}</td>
					</tr>
					<tr>
						<td>Total Kilometers (LE)</td>
						<td>:</td>
						<td>
						@if( $logintimes->afternoonMeter - $logintimes->gtracing <= 0)
					        {{ $total = ($logintimes->afternoonMeter - $logintimes->gtracing) * -1 }} Kms
					    @else
					        {{ $total = $logintimes->afternoonMeter - $logintimes->gtracing }} Kms
					    @endif
						</td>
					</tr>
					@if($logintimes->AmGrade == NULL && $logintimes->AmRemarks == NULL)
					{{ csrf_field() }}
					<tr>
						<td>Remarks</td>
						<td>:</td>
						<td><textarea required name="remarks" cols="30" rows="3" placeholder="Remarks" class="form-control"></textarea></td>
					</tr>
					<tr>
						<td>Grade</td>
						<td>:</td>
						<td>
						<select name="grade" required class="form-control">
							<option value="">--</option>
							<option value="A">A</option>
							<option value="B">B</option>
						 		<option value="C">C</option>
							<option value="D">D</option>
						</select>
						</td>
					</tr>
					<tr>
						<td><input type="submit" class="form-control"></td>
					</tr>
					@else
					<tr>
						<td>Remarks</td>
						<td>:</td>
						<td>{{ $logintimes->AmRemarks }}</td>
					</tr>
						<tr>
						<td>Grade</td>
						<td>:</td>
						<td>{{ $logintimes->AmGrade }}</td>
					</tr>
					@endif
					</table>
					</form>
				</div>
				<div id="edit" class="hidden">
					<form method="POST" action="{{ URL::to('/')}}/{{ $user->id }}/{{ $logintimes->id }}/editGrade">
					    {{ csrf_field() }}
					<table class="table">
					<tr>
						<td>Total Projecs Listed</td>
						<td>:</td>
						<td>{{ $logintimes->TotalProjectsListed }}</td>
					</tr>
					<tr>
						<td>Total Projects Updated</td>
						<td>:</td>
						<td>{{ $logintimes->totalProjectsUpdated }}</td>
					</tr>
					<tr>
						<td>Total Kilometers</td>
						<td>:</td>
						<td>{{ $logintimes->total_kilometers }}</td>
					</tr>
					<tr>
						<td>Remarks</td>
						<td>:</td>
						<td><textarea required name="remarks" cols="30" rows="3" placeholder="Remarks" class="form-control">{{ $logintimes->AmRemarks }}</textarea></td>
					</tr>
					<tr>
						<td>Grade</td>
						<td>:</td>
						<td>
					   @if($logintimes->AmGrade == 'A')
						<select name="grade" required class="form-control">
							<option value="">--</option>
							<option selected value="A">A</option>
							<option value="B">B</option>
						 		<option value="C">C</option>
							<option value="D">D</option>
						</select>
						@elseif($logintimes->AmGrade == 'B')
						<select name="grade" required class="form-control">
							<option value="">--</option>
							<option selected value="A">A</option>
							<option value="B">B</option>
						 		<option value="C">C</option>
							<option value="D">D</option>
						</select>
						@elseif($logintimes->AmGrade == 'C')
						<select name="grade" required class="form-control">
							<option value="">--</option>
							<option selected value="A">A</option>
							<option value="B">B</option>
						 		<option value="C">C</option>
							<option value="D">D</option>
						</select>
						@elseif($logintimes->AmGrade == 'D')
						<select name="grade" required class="form-control">
							<option value="">--</option>
							<option selected value="A">A</option>
							<option value="B">B</option>
						 		<option value="C">C</option>
							<option value="D">D</option>
						</select>
						@else
						<select required class="form-control">
							<option value="">--</option>
							<option selected value="A">A</option>
							<option value="B">B</option>
						 		<option value="C">C</option>
							<option value="D">D</option>
						</select>
						@endif
						</td>
					</tr>
					<tr>
					    <td></td>
					    <td><input type="submit" class="form-control"></td>
					    <td></td>
					</tr>
					</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<form action="{{ URL::to('/') }}/aMaddPoints" method="post">
{{ csrf_field() }}
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Points To {{ $user->name }}</h4>
      </div>
      <div class="modal-body">
        <table class="table table-hover">
		<input type="hidden" name="userId" value="{{ $user->id }}">
		<input type="hidden" name="date" value="{{ date('Y-m-d H:i:s',strtotime($date)) }}">
			<tr>
				<td>Type</td>
				<td>:</td>
				<td>
					<select name="type" id="" class="form-control">
						<option value="">--Select--</option>
						<option value="Add">Add</option>
						<option value="Subtract">Subtract</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Reason</td>
				<td>:</td>
				<td>
					<textarea name="reason" rows="3" class="form-control" placeholder="Reason for adding points"></textarea>
				</td>
			</tr>
			<tr>
				<td>Points</td>
				<td>:</td>
				<td><input type="number" name="point" class="form-control" placeholder="Amount you want to add"></td>
			</tr>
		</table>
      </div>
      <div class="modal-footer">
		<button type="submit" class="btn btn-success pull-left">Add</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
</form>
<script>
    function edit(){
        document.getElementById("edit").className = "panel-body";
        document.getElementById("display").className = "hidden";
        document.getElementById("dispbtn").className = "btn btn-xs btn-primary pull-right";
        document.getElementById("editbtn").className = "hidden";
    };
</script>

@endsection