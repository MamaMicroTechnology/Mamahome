@extends('layouts.sales')
@section('content')

<div class="">
<div class="col-md-1"></div>
	<div class="col-md-10">
		<div class="panel panel-primary">
			<div class="panel-heading text-center">
				Enquiry Data (Generated By You)
			
					<!-- <a href="{{ URL::to('/') }}/eqpipeline?eqpipeline={{ $todays }}&today=today" class="btn btn-success pull-right" >Today's Enquiry</a> -->
				
				
			</div>
			</div>
			
			<div class="panel-body" style="overflow-x: auto">
				<table border="1" id="myTable" class="table table-responsive table-striped table-hover">
					<thead>
						<tr>
							
							<th style="text-align: center">Ward Name</th>
							<th style="text-align: center">Name</th>
							<th style="text-align: center">Requirement Date</th>
							<th style="text-align: center">Enquiry Date</th>
							<th style="text-align: center">Contact</th>
							<th style="text-align: center">Product</th>
							<th style="text-align: center">Quantity</th>
							<th style="text-align: center">Status</th>
							<th style="text-align: center">Remarks</th>
							<th style="text-align: center">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($pipelines as $enquiry)
						<tr>
							
							<td style="text-align: center">
								{{$subwards2[$enquiry->project_id]}}
							</td>
							<td style="text-align: center">
								{{$enquiry -> procurement_name}}
							</td>
							<td style="text-align: center">
								{{$newDate = date('d/m/Y', strtotime($enquiry->requirement_date)) }}
							</td>
							<td style="text-align: center">
								{{ date('d/m/Y', strtotime($enquiry->created_at)) }}
							</td>
							<td style="text-align: center">
								{{$enquiry -> procurement_contact_no }}
							</td>
							<td style="text-align: center">
								{{$enquiry -> main_category}} ({{ $enquiry->sub_category }}), {{ $enquiry->material_spec }}
							</td>
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
							<td style="text-align: center" >
								<a href="{{ URL::to('/') }}/editenq1?reqId={{ $enquiry->id }}" class="btn btn-warning btn-sm pull-right">Edit</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="panel-footer">
				{{ $pipelines->links() }}
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
@endsection
