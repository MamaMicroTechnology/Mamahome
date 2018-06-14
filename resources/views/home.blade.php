@extends('layouts.app')

@section('content')
<br><br>
<h2><center>WELCOME TO ZONAL MANAGER 
<br>ZONE 1, BANGALORE'S DASHBOARD
<BR><br>
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
<br>
<div class="col-md-4 col-md-offset-4">
    <div class="panel panel-default">
        <div class="panel-heading">MINI ATTENDANCE ({{ date('d-m-Y') }})</div>
        <div class="panel-body">
        <table class="table table-hover">
            @foreach($loggedInUsers as $loggedInUser)
                <tr>
                    <td>{{ $loggedInUser->empId }}</td>
                    <td>{{ $loggedInUser->name }}</td>
                    <td>{{ $loggedInUser->inTIme }}</td>
                </tr>
            @endforeach
            @foreach($leLogins as $leLogin)
                <tr>
                    <td>{{ $leLogin->employeeId }}</td>
                    <td>{{ $leLogin->name }}</td>
                    <td>{{ $leLogin->loginTime }}</td>
                </tr>
            @endforeach
        </table>
        </div>
    </div>
</div>
@endsection
