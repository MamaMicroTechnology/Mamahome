@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2">
            
            <br><br>
            <div class="panel panel-default">
                <div class="panel-heading">Departments</div>
                <div class="panel-body">
                    @foreach($departments as $department)
                        <a id="{{ $department->dept_name }}" class="list-group-item" href="#">{{ $department->dept_name }} ({{ $depts[$department->dept_name] }})</a>
                    @endforeach
                        <a id="Formeremployee" class="list-group-item" href="#">Former Employees ({{ $depts["FormerEmployees"] }})</a>
                </div>
            </div>
        </div>
        <div class="col-md-10" id="disp">

        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
@foreach($departments as $department)
<script type="text/javascript">
$(document).ready(function () {
    $("#{{ $department->dept_name }}").on('click',function(){
        $(document.body).css({'cursor' : 'wait'});
        $("#disp").load("{{ URL::to('/') }}/humanresources/{{ $department->dept_name }}?page=hr", function(responseTxt, statusTxt, xhr){
            if(statusTxt == "error")
                alert("Error: " + xhr.status + ": " + xhr.statusText);
        });
        $(document.body).css({'cursor' : 'default'});
    });
});
$(document).ready(function () {
    $("#Formeremployee").on('click',function(){
        $(document.body).css({'cursor' : 'wait'});
        $("#disp").load("{{ URL::to('/') }}/humanresources/Formeremployee?page=hr", function(responseTxt, statusTxt, xhr){
            if(statusTxt == "error")
                alert("Error: " + xhr.status + ": " + xhr.statusText);
        });
        $(document.body).css({'cursor' : 'default'});
    });
});
</script>
@endforeach
@endsection
