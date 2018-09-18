
<?php
	$user = Auth::user()->group_id;
	$ext = ($user == 2? "layouts.app":"layouts.teamheader");
?>
@extends($ext)
@section('content')
@if(Auth::user()->group_id != 2)
<br><br>
<h2><center>WELCOME TO <b>TEAM LEADER </b>
<br>ZONE 1, BANGALORE'S DASHBOARD
<BR><br>
@else
<br><br>
<h2><center>WELCOME TO <b>SENIOR TEAM LEADER </b>
<br>ZONE 1, BANGALORE'S DASHBOARD
<BR><br>
@endif
@if(Auth::user()->group_id == 22)
<table class="table" style="width:50%;">
  <tr>
    <th>Under Your Employees</th>
    <th>Designation</th>
  </tr>
 <h2>Assigned Ward : {{$x}}</h2>
     @foreach($users as $user)
       @if(in_array($user->id,$usersId))
       <tr>
        <td> {{$user->name}}</td>
         <td>{{$user->group->group_name}}</td>
    </tr>
       @endif
     @endforeach    
</table>
@endif
</table>
    <SMALL>You must know your responsibilities and carry out your tasks responsibly.<br>
    We appreciate you services.
    </SMALL>
</center></h2>
<center class="countdownContainer">
    <h1>Operation <i style="color:yellow; font-size: 50px;" class="fa fa-bolt"></i> Lightning</h1>
    <div id="clockdiv">
        <div>
            <span class="days"></span>
            <div class="smalltext">Days</div>
        </div>
        <div>
            <span class="hours"></span>
            <div class="smalltext">Hours</div>

        </div>
        <div>
            <span class="minutes"></span>
            <div class="smalltext">Minutes</div>
        </div>
        <div>
            <span class="seconds"></span>
            <div class="smalltext">Seconds</div>
        </div>
    </div>
</center>
@if(Auth::user()->group_id != 22)
<div class="col-md-5 col-md-offset-3">
    <div class="panel panel-default">
        <div class="panel-heading"><center><b>MINI ATTENDANCE ({{ date('d-m-Y') }})</b></center></div>
        <div class="panel-body">
        <table class="table table-hover">
        <thead>
            <tr>
                <th>Employee-Id</th>
                <th>Name</th>
                <th>Login Time</th>
                <th>Logout Time</th>
            </tr>
           </thead>
            @foreach($loggedInUsers as $loggedInUser)
            @if($loggedInUser->id = 1|| $loggedInUser->id = 2)
                <tr>
                    <td>{{ $loggedInUser->employeeId }}</td>
                    <td>{{ $loggedInUser->name }}</td>
                    <td>{{ $loggedInUser->logintime }}</td>
                    <td>{{ $loggedInUser->logout }}</td>
               </tr>
                @endif
            @endforeach
            
        </table>
        </div>
    </div>
</div>
@endif
@endsection
