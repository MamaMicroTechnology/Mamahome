<?php
	$user = Auth::user()->group_id;
	$ext = ($user == 4? "layouts.amheader":"layouts.app");
?>
@extends($ext)

@section('content')
<div class="col-md-12">
		<div class="panel panel-primary" >
			 <div class="panel-heading text-center" ><b>
			 	<p class="pull-left">Total Enquiry Count : {{$enquiries->total()}}</p>
			 Enquiry Cancelled		 	
			 </b>
                    @if(session('ErrorFile'))
                        <div class="alert-danger pull-right">{{ session('ErrorFile' )}}</div>
                    @endif 
                    <button type="button" onclick="history.back(-1)" class="bk-btn-triangle pull-right" style="margin-top:-10px;" > <i class="fa fa-arrow-circle-left" style="padding:5px;width:50px;color:black;"></i></button>
              </div>
			<div class="panel-body" style="overflow-x:scroll;overflow-y:scroll;height:1000px">
				<form method="GET" action="{{ URL::to('/') }}/search_enquiry">
					<div class="col-md-4 pull-right">
						<div class="input-group">
							<input type="text" name="phNo" class="form-control" placeholder="project_id search">
							<div class="input-group-btn">
								<input type="submit" class="form-control" value="Search">
							</div>
						</div>
					</div>
				</form>

					<table id="myTable" class="table table-responsive table-striped table-hover">
					<thead>
						<tr>
							<th style="text-align: center">Project</th>
							<th style="text-align: center">Subward Number</th>
							<th style="text-align: center">Name</th>
							<th style="text-align: center">Requirement Date</th>
							<th style="text-align: center">Enquiry Date</th>
							<th style="text-align: center">Contact</th>
							<th style="text-align: center">Product</th>
							<th style="text-align: center">Quantity</th>
							<th style="text-align: center">Initiator</th>
							<th style="text-align: center">Status</th>
							<th style="text-align: center">Remarks</th>

							
							<!-- <th style="text-align: center">Edit</th> -->
						</tr>
					</thead>
					<tbody>
						@foreach($enquiries as $enquiry)
					
						<tr>
							<td style="text-align: center">
								<a href="{{URL::to('/')}}/showThisProject?id={{$enquiry ->project != null?$enquiry ->project->project_id :''}}">
									<b>{{$enquiry ->project != null?$enquiry ->project->project_id : $enquiry->manu_id }}</b>
								</a> 
							</td>
							<td style="text-align: center">
                               @foreach($wards as $ward)
                                 @if($ward->id ==($enquiry->project != null ? $enquiry->project->sub_ward_id : $enquiry->sub_ward_id) )
                                <a href="{{ URL::to('/')}}/viewsubward?projectid={{$enquiry->project_id}} && subward={{ $ward->sub_ward_name }}" target="_blank">
                                    {{$ward->sub_ward_name}}
                                </a>
                                  @endif
                               @endforeach
                            </td>

							<td style="text-align:center">{{$enquiry->procurementdetails != null? $enquiry ->procurementdetails->procurement_name:''}}</td>
							<td style="text-align: center">{{$newDate = date('d/m/Y', strtotime($enquiry->requirement_date)) }}</td>
							<td style="text-align: center">{{ date('d/m/Y', strtotime($enquiry->created_at)) }}</td>

							<td style="text-align: center">{{$enquiry->procurementdetails !=null ? $enquiry->procurementdetails->procurement_contact_no:'' }}</td>

							<td style="text-align: center">{{$enquiry->main_category}} ({{ $enquiry->sub_category }}), {{ $enquiry->material_spec }}</td>
							<td style="text-align: center">{{$enquiry->quantity}}</td>
							<td style="text-align: center">{{$enquiry->user != null ? $enquiry->user->name :''}}</td>
							<td style="text-align: center">
								{{ $enquiry->status}}
							</td>
							<td style="text-align: center" onclick="edit('{{ $enquiry->id }}')" id="{{ $enquiry->id }}">
								<form method="POST" action="{{ URL::to('/') }}/editEnquiry">
									{{ csrf_field() }}
									<input type="hidden" value="{{$enquiry->id}}" name="id">
									<input onblur="this.className='hidden'; document.getElementById('now{{ $enquiry->id }}').className='';" name="note" id="next{{ $enquiry->id }}" type="text" size="35" class="hidden" value="{{ $enquiry->notes }}"> 
									<p id="now{{ $enquiry->id }}">{{$enquiry->notes}}</p>
								</form>
							</td>
							<td>
								<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete{{ $enquiry->id }}">Delete</button>
								<!-- Modal -->
							  <div class="modal fade" id="delete{{ $enquiry->id }}" role="dialog">
							    <div class="modal-dialog modal-sm">
							      <div class="modal-content">
							        <div class="modal-header">
							          <button type="button" class="close" data-dismiss="modal">&times;</button>
							          <h4 class="modal-title">Delete</h4>
							        </div>
							        <div class="modal-body">
							          <p>Are you sure you want to delete this Enquiry?</p>
							        </div>
							        <div class="modal-footer">
							        	<a class="btn btn-danger pull-left" href="{{ URL::to('/') }}/delete_enquiry?projectId={{$enquiry->id }}">Yes</a>
							          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
							        </div>
							      </div>
							    </div>
							  </div>
							</td>
							
							<!-- <td>
								<a href="{{ URL::to('/') }}/editenq?reqId={{ $enquiry->id }}" class="btn btn-xs btn-primary">Edit</a>
							</td> -->
						</tr>
						
						@endforeach
					</tbody>
				</table>
						<center>{{ $enquiries->appends(request()->query())->links()}}</center>
			</div>
		</div>
	</div>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
     background-color: #00acd6 

});

</script>
@endsection
