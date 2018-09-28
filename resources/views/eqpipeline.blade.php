<?php
	$extender = Auth::user()->department_id == 1 ? 'layouts.leheader':'layouts.app';
?>
@extends($extender)
@section('content')

<div class="">
<div class="col-md-1"></div>
	<div class="col-md-12">
		<div class="panel panel-defalut" style="border-color:rgb(244, 129, 31); ">
			<div class="panel-heading text-center" style="background-color: rgb(244, 129, 31);color:white">
				Enquiries
					<a href="{{ URL::to('/') }}/eqpipeline?eqpipeline=today" class="btn btn-success btn-sm pull-right" >Today's Enquiry</a>
			</div>
				<div class="panel-body" style="overflow-x: auto">
				<div class="col-md-12">
				<div class="col-md-2">
					
						<label>Status:</label>
					
							<select id="myInput" required name="status" onchange="myFunction()" class="form-control input-sm">
								<option value="">--Select--</option>
								<option value="all">All</option>
								<option value="Enquiry On Process">Enquiry On Process</option>
								<option value="Enquiry Confirmed">Enquiry Confirmed</option>
							</select>
						
				</div>
				<form  method="GET"  action="{{ URL::to('/') }}/eqpipe">
				<div class="col-md-2">
					
					<label>Category:</label>
							<select class="form-control" name="category">
								<option value="">--Select--</option>
								<option value="">All</option>
								@foreach($category as $category)
								<option {{ isset($_GET['category']) ? $_GET['category'] == $category->category_name ? 'selected' : '' : '' }} value="{{ $category->category_name }}">{{ $category->category_name }}</option>
								@endforeach
							</select>
				
				</div>
				<div class="col-md-2">
						<label></label>
						<input type="submit" value="Fetch" class="form-control btn btn-success">
				</div>
				</form>
				<div class="col-md-4 pull-right">
								<label></label>
								<div class="input-group">
									<input oninput="searchphone()" id="searchphone" type="text" name="phNo" class="form-control" placeholder="Phone number search">
									<div class="input-group-btn">
										<input type="submit" class="form-control" value="Search">
									</div>
								</div>
				</div>
				</div>
					<table border="1" id="myTable" class="table table-responsive table-striped table-hover">
						<thead>
							<tr>
							
							</tr>
							<br><br><br><br>
							<tr>
								
								<th style="text-align: center">SubWard Number</th>
								<th style="text-align: center">Name</th>
								<th style="text-align: center">Action</th>
								<th style="text-align: center">Enquiry Date</th>
								<th style="text-align: center">Contact</th>
								<th style="text-align: center">Product</th>
								<th style="text-align: center">Quantity</th>
								<th style="text-align: center">Status</th>
								<th style="text-align: center">Remarks</th>
								<th style="text-align: center">Last Updated Time</th>
								<th style="text-align: center">Update Status</th>
								
								<th style="text-align: center">Requirement Date</th>
							</tr>
						</thead>
						<tbody>
							@foreach($pipelines as $enquiry)
							<tr>	
								 @if($enquiry->manu_id == null)
								<td style="text-align: center">
									{{$subwards2[$enquiry->project_id]}}
								</td>
								@else
								<td style="text-align: center">
									@foreach($sub as $su)
									@if($enquiry->sub_ward_id ==$su->id)
									<a href="{{ URL::to('/')}}/viewsubward?projectid={{$enquiry->project_id}} && subward={{$su->sub_ward_name}}" data-toggle="tooltip" data-placement="top" title="click here to view map" class="red-tooltip" target="_blank">{{$su->sub_ward_name}}
                                    </a>
									@endif
									@endforeach
								</td>
								@endif
								@if($enquiry->manu_id == null)
								<td style="text-align: center">
									{{$enquiry -> procurement_name}}
								</td>
								@else
								<td style="text-align: center">
									@foreach($manu as $man)
									@if($enquiry->manu_id == $man->id)
									{{$man->name}}
									@endif
									@endforeach
								</td>
								@endif
								@if($enquiry->manu_id == null)

								<td style="text-align: center" >
								<a href="{{ URL::to('/') }}/editenq1?reqId={{ $enquiry->id }}" class="btn btn-success btn-sm pull-right">Edit</a>
								</td>
								@else
								<td style="text-align: center" >
								<a href="{{ URL::to('/') }}/menqedit?reqId={{$enquiry->id}}" class="btn btn-primary btn-sm pull-right">Edit</a>
								</td>
								@endif
								
								<td style="text-align: center">
									{{ date('d/m/Y', strtotime($enquiry->created_at)) }}
								</td>
								@if($enquiry->manu_id == null)
								<td style="text-align: center">
									{{$enquiry -> procurement_contact_no }}
								</td>
								@else
								<td style="text-align: center">
									@foreach($manu as $man)
									@if($enquiry->manu_id == $man->id)
									{{$man->contact_no}}
									@endif
									@endforeach
								</td>
								@endif
                               @if($enquiry->manu_id == null)
								<td style="text-align: center">
									{{$enquiry -> main_category}} ({{ $enquiry->sub_category }}), {{ $enquiry->material_spec }}
								</td>
								@else
								<td style="text-align: center">
									{{$enquiry->product}}
								</td>
								@endif
								<td style="text-align: center">
									{{$enquiry -> quantity}}
								</td>
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
									{{ date('d-m-Y H:i A', strtotime("$enquiry->updated_at"))}}
									
								</td>
								<td>
									<form method="POST" action="{{ URL::to('/') }}/manueditEnquiry">
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
								<td style="text-align: center">
									{{$newDate = date('d/m/Y ', strtotime($enquiry->requirement_date)) }}
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
		document.getElementById('next'+arg).className = "";
		document.getElementById('next'+arg).focus();
	}
	function editm(arg){
		document.getElementById('noww'+arg).className = "hidden";
		document.getElementById('nextt'+arg).className = "form-control";
	}
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
	    td = tr[i].getElementsByTagName("td")[7];
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
function searchphone(){
	var input, filter, table, tr, td, i;
  input = document.getElementById("searchphone");
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
	    td = tr[i].getElementsByTagName("td")[4];
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
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
     background-color: #00acd6 

});

</script>
@endsection
