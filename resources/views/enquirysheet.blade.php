@extends('layouts.app')

@section('content')

<div class="{{ Auth::user()->department_id == 0 ? 'col-md-12 col-sm-12':'hidden' }}">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-primary">
			<div class="panel-heading text-center">
				Enquiry Data
			</div>
			<div class="panel-body" style="overflow-x: auto">
				<table id="myTable" class="table table-responsive table-striped table-hover">
					<thead>
						<tr>
							<th style="text-align: center">Project</th>
							<th style="text-align: center">Name</th>
							<th style="text-align: center">Date</th>
							<th style="text-align: center">Contact</th>
							<th style="text-align: center">Email</th>
							<th style="text-align: center">Product</th>
							<th style="text-align: center">Ward Name</th>
							<th style="text-align: center">Quantity</th>
							<th style="text-align: center">Initiator</th>
							<th style="text-align: center">Status</th>
							<th style="text-align: center">Remarks</th>
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
							<td style="text-align: center">{{$enquiry -> procurement_name}}</td>
							<td style="text-align: center">{{$newDate = date('d/m/Y', strtotime($enquiry->requirement_date)) }}</td>
							<td style="text-align: center">{{$enquiry -> procurement_contact_no }}</td>
							<td style="text-align: center">{{$enquiry -> procurement_email}}</td>
							<td style="text-align: center">{{$enquiry -> main_category}} ({{ $enquiry->sub_category }}), {{ $enquiry->material_spec }}</td>
							<td style="text-align: center">{{$subwards2[$enquiry->project_id]}}</td>
							<td style="text-align: center">{{$enquiry -> quantity}}</td>
							<td style="text-align: center">{{$enquiry -> name}}</td>
							<td style="text-align: center">
								@if($enquiry->status == "Not Processed")
									Pipelined
								@elseif($enquiry->status == "Order Confirmed")
									Executed
								@else
									{{$enquiry -> status}}
								@endif
							</td>
							<td style="text-align: center" onclick="edit('{{ $enquiry->id }}')" id="{{ $enquiry->id }}">
								<form method="POST" action="{{ URL::to('/') }}/editEnquiry">
									{{ csrf_field() }}
									<input type="hidden" value="{{$enquiry->id}}" name="id">
									<input name="note" id="next{{ $enquiry->id }}" type="text" class="hidden" value="{{ $enquiry->notes }}"> 
									<p id="now{{ $enquiry->id }}">{{$enquiry->notes}}</p>
								</form>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="panel-footer">
				<center>{{ $enquiries->links() }}</center>
			</div>
		</div>
	</div>
</div>


<div class="{{ Auth::user()->department_id != 0 ? 'col-md-12 col-sm-12':'hidden' }}">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-primary">
			<div class="panel-heading text-center">
				Enquiry Data (Manual entry)
			</div>
			<div class="panel-body" style="overflow-x: auto">
				<table id="myTable2" class="table table-responsive table-striped table-hover">
					<thead>
						<tr>
							<th style="text-align: center">Project</th>
							<th style="text-align: center">Name</th>
							<th style="text-align: center">Date</th>
							<th style="text-align: center">Contact</th>
							<th style="text-align: center">Email</th>
							<th style="text-align: center">Product</th>
							<th style="text-align: center">Ward Name</th>
							<th style="text-align: center">Quantity</th>
							<th style="text-align: center">Remarks</th>
						</tr>
					</thead>
					<tbody>
						@foreach($records as $record)
						<tr>
							<td style="text-align: center">
								<a href="{{URL::to('/')}}/showThisProject?id={{$record -> rec_project}}">
									<b>{{$record -> rec_project}}</b>
								</a> 
							</td>
							<td style="text-align: center">{{$record -> rec_name}}</td>
							<td style="text-align: center">{{$newDate = date('d/m/Y', strtotime($record->rec_date)) }}</td>
							<td style="text-align: center">{{$record -> rec_contact}}</td>
							<td style="text-align: center">{{$record -> rec_email}}</td>
							<td style="text-align: center">{{$record -> rec_product}}</td>
							<td style="text-align: center">{{$subwards[$record->rec_project]}}</td>
							<td style="text-align: center">{{$record -> rec_quantity}}</td>
							<td style="text-align: center" onclick="editm('{{ $record->id }}')">
								<form method="POST" action="{{ URL::to('/') }}/editManualEnquiry">
									{{ csrf_field() }}
									<input type="hidden" value="{{$record->id}}" name="id">
									<input name="note" id="nextt{{ $record->id }}" type="text" class="hidden" value="{{ $record->rec_remarks }}"> 
									<p id="noww{{ $record->id }}">{{$record->rec_remarks}}</p>
								</form>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function edit(arg){
		document.getElementById('now'+arg).className = "hidden";
		document.getElementById('next'+arg).className = "form-control";
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
	        "searching": true,
        	"ordering": true,
        	"info":     true,
	        buttons: [ 
	            {
	                extend: 'excelHtml5',
	                title: 'Sales Report - '+format,
	                className: 'btn btn-md btn-success hidden',
	                text: 'Export To Excel'
	            },
	            {
	            	extend: 'pdf',
	            	title: 'Sales Report - '+format,
	            	className: 'btn btn-md btn-primary hidden',
	            	text: 'Export To PDF' 
	            },            
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
	            {
	                extend: 'excelHtml5',
	                title: 'Sales Report - '+format,
	                className: 'btn btn-md btn-success hidden',
	                text: 'Export To Excel'
	            },
	            {
	            	extend: 'pdf',
	            	title: 'Sales Report - '+format,
	            	className: 'btn btn-md btn-primary hidden',
	            	text: 'Export To PDF' 
	            },            
	        ]
	    } );
	} );
</script>
@endsection