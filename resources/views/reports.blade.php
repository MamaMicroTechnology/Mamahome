@extends('layouts.app')

@section('content')

<div class="col-md-6 col-md-offset-3">
	<div class="panel panel-default">
		<div class="panel-heading">
			@if($loginTimes != null)
				Report of {{ date('d-m-Y',strtotime($loginTimes->logindate)) }}
			@else
				No records found
			@endif
		</div>
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
					<td>{{ $loginTimes != null ? $loginTimes->loginTime : '' }}</td>
				</tr>
				<tr>
					<td>Allocated Ward</td>
					<td>:</td>
					<td>{{ $loginTimes != null ? $loginTimes->allocatedWard : '' }}</td>
				</tr>
				<tr>
					<td>First Listing Time</td>
					<td>:</td>
					<td>{{ $loginTimes != null ? $loginTimes->firstListingTime : '' }}</td>
				</tr>
				<tr>
						<td>First Update Time</td>
						<td>:</td>
						<td>{{ $loginTimes != null ? $loginTimes->firstUpdateTime : '' }}</td>
					</tr>
				<tr>
					<td>No. of projects listed <br> in the morning</td>
					<td>:</td>
					<td>{{ $loginTimes != null ? $loginTimes->noOfProjectsListedInMorning : '' }}</td>
				</tr>
				<tr>
					<td>No. of projects updated <br> in the morning</td>
					<td>:</td>
					<td>{{ $loginTimes != null ? $loginTimes->noOfProjectsUpdatedInMorning : '' }}</td>
				</tr>
				@if($loginTimes != null && $loginTimes->morningMeter != NULL)
				<tr>
					<td>Meter Image</td>
					<td>:</td>
					<td>
						<img src="{{ URL::to('/') }}/public/meters/{{ $loginTimes != null ? $loginTimes->morningMeter : '' }}" height="100" width="200" class="img img-thumbnail">
					</td>
				</tr>
				<tr>
				    <td>Meter Reading</td>
				    <td>:</td>
					<td>
					    {{ $loginTimes != null ? $loginTimes->gtracing : '' }}
					</td>
				</tr>
				@endif
				@if($loginTimes != null && $loginTimes->morningData != NULL)
				<tr>
					<td>Data Image</td>
					<td>:</td>
					<td><img src="{{ URL::to('/') }}/public/data/{{ $loginTimes != null ? $loginTimes->morningData : '' }}" height="100" width="200" class="img img-thumbnail"></td>
				</tr>
				<tr>
					<td>Data Reading</td>
					<td>:</td>
					<td>{{ $loginTimes != null ? $loginTimes->afternoonData : '' }}</td>
				</tr>
				@endif
				<tr>
				    <td>Morning Remarks</td>
				    <td>:</td>
				    <td>{{ $loginTimes != null ? $loginTimes->morningRemarks : '' }}</td>
				</tr>
			</table>
			@if($loginTimes != null && $loginTimes->morningMeter== NULL)
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
			@if($loginTimes != null && $loginTimes->morningData  == NULL)
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
					<td>{{ $loginTimes != null ? $loginTimes->lastListingTime : '' }}</td>
				</tr>
				<tr>
					<td>Last Update Time</td>
					<td>:</td>
					<td>{{ $loginTimes != null ? $loginTimes->lastUpdateTime : '' }}</td>
				</tr>
			    <tr>
					<td>Total Projects Listed</td>
					<td>:</td>
					<td>{{ $loginTimes != null ? $loginTimes->TotalProjectsListed : '' }}</td>
				</tr>
				<tr>
					<td>Total Projects Updated</td>
					<td>:</td>
					<td>{{ $loginTimes != null ? $loginTimes->totalProjectsUpdated : '' }}</td>
				</tr>
				@if($loginTimes != null && $loginTimes->eveningMeter  != NULL)
				<tr>
					<td>Meter Image</td>
					<td>:</td>
					<td><img src="{{ URL::to('/') }}/public/meters/{{ $loginTimes != null ? $loginTimes->eveningMeter : '' }}" height="100" width="200" class="img img-thumbnail"></td>
				</tr>
				<tr>
					<td>Meter Reading</td>
					<td>:</td>
					<td>{{ $loginTimes != null ? $loginTimes->afternoonMeter : '' }}</td>
				</tr>
				@endif
				@if($loginTimes != null && $loginTimes->eveningData  != Null)
				<tr>
					<td>Data Image</td>
					<td>:</td>
					<td><img src="{{ URL::to('/') }}/public/data/{{ $loginTimes != null ? $loginTimes->eveningData : '' }}" height="100" width="200" class="img img-thumbnail"></td>
				</tr>
				<tr>
					<td>Data Reading</td>
					<td>:</td>
					<td>{{ $loginTimes != null ? $loginTimes->afternoonRemarks : '' }}</td>
				</tr>
				@endif
				@if($loginTimes != null && $loginTimes->AmGrade != Null)
				<tr>
				    <td>Asst. Manager Remarks</td>
				    <td>:</td>
				    <td>{{ $loginTimes != null ? $loginTimes->AmRemarks : '' }}</td>
				</tr>
				<tr>
				    <td>Grade</td>
				    <td>:</td>
				    <td>{{ $loginTimes != null ? $loginTimes->AmGrade : '' }}</td>
				</tr>
				@endif
			</table>
			@if($loginTimes != null && $loginTimes->eveningMeter  == NULL)
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
			@if($loginTimes != null && $loginTimes->eveningData == Null)
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