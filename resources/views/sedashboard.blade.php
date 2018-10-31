
<?php
  $use = Auth::user()->group_id;
  $ext = ($use == 1? "layouts.salesheader":"layouts.app");
?>
@extends($ext)
@section('content')
<br><br>
<div style="background-color:white" class="container" >
<h2 ><center>WELCOME TO {{ Auth::user()->group_id == 7 ? ' SALES ENGINEER' : 'SALES ENGINEER' }}
<br>ZONE 1, BANGALORE'S DASHBOARD
<BR><BR>
    <SMALL>You must know your responsibilities and carry out your tasks responsibly.<br>
    We appreciate you services.
    </SMALL>
</center></h2></div>

<center><h2>Your Ward is : {{$ward}}</h2></center>

<div class="row hidden">
      <div class="col-md-4 col-md-offset-4">
        <table class="table table-hover" border=1>
        <center><label for="Points">Your Points For Today</label></center>
          <thead>
            <th>Reason For Earning Point</th>
            <th>Point Earned</th>
          </thead>
          <tbody>
            @foreach($points_indetail as $points)
            <tr>
              <td>{!! $points->reason !!}</td>
              <td style="text-align: right">{{ $points->type == "Add" ? "+".$points->point : "-".$points->point }}</td>
            </tr>
            @endforeach
            <tr>
              <td style="text-align: right;"><b>Total</b></td>
              <td style="text-align: right">{{ $total }}</td>
            </tr>
          </tbody>
        </table>
        </div>
    </div>
</div>
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
@endsection
