@extends('layouts.app')
@section('content')
    <div class="col-md-12">
        <div class="panel panel-primary">
        <div class="panel-heading text-center" style="padding:-20px;">
                        <center ><h5> Manufacturer Details: &nbsp;&nbsp;&nbsp;{{$count}}</h5></center>
                 <button type="button" onclick="history.back(-1)" class="bk-btn-triangle pull-right" style="margin-top:-35px;" > <i class="fa fa-arrow-circle-left" style="padding:5px;width:50px;color: black;"></i></button>
                
                    
                
            </div>
            <div class="panel-body" style="overflow-x: auto">
        <style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    padding: 8px;

}

tr:nth-child(even) {
    background-color: #dddddd;
}

</style>
        <table class="table table-responsive table-striped table-hover" cellspacing="50">
           <thead class="thead-dark" style="background-color:#0ff2191a;">
        <tr>
            <th>SubWardId</th>
            <th>Name</th>
            <th>Phone Number 1</th>
            <th>Phone Number 2</th>

            <th>Address</th>
            <th>Area</th>
            <th>Capacity</th>
            <!-- <th>Present Utilization</th> -->
            <th>Cement Requirement</th>
            <th>Prefered Cement Brand</th>
            <!-- <th>Deliverability</th> -->
            <th>Sand Requirement</th>
            @if(isset($_GET['type']) && $_GET['type'] == "Blocks")
            <th>Manufacturing Type</th>
            @endif
            <!-- <th>Payment Mode</th> -->
            <th>Products</th>
            <th>Payment Method</th>
            <th>Plant Name</th>
            
        </tr>
    </thead>
        @foreach($manufacturers as $manufacturer)
            <tr>
                <td>{{$manufacturer->subward != null ? $manufacturer->subward->sub_ward_name :'' }}</td>
                <td>{{ $manufacturer->proc != null ? $manufacturer->proc->name :$manufacturer->name }}</td>
                <td>{{ $manufacturer->proc != null ? $manufacturer->proc->contact :$manufacturer->contact_no }}</td>
                <td>{{ $manufacturer->proc != null ? $manufacturer->proc->contact1 :''}}</td>
                <td>{{ $manufacturer->address }}</td>
                <td>{{ $manufacturer->total_area }}</td>
                <td>{{ $manufacturer->capacity }}</td>
                <td>{{ $manufacturer->cement_requirement }} {{ $manufacturer->cement_requirement_measurement }}</td>
                <td>{{ $manufacturer->prefered_cement_brand }}</td>
                <td>{{ $manufacturer->sand_requirement }}</td>
                @if(isset($_GET['type']) && $_GET['type'] == "Blocks")
                <td>{{ $manufacturer->type }}</td>
                @endif
                <td>
                    <table class="table table-striped" border=1>
                    <tr>
                        <th>Type</th>
                        <th class="{{ isset($_GET['type']) ? $_GET['type'] == 'RMC' ? 'hidden' : '' : '' }}">Size</th>
                        <th>Price</th>
                    </tr>
                    @foreach($manufacturer->manufacturerProduct as $products)
                        <tr>
                            <td>{{ $products->block_type }}</td>
                            <td class="{{ isset($_GET['type']) ? $_GET['type'] == 'RMC' ? 'hidden' : '' : '' }}">{{ $products->block_size }}</td>
                            <td>₹{{ $products->price }}/-</td>
                        </tr>
                    @endforeach
                    </table>
                </td>
                <td>{{ $manufacturer->payment_mode }}</td>
                <td>{{ $manufacturer->plant_name }}</td>


            </tr>
        @endforeach
        </table>
    </div>
</div>
</div>
@endsection