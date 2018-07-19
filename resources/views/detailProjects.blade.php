@extends('layouts.app')
@section('content')
<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-primary">
		<div class="panel-heading text-center">APPROXIMATE MATERIAL ESTIMATION
		<a class="pull-right btn btn-sm btn-danger" href="{{url()->previous()}}">Back</a>	
		</div>
		<div class="panel-body">
			
			<table class="table table-responsive" border="1">
						{!! $table !!}
			</table>
			<table class="table table-responsive" >
			<tr>
					<td style="text-align: center;">Do You Require Detail Material Calculation?</td>
					<td >
					<a href="#" class="btn btn-sm btn-success ">Yes</a>
					<a class=" btn btn-sm btn-danger " href="{{url()->previous()}}">NO</a>
				</td>
			</tr>
			</table>
			
		</div>
	</div>
</div>
<div class="col-md-8 col-md-offset-2">
	
</div>

@endsection

