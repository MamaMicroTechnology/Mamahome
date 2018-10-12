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
			<table  class="{{ $projects[0]['detailed_mcal'] != null ? 'hidden' : 'table table-responsive' }}" >
			<tr>
				
				@if(isset($_GET['id']))
				<td style="text-align: center;">Do You Require Detail Material Calculation?</td>
					<td >
					<a href="{{URL::to('/')}}/storedetails?value=yes&&id={{ $_GET['id'] }}" type="button" class=" btn btn-sm btn-success" >Yes</a>
					<a href="{{URL::to('/')}}/storedetails?value=no&&id={{ $_GET['id'] }}"  onclick="show()" class=" btn btn-sm btn-danger " href="{{url()->previous()}}" >No</a>
				</td>
				@endif
			</tr>
			</table>
</div>
			
		</div>
	</div>
</div>
<div class="col-md-8 col-md-offset-2">
	
</div>
<!-- <script type="text/javascript">
 function checkthisyes(){
 	alert(" MAMAHOME Executive Will Contact You Shortly")
	}
	function checkthisno(){
 	alert(" Thank You :)")
	}
</script> -->
@if(session('success'))
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #c9ced6;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Success</h4>
        </div>
        <div class="modal-body">
          <p style="text-align:center;">{!! session('success') !!}</p>
        </div>
        <div class="modal-footer">
          <button type="button" required id="hide" style="background-color: #c9ced6;" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
  $(document).ready(function(){
      $("#myModal").modal('show');
  });
</script>

@endif
@endsection

