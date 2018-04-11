<?php
	$user = Auth::user()->group_id;
	$ext = ($user == 4? "layouts.amheader":"layouts.app");
?>
@extends($ext)

@section('content')

<div class="">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading text-center">
				<form method="GET" action="{{ URL::to('/') }}/enquirysheet">
					<a href="{{ URL::to('/') }}/inputview" class="btn btn-danger btn-sm pull-left">Add Enquiry</a>
					
				</form>
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
									<option value="">All</option>
									@foreach($wards as $ward)
									<option value="{{ $ward->id }}">{{ $ward->sub_ward_name }}</option>
									@endforeach
								</select>
							</div>
						<div class="col-md-2">
							<label>Initiator</label>
							<select class="form-control" name="initiator">
								<option value="">--Select--</option>
								<option value="">All</option>
								@foreach($initiators as $initiator)
								<option value="{{ $initiator->id }}">{{ $initiator->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-2">
							<label>Category:</label>
							<select class="form-control" name="category">
								<option value="">--Select--</option>
								<option value="">All</option>
								@foreach($category as $category)
								<option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
								@endforeach
							</select>
						</div>
<!-- 						<div class="col-md-4">
							<label>Status:</label>
							<select name="status" class="form-control">
								<option value="">--Select--</option>
								<option value="all">All</option>
								<option value="Process">On Process</option>
								<option value="Confirmed">Enquiry Confirmed</option>
								<option value="Cancelled">Enquiry Cancelled</option>
							</select>
						</div> -->
						<!-- </div> -->
						<div class="col-md-2">
							<label></label>
							<input type="submit" value="Fetch" class="form-control btn btn-primary">
						</div>
					</div>
				</form>
				
				<br><br><br><br>
				<div class="col-md-6">
					<div class="col-md-2">
						Status:
					</div>
					<div class="col-md-4">
						<select id="myInput" required name="status" onchange="myFunction()" class="form-control input-sm">
							<option value="">--Select--</option>
							<option value="all">All</option>
							<option value="Enquiry On Process">Enquiry On Process</option>
							<option value="Enquiry Confirmed">Enquiry Confirmed</option>
						</select>
					</div>
				</div>
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
							<th style="text-align: center">Edit</th>
						</tr>
					</thead>
					<tbody>
						@foreach($enquiries as $enquiry)
						@if($enquiry->status != "Not Processed")
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
								{{ $enquiry->status}}
							</td>
							<td style="text-align: center" onclick="edit('{{ $enquiry->id }}')" id="{{ $enquiry->id }}">
								<form method="POST" action="{{ URL::to('/') }}/editEnquiry">
									{{ csrf_field() }}
									<input type="hidden" value="{{$enquiry->id}}" name="id">
									<input onblur="this.className='hidden'; document.getElementById('now{{ $enquiry->id }}').className='';" name="note" id="next{{ $enquiry->id }}" type="text" size="35" class="hidden" value="{{ $enquiry->notes }}"> 
									<p id="now{{ $enquiry->id }}">{{$enquiry->notes}}</p>
								</form>
							</td>
							<td>
								<form method="POST" action="{{ URL::to('/') }}/editEnquiry">
									{{ csrf_field() }}
									<input type="hidden" value="{{$enquiry->id}}" name="id">
									<select required name="status" onchange="this.form.submit();" style="width:100px;">
										<option value="">--Select--</option>
										<option>Enquiry On Process</option>
										<option>Enquiry Confirmed</option>
										<option>Enquiry Cancelled</option>
									</select>
								</form>
							</td>
							<td>
								<a href="{{ URL::to('/') }}/editenq?reqId={{ $enquiry->id }}" class="btn btn-xs btn-primary">Edit</a>
							</td>
						</tr>
						@endif
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
	        "paging":   false,
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
	        "paging":   false,
	        "searching": false,
        	"ordering": true,
        	"info":     true,
	        buttons: [ 
	                   
	        ]
	    } );
	} );
</script>
<script type="text/javascript">
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  // Loop through all table rows, and hide those who don't match the search query
  
  if(filter == "ALL"){
  	for (i = 0; i < tr.length; i++) {
        tr[i].style.display = "";
	  }
	}else{
		for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName("td")[9];
	    if (td) {
	      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "none";
	      }
	    }
	  }
	}
}
</script>
@endsection