@extends('layouts.app')

@section('content')
<?php $count = 1; ?>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <table class="table table-hover" border=1>
                <center><label for="Points">{{ $user->name }}'s Points For {{ date('d-M-Y',strtotime($date)) }}</label></center>
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
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Report of {{ $user->name }} for {{ date('d-M-Y',strtotime($date)) }}
                </div>
                <div class="panel-body">
                    <form method=POST action="{{ URL::to('/')}}/grade">
                        {{ csrf_field() }}
                        <input type="hidden" name="userId" value="{{ $user->employeeId }}">
                        <input type="hidden" name="date" value="{{ $date }}">
                            <div class="col-md-12">
                                <div class="col-md-4">AM Remark:</div>
                                <div class="col-md-8"><input placeholder="AM Remark" type="text" value="{{ $attendance->am_remarks }}" name="amremark" class="form-control"></div>
                            </div><br><br>
                            <div class="col-md-12">
                                <div class="col-md-4">Credits earned:</div>
                                <div class="col-md-8"><textarea name="remark" class="form-control" placeholder="Remark" rows="1">{{ $attendance->remarks }}</textarea></div>
                            </div><br><br><br>
                            <div class="col-md-12">
                                <div class="col-md-4">Grade:</div>
                                <div class="col-md-8">
                                    <select name="grade" class="form-control input-xs">
                                        <option value="">--Select--</option>
                                        <option value="A" {{ $attendance->grade == "A"?'selected':'' }}>A</option>
                                        <option value="B" {{ $attendance->grade == "B"?'selected':'' }}>B</option>
                                        <option value="C" {{ $attendance->grade == "C"?'selected':'' }}>C</option>
                                        <option value="D" {{ $attendance->grade == "D"?'selected':'' }}>D</option>
                                    </select>
                                </div>
                            </div><br><br>
                            <p><button id="save" class="btn btn-primary form-control">Save</button></p>
                        </form>
                        <p>{{ $attendance->am_remark }}</p>
                    </div>
                    <table class="table">
                        <thead>
                            <th>Sl.No.</th>
                            <th>Report</th>
                            <th>Start</th>
                            <th>End</th>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $report->report }}</td>
                                <td>{{ $report->start }}</td>
                                <td>{{ $report->end }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
@endsection