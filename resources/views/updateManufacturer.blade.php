@extends('layouts.app')
@section('content')

    <div class="panel panel-success">
        <div class="panel-heading">Manufacturers</div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                    <th>Manufacturer Id</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact No</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach($manufacturers as $manufacturer)
                    <tr>
                        <td><a href="{{ URL::to('/') }}/viewmanu?id={{ $manufacturer->id }}">{{ $manufacturer->id }}</td>
                          
                        <td>{{ $manufacturer->proc != null ?$manufacturer->proc->name:'' }}</td>
                        <td>{{ $manufacturer->address }}</td>
                        <td>{{ $manufacturer->proc != null ? $manufacturer->proc->contact:''}}</td>
                        <td><a href="{{ URL::to('/') }}/updateManufacturerDetails?id={{ $manufacturer->id }}" class="btn btn-primary btn-sm">Edit</a>
                         <a class="btn btn-sm btn-success btn-sm" name="addenquiry" href="{{ URL::to('/') }}/manuenquiry?projectId={{ $manufacturer->id }}" style="color:white;font-weight:bold;padding: 6px;">Add Enquiry</a>
                     </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
