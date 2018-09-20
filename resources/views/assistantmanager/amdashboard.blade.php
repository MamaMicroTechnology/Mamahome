
<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 14? "layouts.app":"layouts.amheader");
?>
@extends($ext)
@section('content')
<br><br>
<div style="background-color:white" class="container" >
<h2 ><center>WELCOME TO {{ Auth::user()->group_id == 14 ? ' HUMAN RESOURCES DASHBOARD' : 'ASSISTANT MANAGER OF SALES AND MARKETING' }}
<br>ZONE 1, BANGALORE'S DASHBOARD
<BR><BR>
    <SMALL>You must know your responsibilities and carry out your tasks responsibly.<br>
    We appreciate you services.
    </SMALL>
</center></h2></div>
    <center class="countdownContainer">
        <h1>Operation <i style="color:yellow; font-size: 50px;" class="fa fa-bolt"></i> Lightning</h1>
        <br>
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
        <br>
    </center>
    <div class="row">
<div class="col-md-5 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading"><b>MINI ATTENDANCE ({{ date('d-m-Y') }}) &nbsp;&nbsp;&nbsp; Office Employess</b></div>
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
            @if($loggedInUser->group_id != 6 && $loggedInUser->group_id != 11)
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

<div class="col-md-5 ">
    <div class="panel panel-default">
        <div class="panel-heading"><b>MINI ATTENDANCE ({{ date('d-m-Y') }}) &nbsp;&nbsp;&nbsp; <span>  Field Employess</span></b></div>
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
            @if($loggedInUser->group_id == 6 || $loggedInUser->group_id == 11)
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
</div>
<div class="col-md-5 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading"><b>MINI ATTENDANCE</b></div>
        <div class="panel-body">
        <table class="table table-hover">
           <tr>
            <td>Total Employees Present</td>
            <td>{{$present }}</td>
            </tr>
            <tr>
                <td>Total Employees Absent</td>
                <td>{{$absent}}</td>
            </tr>
           @foreach($ntlogins as $ntlogin)
             <tr>
                <td>{{$ntlogin->employeeId}}</td>
                <td>{{$ntlogin->name}}</td>
            </tr>

            @endforeach
        </table>
        </div>
    </div>
</div>
@endsection
