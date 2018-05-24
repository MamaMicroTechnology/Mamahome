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
						<button type="submit">Submit</button	>
					</div>
				</form><br>
			<label>Morning</label>
			<table class="table">
				{!! $display !!}
			</table>

			@if($loginTimes != null && $loginTimes->morningMeter== NULL && !isset($_GET['date']))
			@if("08:20:00" > $now)
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
			@endif
			@if($loginTimes != null && $loginTimes->morningData  == NULL && !isset($_GET['date']))
			@if("08:20:00" > $now)
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
			@endif
			<label>Evening</label>
			<table class="table">
			    {!! $evening !!}
			</table>
			@if($loginTimes != null && $loginTimes->eveningMeter  == NULL && !isset($_GET['date']))
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
					<!-- <tr>
						<td>Evening Remarks</td>
						<td>:</td>
						<td><input required type="text" name="eRemark" class="form-control"></td>
					</tr> -->
				</table>
				<input type="submit" value="Save" class="btn btn-primary btn-xs form-control">
			</form>
			@endif
			@if($loginTimes != null && $loginTimes->eveningData == Null && !isset($_GET['date']))
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