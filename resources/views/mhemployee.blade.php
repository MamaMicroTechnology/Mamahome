@extends('layouts.app')
@section('content')
<style type="text/css">
  .dot {
    height: 9px;
    width: 9px;
    background-color:green;
    border-radius: 50%;
    display: inline-block;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-2">
            @if(session('Added'))
                <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('Added') }}
                </div>
            @endif
            @if(session('NotAdded'))
               <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                   {{ session('NotAdded') }}
                </div>
            @endif
            <button class="btn btn-default form-control" data-toggle="modal" data-target="#addEmployee" style="background-color:green;color:white;font-weight:bold">Add Employee </button>
            <br><br>
            <div class="panel panel-default" style="border-color:#f4811f">
                <div class="panel-heading" style="background-color:#f4811f"><b style="font-size:1.3em;color:white">Departments</b></div>
                <div class="panel-body">
                    @foreach($departments as $department)
                        <?php 
                            $content = explode(" ",$department->dept_name);
                            $con = implode("",$content);
                        ?>
                        <a id="{{ $con }}" class="list-group-item" href="#">{{ $department->dept_name }} ({{ $depts[$department->dept_name] }})</a>
                    @endforeach
                    <a id="FormerEmployees" class="list-group-item" href="#">Former Employees ({{ $depts["FormerEmployees"] }})</a>
                </div>
            </div>
        </div>
        <div class="col-md-10" id="disp">
                       <!-- <div class="panel panel-default" style="border-color:green">
                      <div class="panel-heading" style="background-color:green;font-weight:bold;font-size:1.3em;color:white">Total employess 
                       <a class="pull-right btn btn-xs btn-danger" href="{{url()->previous()}}">Back</a>

                      </div>

                      <div class="panel-body" style="height:500px;max-height:500px;overflow-x:hidden; overflow-y:scroll;">
                        fghjkl;
                              </div>
                          </div> -->

                          <br><br><br><br>
                           <img src="http://mamahome360.com/public/android-icon-36x36.png">
                           MAMA HOME PVT LTD&nbsp;&nbsp;
                           Total employees &nbsp;&nbsp;<span class="dot" style=" height: 9px;
    width: 9px;
    background-color:green;
    border-radius: 50%;
    display: inline-block;"></span> {{ $totalcount }}
        </div>
 
<!--Modal-->
<form method="post" action="{{ URL::to('/') }}/amaddEmployee">
    {{ csrf_field() }}
  <div class="modal fade" id="addEmployee" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#f4811f;color:white;fon-weight:bold">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Employee</h4>
        </div>
        <div class="modal-body">
          <table class="table table-hover">
              <tbody>
                  <tr>
                    <td><label>Emp Id</td>
                    <td> <input required type="text" placeholder="Employee Id" class="form-control" name="employeeId"></td>
                  </tr>
                  <tr>
                    <td><label>Name</label></td>
                    <td><input required type="text" placeholder="Name" class="form-control" name="name"></td>
                  </tr>
                  <tr>
                    <td><label>User-Id Of MMT</label></td>
                    <td><input required type="text" placeholder="User-id of MMT" class="form-control" name="email"></td>
                  </tr>
                  <tr>
                    <td><label>Department</label></td>
                      <td><select required class="form-control" name="dept">
                      <option value="">--Select--</option>
                      @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->dept_name }}</option>
                      @endforeach
                  </select></td>
                  </tr>
                  <tr>
                    <td><label>Designation</label></td>
                    <td> <select required class="form-control" name="designation">
                      <option value="">--Select--</option>
                      @foreach($groups as $designation)
                        <option value="{{ $designation->id }}">{{ $designation->group_name }}</option>
                      @endforeach
                  </select></td>
                  </tr> 
                </tbody>
              </table>
            </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Add</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

</form>
<!-- <div class="col-md-10">
        <div class="panel panel-default">
        <div class="panel-heading" style="background-color: green;color: white;padding-bottom: 20px;">Edit Asset Details
        <a class="pull-right btn btn-sm btn-danger" href="{{url()->previous()}}">Back</a>
        </div>
        <div class="panel-body">
             @if (session('Success'))
                        <div class="alert alert-success">
                            {{ session('Success') }}
                        </div>
               @endif
        </div>
    </div>
</div> -->

<div class='b'></div>
<div class='bb'></div>
<div class='message'>
  <div class='check'>
    &#10004;
  </div>
  <p>
    Success
  </p>
  <p>
    @if(session('Success'))
    {{ session('Success') }}
    @endif
  </p>
  <button id='ok'>
    OK
  </button>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
@foreach($departments as $department)
<?php 
    $content = explode(" ",$department->dept_name);
    $con = implode("",$content);
?>
<script type="text/javascript">
$(document).ready(function () {
    $("#{{ $con }}").on('click',function(){
        $(document.body).css({'cursor' : 'wait'});
        $("#disp").load("{{ URL::to('/') }}/viewmhemployee?count={{$depts[$department->dept_name]}}&&dept="+encodeURIComponent("{{ $department->dept_name }}"), function(responseTxt, statusTxt, xhr){
            if(statusTxt == "error")
                alert("Error: " + xhr.status + ": " + xhr.statusText);
        });
        $(document.body).css({'cursor' : 'default'});
    });
});
</script>
<script type="text/javascript">
$(document).ready(function () {
    $("#FormerEmployees").on('click',function(){
        $(document.body).css({'cursor' : 'wait'});
        $("#disp").load("{{ URL::to('/') }}/viewmhemployee?dept=FormerEmployees&&count={{$depts["FormerEmployees"]}}", function(responseTxt, statusTxt, xhr){
            if(statusTxt == "error")
                alert("Error: " + xhr.status + ": " + xhr.statusText);
        });
        $(document.body).css({'cursor' : 'default'});
    });
});
</script>

@endforeach

@endsection
