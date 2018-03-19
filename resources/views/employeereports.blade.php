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
?>
<div class="col-md-10 col-md-offset-1">
	<div class="panel panel-default">
		<div class="panel-heading">Employee List</div>
		<div class="panel-body" style="overflow-x: scroll;">
			<table class="table table-hover">
				<thead id="head">
					<th>Employee Id</th>
					<th>Name</th>
				</thead>
				<tbody>
					{!! $text !!}
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	(function()
	{
		var iMonth = '{{ $month }}';
		var iYear = '{{ $year }}';
		var no = 32 - new Date(iYear, iMonth, 32).getDate();
		var text = "<th>Employee Id</th><th>Name</th>";
		for(var i = 1; i <= no; i++){
			text += "<th>"+i+"-"+iMonth+"-"+iYear+"</th>";
		}
		document.getElementById('head').innerHTML = text;
	})();
</script>
@endsection