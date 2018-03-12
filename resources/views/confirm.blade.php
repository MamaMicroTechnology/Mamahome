@extends('layouts.app')

@section('content')

<div class="col-md-4 col-md-offset-4">
	<div class="panel panel-default">
		<div class="panel-heading">Order details</div>
		<div class="panel-body">
			<form method="get" action="{{ URL::to('/') }}/{{ $orders->project_id }}/confirmOrder">
				{{ csrf_field() }}
				<table class="table">
					<tr>
						<td>Email</td>
						<td>:</td>
						<td><input type="email" name="email" class="form-control input-sm" placeholder="Owner Email" required></td>
					</tr>
					<tr>
						<td>Phone Number</td>
						<td>:</td>
						<td><input type="number" name="phno" class="form-control input-sm" placeholder="Owner Phone Number" required></td>
					</tr>
				</table>
			<table class="table table-hover">
				<th>Item</th>
				<th>Price</th>
				<th>Qnty.</th>
				<th>Total</th>
				<p class="hidden">{{ $total = 0}}</p>
				<tbody>
					<tr>
						<td>{{ $orders->main_category }} 
							@if($orders->sub_category != NULL)
								{{ $orders->sub_category }}
							@endif
						</td>
						<td>{{ $orders->unit_price }}</td>
						<td>{{ $orders->quantity }}</td>
						<td>{{ $orders->total }}</td>
					</tr>
					<p class="hidden">{{ $total = $total + $orders->total }}</p>
				</tbody>
			</table>
			<table class="table table-hover">
				<th>Grand Total</th>
				<th>{{ $total }}</th>
			</table>
			<button type="submit" class="btn btn-sm btn-primary form-control">Confirm Order</button>
			</form>
	</div>
</div>

@endsection