@extends('layouts.amheader')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <div class="panel panel-default" style="border-color:green">
                <div class="panel-heading"  style="background-color:green"><b style="color:white;font-size:1.3em">Departments</b></div>
                <div class="panel-body">
                    @foreach($departments as $department)
                        <a id="{{ $department->dept_name }}" class="list-group-item" href="#">{{ $department->dept_name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-10" id="disp"></div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
    $("#date").on('click',function(){
        $(document.body).css({'cursor' : 'wait'});
        var from = document.getElementById('from').value;
        var to = document.getElementById('to').value;
        alert(from);
        $("#disp").load("{{ URL::to('/') }}/amfinanceview?dept=Operation", function(responseTxt, statusTxt, xhr){
            if(statusTxt == "error")
                alert("Error: " + xhr.status + ": " + xhr.statusText);
        });
        $(document.body).css({'cursor' : 'default'});
    });
});
</script>
@foreach($departments as $department)
<script type="text/javascript">
$(document).ready(function () {
    $("#{{ $department->dept_name }}").on('click',function(){
        $(document.body).css({'cursor' : 'wait'});
        $("#disp").load("{{ URL::to('/') }}/amfinanceview?dept={{ $department->dept_name }}", function(responseTxt, statusTxt, xhr){
            if(statusTxt == "error")
                alert("Error: " + xhr.status + ": " + xhr.statusText);
        });
        $(document.body).css({'cursor' : 'default'});
    });
});
</script>
@endforeach
@endsection
