@extends('layouts.app')
@section('content')

    <table class="table table-responsive" border=1>
        <th>Ward Name</th>
        <th>Project Id</th>
        <th>Order Id</th>
        <th>Category</th>
        <th>Quantity</th>
        <th>Action</th>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->ward_id }}</td>
            <td>{{ $order->project_id }}</td>
            <td>{{ $order->id }}</td>
            <td>{{ $order->main_category }}</td>
            <td>{{ $order->quantity }}</td>
            <td>
                @if($order->clear_for_delivery == "No")
                <form id="theForm" action="{{ URL::to('/') }}/clearOrderForDelivery" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <button class="btn btn-primary btn-xs">Clear For Delivery</button>
                </form>
                @else
                    Cleared For Delivery
                @endif
            </td>
        </tr>
        @endforeach
    </table>

@endsection