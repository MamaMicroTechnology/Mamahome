@extends('layouts.app')

@section('content')

<div class="col-md-12 col-sm-12">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-primary">
			<div class="panel-heading text-center">
				Enquiry Data
			</div>
			<div class="panel-body" style="overflow-x: auto">
				<table class="table table-responsive table-striped table-hover">
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
								<a href="{{URL::to('/')}}/showThisProject?id={{$enquiry -> rec_project}}">
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
							<td style="text-align: center">{{$enquiry->notes}}</td>
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


<div class="col-md-12 col-sm-12">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-primary">
			<div class="panel-heading text-center">
				Enquiry Data (Manual entry)
			</div>
			<div class="panel-body" style="overflow-x: auto">
				<table class="table table-responsive table-striped table-hover">
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
							<td style="text-align: center">{{$record->rec_remarks}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection