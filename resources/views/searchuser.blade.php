@extends('layouts.app')
@section('content')
	<div class="col-md-12">
		<div class="panel panel-default">
			
			<div class="panel-body" style="overflow-x: scroll;">
				<form method="GET" action="{{ URL::to('/') }}/searchuser">
					<div class="col-md-4 pull-right">
						<div class="input-group">
							<input type="text" name="phNo" class="form-control" placeholder="project_id or Manufacturer Id search">
							<div class="input-group-btn">
								<input type="submit" class="form-control" value="Search">
							</div>
						</div>
					</div>
				</form><br><br><br>
			
  <div class="card">
    
   <div class="col-md-6">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default" style="border-color:green">
            <div class="panel-heading" style="background-color:green">
               <b style="color:white">Project Details</b> 
            </div>
            <div class="panel-body">
                <table class="table table-hover table-responsive " border="1">
                    <thead>
                        <th>Projects &nbsp;({{count($projectids)}})</th>
                        <th>action</th>
                        <th>Type Of Customer</th>
                        <th>Name</th>
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
                        <a style="width:100%;" href="{{ URL::to('/') }}/searchuser?phNo={{isset($_GET['phNo']) ? $_GET['phNo']: ''}}&&id={{$ids}}" class="btn btn-info btn-sm form-control" name="pro" id="project" onclick="murali('{{$ids}}')">click here to get details{{$ids}}</a><br>
                        @endforeach
                        </td>
                        <td>
                          @foreach($projecttype as $type)
                                  {{$type['name']}}<br><br>

                          @endforeach
                        </td>
                        <td>{{$cname}}</td>
                        <td>{{$project}}</td>
                           
                        </tr>
                    </tbody>
                </table>        
            </div>
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
                <table class="table table-hover table-responsive" border="1">
                    <thead>
                        <th>Manufacturers&nbsp;({{count($manuids)}})</th>
                        <th>Action</th>
                        <th>Type Of Customer</th>
                        <th>Name</th>
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
                        <a style="width:100%;" href="{{ URL::to('/') }}/searchuser?phNo={{isset($_GET['phNo']) ? $_GET['phNo']: ''}}&&manuid={{$ids}}" class="btn btn-primary btn-sm form-control" name="manu">click here to get details{{$ids}}<br></a>
                        @endforeach
                        </td>
                      	<td>
                      		@foreach($manutype as $type1)
                                  {{$type1['name']}}<br>

                      		@endforeach
                      	</td>
                        <td>{{$cmanu}}</td>
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
                <table class="table table-hover table-responsive" border="1">
                    <thead>
                        <th>Confirm Enquiries&nbsp;({{count($confirmenq)}})({{count($confirms)}})</th>
                        <th>Cancel Enquiries&nbsp;&nbsp;({{count($cancelenq)}})({{count($cancel)}})</th>
                        <th>Enquiry On Process&nbsp;({{count($onprocessenq)}})({{count($onprocess)}})</th>
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
                <table class="table table-hover table-responsive" border="1">
                    <thead>
                        <th>Order Confirms&nbsp;({{count($orderconfirm)}})({{count($oconfirm)}})</th>
                        <th>Enquiry Id</th>
                        <th>Cancel Orders&nbsp;({{count($cancelorder)}})({{count($corder)}})</th>
                        <th>Enquiry Id</th>
                        <th>Get Purchase Invoice</th>
                        <th>Get Proforma Invoice</th>
                       <!--  <th>Quotation</th> -->


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
                      <td>  @foreach($enq as $id)
                           <a href=""> {{$id}}<br></a>
                          @endforeach 
                           @foreach($enqmanu as $eid)
                           <a href=""> {{$eid}}<br></a>
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
                          <td>
                          @foreach($cenq as $orc)
                                  {{$orc}}<br>

                          @endforeach
                          @foreach($cenqm as $orsm)
                                  {{$orsm}}<br>

                          @endforeach
                        </td>
                         <td>
                         
                          @foreach($sproinc as $onsd)
                           <a href="{{ URL::to('/') }}/editenq?reqId={{$onsd}}"> {{$onsd}}<br></a>
                          @endforeach
                            @foreach($smanuinc as $manu)
                           <a href="{{ URL::to('/') }}/manuenquiry?projectId={{$manu }}"> {{$manu}}<br></a>
                          @endforeach
                         <a href="{{ URL::to('/') }}/orders?projectId={{isset($_GET['id']) ? $_GET['id']:''}} {{isset($_GET['manuid']) ? $_GET['manuid']:''}} " class=" btn btn-primary">Get Purchase Order</a>
                        </td>
                        

                        <td>
                          @foreach($cproinc as $cpro)
                           <a href="{{ URL::to('/') }}/editenq?reqId={{$cpro}}"> {{$cpro}}<br></a>
                          @endforeach
                            @foreach($cmanuinc as $manuinc)
                           <a href="{{ URL::to('/') }}/manuenquiry?projectId={{$manu }}"> {{$manuinc}}<br></a>
                          @endforeach
                            <a href="{{ URL::to('/') }}/financeDashboard?projectId={{isset($_GET['id']) ? $_GET['id']:''}} {{isset($_GET['manuid']) ? $_GET['manuid']:''}} " class=" btn btn-primary">Generate Peoforma Invoice</a>
                        </td>
                           
                        </tr>
                    </tbody>
                </table>        
            </div>
        </div>
    </div>
</div>

 <center><div class="col-md-6 col-md-offset-3">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default" style="border-color:green">
            <div class="panel-heading" style="background-color:green">
               <b style="color:white"> Generate Customer_ID </b> 
            </div>
            <div class="panel-body">
              <form action="{{URL::to('/')}}/getcustome" method="post">

                    {{ csrf_field() }}
                
                   <?php 
                   $projectids = serialize($projectids);
                    $projecttype = serialize($projecttype);
                    $manuids = serialize($manuids);
                    $manutype = serialize($manutype);
                    $pconfirmenq = serialize($confirmenq);
                    $pcancelenq = serialize($cancelenq);
                    $ponprocess = serialize($onprocessenq);
                    $porderconfirm = serialize($orderconfirm);

                    $pordercancel = serialize($cancelorder);
                    $monfirmsenq = serialize($confirms);
                    $mcancelenq = serialize($cancel);
                    $monprocess = serialize($onprocess);
                    $morderconfirm = serialize($oconfirm);
                    $mordercancel = serialize($corder);
                  ?>
                   <input type="hidden" name="projectid" value="{{$projectids}}">
                   <input type="hidden" name="project_type" value="{{$projecttype}}">
                   <input type="hidden" name="manuids" value="{{$manuids}}">
                   <input type="hidden" name="manutype" value="{{$manutype}}">

                   <input type="hidden" name="pconfirmenq" value="{{$pconfirmenq}}">
                   <input type="hidden" name="pcancelenq" value="{{$pcancelenq}}">
                   <input type="hidden" name="ponprocess" value="{{$ponprocess}}">
                   <input type="hidden" name="porderconfirm" value="{{$porderconfirm}}">

                    <input type="hidden" name="pordercancel" value="{{$pordercancel}}">
                   <input type="hidden" name="monfirmsenq" value="{{$monfirmsenq}}">
                   <input type="hidden" name="mcancelenq" value="{{$mcancelenq}}">
                   <input type="hidden" name="monprocess" value="{{$monprocess}}">
                    <input type="hidden" name="morderconfirm" value="{{$morderconfirm}}">
                   <input type="hidden" name="mordercancel" value="{{$mordercancel}}">
                  
                 <button style="width:50%;" type="submit" class="form-control btn btn-warning btn-sm"> Generate </button>
               </form>
            </div>
        </div>
    </div>

			</div>
		</div>
	</div></center>


 

  
@endsection
