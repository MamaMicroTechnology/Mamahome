@extends('layouts.amheader')

@section('content')
<div class="col-md-12">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default" style="border-color:green" id='inputpanel'>
			<div class="panel-heading text-center" style="background-color: green">
				<b style="font-size: 1.4em;color:white">Sales Report</b>
				@if(session('error'))
                        <div class="alert-danger pull-right">{{ session('error')}}</div>
                @endif
			</div>
			<div class="panel-body">
				<form method="POST" action="{{URL::to('/')}}/getSalesReport">
					{{csrf_field()}}
					<table class="table table-responsive table-striped">
						<tbody style="border-top-style:hidden">
							<tr>
								<td style="text-align: center"><label>Listing Engineers</label></td>
								<td style="text-align: center">
									<select name="listengs" class="form-control">
										<option value='' disabled selected>--- SELECT ---</option>
										<option value="All">All Listing Engineers</option>
										@foreach($users as $user)
											<option value="{{$user->id}}" @if(isset($le)) {{$user->id == $le?'selected':''}} @endif>{{$user->name}}</option>
										@endforeach
									</select>
								</td>
								<td style="text-align: center">
									<label>From Date : </label>
								</td>
								<td>
									<center><input style="width:80%" type="date" class ="form-control" name="fromdate" id='fromdate' @if(isset($fromdate)) value="{{date('Y-m-d', strtotime($fromdate))}}" @endif /></center>
								</td>
								<td style="text-align: center">
									<label>To Date : </label>
								</td>
								<td style="text-align: center">
									<center><input type="date" style="width:80%" class="form-control" name="todate" id='todate' @if(isset($todate)) value="{{date('Y-m-d', strtotime($todate))}}" @endif /></center>
								</td>
								<td style="text-align:center">
									<center><input value="Submit" type="submit" name="submit" style="width:100%" id='submit' class="btn btn-md btn-success"></center>
								</td>
							</tr>
						</tbody>
					</table>
				</form>		
			</div>
		</div>
		
		<hr>
		@if(isset($totallistings))
		<div class="col-md-12">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default" style="border-color:#f68121">
					<div class="panel-heading text-center" style="background-color:#f68121;color:white;font-size:1.3em">
						<b>Report of {{$le == 'ALL'?$username->name:'All Listing Enineers'}} For The Date : {{date('d-m-Y', strtotime($fromdate))}} To Date : {{date('d-m-Y', strtotime($todate))}}</b>
					</div>
					<div class="panel-body">
						<table class="table table-responsive table-striped" id='myTable'>
							<thead>
								<tr>
									<th><center>LE Name</center></th>
									<th><center>Total Projects Listed</center></th>
									<th><center>Confirmed Orders</center></th>
									<th><center>Initiated Orders</center></th>
								</tr>
							</thead>
							<tbody>
								@if($le == 'All')
								@foreach($users as $user)
									<tr>
										<td>
											<center>{{ $user->name }}</center>
										</td>
										<td>
											<center>{{$totalcount[$user->id]}}</center>
										</td>
										<td>
											<center>{{$confirmcount[$user->id]}}</center>
										</td>
										<td>
											<center>{{$initiatedcount[$user->id]}}</center>
										</td>
									</tr>
								@endforeach
								@else
									<tr>
										<td>
											<center>{{$username->name}}</center>
										</td>
										<td>
											<center>{{$totalcount[$le]}}</center>
										</td>
										<td>
											<center>{{$confirmcount[$le]}}</center>
										</td>
										<td>
											<center>{{$initiatedcount[$le]}}</center>
										</td>
									</tr>
								@endif

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>	
		@endif
		
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
		var format = dd+'-'+mm+'-'+yyyy;
		$.noConflict();
	    $('#myTable').DataTable( {
	        dom: 'Bfrtip',
	        "paging":   false,
	        "searching": false,
        	"ordering": false,
        	"info":     false,
	        buttons: [ 
	            // {
	            //     extend: 'excelHtml5',
	            //     title: 'Sales Report - '+format,
	            //     className: 'btn btn-md btn-success',
	            //     text: 'Export To Excel'
	            // },
	            // {
	            // 	extend: 'pdf',
	            // 	title: 'Sales Report - '+format,
	            // 	className: 'btn btn-md btn-primary',
	            // 	text: 'Export To PDF' 
	            // },            
	        ]
	    } );
	} );
</script>
@endsection