@extends('layouts.app')
@section('content')
	<div class="col-md-12">
		<div class="panel panel-default">
			
			<div class="panel-body" style="overflow-x: scroll;">
				<form method="GET" action="{{ URL::to('/api') }}/searchuser">
					<div class="col-md-4 pull-right">
						<div class="input-group">
							<input type="text" name="phNo" class="form-control" placeholder="project_id or Manufacturer Id search">
							<div class="input-group-btn">
								<input type="submit" class="form-control" value="Search">
							</div>
						</div>
					</div>
				</form><br><br><br>
			

   <div class="col-md-6">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default" style="border-color:green">
            <div class="panel-heading" style="background-color:green">
               <b style="color:white">Project Details</b> 
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <th>Projects</th>
                        <th>action</th>
                        <th>Type Of Customer</th>
                        <th>Number</th>
                    </thead>
                    <tbody>
                        <tr>
                        	
                       <td>
                          @foreach($projectids as $ids)

                           <a href="{{URL::to('/')}}/showThisProject?id={{$ids}}"> {{$ids}}<br></a>
                          @endforeach 
                      </td>
                      <td>
                       @foreach($projectids as $ids)
                        <a style="width:70%;" href="{{ URL::to('/api') }}/searchuser?id={{$ids}}" class="btn btn-primary btn-sm form-control">click here to get details{{$ids}}<br></a>
                        @endforeach
                        </td>
                        <td>
                          @foreach($projecttype as $type)
                                  {{$type['name']}}<br><br>

                          @endforeach
                        </td>
                        <td>{{$project}}</td>
                           
                        </tr>
                    </tbody>
                </table>        
            </div>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default" style="border-color:green">
            <div class="panel-heading" style="background-color:green">
               <b style="color:white">Manufacturer Details</b> 
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <th>Manufacturers</th>
                        <th>Action</th>
                        <th>Type Of Customer</th>
                        <th>Number</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                          @foreach($manuids as $id)

                           <a href="{{ URL::to('/') }}/viewmanu?id={{ $id }}"> {{$id}}<br></a>
                          @endforeach 
                      </td>
                       <td>
                       @foreach($manuids as $ids)
                        <a style="width:70%;" href="{{ URL::to('/api') }}/searchuser?manuid={{$ids}}" class="btn btn-primary btn-sm form-control">click here to get details{{$ids}}<br></a>
                        @endforeach
                        </td>
                      	<td>
                      		@foreach($manutype as $type1)
                                  {{$type1['name']}}<br>

                      		@endforeach
                      	</td>
                       <td>{{$project1}} </td>
                           
                        </tr>
                    </tbody>
                </table>        
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default" style="border-color:green">
            <div class="panel-heading" style="background-color:green">
               <b style="color:white">Enquiry Details</b> 
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <th>Confirm Enquires</th>
                        <th>Cancel Enquires</th>
                        <th>Enquiry On Process</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                          @foreach($confirmenq as $ide)

                           <a href="{{ URL::to('/') }}/editenq?reqId={{$ide}}"> {{$ide}}<br></a>
                          
                          @endforeach 
                           @foreach($confirms as $ides)

                           <a href="{{ URL::to('/') }}/manuenquiry?projectId={{ $ides }}"> {{$ides}}<br></a>
                          
                          @endforeach 
                      </td>
                      	<td>
                      		@foreach($cancelenq as $typee)
                           <a href="{{ URL::to('/') }}/editenq?reqId={{$typee}}"> {{$typee}}<br>
                           
                           </a>
                                 

                      		@endforeach
                          @foreach($cancel as $typees)
                           <a href="{{ URL::to('/') }}/manuenquiry?projectId={{$typees }}"> {{$typees}}<br>
                           
                           </a>
                                 

                          @endforeach
                      	</td>
                        <td>
                      		@foreach($onprocessenq as $on)
                           <a href="{{ URL::to('/') }}/editenq?reqId={{$on}}"> {{$on}}<br></a>
                           
                                  

                      		@endforeach
                            @foreach($onprocess as $ons)
                           <a href="{{ URL::to('/') }}/manuenquiry?projectId={{$ons }}"> {{$ons}}<br></a>
                           
                                  

                          @endforeach
                      	</td>
  
                           
                        </tr>
                    </tbody>
                </table>        
            </div>
        </div>
    </div>
</div>



<div class="col-md-12">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default" style="border-color:green">
            <div class="panel-heading" style="background-color:green">
               <b style="color:white">Order Details</b> 
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <th>Order Confirms</th>
                        <th>Cancel Orders</th>
                        <!-- <th>Enquiry On Process</th> -->
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                          @foreach($orderconfirm as $ido)
                           <a href=""> {{$ido}}<br></a>
                          @endforeach 
                            @foreach($oconfirm as $idos)
                           <a href=""> {{$idos}}<br></a>
                          @endforeach 
                      </td>
                      	<td>
                      		@foreach($cancelorder as $or)
                                  {{$or}}<br>

                      		@endforeach
                          @foreach($corder as $ors)
                                  {{$ors}}<br>

                          @endforeach
                      	</td>
                        
                           
                        </tr>
                    </tbody>
                </table>        
            </div>
        </div>
    </div>
</div>



			</div>
		</div>
	</div>
	



@endsection
