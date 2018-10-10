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
					<a href="{{ URL::to('/') }}/inputview" class="btn btn-danger btn-sm pull-left">Add Enquiry</a>
					<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<p class="pull-left" style="padding-left: 50px;" id="display" >
				</p>
					
				Enquiry Data : {{count($enquiries)}}
				 <button type="button" onclick="history.back(-1)" class="bk-btn-triangle pull-right" style="margin-top:-10px;" > <i class="fa fa-arrow-circle-left" style="padding:5px;width:50px;color: black;"></i></button>
				
					
				
			</div>
			<div class="panel-body" style="overflow-x: auto">
			
					
			@if(Auth::user()->group_id == 1)
				<form method="GET" action="{{ URL::to('/') }}/adenquirysheet">
			@elseif(Auth::user()->group_id == 17)
				<form method="GET" action="{{ URL::to('/') }}/scenquirysheet">
			@else
				<form method="GET" action="{{ URL::to('/') }}/tlenquirysheet">
			@endif
					<div class="col-md-12">
							<div class="col-md-2">
								<label>From (Enquiry Date)</label>
								<input value = "{{ isset($_GET['from']) ? $_GET['from']: '' }}" type="date" class="form-control" name="from">
							</div>
							<div class="col-md-2">
								<label>To (Enquiry Date)</label>
								<input  value = "{{ isset($_GET['to']) ? $_GET['to']: '' }}" type="date" class="form-control" name="to">
							</div>
							@if(Auth::user()->group_id != 22)
							<div class="col-md-2">
								<label>Ward</label>
								<select id="myInput" required name="enqward" onchange="this.form.submit()" class="form-control ">
									<option value="">--Select--</option>
									@foreach($wardwise as $wards2)
		                            <option value="{{$wards2->id}}">{{$wards2->ward_name}}</option>
									@endforeach
								</select>
							</div>
							@endif
							<div class="col-md-2">
								<label>Sub Wards</label>
								<select class="form-control" name="ward">
									<option value="">--Select--</option>
									<option value="">All</option>
									@foreach($wards as $ward)
									<option {{ isset($_GET['ward']) ? $_GET['ward'] == $ward->id ? 'selected' : '' : '' }} value="{{ $ward->id }}">{{ $ward->sub_ward_name }}</option>
									@endforeach
								</select>
							</div>
						<div class="col-md-2">
							<label>Initiator</label>
							<select class="form-control" name="initiator">
								<option value="">--Select--</option>
								<option value="">All</option>
								@foreach($initiators as $initiator)
								<option {{ isset($_GET['initiator']) ? $_GET['initiator'] == $initiator->id ? 'selected' : '' : '' }} value="{{ $initiator->id }}">{{ $initiator->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-2">
							<label></label>
							<input type="submit" value="Fetch" class="form-control btn btn-primary">
						</div>
					</div>
				</form>
				
				<br><br><br><br>
				<div class="col-md-3">
					<div class="col-md-2">
						<label>Status: </label>
					</div>
					<div class="col-md-6">
						<select id="myInput" required name="status" onchange="myFunction()" class="form-control input-sm">
							<option value="">--Select--</option>
							<option value="all">All</option>
							<option value="Enquiry On Process">Enquiry On Process</option>
							<option value="Enquiry Confirmed">Enquiry Confirmed</option>
						</select>
					</div>
                  </div>
                  <form method="GET" action="{{ URL::to('/') }}/tlenquirysheet"> 
					
                  <div class="col-md-3">
						<div class="col-md-3">
								<label>Category: </label>
						</div>
						<div class="col-md-6">
								<select id="categ" class="form-control" name="category">
									<option value="">--Select--</option>
									<option value="">All</option>
									@foreach($category as $category)
									<option {{ isset($_GET['category']) ? $_GET['category'] == $category->category_name ? 'selected' : '' : '' }} value="{{ $category->category_name }}">{{ $category->category_name }}</option>
									@endforeach
								</select>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="col-md-3">
							<label> Manufacturer: </label>
						</div>
					
						<div class="col-md-6">
							<select id="categ" class="form-control" name="manu" onchange="this.form.submit()">
									<option value="">--Select--</option>
									<option value="manu">All</option>
									<option value="Enquiry On Process">Enquiry On Process</option>
									<option value="Enquiry Confirmed">Enquiry Confirmed</option>
								</select>
						</div>
					</div>
                </form>
                <br>
				<table id="myTable" class="table table-responsive table-striped table-hover">
					<thead>
						<tr>
							<th style="text-align: center">Project_Id</th>
							<th style="text-align: center">SubWard Name</th>
							<th style="text-align: center">Name</th>
							<th style="text-align: center">Requirement Date</th>
							<th style="text-align: center">Enquiry Date</th>
							<th style="text-align: center">Contact</th>
							<th style="text-align: center">Product</th>
							<th style="text-align: center">Old Quantity</th>
							<th style="text-align: center">Enquiry Quantity</th>
							<th style="text-align: center">Total Quantity</th>
							<th style="text-align: center">Initiator</th>
							<th style="text-align: center">Converted by</th>
							<th style="text-align: center">Last Update</th>
							<th style="text-align: center">Status</th>
							<th style="text-align: center">Remarks</th>
							<th style="text-align: center">Update Status</th>
							<th style="text-align: center">Edit</th>
						</tr>
					</thead>
					<tbody>
						<?php $pro=0; $con=0; $total=0; $sum=0; $sum1=0; $sum2=0; ?>
						@foreach($enquiries as $enquiry)

							@if($enquiry->status == "Enquiry On Process")
							<?php	$pro++; ?>
								<?php $sum = $sum + $enquiry->total_quantity; 
								 ?>
								
							@endif

							@if($enquiry->status == "Enquiry Confirmed")
							<?php	$con++; 
							 ?>

								
									<?php $sum1 = $sum1 + $enquiry->total_quantity; 
									 ?>
								

							@endif

							@if($enquiry->status == "Enquiry Confirmed" || $enquiry->status == "Enquiry On Process")
							<?php  $total++; 
							?>
								
									<?php $sum2 = $sum2 + $enquiry->total_quantity; 
									 ?>
								
							@endif
                        @endforeach
                        
						@foreach($enquiries as $enquiry)
                        @if($enquiry->status != "Not Processed")
					        @if($enquiry->manu_id == NULL)
							<td style="text-align: center">
								<a target="_blank" href="{{URL::to('/')}}/showThisProject?id={{$enquiry -> project_id}}">
									<b>{{$enquiry->project_id }}</b>
								</a> 
							</td>
							@else
							<td style="text-align:center;background-color:rgb(21, 137, 66);color:black;">
								<a target="_blank" href="{{ URL::to('/') }}/updateManufacturerDetails?id={{ $enquiry->manu_id }}">
									<b style="color:white;"> {{$enquiry->manu_id}}</b>
								</a> 
							</td>
							@endif
							<td style="text-align: center">

                               @foreach($wards as $ward)
                                 @if($ward->id ==($enquiry->project != null ? $enquiry->project->sub_ward_id : $enquiry->sub_ward_id) )
                                <a href="{{ URL::to('/')}}/viewsubward?projectid={{$enquiry -> project_id}} && subward={{ $ward->sub_ward_name }}" target="_blank">
                                    {{$ward->sub_ward_name}}</a></td>
                                  @endif
                               @endforeach

							<td style="text-align: center">{{ $enquiry->procurementdetails != null ? $enquiry->procurementdetails->procurement_name :''  }}
                       {{ $enquiry->proc != null ? $enquiry->proc->name :''  }}
							</td>
							<td style="text-align: center">{{$newDate = date('d/m/Y', strtotime($enquiry->requirement_date)) }}</td>
							<td style="text-align: center">{{ date('d/m/Y', strtotime($enquiry->created_at)) }}</td>
							<td style="text-align: center">{{ $enquiry->procurementdetails != null ? $enquiry->procurementdetails->procurement_contact_no : '' }}
							 {{ $enquiry->proc != null ? $enquiry->proc->contact :''  }}</td>
							<td style="text-align: center">{{$enquiry -> main_category}} ({{ $enquiry->sub_category }}), {{ $enquiry->material_spec }} {{ $enquiry->product }} 
							</td>
							<td style="text-align: center">
								<?php $quantity = explode(", ",$enquiry->quantity); ?>
								@for($i = 0; $i<count($quantity); $i++)
								{{ $quantity[$i] }}<br>
								@endfor
							</td>
							<td style="text-align: center">{{ $enquiry->enquiry_quantity }}</td>
							<td style="text-align: center">{{ $enquiry->total_quantity }}</td>
							<td style="text-align: center">{{$enquiry->name}}</td>
							<td style="text-align: center">
							{{ $enquiry->user != null ? $enquiry->user->name : '' }}
							</td>
							<td style="text-align: center">
								{{ date('d/m/Y', strtotime($enquiry->updated_at)) }}
								{{ $enquiry->user != null ? $enquiry->user->name : '' }}
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
								<form method="POST" action="{{ URL::to('/') }}/editEnquiry">
									{{ csrf_field() }}
									<input type="hidden" value="{{$enquiry->id}}" name="eid">
									<input type="hidden" value="{{$enquiry->manu_id}}" name="manu_id">

									
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
					<!--  <tr>
						<td style="text-align    : center"></td>
					        <td style="text-align: center"></td>
					        <td style="text-align: center"></td>
					        <td style="text-align: center"></td>
					        <td style="text-align: center"></td>
					        <td style="text-align: center"></td>
					        <td style="text-align: center">Total</td>
						 	<td style="text-align: center">{{ $totalofenquiry }}</td>
						 	<td style="text-align: center"></td>
					        <td style="text-align: center"></td>
					        <td style="text-align: center"></td>
					        <td style="text-align: center"></td>
					        <td style="text-align: center"></td>
					</tr> -->
					
				</table>
				<!-- <table>
					<tbody>
						<tr>total</tr>
					</tbody>
				</table> -->
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
	    td = tr[i].getElementsByTagName("td")[13];
	    if (td) {
	      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "none";
	      }
	    }
	  }
	}
	if(document.getElementById("myInput").value  == "Enquiry On Process"){
		
		if(document.getElementById("categ").value  != "All"){
		
				document.getElementById("display").innerHTML = "Enquiry On Process  :  {{  $pro }}   /  Quantity On Process : {{ $sum }} "
		 }
	}
	else if(document.getElementById("myInput").value == "Enquiry Confirmed"){
		if(document.getElementById("categ").value  != "All"){
		document.getElementById("display").innerHTML = "Enquiry Confirmed  :  {{  $con }}   /   Quantity On Confirmed : {{ $sum1 }}"
		}
	}
	else {

		if(document.getElementById("categ").value  != "All"){
		document.getElementById("display").innerHTML = "Total Enquiry Count  :  {{  $total }}   /   Total Quantity  :  {{ $sum2 }}  "
		}
	}


	// if(document.getElementById("myInput").value  == "Enquiry On Process"){

	// 	if(document.getElementById("categ").value  == "All Category"){
			
	// 	document.getElementById("display").innerHTML = "Enquiry On Process  :  {{  $pro }}"
	// 	}
	// }
	// else if(document.getElementById("myInput").value == "Enquiry Confirmed"){
		
	// 	if(document.getElementById("categ").value  == "All Category"){
	// 	document.getElementById("display").innerHTML = "Enquiry Confirmed  :  {{  $con }}"
	// 	}
	// }
	// else {
	// 	if(document.getElementById("categ").value  == "All Category"){
	// 	document.getElementById("display").innerHTML = "Total Enquiry Count  :  {{  $total }}"
	// }
	// }
}
</script>
 <script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
     background-color: #00acd6 

});
</script>
@endsection
