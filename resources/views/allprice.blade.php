@extends('layouts.app')

@section('content')
<div class="col-md-8">
    <div class="col-md-8 col-md-offset-4">
        <div class="panel panel-default" style="border-color:green">
            <div class="panel-heading text-center" style="background-color:green">
                <b style="color:white">pricess</b>
                <a  href="javascript:history.back()" class="btn btn-sm btn-danger btn-sm pull-right">Back</a> 
            </div>
        <table  class="table table-responsive table-striped" border="1">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Sub Category</th>
                        <!-- <th>Designation</th> -->
                        <th>Quantity</th>
                         @if(Auth::user()->group_id == 2)
                        <th> Price</th>
                        @endif
                       <!--  <th>Asst-TLs Price</th> -->
                        @if(Auth::user()->group_id == 6 || Auth::user()->group_id == 7 || Auth::user()->group_id == 17 )
                       <th> Price</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                @foreach($myPrices as $myPrice)
                <tr>
                    <td>{{ $myPrice->category_name }}</td>
                    <td>{{ $myPrice->brand }}</td>
                    <td>{{ $myPrice->sub_cat_name }}</td>
                    <td>{{ $myPrice->quantity }}</td>
                         @if(Auth::user()->group_id == 2)

                    <td>{{ $myPrice->stl }}</td>
                    @endif
                    <!-- <td>{{ $myPrice->asstl }}</td> -->
                        @if(Auth::user()->group_id == 6 || Auth::user()->group_id == 7 || Auth::user()->group_id == 17 )
                        <td>{{ $myPrice->leandse }}
                       </td>
                        @endif
                </tr>
                @endforeach
                   </tbody>
                   </table>

        </div>
    </div>
</div>
</div>

@endsection