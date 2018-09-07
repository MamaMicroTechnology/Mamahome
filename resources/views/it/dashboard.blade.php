@extends('layouts.app')
@section('content')
<form action="{{ URL::to('/') }}/reportsForIt" method="POST">
    {{ csrf_field() }}
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-warning">
            <div class="panel-heading">Reports for IT</div>
            <div class="panel-body">
                <table class="table table-hover" id="reports">
                    <thead>
                        <th>Report</th>
                        <th>From</th>
                        <th>To</th>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                        <tr>
                            <td>{{ $report->report }}</td>
                            <td>{{ date('h:i a',strtotime($report->start)) }}</td>
                            <td>{{ date('h:i a',strtotime($report->end)) }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td><input required type="text" name="report[]" id="report" class="form-control" placeholder="Report"></td>
                            <td><input required type="time" name="from[]" id="from" class="form-control"></td>
                            <td><input required type="time" name="to[]" id="to" class="form-control"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="btn-group">
                    <button type="button" onclick="myFunction1()" class="btn btn-warning btn-sm">
                        &nbsp; <span class="glyphicon glyphicon-plus"></span>&nbsp;
                    </button>
                    <button type="button" onclick="myDelete1()" class="btn btn-danger btn-sm">
                        &nbsp; <span class="glyphicon glyphicon-minus"></span>&nbsp;
                    </button>
                </div>
            </div>
            <div class="panel-footer">
                <input type="submit" value="Submit" class="form-control btn btn-success">
            </div>
        </div>
    </div>
</form>

<script>
function myFunction1() {
    alert();
    var table = document.getElementById("reports");
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    cell1.innerHTML = "<input required type='text' name='report[]' id='report' class='form-control' placeholder='Report'>";
    cell2.innerHTML = "<input required type='time' name='from[]' id='from' class='form-control'>";
    cell3.innerHTML = "<input required type='time' name='to[]' id='to' class='form-control'>";
}
function myDelete1() {
    var table = document.getElementById("reports");
    if(table.rows.length >= {{ count($reports) + 3 }}){
        document.getElementById("reports").deleteRow(-1);
    }
}
 // desktop notification
 document.addEventListener('DOMContentLoaded', function () {
    if (!Notification) {
      alert('Desktop notifications not available in your browser. Try Chromium.'); 
      return;
    }
    if (Notification.permission !== "granted")
      Notification.requestPermission();
  });
  setInterval(function(){ notifyMe(); }, 1000);
  function notifyMe() {
    var currentTime = new Date();
    var myTime = currentTime.getHours()+ " : " + currentTime.getMinutes() + " : " + currentTime.getSeconds();
    var endTime = "16 : 30 : 0";
    var n = endTime == myTime;
    if(endTime == myTime){
      if (Notification.permission !== "granted")
        Notification.requestPermission();
      else {
        var notification = new Notification('Hello There!', {
          icon: 'https://assets-cdn.github.com/images/modules/open_graph/github-mark.png',
          body: "It is time for you to push your codes.",
        });
      }
    }
  }
</script>
@if(session('Success'))
<script>
    swal("success","{{ session('Success') }}","success");
</script>
@endif
@endsection