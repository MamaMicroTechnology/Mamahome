@extends('layouts.leheader')
@section('content')

    <div class="panel panel-success">
        <div class="panel-heading">Manufacturers</div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact No</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach($manufacturers as $manufacturer)
                    <tr>
                        <td>{{ $manufacturer->name }}</td>
                        <td>{{ $manufacturer->address }}</td>
                        <td>{{ $manufacturer->contact_no }}</td>
                        <td><a href="{{ URL::to('/') }}/updateManufacturerDetails?id={{ $manufacturer->id }}" class="btn btn-success btn-xs">Update</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection