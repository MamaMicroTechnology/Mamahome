@extends('layouts.sales')
@section('content')
	<div class="col-md-12">
		<div class="panel panel-danger">
			<div class="panel-heading">Orders Pipelined</div>
			<div class="panel-body">
				<table class="table table-responsive">
					<thead>
						<th>Project Id</th>
						<th>Main Category</th>
						<th>Sub Category</th>
						<th>Material Specification</th>
						<th>Requirement Date</th>
						<th>Measurement Unit</th>
						<th>Unit Price</th>
						<th>Quantity</th>
					</thead>
					<tbody>
						@foreach($pipelines as $pipeline)
						<tr>
							<td>{{ $pipeline->project_id }}</td>
							<td>{{ $pipeline->main_category }}</td>
							<td>{{ $pipeline->sub_category }}</td>
							<td>{{ $pipeline->material_spec }}</td>
							<td>{{ $pipeline->requirement_date }}</td>
							<td>{{ $pipeline->measurement_unit }}</td>
							<td>{{ $pipeline->unit_price }}</td>
							<td>{{ $pipeline->quantity }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection