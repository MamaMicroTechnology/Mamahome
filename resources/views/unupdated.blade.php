@extends('layouts.app')
@section('content')
<div class="container">
<div class="col-md-12">
    <div class="panel panel-default" style="border-color:green;"> 
                <div class="panel-heading" style="background-color: green;color:white;">  Projects To Be Updated
                @if($total != 0)
                 From <span>&nbsp;&nbsp;&nbsp;</span> <b style="color:white;">{{ date('d-m-Y', strtotime($from)) }}</b> &nbsp;&nbsp; To  &nbsp;&nbsp; <b style="color: white;">{{ date('d-m-Y', strtotime($to)) }}</b> : {{ $total }} 
                	
                @endif

                    @if(session('ErrorFile'))
                        <div class="alert-danger pull-right">{{ session('ErrorFile' )}}</div>
                    @endif 
                </div>
                <div class="panel-body">
               	    <div class="col-md-12">
               	    <form method="GET" action="{{ URL::to('/') }}/Unupdated">
               	    	 {{csrf_field()}}
               	    	 	<div class="col-md-2">
								<label>Choose Ward :</label><br>
					                <select name="ward" class="form-control" id="ward" onchange="loadsubwards()">
					                    <option value="">--Select--</option>
					                    @foreach($wards as $ward)
					                    <option value="{{ $ward->id }}">{{ $ward->ward_name }}</option>
					                    @endforeach
					                </select>
							</div>
							<div class="col-md-2">
								<label>Choose Subward :</label><br>
					                <select name="subward" class="form-control" id="subward">
					                </select>
							</div>
                			<div class="col-md-2">
								<label>From Date</label>
								<input value = "{{ isset($_GET['from'])  }}" type="date" class="form-control" name="from">
							</div>
							<div class="col-md-2">
								<label>To Date</label>
								<input  value = "{{ isset($_GET['to']) ? $_GET['to']: '' }}" type="date" class="form-control" name="to">
							</div>
							<div class="col-md-2">
								<label></label>
								<input type="submit" value="Fetch" class="form-control btn btn-primary">
							</div>
					</form>
					</div>
				
					<table class="table table-hover">
					<thead>
						<th>Project Id</th>
						<th>Project Name</th>
						
						<th>Project Status</th>
						<th>Quality</th>
						<th>Address</th>
						<th>Update </th>
						<th>Remarks</th>
					</thead>
					@if($project != null)
					@foreach($project as $projects)
					<tbody>
						<td>{{ $projects->project_id }}</td>
						<td>{{ $projects->project_name }}</td>
						
						<td>{{ $projects->project_status }}</td>
						<td>{{ $projects->quality }}</td>
						<td>
						@foreach($site as $sites)
							@if($sites->project_id == $projects->project_id)
							<a href="#" >{{ $sites->address }}</a>
							@endif
							@endforeach
						</td>
						<td style="width:30%;">{{ date('d-m-Y', strtotime($projects->updated_at)) }}</td>
						<td>{{ $projects->remarks }}</td>
					</tbody>
					@endforeach
					@endif
                {{$projects->links()}}
					</table>
                </div>
             
               
    </div>
   </div>
</div>
<script type="text/javascript">
    function loadsubwards()
    {
        var x = document.getElementById('ward');
        var sel = x.options[x.selectedIndex].value;
        if(sel)
        {
            $.ajax({
                type: "GET",
                url: "{{URL::to('/')}}/loadsubwards",
                data: { ward_id: sel },
                async: false,
                success: function(response)
                {
                    if(response == 'No Sub Wards Found !!!')
                    {
                        document.getElementById('error').innerHTML = '<h4>No Sub Wards Found !!!</h4>';
                        document.getElementById('error').style,display = 'initial';
                    }
                    else
                    {
                        var html = "<option value='' disabled selected>---Select---</option>";
                        for(var i=0; i< response.length; i++)
                        {
                            html += "<option value='"+response[i].id+"'>"+response[i].sub_ward_name+"</option>";
                        }
                        document.getElementById('subward').innerHTML = html;
                    }
                    
                }
            });
        }
    }
</script>
@endsection

