@extends('layouts.app')
@section('content')
<br><br>
<div style="background-color:white" class="container" >
<h2 ><center>WELCOME TO {{ Auth::user()->group_id == 7 ? ' SALES ENGINEER' : 'ASSISTANT MANAGER OF SALES AND MARKETING' }}
<br>ZONE 1, BANGALORE'S DASHBOARD
<BR><BR>
    <SMALL>You must know your responsibilities and carry out your tasks responsibly.<br>
    We appreciate you services.
    </SMALL>
</center></h2></div>
<div class="row">
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
@endsection