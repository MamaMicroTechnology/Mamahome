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
      <div class="panel panel-default" style="border-color:green">
        <div class="panel-heading" style="background-color:green;font-weight:bold;font-size:1.3em;color:white">Employees
          </div>

        <div class="panel-body" style="height:500px;max-height:500px;overflow-x:hidden; overflow-y:scroll;">
                      
                                     <img src="http://mamahome360.com/public/android-icon-36x36.png">
                                     MAMA HOME PVT LTD&nbsp;&nbsp;
                                     Total employees &nbsp;&nbsp;<span class="dot" style=" height: 9px;
                          width: 9px;
                          background-color:green;
                          border-radius: 50%;
                          display: inline-block;"></span> {{ $totalcount }}
                          <div class="col-md-4 pull-right">
                                    <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Search for names and Phone Number" >
                          </div>
                          <br>
                          <br>
                          <br>

                          <div id="name" class="hidden">
                          @foreach($users as $user)
                          <a href="{{ URL::to('/') }}/viewEmployee?UserId={{ $user->employeeId }}" >
                          <div id="" style="overflow: hidden;" class="col-md-3 col-md-offset-1">
                          <center><img class="img1" src="{{ URL::to('/') }}/public/profilePic/{{ $user->profilepic }}" width="100" height="100">
                           <p style="text-align: center;">{{ $user->name }}</p>
                            <p style="text-align: center;">{{  $user->office_phone }}</p>
                          
                          </center>
                          @if($loop->iteration % 3==0)
                              </div>
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <div class="row">
                              @endif
                         </div>
                        </a>
                          @endforeach
                        </div>
                </div>
              </div>
                <table  class="table table-hover table-responsive" style="border: 2px solid gray;">
                  <thead>
                    <th style="border: 1px solid gray;">Department</th>
                    <th style="border: 1px solid gray;">Number of Employees</th>
                    <th style="border: 1px solid gray;">Average Age</th>
                  </thead>
                  <tbody>
                  @php $totalEmp=0; $totalAvg = 0; $i = 0; @endphp
                      @foreach($departments as $department)
                      <tr> 
                          <td style="border: 1px solid gray;">{{ $department->dept_name }}</td>
                          <td style="border: 1px solid gray;">{{ $depts[$department->dept_name] }}</td>
                          @php $totalEmp += $depts[$department->dept_name]; @endphp
                          <td style="border: 1px solid gray;">{{ round($avgAge[$department->dept_name]) }}</td>
                          @php $totalAvg += round($avgAge[$department->dept_name]); @endphp
                          @if($avgAge[$department->dept_name] != 0)
                            @php $i++ @endphp
                          @endif
                      </tr>
                      @endforeach
                      <br>
                      {{ $totalAvg }}
                      <tr> 
                          <th style="border: 1px solid gray; text-align:right;"></th>
                          <th style="border: 1px solid gray;">{{ $totalEmp }}</th>
                          <th style="border: 1px solid gray;">{{ round($totalAvg / $i) }} </th>
                      </tr>
                    </tbody>
                     </table>
                      <table  class="table table-hover table-responsive" style="border: 2px solid gray;">
                          <thead>
                            <th style="border: 1px solid gray;">Qualification</th>
                            <th style="border: 1px solid gray;">Count</th>
                          </thead>
                          <tbody>
                            <tr> 
                                            <td style="border: 1px solid gray;">MBA & MCA</td>
                                            <td style="border: 1px solid gray;">6</td>
                                           
                            </tr>
                             <tr> 
                                            <td style="border: 1px solid gray;">Engineering</td>
                                            <td style="border: 1px solid gray;">37</td>
                                           
                            </tr>
                            <tr> 
                                            <td style="border: 1px solid gray;">Degree</td>
                                            <td style="border: 1px solid gray;">7</td>
                                           
                            </tr>
                          </tbody>
                        </table>   
        </div>
    </div>
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
<script type="text/javascript">
  function myFunction()
     {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("name");
    p = ul.getElementsByTagName("a");
    for (i = 0; i < p.length; i++) {
        a = p[i].getElementsByTagName("p")[0];
        b = p[i].getElementsByTagName("p")[1];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1 || b.innerHTML.toUpperCase().indexOf(filter) > -1) {
            document.getElementById("name").className = "show";
        } else {
            p[i].style.display = "none";
        }
    }
}
</script>
@endsection
