@extends('layouts.app')

@section('content')

<div class="">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading text-center">
				Enquiry Data
			</div>
			<div class="panel-body" style="overflow-x: auto">
				<form method="GET" action="{{ URL::to('/') }}/enquirysheet">
					<div class="col-md-12">
						<div class="col-md-2">
							<label>From (Enquiry Date)</label>
							<input type="date" class="form-control" name="from">
						</div>
						<div class="col-md-2">
							<label>To (Enquiry Date)</label>
							<input type="date" class="form-control" name="to">
						</div>
						<div class="col-md-2">
							<label>Wards</label>
							<select class="form-control" name="ward">
								<option value="">--Select--</option>
								@foreach($wards as $ward)
								<option value="{{ $ward->id }}">{{ $ward->sub_ward_name }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-2">
							<label>Initiator</label>
							<select class="form-control" name="initiator">
								<option value="">--Select--</option>
								@foreach($initiators as $initiator)
								<option value="{{ $initiator->id }}">{{ $initiator->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-2">
							<label>Category:</label>
							<select class="form-control" name="category">
								<option value="">--Select--</option>
								@foreach($category as $category)
								<option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-2">
							<label></label>
							<input type="submit" value="Fetch" class="form-control btn btn-primary">
						</div>
					</div>
				</form>
				<br>
				<table id="myTable" class="table table-responsive table-striped table-hover">
					<thead>
						<tr>
							<th style="text-align: center">Project</th>
							<th style="text-align: center">Ward Name</th>
							<th style="text-align: center">Name</th>
							<th style="text-align: center">Requirement Date</th>
							<th style="text-align: center">Enquiry Date</th>
							<th style="text-align: center">Contact</th>
							<th style="text-align: center">Product</th>
							<th style="text-align: center">Quantity</th>
							<th style="text-align: center">Initiator</th>
							<th style="text-align: center">Status</th>
							<th style="text-align: center">Remarks</th>
							<th style="text-align: center">Update Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach($enquiries as $enquiry)
						<tr>
							<td style="text-align: center">
								<a href="{{URL::to('/')}}/showThisProject?id={{$enquiry -> project_id}}">
									<b>{{$enquiry -> project_id }}</b>
								</a> 
							</td>
							<td style="text-align: center">{{$subwards2[$enquiry->project_id]}}</td>
							<td style="text-align: center">{{$enquiry -> procurement_name}}</td>
							<td style="text-align: center">{{$newDate = date('d/m/Y', strtotime($enquiry->requirement_date)) }}</td>
							<td style="text-align: center">{{ date('d/m/Y', strtotime($enquiry->created_at)) }}</td>
							<td style="text-align: center">{{$enquiry -> procurement_contact_no }}</td>
							<td style="text-align: center">{{$enquiry -> main_category}} ({{ $enquiry->sub_category }}), {{ $enquiry->material_spec }}</td>
							<td style="text-align: center">{{$enquiry -> quantity}}</td>
							<td style="text-align: center">{{$enquiry -> name}}</td>
							<td style="text-align: center">
								@if($enquiry->status == "Not Processed")
								Pipelined
								@else
								{{ $enquiry->status}}
								@endif
							</td>
							<td style="text-align: center" onclick="edit('{{ $enquiry->id }}')" id="{{ $enquiry->id }}">
								<form method="POST" action="{{ URL::to('/') }}/editEnquiry">
									{{ csrf_field() }}
									<input type="hidden" value="{{$enquiry->id}}" name="id">
									<input onblur="this.className='hidden'; document.getElementById('now{{ $enquiry->id }}').className='';" name="note" id="next{{ $enquiry->id }}" type="text" maxlength="6" size="35" class="hidden" value="{{ $enquiry->notes }}"> 
									<p id="now{{ $enquiry->id }}">{{$enquiry->notes}}</p>
								</form>
							</td>
							<td>
								<form method="POST" action="{{ URL::to('/') }}/editEnquiry">
									{{ csrf_field() }}
									<input type="hidden" value="{{$enquiry->id}}" name="id">
									<select required name="status" onchange="this.form.submit();" style="width:100px;">
										<option value="">--Select--</option>
										<option>Order Confirmed</option>
										<option>Order Closed</option>
										<option>Order Cancelled</option>
									</select>
								</form>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="panel-footer">
				
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function edit(arg){
		document.getElementById('now'+arg).className = "hidden";
		document.getElementById('next'+arg).className = "";
		document.getElementById('next'+arg).focus();
	}
	function editm(arg){
		document.getElementById('noww'+arg).className = "hidden";
		document.getElementById('nextt'+arg).className = "form-control";
	}
</script>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var today = new Date();
		var dd = today.getDate(); //Get day
		var mm = today.getMonth()+1; //January is 0!

		var yyyy = today.getFullYear();
		if(dd<10){
		    dd='0'+dd;
		} 
		if(mm<10){
		    mm='0'+mm;
		} 
		var format = dd+'-'+mm+'-'+yyyy;
		$.noConflict();
	    $('#myTable').DataTable( {
	        dom: 'Bfrtip',
	        "paging":   true,
	        "searching": false,
        	"ordering": true,
        	"info":     true,
	        buttons: [ 
	            // {
	            //     extend: 'excelHtml5',
	            //     title: 'Sales Report - '+format,
	            //     className: 'btn btn-md btn-success hidden',
	            //     text: 'Export To Excel'
	            // },
	            // {
	            // 	extend: 'pdf',
	            // 	title: 'Sales Report - '+format,
	            // 	className: 'btn btn-md btn-primary hidden',
	            // 	text: 'Export To PDF' 
	            // },            
	        ]
	    } );
	} );
</script>
<script type="text/javascript">
	$(document).ready(function() {
		var today = new Date();
		var dd = today.getDate(); //Get day
		var mm = today.getMonth()+1; //January is 0!

		var yyyy = today.getFullYear();
		if(dd<10){
		    dd='0'+dd;
		} 
		if(mm<10){
		    mm='0'+mm;
		} 
		var format = dd+'-'+mm+'-'+yyyy;
		$.noConflict();
	    $('#myTable2').DataTable( {
	        dom: 'Bfrtip',
	        "paging":   true,
	        "searching": true,
        	"ordering": true,
        	"info":     true,
	        buttons: [ 
	                   
	        ]
	    } );
	} );
</script>
@endsection