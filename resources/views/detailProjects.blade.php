@extends('layouts.app')
@section('content')
<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-primary">
		<div class="panel-heading text-center">MATERIAL ESTIMATION  
			<a class="pull-right btn btn-sm btn-danger" href="{{url()->previous()}}">Back</a>
		</div>
		<div class="panel-body">
			
			<table class="table table-responsive" border="1">
						{!! $table !!}
			</table>
		</div>
	</div>
</div>
<div class="col-md-8 col-md-offset-2">
	
</div>

@endsection