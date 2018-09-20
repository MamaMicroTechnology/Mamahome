@extends('layouts.app')
@section('content')
<div style="background-color:white" class="container" >
<h2 ><center>WELCOME TO  RESEARCH AND DEVELOPMENT
<br>ZONE 1, BANGALORE'S DASHBOARD
<BR><BR>
    <SMALL>You must know your responsibilities and carry out your tasks responsibly.<br>
    We appreciate you services.
    </SMALL>
</center></h2></div>
@if(session('Success'))
<script>
    swal("success","{{ session('Success') }}","success");
</script>
@endif
@if(session('error'))
<script>
    swal("success","{{ session('error') }}","success");
</script>
@endif
@endsection