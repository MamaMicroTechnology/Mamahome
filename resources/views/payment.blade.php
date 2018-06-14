<?php
  $user = Auth::user()->group_id;
  $ext = ($user == 4? "layouts.amheader":"layouts.app");
?>
@extends($ext)
@section('content')
<div class="col-md-12">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <b style="font-size:1.4em;text-align:center">Payment&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Count : {{ $pay }} </b>
                <a class="pull-right btn btn-sm btn-danger" href="{{url()->previous()}}"><b>Back</b></a>
            </div>
            <div class="panel-body">
                <table class="table table-responsive table-striped table-hover" border="1">
    				<thead>
                        <th style="text-align:center">Order ID</th>
    				    <th style="text-align:center">Project Id</th>
    					<th style="text-align:center">Customer Name</th>
    					<th style="text-align:center">Payment Method</th>
    					<th style="text-align:center">Advance Amount</th>
    					<th style="text-align:center">Total Amount</th>
    					<th style="text-align:center">log_Name</th>
                        <th style="text-align:center">Payment Status</th>

                        <!-- <th style="text-aligh:center">View Invoice</th> -->
    				</thead>
    				<tbody>
					   @foreach($payment as $pay)
					    <tr>
                            <td style="text-align:center">
                                <a href="{{URL::to('/')}}/inputinvoice?id={{$pay->order_id}}" target="_blank">{{ $pay->order_id }}</a>
                            </td>
					        <td style="text-align:center">{{ $pay->project_id}}</td>
					        <td style="text-align:center">{{ $pay->c_name }}</td>
					        <td style="text-align:center">{{ $pay->p_method }} </td>
					        <td style="text-align:center">{{ $pay->advance_amount }}</td>
					        <td style="text-align:center">{{ $pay->amount }}</td>
					        <td style="text-align:center">{{ $pay->log_name }}</td>
                            <td style="text-align:center">{{ $pay->payment_status }}</td>
                           </td> 
					    </tr>
					   @endforeach
    			    </tbody>
    			</table>    
            </div>
        </div>
    </div>
</div>
@endsection