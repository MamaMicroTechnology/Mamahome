@extends('layouts.amheader')

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
							<th style="text-align: center">Location</th>
							<th style="text-align: center">Quantity</th>
						</tr>
					</thead>
					<tbody>
						@foreach($records as $record)
						<tr>
							<td style="text-align: center">
								<a href="{{URL::to('/')}}/showThisProject?id={{$record -> rec_project}}">
									<b style="color:red">{{$record -> project_name}} ({{$record -> road_name}})</b>
								</a> 
							</td>
							<td style="text-align: center">{{$record -> rec_name}}</td>
							<td style="text-align: center">{{$newDate = date('d/m/Y', strtotime($record->rec_date)) }}</td>
							<td style="text-align: center">{{$record -> rec_contact}}</td>
							<td style="text-align: center">{{$record -> rec_email}}</td>
							<td style="text-align: center">{{$record -> rec_product}}</td>
							<td style="text-align: center">{{$record -> rec_location}}</td>
							<td style="text-align: center">{{$record -> rec_quantity}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection