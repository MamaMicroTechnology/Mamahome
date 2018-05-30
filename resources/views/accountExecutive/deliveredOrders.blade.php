@extends('layouts.aeheader')
@section('content')
<div class="col-md-6 col-md-offset-3">
    <table class="table table-hover">
        <label>Customers</label>
        <thead>
            <th>Project Id</th>
            <th>Name</th>
            <th>Materials Bought</th>
        </thead>
        <tbody>
            @foreach($deliveredOrders as $delivered)
            <tr>
                <td>{{ $delivered->project_id }}</td>
                <td>{{ $delivered->project_name }}</td>
                <td>{{ $delivered->sub_category }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection