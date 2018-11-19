
<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 26? "finance.layouts.headers":"layouts.app");
?>
@extends($ext)
@section('content')
<div class="col-md-12 ">
    <table class="table table-responsive" border=1>
        <!-- <th>Ward Name</th> -->
        <th>Requirement Date</th>
        <th>Project Id</th>
        <th>Order Id</th>
        <th>Category</th>
        <th>Quantity</th>
        <th>Payment Details</th>
        @if(Auth::user()->group_id != 22)
        <th>Confirm Payment</th>
        <th>MAMAHOME Invoice</th>
        @endif
        @foreach($orders as $order)
        <tr style="{{ date('Y-m-d') == $order->requirement_date ? 'background-color:#ccffcc': '' }}">
            <td>{{ date('d M, y',strtotime($order->requirement_date)) }}</td>
            <td>{{ $order->project_id }}</td>
            <td>{{ $order->id }}</td>
            <td>{{ $order->main_category }}</td>
            <td>{{ $order->quantity }}</td>
            <td>
                @if($order->payment_status == "Payment Received")
                <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal{{ $order->id }}">
                    Payment Details
                    <span class="badge">{{ $counts[$order->id] }}</span>    
                </button>
                @endif
            </td>
              @if(Auth::user()->group_id != 22)
            <td>
                
                            <div class="btn-group">
                                <!-- <a class="btn btn-xs btn-success" href="{{URL::to('/')}}/confirmpayment?id={{ $order->id }}">Confirm</a> -->
                               <button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#payment"> Confirm</button>
                                <button class="btn btn-xs btn-danger pull-right" onclick="cancelOrder('{{ $order->id }}')">Cancel</button>
                            </div>
              
                           
            </td>
            <td>
                @if($order->clear_for_delivery == "No")
                <form id="theForm" action="{{ URL::to('/') }}/clearOrderForDelivery" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <button class="btn btn-primary btn-xs">Clear For Delivery</button>
                </form>
                @else
                    <!-- <a href="{{ route('downloadProformatTaxInvoice',['download'=>'pdf','id'=>$order->id]) }}" class="btn btn-warning btn-xs">Download INVOICE</a>
                    <a href="{{ route('downloadProformatTaxInvoice',['id'=>$order->id]) }}" class="btn btn-success btn-xs">Invoice</a>
                    <br> -->
                    <a href="{{ route('downloadProformaInvoice',['download'=>'pdf','id'=>$order->id]) }}" class="btn btn-warning btn-xs">Download TAX INVOICE</a>
                    <a href="{{ route('downloadProformaInvoice',['id'=>$order->id]) }}" class="btn btn-primary btn-xs">TAX Invoice</a>
                @endif
            </td>
            @endif
        </tr>
                    <!-- Modal -->
                    <div id="payment" class="modal fade" role="dialog">
                      <div class="modal-dialog" style="width:30%">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{ $order->id }}</h4>
                          </div>
                          <div class="modal-body">
                           <form action="{{ URL::to('/') }}/sendMessage" method="post">
                            {{ csrf_field() }}
                            <label>Quantity : </label>
                            <input type="text" class="form-control" name="quantity" placeholder="quantity">
                            <br>
                            <label>Rate (Per Unit) : </label>
                            <input type="text"  class="form-control" name="quantity" placeholder="Unit Price">
                            <br>
                            <button type="submit" class="btn btn-sm btn-success" type="">Save</button>
                            <br>
                           </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>

                      </div>
                    </div>
        @endforeach
    </table>
    <center>
        {{ $orders->links() }}
    </center>
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
                    
                    @foreach($payments as $payment)
                        @if($payment->order_id == $order->id)
                        <img src="{{ URL::to('/') }}/payment_details/{{ $payment->file }}" alt="payment_slip" class="img-thumbnail">
                        @endif
                    @endforeach
                    <p>
                    <b>Note: </b><br>
                        {{ $order->payment_note }}
                    </p>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            Messages: <br>
                            @foreach($messages as $message)
                                @if($message->to_user == $order->id)
                                    <p
                                        style="width:70%;
                                            border-style:ridge;
                                            padding:10px;
                                            border-width:2px;
                                            border-radius:10px;
                                            {{ $message->from_user == Auth::user()->id ? 'border-bottom-left-radius:0px;' : 'border-bottom-right-radius:0px;' }}
                                            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
                                            "
                                            class="text-justify {{ $message->from_user == Auth::user()->id ? 'pull-right' : 'pull-left' }}">
                                        @foreach($users as $user)
                                            @if($user->id == $message->from_user)
                                                <b>- {{ $user->name }} : </b><br>
                                            @endif
                                        @endforeach
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $message->body }}
                                        <br>
                                        <span class="pull-right"><i>{{ $message->created_at->diffforHumans() }}</i></span>
                                    </p>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-md-12">
                            <form action="{{ URL::to('/') }}/sendMessage" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="orderId" value="{{ $order->id }}">    
                                <div class="input-group">
                                    <input type="text" name="message" id="message" placeholder="Type Your Message Here" class="form-control">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-success">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
    swal('Success',"{{ session('Success') }}",'success');
</script>
@endif
@endsection