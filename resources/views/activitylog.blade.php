@extends('layouts.app')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">Activities</div>
	<div class="panel-body">
		<table class="table table-hover" id="myTable">
			<thead>
				<th>Date/Time</th>
				<th>User Id</th>
				<th>Activities</th>
			</thead>
			<tbody>
				@foreach($activities as $activity)
				<tr>
					
					<td>{{ date('d-m-Y h:i A', strtotime($activity->created_at)) }}</td>
					<td>{{ $activity->employee_id }}</td>
					<td>{{ $activity->activity }}</td>
				</tr>
				@endforeach
				</tbody>
		</table>
	</div>
</div>
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
	$(document).ready(function() {
		
		$.noConflict();
	    $('#myTable').DataTable( {
	        dom: 'Bfrtip',
	        "paging":   true,
	        "searching": true,
        	"ordering": true,
        	"info":     true,
	        buttons: [ 
	                      
	        ]
	    } );
	} );
</script>
@endsection