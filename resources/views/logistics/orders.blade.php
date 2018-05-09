@extends('layouts.logisticslayout')
@section('title','Logistics Orders')
@section('content')
<div class="col-md-12 col-sm-12">
	<div class="panel panel-primary" style="overflow-x: scroll;">
		<div class="panel-heading text-center">
			<b style="color:white;font-size:1.4em">Confirmed Orders &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Total Count : {{$count}}</b>
			<a class="pull-right btn btn-sm btn-danger" href="{{URL::to('/')}}/home" id="btn1" style="color:white;"><b>Back</b></a>
		</div>
		<div id="orders" class="panel-body">
			<table class="table table-responsive table-striped">
				<thead>
				    <th style="text-align:center">Project ID</th>
                    <th style="text-align: center;">Order Id</th>
					<th style="text-align:center">Quantity</th>					
					<!-- <th style="text-align:center">Status</th> -->
					<th style="text-align:center">Dispatch Status</th>
					<th style="text-align:center">Payment Status</th>
					<th style="text-align:center">Delivery Status</th>
                    <th style="text-align:center">Action</th>
					
				</thead>
				<tbody>
					@foreach($view as $rec)
					<tr id="row-{{$rec->id}}">
						<td style="text-align:center"><a href="{{URL::to('/')}}/showProjectDetails?id={{$rec->project_id}}">{{$rec -> project_id}}</a></td>
                        <td style="text-align:center">{{ $rec->orderid }}</td>
						<td style="text-align:center">{{$rec->quantity}} {{$rec->measurement_unit}}</td>
						<!-- <td style="text-align:center"></td> -->
						<td style="text-align:center">
						@if($rec->dispatch_status=='Yes')
						    Dispatched
						@else
						    <button onclick="updateDispatch('{{ $rec->orderid }}')" class="btn btn-success btn-sm">Dispatch</button>
						@endif    
						</td>
				        <td style="text-align: center;">
                            @if($rec->payment_status != "Payment Received" && $rec->dispatch_status == 'Yes')
							<button data-toggle="modal" data-target="#PaymentModal{{$rec->orderid}}" class="btn btn-success btn-sm">Payment Details</button>
                                <form method="POST" action="{{ URL::to('/') }}/saveSignature" enctype="multipart/form-data">
                                    {{ csrf_field() }}
									<div id="PaymentModal{{$rec->orderid}}" class="modal fade" role="dialog">
										<div class="modal-dialog modal-sm">
											<!-- Modal content-->
											<div class="modal-content">
											<div class="modal-header">
												Payment
											</div>
											<div class="modal-body">
												<label for="amount">Amount Received:</label>
												<input required type="text" name="amount" id="amount" placeholder="Amount Received" class="form-control input-sm"><br>
												<label for="sign">Signature:</label>
												<input required type="file" name="signature" id="sign" class="form-control input-sm" accept="image/*">
												<input type="hidden" name="orderId" value="{{ $rec->orderid }}">
											</div>
											<div class="modal-footer">
												<button type="submit" class="btn btn-success pull-left">Save</button>
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
                                </form>
                            @else
                                <a href="{{ URL::to('/') }}/public/signatures/{{ $rec->signature }}">{{ $rec->payment_status }}</a>
                            @endif
                        </td>
                        <td style="text-align:center">
                            @if($rec->delivery_status == "Not Delivered")
								<!-- Trigger the modal with a button -->
							<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal{{ $rec->orderid }}">Deliver</button>

							<!-- Modal -->
							<form action="{{ URL::to('/') }}/saveDeliveryDetails" method="post" enctype="multipart/form-data">
								{{ csrf_field() }}
								<input type="hidden" name="orderId" value="{{ $rec->orderid }}">
								<div id="myModal{{ $rec->orderid }}" class="modal fade" role="dialog">
								<div class="modal-dialog">

									<!-- Modal content-->
									<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Order Delivery Form</h4>
									</div>
									<div class="modal-body">
										<table class="table table-hover" border=1>
											<tr>
												<td colspan=2><label for="Images">Images</label></td>
											</tr>
											<tr>
												<td>Vehicle No.</td>
												<td><input required accept="image/*" oninput="inputcheck()" type="file" name="vno" id="vno" class="form-control"></td>
											</tr>
											<tr>
												<td>Location Picture</td>
												<td><input required accept="image/*" oninput="inputcheck()" type="file" name="lp" id="lp" class="form-control"></td>
											</tr>
											<tr>
												<td>Quality of Material</td>
												<td><input required accept="image/*" oninput="inputcheck()" type="file" name="qm" id="qm" class="form-control"></td>
											</tr>
											<tr>
												<td colspan="2"><center><label for="Video">Video</label></center></td>
											</tr>
											<tr>
												<td>
													Delivery Video
													<br>(Video should cover all the<br>necessary fields as in images)
												</td>
												<td><input accept="video/*" oninput="inputcheck()" type="file" name="vid" id="vid" class="form-control"></td>
											</tr>
										</table>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-success pull-left">Save</button>
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
									</div>
								</div>
								</div>
							</form>
                                <!-- <button onclick="deliverOrder('{{ $rec->orderid }}')" class="btn btn-success btn-sm">Deliver</button> -->
                            @else
							<?php
								$images = "<a class='".($rec->vehicle_no == null ? 'hidden':'')."' href='".$_SERVER['HTTP_HOST']."/delivery_details/".$rec->vehicle_no."'>Vehicle No</a><br>"
											."<a class='".($rec->location_picture == null ? 'hidden':'')."' href='".$_SERVER['HTTP_HOST']."/delivery_details/".$rec->location_picture."'>Location Picture</a><br>"
											."<a class='".($rec->quality_of_material == null ? 'hidden':'')."' href='".$_SERVER['HTTP_HOST']."/delivery_details/".$rec->quality_of_material."'>Quality Of Material</a><br>"
											."<a class='".($rec->delivery_video == null ? 'hidden':'')."' href='".$_SERVER['HTTP_HOST']."/delivery_details/".$rec->delivery_video."'>Video</a>";
							?>
								<a href="#" data-toggle="popover" title="Delivery Images" data-content="{!! $images !!}">
									{{ $rec->delivery_status }}
								</a>
                            @endif
                        </td>
                        <td style="text-align:center">
                            @if($rec->payment_status == "Payment Received")
                                {{ $rec->payment_status }}
                            @elseif($rec->delivery_status != "Delivered")
    				            <a onclick="cancelOrder('{{$rec->orderid}}')" class="btn btn-sm btn-danger" style="width:99%" >
    				                <b>Cancel Order</b>
    				            </a>
                            @else
                                Order Delivered
                            @endif
				        </td>
					</tr>
					@endforeach
				</tbody>	
			</table>
			<br>
			<center>{{$view->links()}}</center>	
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({html:true});   
});
</script>
<script type="text/javascript">
	
	function pay(arg)
	{
		var ans = confirm('Are You Sure ? Note: Changes Made Once CANNOT Be Undone');
		if(ans){
			$.ajax({
				type: 'GET',
				url: "{{URL::to('/')}}/updateampay",
				data: {id: arg},
				async: false,
				success: function(response){
					console.log(response);
				}
			});
		}
		return false;
	}

	function updateDispatch(arg)
	{
		var ans = confirm('Are You Sure ? Note: Changes Made Once CANNOT Be Undone');
		if(ans){
    		$.ajax({
    			type: 'GET',
    			url: "{{URL::to('/')}}/updateamdispatch",
    			data: {id: arg},
    			async: false,
    			success: function(response){
    				console.log(response);
                     $("#orders").load(location.href + " #orders>*", "");
    			}
    		});
		}
		return false;	
	}
	
	function deliverOrder(arg)
	{
	    var ans = confirm('Are You Sure To Confirm This Order ?');
	    if(ans)
	    {
    	    $.ajax({
    	       type:'GET',
    	       url: "{{URL::to('/')}}/deliverOrder",
    	       data: {id : arg},
    	       async: false,
    	       success: function(response)
    	       {
    	           console.log(response);
    	           $("#orders").load(location.href + " #orders>*", "");
    	       }
    	    });
	    }    
	}
	
	function cancelOrder(arg)
	{
	    var ans = confirm('Are You Sure To Cancel This Order ?');
	    if(ans)
	    {
    	    $.ajax({
    	       type:'GET',
    	       url: "{{URL::to('/')}}/cancelOrder",
    	       data: {id : arg},
    	       async: false,
    	       success: function(response)
    	       {
    	           console.log(response);
    	           $("#orders").load(location.href + " #orders>*", "");
    	       }
    	    });
	    }
	 }

</script>
@endsection
