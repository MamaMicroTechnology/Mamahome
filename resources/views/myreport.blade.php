<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 7? "layouts.sales":"layouts.app");
?>
@extends($ext)
@section('content')
<center><table >
                <tr><td>You have attended {{ $calls }} calls so far.</td></tr>
                <tr><td>Marked {{ $followups }} projects for followups.</td></tr>
                <tr><td>{{ $ordersinitiate }} orders initiated.</td></tr>
                <tr><td>{{ $ordersConfirmed }} orders confirmed.</td></tr>
                <tr><td>Genuine Projects : {{ $genuineProjects }}</td></tr>
                <tr><td>Fake Projects: {{ $fakeProjects }}</td></tr>
                <tr><td>Total : {{ $genuineProjects + $fakeProjects }}</td></tr>
                 <tr><td>Today Number Of Calls:</td></tr>
            </table></center>
       
@endsection