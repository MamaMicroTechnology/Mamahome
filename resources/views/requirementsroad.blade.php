@extends('layouts.leheader')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-4">
	<div class="panel panel-default">
		<div class="panel-heading">Projects</div>
		<div class="panel-body">
			<table class="table table-responsive table-striped table-hover" style="border: 2px solid gray;">
          <tbody >
                <tr>
                  <td style="border: 1px solid gray;"> <label>Total Number of Projects Listed till nOw</label></td>
                  <td style="border: 1px solid gray;"><strong>{{ $numbercount }}</strong></td>
                </tr>
                <tr>
                  <td style="border: 1px solid gray;"> <label>TOtal number of projects in {{$subwards->sub_ward_name}}</label></td>
                  <td style="border: 1px solid gray;"><strong>{{ $totalprojects}}</strong></td>
                </tr>
                <tr>  
                  <td style="border: 1px solid gray;"><label>Genuine Projects</label></td>
                  <td style="border: 1px solid gray;"><strong>{{ $genuineprojects }}</strong></td>
                </tr>
                <tr>
                  <td style="border: 1px solid gray;"><label>Unverified Projects</label></td>
                  <td style="border: 1px solid gray;"><strong>{{ $unverifiedprojects }}</strong></td>
                </tr>
                <tr>
                  <td style="border: 1px solid gray;"><label>Fake Projects</label></td>
                  <td style="border: 1px solid gray;"><strong>{{ $fakeprojects }}<strong></td>
                </tr>
                <tr>
                  <td style="border: 1px solid gray;"><label>Last 30 Days Updated Projects</label></td>
                  <td style="border: 1px solid gray;"><strong>{{ $update  }}<strong></td>
                </tr>
                <tr>
                  <td style="border: 1px solid gray;"><label>remaining Projects</label></td>
                  <td style="border: 1px solid gray;"><strong>{{ $bal }}<strong></td>
                </tr>
          </tbody>
        </table>
	
		</div>
		
	</div>
</div>
<div class="col-md-4" style="margin-left: 20%;">
	<div class="panel panel-default">
		<div class="panel-heading">Select</div>
		<div class="panel-body">
			<ul class="list-group">
				<li class="list-group-item">
					<a href="{{ URL::to('/') }}/projectrequirement?road={{ $todays }}&today=today">Today's Listing ({{ $todays }} projects)</a>
				</li>
				
			</ul>
			 <form method="GET" action="{{ URL::to('/') }}/projectrequirement">
			<select name="quality" class="form-control" onchange="form.submit()" >
			    <option value="">-----Select----</option>
				<option value="Genuine">Genuine</option>
					<option value="Unverified">Unverified</option>
						<!-- <option value="Fake">Fake</option> -->
			</select> 
			</form>
		</div>
		
	</div>
</div>
<div class="col-sm-4" style="margin-left: 20%;">
  <h4>Project Search </h4>
  <form method="GET" action="{{ URL::to('/') }}/projectrequirement">
         
            <div class="input-group">
              <input type="text" name="phNo" class="form-control" placeholder="Phone number and project_id search">
              <div class="input-group-btn">
                <input type="submit" class="form-control" value="Search">
              </div>
            </div>
        
        </form>
</div>
</div>

       
@endsection