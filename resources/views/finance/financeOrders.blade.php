@extends('layouts.app')
@section('content')
<div class="col-md-10 col-md-offset-1">
    <table class="table table-responsive" border=1>
        <!-- <th>Ward Name</th> -->
        <th>Project Id</th>
        <th>Order Id</th>
        <th>Category</th>
        <th>Quantity</th>
        <th>Payment Details</th>
        <th>Action</th>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->project_id }}</td>
            <td>{{ $order->id }}</td>
            <td>{{ $order->main_category }}</td>
            <td>{{ $order->quantity }}</td>
            <td>
                <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal{{ $order->id }}">Payment Details</button>
            </td>
            <td>
                @if($order->clear_for_delivery == "No")
                <form id="theForm" action="{{ URL::to('/') }}/clearOrderForDelivery" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <button class="btn btn-primary btn-xs">Clear For Delivery</button>
                </form>
                @else
                    <a href="{{ route('downloadProformaInvoice',['download'=>'pdf','id'=>$order->id]) }}" class="btn btn-warning btn-xs">Download PDF</a>
                    <a href="{{ route('downloadProformaInvoice',['id'=>$order->id]) }}" class="btn btn-success btn-xs">View Invoice</a>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</div>
    @foreach($orders as $order)
        <!-- Modal -->
        <div id="myModal{{ $order->id }}" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ $order->id }} Payment Details</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ URL::to('/') }}/savePaymentDetails" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <label for="payment_mode">Payment Mode</label>
                        <input required type="text" name="payment_mode" id="payment_mode" placeholder="Payment Mode" class="form-control input-sm">
                        <br>
                        <label for="payment_mode">Payment Slip</label>
                        <input required multiple type="file" name="payment_slip[]" id="payment_slip" accept="image/*" class="form-control input-sm" >
                        <br>
                        <button type="submit" class="form-control btn btn-success">Save</button>
                    </form>
                    @foreach($payments as $payment)
                        @if($payment->order_id == $order->id)
                        <img src="{{ URL::to('/') }}/payment_details/{{ $payment->file }}" alt="payment_slip" class="img-thumbnail">
                        @endif
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </div>

            </div>
        </div>
    @endforeach
@if(session('Success'))
<script>
    swal('success',"{{ session('Success') }}",'Success');
</script>
@endif
@endsection