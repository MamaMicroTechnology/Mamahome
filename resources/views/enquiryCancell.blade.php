<?php
	$user = Auth::user()->group_id;
	$ext = ($user == 4? "layouts.amheader":"layouts.app");
?>
@extends($ext)

@section('content')
<div class="col-md-12">
		<div class="panel panel-primary" >
			 <div class="panel-heading text-center" ><b>
			 	<p class="pull-left">Total Enquiry Count : {{$cancelcount}}</p>
			 Enquiry Cancelled		 	
			 </b>
                    @if(session('ErrorFile'))
                        <div class="alert-danger pull-right">{{ session('ErrorFile' )}}</div>
                    @endif 
                    <button type="button" onclick="history.back(-1)" class="bk-btn-triangle pull-right" style="margin-top:-10px;" > <i class="fa fa-arrow-circle-left" style="padding:5px;width:50px;color:black;"></i></button>
              </div>
			<div class="panel-body" style="overflow-x:scroll;overflow-y:scroll;height:1000px">

					<table id="myTable" class="table table-responsive table-striped table-hover">
					<thead>
						<tr>
							<th style="text-align: center">Project</th>
							<th style="text-align: center">Subward Number</th>
							<th style="text-align: center">Name</th>
							<th style="text-align: center">Requirement Date</th>
							<th style="text-align: center">Enquiry Date</th>
							<th style="text-align: center">Contact</th>
							<th style="text-align: center">Product</th>
							<th style="text-align: center">Quantity</th>
							<th style="text-align: center">Initiator</th>
							<th style="text-align: center">Status</th>
							<th style="text-align: center">Remarks</th>
							
							<!-- <th style="text-align: center">Edit</th> -->
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
							<td style="text-align: center">
							<a  href="{{ URL::to('/')}}/viewsubward?projectid={{$enquiry -> project_id }} && subward={{$subwards2[$enquiry->project_id]}}" data-toggle="tooltip" data-placement="top" title="click here to view map" class="red-tooltip" target="_blank">{{$subwards2[$enquiry->project_id]}}
                                    </a></td>
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
							
							<!-- <td>
								<a href="{{ URL::to('/') }}/editenq?reqId={{ $enquiry->id }}" class="btn btn-xs btn-primary">Edit</a>
							</td> -->
						</tr>
						
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
     background-color: #00acd6 

});

</script>
@endsection
