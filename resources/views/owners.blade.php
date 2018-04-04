@extends('layouts.app')
@section('content')
<table id="attendance" class="table table-hover">
	<thead>
		<th>Name</th>
		<th>Contact</th>
		<th>Email</th>
		<th>Address</th>
		<th>Budget</th>
		<th>Size</th>
		<th>Status</th>
		<th>Quality</th>
		<th>Action</th>
	</thead>
	<tbody id="details">
		@foreach($projects as $project)
		<tr>
			<td>{{$project->ownerdetails->owner_name}}</td>
				<td>{{$project->ownerdetails->owner_contact_no}}</td>
				<td>{{$project->ownerdetails->owner_email}}</td>
				<td>{{$project->siteaddress->address}}</td>
				<td>{{$project->budget }}Cr.</td>
				<td>{{$project->project_size}} Sqm</td>
				<td>{{$project->project_status}}</td>
				<td>{{$project->quality}}</td>
				<td>
					<a target='_blank' href="{{ URL::to('/') }}/ameditProject?projectId={{$project->project_id}}" class='btn btn-primary btn-sm'>Edit</a>
				</td>
			</tr>
			@endforeach
	</tbody>
</table>
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
		var today = new Date();
		var dd = today.getDate(); //Get day
		var mm = today.getMonth()+1; //January is 0!

		var yyyy = today.getFullYear();
		if(dd<10){
		    dd='0'+dd;
		} 
		if(mm<10){
		    mm='0'+mm;
		} 
		var format = "09" + "-" + "2018";
		$.noConflict();
	    $('#attendance').DataTable( {
	        dom: 'Bfrtip',
	        "paging":   false,
	        "searching": true,
        	"ordering": true,
        	"info":     false,
	        buttons: [ 
	            {
	                extend: 'excelHtml5',
	                title: 'Employee Attendance - '+format,
	                className: 'btn btn-xs btn-success',
	                text: 'Export To Excel'
	            },
	            // {
	            // 	extend: 'pdf',
	            // 	title: 'Employee Attendance - '+format,
	            // 	className: 'btn btn-md btn-primary',
	            // 	text: 'Export To PDF' 
	            // },            
	        ]
	    } );
	} );
</script>
@endsection