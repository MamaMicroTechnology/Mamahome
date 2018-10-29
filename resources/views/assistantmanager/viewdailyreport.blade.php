
<?php
    $use = Auth::user()->group_id;
    $ext = ($use == 14? "layouts.app":"layouts.amheader");
?>
@extends($ext)
@section('content')
<?php $count = 1; ?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Report of {{ $user->name }} for {{ date('d-M-Y',strtotime($date)) }}
                </div>
                <div class="panel-body">
                    <form method=POST action="{{ URL::to('/')}}/amgrade">
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
@endsection