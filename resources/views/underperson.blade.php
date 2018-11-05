@extends('layouts.app')
@section('content')

<div class="col-sm-10 col-sm-offset-1">
	<div class="panel panel-primary">
		<div class="panel-heading">Contractors
			
		</div>
		<div class="panel-body">
			<form method="GET" action="{{ URL::to('/') }}/underperson">
				 <div class="input-group col-md-4 pull-right">
				 	<br>
				<button type="submit" class="btn btn-primary btn-sm" style="width:60%;">Fecth</button>
				</div>
				<div class="input-group col-md-4 pull-left">
					<label>Choose Ward :</label><br>
                          <select name="ward" class="form-control" id="ward" onchange="loadsubwards()" style="width:80%;">
                              <option value="">--Select--</option>
                              @foreach($wards as $ward)
                              <option value="{{ $ward->id }}">{{ $ward->ward_name }}</option>
                              @endforeach
                          </select>
					
				</div>
              <div class="input-group col-md-4 pull-left">
					<label>Choose Subward :</label><br>
                          <select name="subward" class="form-control" id="subward" style="width:80%;">
                          </select>
              </div>
					
				</div>
			</form>
			<table class="table table-hover">
				<thead>
					<th>Contractor Name</th>
					<th>Contact No.</th>
					<th>No of projects</th>
					<th>Project Ids</th>
					<th>View</th>
				</thead>
				<tbody>
					
					@foreach($conName as $contractor)
					<tr>
						<td>{{ $contractor->contractor_name }}</td>
						<td>{{ $contractor->contractor_contact_no }}</td>
						<td>{{count($projects[$contractor->contractor_contact_no])}}</td>
						<td>{{ $projects[$contractor->contractor_contact_no]}}</td>
                       <td><a href="{{ URL::to('/') }}/viewProjects?no={{ $contractor->contractor_contact_no }}">View Projects</a></td>
					</tr>
					@endforeach
				
				</tbody>
			</table>
		</div>
		<div class="panel-footer">
			<center>
			
				{{ $contractor->links(); }}
				
			</center>
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
                        
                        var html = "<option value='All'>ALL</option>";

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