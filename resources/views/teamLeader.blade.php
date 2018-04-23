
<?php
	$user = Auth::user()->group_id;
	$ext = ($user == 2? "layouts.app":"layouts.teamheader");
?>
@extends($ext)
@section('content')
<br><br>
<h2><center>WELCOME TO TEAM LEADER 
<br>ZONE 1, BANGALORE'S DASHBOARD
<BR><br>
    <SMALL>You must know your responsibilities and carry out your tasks responsibly.<br>
    We appreciate you services.
    </SMALL>
</center></h2>

@endsection
