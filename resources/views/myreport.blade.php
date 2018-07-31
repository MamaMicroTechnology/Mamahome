
@extends('layouts.app')
@section('content')

<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading" style="background-color: green;color:white;">My Report</div>
        <div class="panel-body">
            <table class="table table-hover" border=1>
                <thead>
                    <th>Number Of Calls Attended</th>
                    <th>Follow Up Projects</th>
                    <th>Number Of Orders Initiate</th>
                    <th>Number Of Orders Confirmed</th>
                    <th>Genuine Projects</th>
                    <th>Fake Projects</th>
                    <th>Total Projects</th>
                    <!-- <th> Number Of Calls Attended Today </th> -->
                </thead>
                <tbody>
                   
                    <tr>
                        <td>{{ $calls }}</td>
                        <td>{{ $followups }}</td>
                        <td>{{ $ordersinitiate }}</td>
                        <td>{{$ordersConfirmed }}</td>
                        <td>{{ $genuineProjects }}</td>
                        <td>{{ $fakeProjects }}</td>
                        <td>{{ $genuineProjects + $fakeProjects }}</td>
                        <td></td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>























<!-- <center><table >
                <tr><td>You have attended {{ $calls }} calls so far.</td></tr>
                <tr><td>Marked {{ $followups }} projects for followups.</td></tr>
                <tr><td>{{ $ordersinitiate }} orders initiated.</td></tr>
                <tr><td>{{ $ordersConfirmed }} orders confirmed.</td></tr>
                <tr><td>Genuine Projects : {{ $genuineProjects }}</td></tr>
                <tr><td>Fake Projects: {{ $fakeProjects }}</td></tr>
                <tr><td>Total : {{ $genuineProjects + $fakeProjects }}</td></tr>
                 <tr><td>Today Number Of Calls:</td></tr>
            </table></center> -->
       
@endsection