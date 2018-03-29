@extends('layouts.app')

@section('content')

<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-warning">
		<div class="panel-heading">Search for contractor (Based on phone no.)</div>
		<div class="panel-body">
			<div class="input-group">
				<input type="text" name="phone" id="phone" class="form-control" placeholder="Enter Contractor Phone Number">
				<div class="input-group-btn">
					<button type="button" class="btn btn-primary" onclick="contractors()">Search</button>
				</div>
			</div>
			<table id="condetails" class="table table-hover">
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
				<tbody id="details"></tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
function contractors(){
    var e = document.getElementById('phone').value;
    $.ajax({
        type:'GET',
        url:"{{URL::to('/')}}/getContractorProjects",
        async:false,
        data:{phone : e},
        success: function(response)
        {
            console.log(response);
            document.getElementById('details').innerHTML = response;
        }
    });
}
</script>
@endsection