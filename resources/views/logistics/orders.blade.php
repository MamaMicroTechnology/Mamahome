<?php
    $use = Auth::user()->group_id;
    $ext = ($use == 1? "layouts.app":"layouts.leheader");
?>
@extends($ext)
@section('content')

<div class="col-md-12 col-sm-12">
	<div class="panel panel-primary" style="overflow-x: scroll;">
	<div class="panel-heading text-center">
		<b style="color:white;font-size:1.4em">
			Confirmed Orders &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Total Count : {{$count}}
		</b>
		<a class="pull-right btn btn-sm btn-danger" href="{{URL::to('/')}}/home" id="btn1" style="color:white;">
			<b>Back</b>
		</a>
	</div>

	<div id="orders" class="panel-body">
		<table class="table table-responsive table-striped">
			<thead>
				<th style="text-align:center">Project ID</th>
				<th style="text-align: center;">Order Id</th>
				<th style="text-align:center">Product</th>
				<th style="text-align:center">Quantity</th>					
				<!-- <th style="text-align:center">Dispatch Status</th> -->
				<th style="text-align:center">Payment Status</th>
				<th style="text-align:center">Delivery Status</th>
				<th style="text-align:center">Action</th>
				<th style="text-align:center">Deposit Bank</th>

				<th style="text-align:center">Remark</th>
				<th style="text-align:center">Invoice</th>
			</thead>
			<tbody>
				@foreach($view as $rec)
					<tr id="row-{{$rec->id}}">
						<td style="text-align:center"><a href="{{URL::to('/')}}/showProjectDetails?id={{$rec->project_id}}">{{$rec -> project_id}}</a></td>
						<td style="text-align:center">{{ $rec->orderid }}</td>
						<td>
							{{ $rec->main_category }}<br>
							({{ $rec->sub_category }})
						</td>
						<td style="text-align:center">{{$rec->quantity}} {{$rec->measurement_unit}}</td>
						<td style="text-align: center;">
							@if($rec->paymentStatus != "Payment Received" )
								<button data-toggle="modal" data-target="#PaymentModal{{$rec->orderid}}" class="btn btn-success btn-sm">
									Payment Details
								</button>
							
									<div id="PaymentModal{{$rec->orderid}}" class="modal fade" role="dialog">
										<div class="modal-dialog modal-sm">
											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header">
													Payment Details<br>
												</div>
												<div class="modal-body">
													@foreach($paymentDetails as $paymentDetail)
														@if($paymentDetail->order_id == $rec->orderid)
															<img src="{{ URL::to('/') }}/payment_details/{{ $paymentDetail->file }}" alt="payment_slip" class="img-thumbnail">
														@endif
													@endforeach
													<br>
													<b>Note:</b>
													<small>
														{{ $rec->payment_note }}
													</small>
												</div>
												<div class="modal-footer">
													<!-- <button type="submit" class="btn btn-success pull-left">Save</button> -->
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>
							@else
								<a href="{{ URL::to('/') }}/public/signatures/{{ $rec->signature }}">{{ $rec->paymentStatus }}</a>
							@endif
						</td>
						<td style="text-align:center">
							<a href="{{ URL::to('/') }}/takesignature?orderId={{ $rec->orderid }}" class="btn btn-success btn-sm">
								@if($rec->delivery_status == "Delivered")
									Delivery Details
								@else
									Deliver
								@endif
							</a>
						</td>
						<td style="text-align:center">
							@if($rec->paymentStatus == "Payment Received")
							{{ $rec->paymentStatus }}

							@elseif($rec->delivery_status != "Delivered")
								{{ $rec->delivery_status }}
							@else
								Order Delivered
							@endif
						</td>
						<td>
							@if($rec->payment_status != "Closed" ) 
								@if($rec->paymentStatus == "Payment Received" ) 
									<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal6{{ $rec->orderid }}">Deposit</button>
								@endif
							@endif
							@if($rec->paymentStatus == "Payment Received" ) 
								@if($rec->payment_status == "Closed" ) 
									<button class="btn btn-danger btn-sm" data-toggle="modal" >Closed</button>
								@endif
							@endif

							<div class="modal" id="myModal6{{ $rec->orderid }}">
								<div class="modal-dialog">
									<div class="modal-content">

										<!-- Modal Header -->
										<div class="modal-header" style="background-color:green">
											<h4 class="modal-title"><CENTER style="color: white;">Cash Collection  </CENTER></h4>
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>

										<!-- Modal body -->
										<div class="modal-body">
											<form action="{{ URL::to('/') }}/deposit" method="post" enctype="multipart/form-data">
												{{ csrf_field() }}
												<input type="hidden" name="orderId" value="{{ $rec->orderid }}">
												<input type="hidden" name="user_id" value="{{ $rec->delivery_boy }}">
												<table class="table table-hover" border=1 >
													<tr>
														<td>Bank Name</td>
														<td>
															<select class="form-control" style="width: 40%" name="zone_id">
																<option value="select">----Select----</option>
																@foreach($zone as $zones)
																<option value="{{ $zones->id }}">{{ $zones->zone_name }}</option>
																@endforeach
															</select>
															<select class="form-control" style="width: 40%;margin-top: -35px;margin-left:45%;" name="bankname">
																<option value="select">----Select----</option>
																<option value="AxisBank">Axis Bank</option>
															</select>
														</td>
													</tr>
													<tr>
														<td>Amount</td>
														<td>
															<input required class="form-control" type="text" name="Amount" value="{{ $rec->amount }}">
														</td>
													</tr>
													<tr>
														<td>Date Of Deposit </td>
														<td>
															<input required class="form-control" type="date" name="bdate" >
														</td>
													</tr>
													<tr>
														<td>Cash Deposit Receipt Pic</td>
														<td>
															<input required class="form-control" type="file" name="image">
														</td>
													</tr>
												</table>
												<center><button type="submit" value="submit" class="btn btn-success btn-sm">Submit</button></center>
											</form>
										</div>
										<!-- Modal footer -->
										<div class="modal-footer">
											<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</div>
						</td>
						<td>
							<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal5{{ $rec->orderid }}">Feedback</button>
							<div class="modal" id="myModal5{{ $rec->orderid }}">
								<div class="modal-dialog">
									<div class="modal-content">
										<!-- Modal Header -->
										<div class="modal-header" style="background-color:green">
											<h4 class="modal-title"><CENTER style="color: white;">Coustomer Information  </CENTER></h4>
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
										<!-- Modal body -->
										<div class="modal-body">
											<form action="{{ URL::to('/') }}/feedback" method="post" enctype="multipart/form-data">
												{{ csrf_field() }}
												<input type="hidden" name="orderId" value="{{ $rec->orderid }}">
												<table class="table table-hover" border=1 >
													<tr>
														<td>Customer Satisfied ?</td>
														<td>
															<label><input required value="Yes" id="home1" type="radio" name="happy"><span>&nbsp;</span>Yes</label>
															<span>&nbsp;&nbsp;&nbsp;  </span>
															<label><input required value="No" id="home2" type="radio" name="happy"><span>&nbsp;</span>No</label>
															<span>&nbsp;&nbsp;&nbsp;  </span>
															<label><input required value="None" id="home3" type="radio" name="happy"><span>&nbsp;</span>None</label>
														</td>
													</tr>
													<tr>
														<td>Customer Is Happy With Quality Of Material?</td>
													<td>
														<label><input required value="Yes" id="home1" type="radio" name="quan"><span>&nbsp;</span>Yes</label>
														<span>&nbsp;&nbsp;&nbsp;  </span>
														<label><input required value="No" id="home2" type="radio" name="quan"><span>&nbsp;</span>No</label>
														<span>&nbsp;&nbsp;&nbsp;  </span>
														<label><input required value="None" id="home3" type="radio" name="quan"><span>&nbsp;</span>None</label>
													</td>
													</tr>
													<tr>
														<td>Customer Issue  ?</td>
														<td>
															<label><input required value="Yes" id="home1" type="radio" name="issue"><span>&nbsp;</span>Yes</label>
															<span>&nbsp;&nbsp;&nbsp;  </span>
															<label><input required value="No" id="home2" type="radio" name="issue"><span>&nbsp;</span>No</label>
															<span>&nbsp;&nbsp;&nbsp;  </span>
															<label><input required value="None" id="home3" type="radio" name="issue"><span>&nbsp;</span>None</label>
														</td>
													</tr>
													<tr>
														<td>Note</td>
														<td>
															<textarea required value="Yes" class="form-control"  type="text" name="note"></textarea><span>&nbsp;</span>
														</td>
													</tr>
												</table>
												<center><button type="submit" value="submit" class="btn btn-success btn-sm">Submit </button></center>
											</form>
										</div>
										<!-- Modal footer -->
										<div class="modal-footer">
											<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</div>
						</td>
						<td>
							<a href="{{ route('downloadProformaInvoice',['download'=>'pdf','id'=>$rec->orderid]) }}" class="btn btn-warning btn-xs">Download PDF</a>
							<a href="{{ route('downloadProformaInvoice',['id'=>$rec->orderid]) }}" class="btn btn-success btn-xs">View Invoice</a>
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
	function rtgs(){
		document.getElementById('rtgs').className = "form-control input-sm";
		document.getElementById('cash').className = "hidden";
	}
	function cash(){
		document.getElementById('cash').className = "form-control input-sm";
		document.getElementById('rtgs').className = "hidden";
	}
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
	function changeValue(val, id){
	//use comparison operator   
		if(val=="Cheque" || val=="RTGS" || val=="Cash" )
			document.getElementById('show'+id).className = "";
		else{
			document.getElementById('show'+id).className="hidden";
		}
	}

</script>

@endsection
