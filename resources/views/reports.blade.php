@extends('layouts.app')

@section('content')

<div class="col-md-6 col-md-offset-3">
	<div class="panel panel-default">
		<div class="panel-heading">Report of {{ date('d-M-Y',strtotime($loginTimes->logindate)) }}</div>
		<div class="panel-body">
		    <form method="GET" action="{{ URL::to('/') }}/reports">
					<div class="col-md-3">
						Choose Date:
					</div>
					<div class="col-md-4">
						<input required type="date" name="date" class="form-control input-sm">
					</div>
					<div>
						<button type="submit">Submit</button>
					</div>
				</form><br>
			<label>Morning</label>
			<table class="table">
				<tr>
					<td>Login Time</td>
					<td>:</td>
					<td>{{ $loginTimes->loginTime }}</td>
				</tr>
				<tr>
					<td>Allocated Ward</td>
					<td>:</td>
					<td>{{ $loginTimes->allocatedWard }}</td>
				</tr>
				<tr>
					<td>First Listing Time</td>
					<td>:</td>
					<td>{{ $loginTimes->firstListingTime }}</td>
				</tr>
				<tr>
						<td>First Update Time</td>
						<td>:</td>
						<td>{{ $loginTimes->firstUpdateTime }}</td>
					</tr>
				<tr>
					<td>No. of projects listed <br> in the morning</td>
					<td>:</td>
					<td>{{ $loginTimes->noOfProjectsListedInMorning }}</td>
				</tr>
				<tr>
					<td>No. of projects updated <br> in the morning</td>
					<td>:</td>
					<td>{{ $loginTimes->noOfProjectsUpdatedInMorning }}</td>
				</tr>
				@if($loginTimes->morningMeter != NULL)
				<tr>
					<td>Meter Image</td>
					<td>:</td>
					<td>
						<img src="{{ URL::to('/') }}/public/meters/{{ $loginTimes->morningMeter }}" height="100" width="200" class="img img-thumbnail">
					</td>
				</tr>
				<tr>
				    <td>Meter Reading</td>
				    <td>:</td>
					<td>
					    {{ $loginTimes->gtracing }}
					</td>
				</tr>
				@endif
				@if($loginTimes->morningData != NULL)
				<tr>
					<td>Data Image</td>
					<td>:</td>
					<td><img src="{{ URL::to('/') }}/public/data/{{ $loginTimes->morningData }}" height="100" width="200" class="img img-thumbnail"></td>
				</tr>
				<tr>
					<td>Data Reading</td>
					<td>:</td>
					<td>{{ $loginTimes->afternoonData }}</td>
				</tr>
				@endif
				<tr>
				    <td>Morning Remarks</td>
				    <td>:</td>
				    <td>{{ $loginTimes->morningRemarks }}</td>
				</tr>
			</table>
			@if($loginTimes->morningMeter == NULL)
			<form method="post" action="{{ URL::to('/') }}/addMorningMeter" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="hidden" name="morningCount" value="{{ $projectCount }}">
				<table class="table">		
					<tr>
						<td>Meter Image</td>
						<td>:</td>
						<td><input required type="file" accept="image/*" name="morningMeter" class="form-control"></td>
					</tr>
					<tr>
						<td>Meter Reading</td>
						<td>:</td>
						<td><input required type="text" name="morningMeterReading" class="form-control"></td>
					</tr>
				</table>
				<input type="submit" value="Save" class="btn form-control btn-xs btn-primary">
			</form>
			@endif
			@if($loginTimes->morningData == NULL)
			<form method="post" action="{{ URL::to('/') }}/addMorningData" enctype="multipart/form-data">
				{{ csrf_field() }}
				<table class="table">		
					<tr>
						<td>Data Image</td>
						<td>:</td>
						<td><input required type="file" accept="image/*" name="morningData" class="form-control"></td>
					</tr>
					<tr>
						<td>Data Reading</td>
						<td>:</td>
						<td><input required type="text" name="morningDataReading" class="form-control"></td>
					</tr>
				</table>
				<input type="submit" value="Save" class="btn form-control btn-xs btn-primary">
			</form>
			@endif
			<label>Evening</label>
			<table class="table">
			    <tr>
					<td>Last Listing Time</td>
					<td>:</td>
					<td>{{ $loginTimes->lastListingTime }}</td>
				</tr>
				<tr>
					<td>Last Update Time</td>
					<td>:</td>
					<td>{{ $loginTimes->lastUpdateTime }}</td>
				</tr>
			    <tr>
					<td>Total Projects Listed</td>
					<td>:</td>
					<td>{{ $loginTimes->TotalProjectsListed }}</td>
				</tr>
				<tr>
					<td>Total Projects Updated</td>
					<td>:</td>
					<td>{{ $loginTimes->totalProjectsUpdated }}</td>
				</tr>
				@if($loginTimes->eveningMeter != NULL)
				<tr>
					<td>Meter Image</td>
					<td>:</td>
					<td><img src="{{ URL::to('/') }}/public/meters/{{ $loginTimes->eveningMeter }}" height="100" width="200" class="img img-thumbnail"></td>
				</tr>
				<tr>
					<td>Meter Reading</td>
					<td>:</td>
					<td>{{ $loginTimes->afternoonMeter }}</td>
				</tr>
				@endif
				@if($loginTimes->eveningData != Null)
				<tr>
					<td>Data Image</td>
					<td>:</td>
					<td><img src="{{ URL::to('/') }}/public/data/{{ $loginTimes->eveningData }}" height="100" width="200" class="img img-thumbnail"></td>
				</tr>
				<tr>
					<td>Data Reading</td>
					<td>:</td>
					<td>{{ $loginTimes->afternoonRemarks }}</td>
				</tr>
				@endif
				@if($loginTimes->AmGrade != Null)
				<tr>
				    <td>Asst. Manager Remarks</td>
				    <td>:</td>
				    <td>{{ $loginTimes->AmRemarks }}</td>
				</tr>
				<tr>
				    <td>Grade</td>
				    <td>:</td>
				    <td>{{ $loginTimes->AmGrade }}</td>
				</tr>
				@endif
			</table>
			@if($loginTimes->eveningMeter == NULL)
			<form method="POST" action="{{ URL::to('/') }}/eveningMeter" enctype="multipart/form-data">
				{{ csrf_field() }}
				<table class="table">
					<tr>
						<td>Meter Image</td>
						<td>:</td>
						<td><input required type="file" accept="image/*" name="eveningMeterImage" class="form-control"></td>
					</tr>
					<tr>
						<td>Meter Reading</td>
						<td>:</td>
						<td><input required type="text" name="eveningMeterReading" class="form-control"></td>
					</tr>
				</table>
				<input type="submit" value="Save" class="btn btn-primary btn-xs form-control">
			</form>
			@endif
			@if($loginTimes->eveningData == Null)
			<form method="POST" action="{{ URL::to('/') }}/eveningData" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="hidden" name="totalCount" value ="{{ $projectCount }}">
				<table class="table">
					<tr>
						<td>Data Image</td>
						<td>:</td>
						<td><input required type="file" accept="image/*" name="eveningDataImage" class="form-control"></td>
					</tr>
					<tr>
						<td>Data Reading</td>
						<td>:</td>
						<td><input required type="text" name="eveningDataReading" class="form-control"></td>
					</tr>
				</table>
				<input type="submit" value="Save" class="btn btn-primary btn-xs form-control">
			</form>
			@endif
		</div>
	</div>
</div>

@endsection