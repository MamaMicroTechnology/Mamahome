@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2">
           
            <div class="panel panel-default">
                <div class="panel-heading">Departments</div>
                <div class="panel-body">
                    @foreach($departments as $department)
                        <?php 
                            $content = explode(" ",$department->dept_name);
                            $con = implode("",$content);
                        ?>
                        <a id="{{ $con }}" class="list-group-item" href="#">{{ $department->dept_name }}</a>
                    @endforeach
                    <a id="Formeremployee" class="list-group-item" href="#">Former Employees</a>
                </div>
            </div>
        </div>
        <div class="col-md-10" id="disp">

        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
@foreach($departments as $department)
<?php 
    $content = explode(" ",$department->dept_name);
    $con = implode("",$content);
?>
<script type="text/javascript">
$(document).ready(function () {
    $("[id = '{{ $con }}']").on('click',function(){
        $(document.body).css({'cursor' : 'wait'});
        $("#disp").load("{{ URL::to('/') }}/humanresources/"+encodeURIComponent("{{ $department->dept_name }}")+"?page=anr", function(responseTxt, statusTxt, xhr){
            if(statusTxt == "error")
                alert("Error: " + xhr.status + ": " + xhr.statusText);
        });
        $(document.body).css({'cursor' : 'default'});
    });
});
$(document).ready(function () {
    $("#Formeremployee").on('click',function(){
        $(document.body).css({'cursor' : 'wait'});
        $("#disp").load("{{ URL::to('/') }}/humanresources/Formeremployee?page=anr", function(responseTxt, statusTxt, xhr){
            if(statusTxt == "error")
                alert("Error: " + xhr.status + ": " + xhr.statusText);
        });
        $(document.body).css({'cursor' : 'default'});
    });
});
</script>
@endforeach
@endsection
