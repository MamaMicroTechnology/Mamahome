<?php
	$user = Auth::user()->group_id;
	$ext = ($user == 4? "layouts.amheader":"layouts.app");
?>
@extends($ext)
@section('content')
<div class="col-md-12">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default" style="border-color: #f4811f">
			<div class="panel-heading" style="background-color: #f4811f;text-align:center">
				<b style="font-size: 1.3em;color:white;">Enquiry Sheet</b>
				<br><br>
			</div>
			<div class="panel-body">
				<form method="POST" id="sub" action="{{URL::to('/')}}/editinputdata">
					{{csrf_field()}}
					<input type="hidden" value="{{ $enq->id }}" name="reqId">
					@if(SESSION('success'))
					<div class="text-center alert alert-success">
						<h3 style="font-size:1.8em">{{SESSION('success')}}</h3>
					</div>
					@endif
					@if(session('Error'))
					<div class="alert alert-danger alert-dismissable">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					{{ session('Error') }}
					</div>
					@endif
					<table class="table table-responsive table-hover">
						<tbody>
							<tr>
								<td style="width:30%"><label>Requirement Date* : </label></td>
								<td style="width:70%"><input value="{{ $enq->requirement_date }}" required type="date" name="edate" id="edate" class="form-control" style="width:30%" /></td>
							</tr>
							<tr>
								<td><label>Contact Number* : </label></td>
								<td>
									{{ $enq->contact_no }}
									<!-- <input value="" required type="text" name="econtact" id='econtact' maxlength="10" onkeyup="check('econtact')" onblur="getProjects()" placeholder="10 Digits Only" class="form-control" /><div id="error"></div> -->
								</td>
							</tr>
							<!-- <tr>
								<td><label>Name* : </label></td>
								<td><input required type="text" name="ename" id="ename" class="form-control"/></td>
							</tr> -->
							<tr>
								<td><label>Project* : </label></td>
								<td>
									{{ $enq->name }}
								</td>
							</tr>	
							
						
							@if(Auth::user()->group_id == 7)
							
							<tr>
								<td><label>Initiator* : </label></td>
								<td>	
									<select required class="form-control"  name="initiator">
										@foreach($users as $user)
										<option value="{{$user->id}}">{{$user->name}}</option>
										@endforeach
									</select>
								</td>
							</tr>
								
							@elseif(Auth::user()->group_id == 6)
							<tr>
								<td><label>Initiator* : </label></td>
								<td>	
									<select required class="form-control"  name="initiator">
										@foreach($users1 as $user)
										<option value="{{$user->id}}">{{$user->name}}</option>
										@endforeach
									</select>
								</td>
							</tr>
							@else
									@if($enq->name == null)
									<tr>
										<td><label>Initiator* : </label></td>
										<td>	
											<select required class="form-control"  name="initiator">
												<option value="">--Select--</option>
												@foreach($users2 as $user)
												<option value="{{$user->id}}">{{$user->name}}</option>
												@endforeach
											</select>
										</td>
									</tr>
									@else
									<tr>
										<td><label>Initiator* : </label></td>
										<td>	
											<select required class="form-control" name="initiator">
												
												
												<option value="{{$enq->name}}">{{$enq->name}}</option>
												
											</select>
										</td>
									</tr>
								@endif
							@endif
							<tr>
								<td><label>Location* : </label></td>
								<td>{{ $enq->address }}</td>
							</tr>

                              <tr>
    <td><label>Billing And Shipping Address : </label></td>
    <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal4">
 Address
</button>
<!-- The Modal -->
<div class="modal" id="myModal4">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Billing And Shipping Address </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
       
        <label>Blling Adderss</label>
            <textarea class="form-control" type="text" name="billadress" cols="70" rows="7" style="resize:none;" value="{{ $enq->billadress }}">{{ $enq->billadress }}
        </textarea>
            
       <br>
        <label>Shipping Adderss &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><br><br>
        <div class="col-md-12">
            <div class="col-md-9">
               <label><input type="radio" name="name" id="ss" onclick="myfunction()">&nbsp;&nbsp;&nbsp;same Address</label><br><br>
            </div>
            
        </div>
        <label id="sp1">Shipping Adderss</label>
            <textarea class="form-control" id="sp" type="text" name="ship" cols="70" rows="7" style="resize:none;" value="{{ $enq->ship }}">
            {{ $enq->ship }}
        </textarea>
           <script type="text/javascript">
               function myfunction(){
          
                document.getElementById('sp').style.display = "none";
                document.getElementById('sp1').style.display = "none";
               }


           </script> 
       <br>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Save</button>
      </div>
</div>

      <!-- Modal footer -->

    </div>
  </div>

</td>
</tr>

							<tr>
								<td><label>Enquiry Quantity : </label></td>
								<td><input type="text" value="{{ $enq->total_quantity  !=null ? $enq->total_quantity  : ''}}" name="total_quantity" id="tquantity" class="form-control" />
								</td>
							</tr>
							
							<tr>
								<td><label>Remarks* : </label></td>
								<td>
									<textarea rows="4" cols="40" name="eremarks" id="eremarks" class="form-control" />{{ $enq->notes }}</textarea>
								</td>
							</tr>
						</tbody>
					</table>
					<input type="hidden" id="measure" name="measure">
					<div class="text-center">
						<button type="button" onclick="submiteditenq()" name="" id="" class="btn btn-md btn-success" style="width:40%" >Submit</button>
						<input type="reset" name="" class="btn btn-md btn-warning" style="width:40%" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="http://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
	function check(arg){
	 var input = document.getElementById(arg).value;
	    if(isNaN(input)){
		       document.getElementById(arg).value = "";
	    }
	    document.getElementById('econtact').style.borderColor = '';
	    if(input){
		    if(isNaN(input)){
		      while(isNaN(document.getElementById(arg).value)){
		      var str = document.getElementById(arg).value;
		      str     = str.substring(0, str.length - 1);
		      document.getElementById(arg).value = str;
		      }
		    }
		}
	}
	
    function getAddress(){
    	var e = document.getElementById('selectprojects');
    	var projectId = e.options[e.selectedIndex].value;
    	$.ajax({
    		type: 'GET',
    		url: "{{ URL::to('/') }}/getAddress",
    		async: false,
    		data: { projectId : projectId},
    		success: function(response){
    			document.getElementById('elocation').value = response.address;
    		}
    	})
    }
</script>

@endsection
