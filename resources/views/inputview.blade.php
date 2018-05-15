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
				<form method="POST" name="myform" action="{{URL::to('/')}}/inputdata">
					{{csrf_field()}}
					@if(SESSION('success'))
					<div class="text-center alert alert-success">
						<h3 style="font-size:1.8em">{{SESSION('success')}}</h3>
					</div>
					@endif
					<table class="table table-responsive table-hover">
						<tbody>
							<tr>
								<td style="width:30%"><label> Enuiry Date* : </label></td>
								<td style="width:70%"><input required type="date" name="edate" id="edate" class="form-control" style="width:30%" /></td>
							</tr>
							<tr> 
								@if(!isset($_GET['projectId']))
								<td><label>Contact Number* : </label></td>
								<td><input required type="text" name="econtact" id='econtact' maxlength="10" onkeyup="check('econtact')" onblur="getProjects()" placeholder="10 Digits Only" class="form-control" /><div id="error"></div></td>
								@else
								<td><label>Contact Number: </label></td>
								<td >{{ $projects->procurementdetails != NULL?$projects->procurementdetails->procurement_contact_no:'' }}</td>
								@endif
							</tr>
							<!-- <tr>
								<td><label>Name* : </label></td>
								<td><input required type="text" name="ename" id="ename" class="form-control"/></td>
							</tr> -->
							<tr>
								@if(!isset($_GET['projectId']))
								<td><label>Project* : </label></td>
								<td>
									
									<select required class="form-control" id='selectprojects' name="selectprojects" onchange="getAddress()">
									</select>
								</td>
								@else
								<td><label>Project_id : </label></td>
								<td >
									<input type="hidden" value="{{ $projects->project_id }}" name="selectprojects">
									{{ $projects->project_id }}</td>
								@endif
							</tr>	
							<tr>
								<td><label>Select category:</label></td>
								<td><button  required type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Product</button></td>
							</tr>
<!-- model -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width:80%">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: green;color: white;" >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><center>CATEGORY</center></h4>
        </div>
        <div class="modal-body" style="height:500px;overflow-y:scroll;">
        <br>
        <br>
        <div class="row">	
		@foreach($category as $cat)
			
			<div class="col-md-4" >
					<div class="thumbnail" style="border: 1px solid black;min-height: 100px;">
	                  <button style="background-color:#b8b894;width:100%;color:black;" class="btn btn-default " name="mCategory[]" id="mCategory{{ $cat->id }}"   >{{$cat->category_name}}</button>

	                  @foreach($cat->brand as $brand)
	                   <div class="row">
	                   		<div class="col-md-6">
			                  	<b><u>{{$brand->brand}}</u></b><br>
			                  @foreach($brand->subcategory as $subcategory)
			                  		<!-- <div class="col-md-6"> -->
			                  			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			                  			<label class="checkbox-inline">
			                  			 <input type="checkbox" name="subcat[]" value="{{ $subcategory->id}}" id="">{{ $subcategory->sub_cat_name}}
			                  			</label>
			                  			<br>
			                  		<!-- </div> -->
			                  @endforeach
			                  </div>
			           </div>
	                  @endforeach
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
							@if(Auth::user()->group_id == 6)
							<tr>
								<td><label>Initiator* : </label></td>
								<td>	
									<select class="form-control" name="initiator">
										<option value="">--Select--</option>
										@foreach($users1 as $user)
										<option value="{{$user->id}}">{{$user->name}}</option>
										@endforeach
									</select>
								</td>
							</tr>
							@elseif(Auth::user()->group_id == 7)
							<tr>
								<td><label>Initiator* : </label></td>
								<td>	
									<select class="form-control" name="initiator">
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
										<option value="">--Select--</option>
										@foreach($users as $user)
										<option value="{{ $user->id }}">{{ $user->name }}</option>
										@endforeach
									</select>
								</td>
							</tr>
							@endif
							<tr>
								<td><label>Location* : </label></td>
								<td>
									@if(isset($_GET['projectId']))
									<input type="text" value="{{ $projects->siteaddress != Null ? $projects->siteaddress->address  : '' }}" name="elocation" id="elocation" class="form-control" />
									@else
									<input type="text" name="elocation" id="elocation" class="form-control" />
									@endif
								</td>
							</tr>
							<tr>
								<td><label>Quantity* : </label></td>
								<td><input required type="text" oninput="getquantity()" name="equantity"   id="equantity" class="form-control" /></td>
							</tr>
							<tr>
								<td><label>Remarks : </label></td>
								<td>
									<textarea style="resize: none;" rows="4" cols="40" name="eremarks" id="eremarks" class="form-control" /></textarea>
								</td>
							</tr>
						</tbody>
					</table>
					<input type="hidden" id="measure" name="measure">
					<div class="text-center">
						<input type="submit"  name="" id="" class="btn btn-md btn-success"  style="width:40%" />
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
	}function getProjects()
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
	var count = 0;
	function getBrands(id,category_name){
		alert();
		var e = id;
		var category = document.getElementById("mCategory"+id);
		if(category.checked == true){
			
		    $.ajax({
	            type:'GET',
	            url:"{{URL::to('/')}}/getBrands",
	            async:false,
	            data:{cat : e}, 
	            success: function(response)
	            {
	                console.log(response);
	                var ans = document.getElementById('brands').innerHTML;
	                var name = category_name;
	                var n = ans.search(category_name);
					if(n != -1){
						
						document.getElementById(category_name).style.display = "";

					}else{
						
		                ans += "<div id = '"+name+"' class='col-md-4'>"+"*"+name+"<br>";
		                count++;
		                for(var i=0;i<response[0].length;i++)
		                {
		                    ans += "<label  class='checkbox-inline'>"+"<input name='bnd[]' id='brand"+response[0][i].id+"' type='checkbox' onchange=\"getSubCat('"+response[0][i].id+"','"+response[0][i].brand+"')\" value='"+response[0][i].id+"'>"+response[0][i].brand+"</label>"+"<br>";
		                }
		                ans += "</div>";
		               
		                document.getElementById('brands').innerHTML = ans;
			        }
	            }
	        });
		}
		else
		{
			
			var check = document.getElementById("brands").innerHTML;
			var n = check.search(category_name);
			if(n != -1){
				document.getElementById(category_name).style.display = "none";
			}

		}
	}
	function getSubCat(id,brandname)
    {
    	
        var brand = id;
        var subcategory =document.getElementById("brand"+id);
        if(subcategory.checked == true){
        	
        	$.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/getSubCat",
            async:false,
            data:{brand: brand},
            success: function(response)
            {
            		console.log(response);
	            	var name =brandname;
	                var text =  document.getElementById('sCategory').innerHTML;
	                var n = text.search(brandname);
	                if(n != -1){
	                	alert(2);
	                	document.getElementById(brandname).style.display = "";

	                }
	                else{
	                	
	                 text += "<div id = '"+name+"' class='col-md-4'>"+"*"+name+"<br>";
	                for(var i=0; i < response[1].length; i++)
	                {
	                    text += "<label  class='checkbox-inline'>"+"<input name='subcat[]' type='checkbox' value="+response[1][i].id+">"+response[1][i].sub_cat_name+"</label>"+"<br>";
	                    
	                }
	                text += "<div>";
	                document.getElementById('sCategory').innerHTML = text;
	                }
   			 	}
       		 }); 
         }
         else{
         	
         	var check = document.getElementById("sCategory").innerHTML;
			var n = check.search(brandname);
			if(n != -1){
				
				document.getElementById(brandname).style.display = "none";
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