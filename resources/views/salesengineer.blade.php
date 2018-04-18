<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 7? "layouts.sales":"layouts.app");
?>
@extends($ext)
@section('content')
		<div class="col-md-12">
		    <div class="col-md-6">
    			<div class="panel panel-default" style="overflow: scroll;">
    				<div class="panel-heading" style="background-color:#158942;color:white;font-size:1.4em;font-weight:bold">Project List <p class="pull-right">{{ $subwards }} ({{ $projectscount }} projects in total)</p></div>	
    				<div class="panel-body">
    					<table class="table table-hover table-striped">
    						<thead>
    							<th>Project Name</th>
    							<th style="width:15%">Address</th>
    							<th>Procurement Name</th>
    							<th>Contact No.</th>
    							<th>Action</th>
    						</thead>
    						<tbody>
    							@foreach($projects as $project)
    							<tr>
    								<td id="projname-{{$project->project_id}}">{{ $project->project_name }}</td>
    								<td id="projsite-{{$project->project_id}}">
                                        {{ $project->siteaddress != null ? $project->siteaddress->address : '' }}
                                    </td>
    								<td id="projproc-{{$project->project_id}}">
                                        {{ $project->procurementdetails != NULL?$project->procurementdetails->procurement_name:'' }}
                                    </td>
    								<td id="projcont-{{$project->project_id}}"><address>{{ $project->procurementdetails != NULL?$project->procurementdetails->procurement_contact_no:'' }}</address></td>
    								<td><button class="btn btn-sm" style="background-color:#F57F1B;color:white;font-weight:bold" id="viewdet({{$project->project_id}})" onclick="view('{{$project->project_id}}')">View</button>
    								<form method="post" action="{{ URL::to('/') }}/confirmedProject">
    								    {{ csrf_field() }}
    								    <input type="hidden" value="{{ $project->project_id }}" name="id">
    								    <div class="checkbox">
                                          <label><input type="checkbox" {{ $project->confirmed == "True"?'checked':'' }} name="confirmed" onchange="this.form.submit()">Called</label>
                                        </div>
    								</form>
    								</td>
    							</tr>
    							@endforeach
    						</tbody>
    					</table>
    				</div>
    				<div class="panel-footer">
                        @if(Auth::user()->group_id == 7)
    					<center>{{ $projects->links() }}</center>
                        @else
                        <center>
                             <ul class="pagination">
                                {{ $projects->links() }}
                            </ul> 
                        </center>
                        @endif
    				</div>
    			</div>
    		</div>
    		
    		<div class="col-md-6" id="hidepanelright" style="display:none">
    		    <div class="panel panel-default">
    				<div class="panel-heading" style="background-color:#158942;color:white;font-weight:bold">
    				    <a class="btn btn-sm btn-danger pull-right" onclick="document.getElementById('hidepanelright').style.display= 'none';" style="color:white;font-weight:bold">Close</a> 
    				    <a class="btn btn-sm btn-primary pull-right" name="addenquiry" onclick="addrequirement()" style="color:white;font-weight:bold">Add Enquiry</a>
    				    <p>Actions</p>
    				</div>	
    				<div class="panel-body" id="panelbodyright">
    				    <h3 style="font-weight:bold;" class="text-center">Selected Details</h3>
    				    <label style="font-weight:bold"><u>Name: </u></label>&nbsp;&nbsp;<label id='seldetprojname'></label><br>
    				    <label style="font-weight:bold"><u>Site: </u></label>&nbsp;&nbsp;<label id='seldetprojsite'></label><br>
    				    <label style="font-weight:bold"><u>Procurement Name: </u></label>&nbsp;&nbsp;<label id='seldetprojproc'></label><br>
    				    <label style="font-weight:bold"><u>Contact No: </u></label>&nbsp;&nbsp;<label id='seldetprojcont'></label><br>
    					
    						    @foreach($projects as $project)   
    						    <div class="col-md-12" id="table-{{$project->project_id}}">
    						    <form method="post" action="{{ URL::to('/') }}/{{ $project->project_id }}/salesUpdateProject">
    						        {{ csrf_field() }}
        						    <table class="table table-responsive table-hover table-striped">
            					        <thead>
            					            <tr>
            					               <th colspan="2" style="font-size:1.3em;text-align:center"><b>Requirement</b></th>
            					            </tr>
            					        </thead>
            					        <tbody>
            					            <tr id="selectpanelright-{{$project->project_id}}">
        						                <td><label>Status</label></td>
        						                <td>
                						            <select class="form-control" style="width: 100%" id="statusproj-{{$project->project_id}}" name="status">
                										<option disabled selected>Select</option>
                                                        <option value="Planning" {{ $project->project_status == 'Planning'? 'selected':''}}>Planning</option>
                                                        <option value="Digging" {{ $project->project_status == 'Digging'? 'selected':''}}>Digging</option>
                                                        <option value="Foundation" {{ $project->project_status == 'Foundation'? 'selected':''}}>Foundation</option>
                                                        <option value="Pillars" {{ $project->project_status == 'Pillars'? 'selected':''}}>Pillars</option>
                                                        <option value="Walls" {{ $project->project_status == 'Walls'? 'selected':''}}>Walls</option>
                                                        <option value="Roofing" {{ $project->project_status == 'Roofing'? 'selected':''}}>Roofing</option>
                                                        <option value="Electrical & Plumbing" {{ $project->project_status == 'Electrical & Plumbing'? 'selected':''}}>Electrical &amp; Plumbing</option>
                                                        <option value="Plastering" {{ $project->project_status == 'Plastering'? 'selected':''}}>Plastering</option>
                                                        <option value="Flooring" {{ $project->project_status == 'Flooring'? 'selected':''}}>Flooring</option>
                                                        <option value="Carpentry" {{ $project->project_status == 'Carpentry'? 'selected':''}}>Carpentry</option>
                                                        <option value="Paintings" {{ $project->project_status == 'Paintings'? 'selected':''}}>Paintings</option>
                                                        <option value="Fixtures" {{ $project->project_status == 'Fixtures'? 'selected':''}}>Fixtures</option>
                                                        <option value="Completion" {{ $project->project_status == 'Completion'? 'selected':''}}>Completion</option>
                									</select>
                						        </td>
        						            </tr>
        						            <tr id="locpanelright-{{$project->project_id}}">
                						        <td><label>Location</label></td>
                						        <td>
                						            <input type="text" class="form-control" id="location-{{$project->project_id}}" value="{{ $project->siteaddress != null ? $project->siteaddress->address : ''}}" name="address">
                						        </td>
        						            </tr>
        						            <tr id="matpanelright-{{$project->project_id}}">
                						        <td><label>Materials</label></td>
                						        <td>
                						            <input value="{{ $project->remarks }}" type="text" class="form-control" id="mat-{{$project->project_id}}" name="materials">
                						        </td>
            						        </tr>
                						    <tr id="reqpanelright-{{$project->project_id}}">
                						        <td><label>Requirement Date</label></td>
                						        <td>
                						            <input  style="width:100%" type="date"  class="form-control" id="date-{{$project->project_id}}" name="reqDate">
                						        </td>
                						    </tr>
                						    <tr id="quepanelright-{{$project->project_id}}">
                						        <td><label>Questions</label></td>
                						        <td>
                						            <select style="width: 100%" class="form-control" id="select-{{$project->project_id}}" name="qstn">-->
                										<option disabled selected>--- Select ---</option>
                										<option {{ $project->with_cont == 'NOT INTERESTED'? 'selected':'' }} value="NOT INTERESTED">NOT INTERESTED</option>
                										<option {{ $project->with_cont == 'BUSY'? 'selected':'' }} value="BUSY">BUSY</option>
                										<option {{ $project->with_cont == 'WRONG NO'? 'selected':'' }} value="WRONG NO">WRONG NO</option>
                										<option {{ $project->with_cont == 'PROJECT CLOSED'? 'selected':'' }} value="PROJECT CLOSED">PROJECT CLOSED</option>
                										<option {{ $project->with_cont == 'CALL BACK LATER'? 'selected':'' }} value="CALL BACK LATER">CALL BACK LATER</option>
                										<option {{ $project->with_cont == 'THEY WILL CALL BACK WHEN REQUIRED'? 'selected':'' }} value="THEY WILL CALL BACK WHEN REQUIRED">THEY WILL CALL BACK WHEN REQUIRED</option>
                										<option {{ $project->with_cont == 'CALL NOT ANSWERED'? 'selected':'' }} value="CALL NOT ANSWERED">CALL NOT ANSWERED</option>
                										<option {{ $project->with_cont == 'FINISHING'? 'selected':'' }} value="FINISHING">FINISHING</option>
                										<option {{ $project->with_cont == 'SWITCHED OFF'? 'selected':'' }} value="SWITCHED OFF">SWITCHED OFF</option>
                										<option {{ $project->with_cont == 'SAMPLE REQUEST'? 'selected':'' }} value="SAMPLE REQUEST">SAMPLE REQUEST</option>
                										<option {{ $project->with_cont == 'MATERIAL QUOTATION'? 'selected':'' }} value="MATERIAL QUOTATION">MATERIAL QUOTATION</option>
                										<option {{ $project->with_cont == 'WILL FOLLOW UP AFTER DISCUSSION WITH OWNER'? 'selected':'' }} value="WILL FOLLOW UP AFTER DISCUSSION WITH OWNER">WILL FOLLOW UP AFTER DISCUSSION WITH OWNER</option>
                                                        <option {{ $project->with_cont == 'DUPLICATE NUMBER'? 'selected':'' }} value="DUPLICATE NUMBER">DUPLICATE NUMBER</option>
                                                        <option {{ $project->with_cont == 'NOT REACHABLE'? 'selected':'' }} value="NOT REACHABLE">NOT REACHABLE</option>
                									</select>
                						        </td>
                						    </tr>
                						    <tr>
                						        <td><b>Follow Up?</b></td>
                    						    <td>
                    						        <div class="radio">
                                                      <label><input {{ $project->followup == 'No'?'checked':'' }} type="radio" name="follow" value="No">No</label>
                                                    </div>
                                                    <div class="radio">
                                                      <label><input {{ $project->followup == 'Yes'?'checked':'' }} type="radio" name="follow" value="Yes">Yes</label>
                                                    </div>
                    						   </td>
                						    </tr>
                						    <tr>
                						        <td><b>Quality</b></td>
                						        <td>
                						            <select class="form-control" id="quality-{{$project->project_id}}" name="quality">
                						                <option value="null" disabled selected>--- Select ---</option>
                						                <option value="Genuine" {{ $project->quality == 'Genuine'? 'selected':''}}>Genuine</option>
                						                <option value="Fake" {{ $project->quality == 'Fake'? 'selected':''}}>Fake</option>
                						            </select>
                						        </td>
                						    </tr>
                						    <tr>
                						        <td><b>Contract</b></td>
                						        <td>
                						            <select class="form-control" id="contract-{{$project->project_id}}" name="contract">
                						                <option value="null" disabled selected>--- Select ---</option>
                						                <option value="Labour Contract">Labour Contract</option>
														<option value=" Material Contrac"> Material Contract</option>
														
                                                        <option value=" None">None</option>
                                                        
                						            </select>
                						        </td>
                						    </tr>
                						    <tr>
                						        <td><b>Note</b></td>
                						        <td>
                						            <textarea name="note" id="note" class="form-control">{{ $project->note }}</textarea>
                						        </td>
                						    </tr>
            					        </tbody>
            			            </table>
            			            <input type="submit" value="Save" class="btn btn-primary form-control">
        				            </form>
            			            <br>
            			            <h4 style="text-align:center;font-weight:bold">Buyer Details</h4>
                                    <div class="panel-group">
                			            @if($project->ownerdetails != NULL)
                                        <div class="panel panel-default">
                                            <div class="panel-heading"  style="color:white;background-color:#158942;">
                                                <h4 class="panel-title">
                                                   <b>Owner Details</b>
                                                </h4>
                                            </div>
                                            
                                            <div>
                                                <div class="panel-body">
                                                    <table class="table table-responsive table-striped table-hover">
                                                        <tbody>
                                                            <tr>
                                                                <td><b>Name : </b></td>
                                                                <td><input type="text" class="form-control" id="ownername-{{$project->project_id}}" value="{{$project->ownerdetails->owner_name}}" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Phone : </b></td>
                                                                <td><input type="text" maxlength="10" class="form-control" id="ownerphone-{{$project->project_id}}" value="{{$project->ownerdetails->owner_contact_no}}" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Email : </b></td>
                                                                <td><input type="text" class="form-control" id="owneremail-{{$project->project_id}}" value="{{$project->ownerdetails->owner_email}}" /></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="text-center">
                                                        <a onclick="updateOwner({{$project->project_id}})" class="btn btn-sm btn-success" name="ownersubmit-{{$project->project_id}}" id="ownersubmit-{{$project->project_id}}" >Submit</a>
                                                        <a onclick="clearOwner({{$project->project_id}})" class="btn btn-sm btn-danger" name="ownerclear-{{$project->project_id}}" id="ownerclear-{{$project->project_id}}" >Clear</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($project->consultantdetails != NULL)
                                        <div class="panel panel-default">
                                            <div class="panel-heading" style="background-color:#F57F1B;color:white">
                                                <h4 class="panel-title">
                                                    <b>Consultant Details</b>
                                                </h4>
                                            </div>
                                            <div>
                                                <div class="panel-body">
                                                    <table class="table table-responsive table-striped table-hover">
                                                        <tbody>
                                                            <tr>
                                                                <td><b>Name : </b></td>
                                                                <td><input type="text" class="form-control" id="consultantname-{{$project->project_id}}" value="{{$project->consultantdetails->consultant_name}}" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Phone : </b></td>
                                                                <td><input type="text" maxlength="10" class="form-control" id="consultantphone-{{$project->project_id}}" value="{{$project->consultantdetails->consultant_contact_no}}" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Email : </b></td>
                                                                <td><input type="text" class="form-control" id="consultantemail-{{$project->project_id}}" value="{{$project->consultantdetails->consultant_email}}" /></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="text-center">
                                                        <a onclick="updateConsultant({{$project->project_id}})" class="btn btn-sm btn-success" name="consultantsubmit-{{$project->project_id}}" id="consultantsubmit-{{$project->project_id}}" >Submit</a>
                                                        <a onclick="clearConsultant({{$project->project_id}})" class="btn btn-sm btn-danger" name="consultantclear-{{$project->project_id}}" id="consultantclear-{{$project->project_id}}" >Clear</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($project->contractordetails != NULL)
                                        <div class="panel panel-default">
                                            <div class="panel-heading" style="background-color:#158942;color:white">
                                                <h4 class="panel-title">
                                                    <b>Contractor Details</b>
                                                </h4>
                                            </div>
                                            <div>
                                                <div class="panel-body">
                                                    <table class="table table-responsive table-striped table-hover">
                                                        <tbody>
                                                            <tr>
                                                                <td><b>Name : </b></td>
                                                                <td><input type="text" class="form-control" id="contractorname-{{$project->project_id}}"  value="{{$project->contractordetails->contractor_name}}" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Phone : </b></td>
                                                                <td><input type="text" maxlength="10" class="form-control" id="contractorphone-{{$project->project_id}}" value="{{$project->contractordetails->contractor_contact_no}}" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Email : </b></td>
                                                                <td><input type="text" class="form-control" id="contractoremail-{{$project->project_id}}" value="{{$project->contractordetails->contractor_email}}" /></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="text-center">
                                                        <a onclick="updateContractor({{$project->project_id}})" class="btn btn-sm btn-success" name="contractorsubmit-{{$project->project_id}}" id="contractorsubmit-{{$project->project_id}}" >Submit</a>
                                                        <a onclick="clearContractor({{$project->project_id}})" class="btn btn-sm btn-danger" name="contractorclear-{{$project->project_id}}" id="contractorclear-{{$project->project_id}}" >Clear</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
    				            </div>
    				        @endforeach
    			        </div>
    			    </div>	
    		    </div>
		</div>


	<script type="text/javascript">
// 	Reuben

function updatemat(arg)
		{
			var x = confirm('Are You Sure ?');
			if(x)
			{
				var e = document.getElementById('mat-'+arg).value;
				$.ajax({
					type: 'get',
					url: "{{URL::to('/')}}/"+arg+"/updatemat",
					data: {opt: e},
					async: false,
					success: function(response)
					{
						location.reload(true);
					}
				}); 				
			}
			return false;
		}

// Ends Reuben's line
	
	
		function view(arg){
		    document.getElementById('hidepanelright').style.display = 'initial';//Make the whole panel visible
		    var x = parseInt(arg);
		    document.getElementsByName('addenquiry').id = x;
		    document.getElementById('seldetprojname').innerHTML = document.getElementById('projname-'+arg).innerHTML;
		    document.getElementById('seldetprojsite').innerHTML = document.getElementById('projsite-'+arg).innerHTML;
		    document.getElementById('seldetprojproc').innerHTML = document.getElementById('projproc-'+arg).innerHTML;
		    document.getElementById('seldetprojcont').innerHTML = document.getElementById('projcont-'+arg).innerHTML;
		    for(var i =0; i<100000; i++)
		    {
		        if(document.getElementById('table-'+i))
		        {
		            document.getElementById('table-'+i).style.display = 'initial';
		        }
		    }
		    for(var i=0; i<100000; i++){
		        if(i != x)
		        {
		           if(document.getElementById('table-'+i))
		               document.getElementById('table-'+i).style.display = 'none';
		        }
		    }
		    return false;
		}
		
		function confirmthis(arg)
		{
			var x = confirm('Are You Sure ?');
			if(x){
				var e = document.getElementById("select-"+arg);
				var opt = e.options[e.selectedIndex].value;
				$.ajax({
					type: 'get',
					url: "{{URL::to('/')}}/"+arg+"/confirmthis",
					data: {opt: opt},
					async: false,
					success: function(response)
					{
						location.reload(true);
					}
				});
			}
			return false;
		}

		function checkdate(arg)
		{
			var today 	     = new Date();
			var day 	  	 = (today.getDate().length ==1?"0"+today.getDate():today.getDate()); //This line by Siddharth
			var month 	  	 = parseInt(today.getMonth())+1;
			month 	  	     = (today.getMonth().length == 1 ? "0"+month : "0"+month);
			var e 			 = parseInt(month);  //This line by Siddharth
			var year 	  	 = today.getFullYear();
			var current_date = new String(year+'-'+month+'-'+day);
			//Extracting individual date month and year and converting them to integers
			var val = document.getElementById(arg).value;
			var c 	= val.substring(0, val.length-6);
			c 	  	= parseInt(c);
			var d 	= val.substring(5, val.length-3);
			d     	= parseInt(d);
			var f   = val.substring(8, val.length);
			f       = parseInt(f);
			var select_date = new String(c+'-'+d+'-'+f);
			if (c < year) {
				alert('Previous dates not allowed');
				document.getElementById(arg).value = null; 
				document.getElementById(arg).focus();
				return false; 	
			}
			else if(c === year && d < e){
				alert('Previous dates not allowed');
				document.getElementById(arg).value = null;
				document.getElementById(arg).focus(); 
				return false;	
			}
			else if(c === year && d === e && f < day){
				alert('Previous dates not allowed');
				document.getElementById(arg).value = null;
				document.getElementById(arg).focus(); 
				return false;	
			}
			else{
				return false;
			}
			//document.getElementById('rDate').value = current_date;  	
  		}

		function confirmstatus(arg)
		{
			var x = confirm('Are You Sure To Confirm Status ?');
			if(x)
			{
				$.ajax({
					type: 'get',
					url: "{{URL::to('/')}}/"+arg+"/confirmstatus",
					data: {opt: arg},
					async: false,
					success: function(response)
					{
						location.reload(true);
					}
				});
			}
			return false;
		}

		function updatestatus(arg)
		{
			var x = confirm('Are You Sure ?');
			if(x)
			{
				var e = document.getElementById('statusproj-'+arg);
				var opt = e.options[e.selectedIndex].value;
				$.ajax({
					type: 'get',
					url: "{{URL::to('/')}}/"+arg+"/updatestatus",
					data: {opt: opt},
					async: false,
					success: function(response)
					{
						location.reload(true);
					}
				}); 				
			}
			return false;
		}

		function updatelocation(arg)
		{
			var text = document.getElementById('location-'+arg).value;
			var x = confirm('Do You Want To Save The Changes ?');
			if(x)
			{
				var newtext = document.getElementById('location-'+arg).value;	
				$.ajax({
					type: 'get',
					url: "{{URL::to('/')}}/"+arg+"/updatelocation",
					async: false,
					data: {newtext: newtext},
					success: function(response)
					{
						location.reload(true);
					}
				});
			}
			else
			{
				document.getElementById('location-'+arg).value = text;
			}
		}
		
		function updateOwner(arg)
		{
		    var x = confirm('Save Changes ?');
		    if(x)
		    {
		        var id = parseInt(arg);
		        var name = document.getElementById('ownername-'+arg).value;
		        var phone = document.getElementById('ownerphone-'+arg).value;
		        var email = document.getElementById('owneremail-'+arg).value;
		        
		        $.ajax({
		           type: 'GET',
		           url: "{{URL::to('/')}}/updateOwner",
		           data: {name:name, phone:phone, email:email, id:id},
		           async: false,
		           success: function(response)
		           {
		               console.log(response);
		           }
		        });
		    }
		}
        function updateConsultant(arg)
		{
		    var x = confirm('Save Changes ?');
		    if(x)
		    {
		        var id = parseInt(arg);
		        var name = document.getElementById('consultantname-'+arg).value;
		        var phone = document.getElementById('consultantphone-'+arg).value;
		        var email = document.getElementById('consultantemail-'+arg).value;
		        alert(id);
		        $.ajax({
		           type: 'GET',
		           url: "{{URL::to('/')}}/updateConsultant",
		           data: {name:name, phone:phone, email:email, id:id},
		           async: false,
		           success: function(response)
		           {
		               console.log(response);
		           }
		        });
		    }
		}
		function updateContractor(arg)
		{
		    var x = confirm('Save Changes ?');
		    if(x)
		    {
		        var id = parseInt(arg);
		        var name = document.getElementById('contractorname-'+arg).value;
		        var phone = document.getElementById('contractorphone-'+arg).value;
		        var email = document.getElementById('contractoremail-'+arg).value;
		        
		        $.ajax({
		           type: 'GET',
		           url: "{{URL::to('/')}}/updateContractor",
		           data: {name:name, phone:phone, email:email, id:id},
		           async: false,
		           success: function(response)
		           {
		               console.log(response);
		           }
		        });
		    }
		}
		function updateProcurement(arg)
		{
		    var x = confirm('Save Changes ?');
		    if(x)
		    {
		        var id = parseInt(arg);
		        var name = document.getElementById('procurementname-'+arg).value;
		        var phone = document.getElementById('procurementphone-'+arg).value;
		        var email = document.getElementById('procurementemail-'+arg).value;
		        
		        $.ajax({
		           type: 'GET',
		           url: "{{URL::to('/')}}/updateProcurement",
		           data: {name:name, phone:phone, email:email, id:id},
		           async: false,
		           success: function(response)
		           {
		               console.log(response);
		           }
		        });
		    }
		}
		function addrequirement(){
		    var id = document.getElementsByName('addenquiry').id;
		    window.location.href="{{ URL::to('/') }}/requirements?projectId="+id;
		}
		
	</script>
	@endsection
