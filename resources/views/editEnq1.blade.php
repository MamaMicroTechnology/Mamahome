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
			</div>
			<div class="panel-body">
				<form method="POST" action="{{URL::to('/')}}/editinputdata">
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
									{{ $enq->procurement_contact_no }} {{ $enq->contractor_contact_no }} {{ $enq->site_engineer_contact_no }}
									{{ $enq->owner_contact_no }} {{ $enq->consultant_contact_no }}
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
									{{ $enq->project_name }}
								</td>
							</tr>	
							<tr>
								<td><label>Select category:</label></td>
								<td><button id="mybutton" type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Product</button></td>
							</tr>
<?php
	$sub = explode(", ",$enq->quantity);
	$brands = explode(", ",$enq->brand);
?>

<!-- model -->
<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog" style="width:80%">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header" style="background-color: rgb(244, 129, 31);color: white;" >
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"><center>CATEGORY</center></h4>
</div>
<div class="modal-body" style="height:500px;overflow-y:scroll;">
    <br><br>
    <div class="row">
        @foreach($category as $cat)
        <div class="col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading">{{$cat->category_name}}</div>
                <div class="panel-body" style="height:300px; max-height:300; overflow-y: scroll;">
						<?php
							$i = 0;
						?>
                @foreach($cat->brand as $brand)
                <div class="row">
                    <b class="btn btn-sm btn-warning form-control" style="border-radius: 0px;" data-toggle="collapse" data-target="#demo{{ $brand->id }}"><u>{{$brand->brand}}</u></b>
                    <br>
                    <div id="demo{{ $brand->id }}" class="collapse">
                        @foreach($brand->subcategory as $subcategory)
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label class="checkbox-inline">
                                <input type="hidden" id="quantity{{ $subcategory->id }}" value="{{ $subcategory->Quantity }}">
                                <input {{ in_array($subcategory->sub_cat_name, explode(" :",$sub[$i])) ? 'checked' : '' }} type="checkbox" name="subcat[]" id="subcat{{ $subcategory->id }}" value="{{ $subcategory->id}}" id="">{{ $subcategory->sub_cat_name}}
								<?php 
									$qnt = explode(' :',$sub[$i]);
								?>
								<input value= "{{ in_array($subcategory->sub_cat_name, explode(' :',$sub[$i])) ? $qnt[1] : '' }}" type="text" placeholder="Quantity" id="quan{{$subcategory->id}}" onblur="quan('{{$subcategory->id }}')" onkeyup="check('{{$subcategory->id}}')" autocomplete="off" name="quan[]" class="form-control">
                            </label>
                            <br><br>
                        @endforeach
							<?php
								$i++;
								if($i == count($sub)){
									$i = 0;
								}
							?>
                        <center><span id="total" >total:</span></center>
                    </div>
                    <br>
                </div><br>
                @endforeach
                </div>
            </div>
        </div>
        @if($loop->iteration % 3==0)
        </div>
        <div class="row">
        @endif
        @endforeach
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" data-dismiss="modal">Save</button>
</div>
</div>
</div>
</div>
<!-- model end -->

							@if(Auth::user()->group_id == 7)
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
								<td><label>Quantity* : </label></td>
								<td>{{ $enq->quantity }}</td>
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
						<input type="submit" name="" id="" class="btn btn-md btn-success" style="width:40%" />
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
	    document.getElementById('econtact').style.borderColor = '';
	    var input = document.getElementById(arg).value;
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
	function getProjects()
	{
		var x = document.getElementById('econtact').value;
		document.getElementById('error').innerHTML = '';
		if(x)
		{
			$.ajax({
				type: 'GET',
				url: "{{URL::to('/')}}/getProjects",
				data: {contact: x},
				async: false,
				success: function(response)
				{
					if(response == 'Nothing Found')
					{
						document.getElementById('econtact').style.borderColor = "red";
						document.getElementById('error').innerHTML = "<br><div class='alert alert-danger'>No Projects Found !!!</div>"; 
						document.getElementById('econtact').value = '';
					}
					else
					{
						var result = new String();
						result = "<option value='' disabled selected>----SELECT----</option>";
						for(var i=0; i<response.length; i++)
						{
							result += "<option value='"+response[i].project_id+"'>"+response[i].project_name+" - "+response[i].road_name+"</option>";
						}
						console.log(result);
						document.getElementById('selectprojects').innerHTML =result;	
					}
					
				}
			});
		}
	}    
	function getBrands(){
		var e = document.getElementById('mCategory');
	    var cat = e.options[e.selectedIndex].value;
	    if(cat == "All"){
	    	document.getElementById('brand').innerHTML = "<option value='All'>All</option>";
	    	document.getElementById('sCategory').innerHTML = "<option value='All'>All</option>";
	    }else{
	    	    $.ajax({
	    	        type:'GET',
	    	        url:"{{URL::to('/')}}/getBrands",
	    	        async:false,
	    	        data:{cat : cat},
	    	        success: function(response)
	    	        {
	    	            console.log(response);
	    	            var ans = "<option value=''>--Select--</option><option value='All'>All</option>";
	    	            for(var i=0;i<response[0].length;i++)
	    	            {
	    	                ans += "<option value='"+response[0][i].id+"'>"+response[0][i].brand+"</option>";
	    	            }
	    	            document.getElementById('brand').innerHTML = ans;
	    	        }
	    	    });
	    	}
	}
	function getSubCat()
    {
        var e = document.getElementById("mCategory");
        var cat = e.options[e.selectedIndex].value;
        var brand = document.getElementById("brand").value;
        $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/getSubCat",
            async:false,
            data:{cat : cat, brand: brand},
            success: function(response)
            {
                var text = "<option value='' disabled selected>----Select----</option><option value='All'>All</option>";
                for(var i=0; i < response[1].length; i++)
                {
                    text += "<option value="+response[1][i].id+">"+response[1][i].sub_cat_name+"</option>";
                }
                document.getElementById('sCategory').innerHTML = text;
                document.getElementById('measure').value = response[0].measurement_unit;
            }
        });    
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
<script type="text/javascript">
	 function getquantity()
	{
		var quan=document.myform.equantity.value;
			if(isNaN(quan)){
				document.getElementById('equantity').value="";
				myform.equantity.focus();
		     }
	}
</script>
@endsection
