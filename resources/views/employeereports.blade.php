

@extends('layouts.app')
@section('content')
<?php
	if(isset($_GET['month']) && isset($_GET['year'])){
		$month = $_GET['month'];
		$year = $_GET['year'];
	}else{
		$month = date('m');
		$year = date('Y');
	}
	$thismonth = date('m');
	$prevMonth = ($month == 1 ? '12' : $month - 1);
	$nextMonth = ($month == 12 ? '1' : $month + 1);
	$prevYear = ($month == 1 ? $year - 1: $year);
	$nextYear = ($month == 12 ? $year + 1: $year);
	$ofdays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
	switch ($month) {
		case '1':
			$current = "January";
			break;
		case '2':
			$current = "February";
			break;
		case '3':
			$current = "March";
			break;
		case '4':
			$current = "April";
			break;
		case '5':
			$current = "May";
			break;
		case '6':
			$current = "June";
			break;
		case '7':
			$current = "July";
			break;
		case '8':
			$current = "August";
			break;
		case '9':
			$current = "September";
			break;
		case '10':
			$current = "October";
			break;
		case '11':
			$current = "November";
			break;
		case '12':
			$current = "December";
			break;
		
		default:
			# code...
			break;
	}
?>
<div class="col-md-12" style="font-size: 11px;">
	<div class="panel panel-default" style="border-color:rgb(244, 129, 31);">
		<div class="panel-heading" style="background-color: rgb(244, 129, 31);color:white;">Employee Attendance for the month of <?php print($current." ".$year); ?>
			<div class="pull-right btn-group">
				@if(Auth::user()->group_id == 1)
				<a href="{{ URL::to('/') }}/employeereports?month={{ $prevMonth }}&year={{ $prevYear }}" class="btn btn-default btn-sm">
					previous</a>
				<a href="{{ URL::to('/') }}/employeereports" class="btn btn-default btn-sm">
					<span class="glyphicon glyphicon-refresh"></span></a>
				</a>
				<a href="{{ URL::to('/') }}/employeereports?month={{ $nextMonth }}&year={{ $nextYear }}" class="btn btn-default btn-sm {{ $month == $thismonth ? 'disabled' : ''}}">
					next</a>
				</a>
				@else
					<a href="{{ URL::to('/') }}/amviewattendance?month={{ $prevMonth }}&year={{ $prevYear }}" class="btn btn-default btn-sm">
					previous</span></a>
					<a href="{{ URL::to('/') }}/amviewattendance" class="btn btn-default btn-sm">
						<span class="glyphicon glyphicon-refresh"></span></a>
					</a>
					<a href="{{ URL::to('/') }}/amviewattendance?month={{ $nextMonth }}&year={{ $nextYear }}" class="btn btn-default btn-sm {{ $month == $thismonth ? 'disabled' : ''}}">
						next</span></a>
					</a>
				@endif
			</div>
			<br><small><i>'Total' column at the end represents the total no. of working days by the individual employee</i></small>
		</div>
		<div class="panel-body" style="overflow-x: scroll;">
			<table id="attendance" class="table table-hover">
				<thead id="head">
					<th>Id</th>
					<th>Name</th>
					<?php
						for($i = 1;$i<=$ofdays;$i++){
							if($i < 10){
			                    $date = "0".$i."-".$month."-".$year;
			                    $nameofday = date("l", mktime(0,0,0,$month,$i,$year));
			                }else{
			                    $date = $i."-".$month."-".$year;
			                    $nameofday = date("l", mktime(0,0,0,$month,$i,$year));
			                }
			                print("<th>".$date."<br>(".$nameofday.")</th>");
						}
					?>
					<th>Total</th>
				</thead>
				<tbody>
					{!! $text !!}
				</tbody>
			</table>
		</div>
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
		var format = "{{ $month }}" + "-" + "{{ $year }}";
		$.noConflict();
	    $('#attendance').DataTable( {
	        dom: 'Bfrtip',
	        "paging":   false,
	        "searching": true,
        	"ordering": true,
        	"info":     false,
	        buttons: [ 
	            // {
	            //     extend: 'excelHtml5',
	            //     title: 'Employee Attendance - '+format,
	            //     className: 'btn btn-xs btn-success',
	            //     text: 'Export To Excel'
	            // },
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