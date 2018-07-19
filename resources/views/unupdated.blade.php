@extends('layouts.app')
@section('content')
<div class="container">
<div class="col-md-12">
    <div class="panel panel-default" style="border-color:green;"> 
                <div class="panel-heading text-center" style="background-color: green;color:white;"><b class="pull-left">Projects To Be Updated
                @if($totalproject != 0)
                 From <span>&nbsp;&nbsp;&nbsp;</span><b style="color: white;">{{ date('d-m-Y', strtotime($previous)) }} To {{ date('d-m-Y', strtotime($today)) }}</b> </b>

               <b>Count : {{ $totalproject }}</b>
  

                <b class="pull-right"> Projects Not Been Updated In 45 Days.</b>

                	
                @endif

                    @if(session('ErrorFile'))
                        <div class="alert-danger pull-right">{{ session('ErrorFile' )}}</div>
                    @endif 
                </div>
                <div class="panel-body">
               	    <div class="col-md-12">
               	    <form method="GET" action="{{ URL::to('/') }}/Unupdated">
               	    	 	<div class="col-md-2">
								<label>Choose Ward :</label><br>
					                <select name="ward" class="form-control" id="ward" onchange="loadsubwards()">
					                    <option value="">--Select--</option>
					                    <option value="All">All</option>
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
								<label></label>
								<input type="submit" value="Fetch" class="form-control btn btn-primary">
							</div>
					</form>
					</div>
				<br><br><br><br>
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
					
					@foreach($projects as $project)
					<tbody>
						<td>{{ $project->project_id }}</td>
						<td>{{ $project->project_name }}</td>
						
						<td>{{ $project->project_status }}</td>
						<td>{{ $project->quality }}</td>
						<td>
						@foreach($site as $sites)
							@if($sites->project_id == $project->project_id)
							<a href="#" >{{ $sites->address }}</a>
							@endif
							@endforeach
						</td>
						<td style="width:10%;">{{ date('d-m-Y', strtotime($project->updated_at)) }}</td>
						<td>{{ $project->remarks }}</td>
					</tbody>
					@endforeach
					
				</table>
				@if(count($projects) != 0)
                {{ $projects->appends($_GET)->links() }}
                @endif
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