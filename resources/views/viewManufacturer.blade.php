@extends('layouts.app')
@section('content')
    <div class="col-md-10 col-md-offset-1">
        <table class="table" border=1>
        <tr>
            <th>SubWardId</th>
            <th>Name</th>
            <th>Address</th>
            <th>Area</th>
            <th>Capacity</th>
            <!-- <th>Present Utilization</th> -->
            <th>Cement Requirement</th>
            <th>Prefered Cement Brand</th>
            <!-- <th>Deliverability</th> -->
            <th>Sand Requirement</th>
            <th>Manufacturing Type</th>
            <!-- <th>Payment Mode</th> -->
            <th>Products</th>
        </tr>
        @foreach($manufacturers as $manufacturer)
            <tr>
                <td>{{ $manufacturer->sub_ward_id }}</td>
                <td>{{ $manufacturer->name }}</td>
                <td>{{ $manufacturer->address }}</td>
                <td>{{ $manufacturer->area }}</td>
                <td>{{ $manufacturer->capacity }}</td>
                <td>{{ $manufacturer->cement_requirement }} {{ $manufacturer->cement_requirement_measurement }}</td>
                <td>{{ $manufacturer->prefered_cement_brand }}</td>
                <td>{{ $manufacturer->sand_requirement }}</td>
                <td>{{ $manufacturer->type }}</td>
                
                <td>
                    <table class="table table-striped" border=1>
                    <tr>
                        <th>Type</th>
                        <th>Size</th>
                        <th>Price</th>
                    </tr>
                    @foreach($manufacturer->manufacturerProduct as $products)
                        <tr>
                            <td>{{ $products->block_type }}</td>
                            <td>{{ $products->block_size }}</td>
                            <td>₹{{ $products->price }}/-</td>
                        </tr>
                    @endforeach
                    </table>
                </td>
            </tr>
        @endforeach
        </table>
    </div>
@endsection