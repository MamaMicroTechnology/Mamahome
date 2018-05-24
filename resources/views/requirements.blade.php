@extends('layouts.app')
@section('content')
<?php
	$id = $_GET['projectId'];
?>
<div class="col-md-6 col-md-offset-3">
<div class="panel panel-default">
	<div class="panel-heading">
		Enquiry
		<button class="pull-right btn btn-sm btn-success" id="btn1" onclick="show()">Add</button>
		<button class="hidden" id="btn2" onclick="hide()">Cancel</button>
	</div>
	<div class="panel-body">
		<div id="add" class="hidden">
			<form method="POST" action="{{ URL::to('/') }}/addRequirement?pId={{ $id }}" enctype="multipart/form-data">
				{{ csrf_field() }}
				<table class="table">
					<tr>
						<td ><label> Enquiry Date* </label></td>
						<td>:</td>
						<td ><input required type="date" name="edate" id="edate" class="form-control"  /></td>
					</tr>
					<tr>
								<td><label>Contact Number </label></td>
								<td>:</td>
								<td >{{ $projects->procurementdetails != NULL?$projects->procurementdetails->procurement_contact_no:'' }}</td>
					</tr>
					<tr>
								<td><label>Project_id</label></td>
								<td>:</td>
								<td >{{ $projects->project_id }}</td>
					</tr>
					<tr>
						<td>Main Category</td>
						<td>:</td>
						<td>

							<table class="table table-resonsive">
								<tr >
								@foreach($category as $cat)
								<div class="col-md-3">
								<label class="checkbox-inline">
		                                  <input type="checkbox" name="mCategory" id="mCategory{{ $cat->id }}" required onchange="getBrands('{{ $cat->id }}','{{ $cat->category_name }}')" value="{{$cat->category_name}}" >{{$cat->category_name}}
		                        </label>
		                        </div>

		                         @endforeach
		                     	</tr>
                         	</table>
						</td>
					</tr>
					<tr>
						<td>Brands</td>
						<td>:</td>
						<td id="brand">
						</td>
					</tr>
					<tr>
						<td>Sub Category</td>
						<td>:</td>
						<td>
							
								<select name="sCategory" id="sCategory" class="form-control input-sm" onchange="getPrice()">
								
							</select>
						</td>
					</tr>
					<tr>
						<td>Material Specification</td>
						<td>:</td>
						<td><textarea name="mSpec" required class="form-control" placeholder="Material Specification"></textarea></td>
					</tr>
					<tr>
						<td>Referral Images</td>
						<td>:</td>
						<td>
							<input type="file" name="rfImage1" accept="image/*" class="form-control">
							<br>
							<input type="file" name="rfImage2"  accept="image/*" class="form-control">
						</td>
					</tr>
					<tr>
						<td>Requirement date</td>
						<td>:</td>
						<td>
							<input required type="date" name="rDate" id="rDate" onblur="checkdate()" class="form-control">
						</td>
					</tr>
					<tr>
						<td>Measurement Unit</td>
						<td>:</td>
						<td>
							<input type="text" class="form-control" style="background-color:#e5e5e5" readonly id="measure" name="measure" />
						</td>
					</tr>
					<tr>
						<td>Unit Price</td>
						<td>:</td>
						<td><input placeholder="Unit Price"  style="background-color:#e5e5e5" id="uPrice" type="text" readonly style="border-style= hidden;" class="form-control" name="uPrice"></td>
					</tr>
					
					<tr id="truck"></tr>   
					<tr>
						<td>Total Quantity</td>
						<td>:</td>
						<td><input placeholder="Quantity" autocomplete="off" id="quantity" type="text" class="form-control" name="quantity" onkeyup="calculate();check();" onblur="checkno()"></td>
					</tr>
					<tr>
						<td>Total Amount</td>
						<td>:</td>
						<td><input placeholder="Total" id="total" style="background-color:#e5e5e5" onfocus="document.getElementById('total').disabled = true;" onblur="document.getElementById('total').disabled = false;" type="text" class="form-control" name="total"></td>
					</tr>
					<tr>
						<td>Notes</td>
						<td>:</td>
						<td>
							<textarea class="form-control" placeholder="Notes" name="notes"></textarea>
						</td>
					</tr>
				</table>
				<table>
				    <tbody>
				        <tr>
    				        <td style="width:300px"><button type="submit" class="form-control btn-success">Add</button></td>
    				        <td style="width:300px"><button type="reset" class="form-control btn-warning">Clear</button></td>
				        </tr>
				    </tbody>
				</table>	
			</form>
		</div>
		<div id="sandmodal" class="modal fade" role="dialog">
	        <div class="modal-dialog modal-sm">
	        <!-- Modal content-->
		        <div class="modal-content">
		          <div class="modal-header">
		            <button type="button" class="close" data-dismiss="modal">&times;</button>
		            <h4 class="modal-title">Price Calculator</h4>
		          </div>
		          <div class="modal-body">
		          	<input type="hidden" readonly="true" id="tc">
		          	<input type="hidden" readonly="true" id="gst">
		          	<input type="hidden" readonly="true" id="royalty">
		            Quantity : <input type="text" name="" id='i1' class="form-control" placeholder="Quantity" />
		            Distance : <input type="text" id="i2" name="" class="form-control" placeholder="Distance" />
		            <br>
		            <button onclick="func_sand()" class="btn btn-md btn-primary text-center" data-dismiss="modal">Submit</button>
		          </div>
		          <div class="modal-footer">
		            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		          </div>
		        </div>
	        </div>
	    </div>
		<div id="req" class="">
			@if(count($requirements) == 0)
				No enquiry found yet! Please add some.
			@elseif(count($requirements) == 1)
				This is your enquiry
			@else
				These are your enquiries
			@endif
			@if(session('Error'))
			<div class="alert-danger pull-right">{{ session('Error')}}</div>
			@endif
			@if(session('Success'))
			<div class="alert-success pull-right">{{ session('Success')}}</div>
			@endif
				{{ csrf_field() }}
				<table class="table">
					<thead>
						
						<th>Main Category</th>
						<th>Sub-Category</th>
						<th>Qnty.</th>
						<th>Status</th>
						<th>Action</th>
					</thead>
					<tbody>
						@foreach($requirements as $requirement)
							<tr>
								
								<td>{{ $requirement->main_category }}</td>
								<td>{{ $requirement->sub_category }}</td>
								<td>{{ $requirement->quantity }} {{ $requirement->measurement_unit }}</td>
								<td id="status-{{ $requirement->id }}">{{ $requirement->status }}</td>
								<td><a class="btn btn-xs btn-primary" id="init-{{ $requirement->id }}" onclick="initiateOrder('{{ $requirement->id }}')">Initiate Enquiry</a></td>
							</tr>
						@endforeach
					</tbody>
				</table>
    		</div>
    	</div>
    </div>
<script src="http://code.jquery.com/jquery-3.3.1.js"></script> 
<script type="text/javascript">
    function check(){
	    var input = document.getElementById('quantity').value;
	    if(isNaN(input)){
	      	while(isNaN(document.getElementById('quantity').value)){
	      	var str = document.getElementById('quantity').value;
	      	str     = str.substring(0, str.length - 1);
	      	document.getElementById('quantity').value = str;
	      	}
	    }
	    else{
	      	input = input.trim();
	      	document.getElementById('quantity').value = input;
	    }
	    return false;
	}
    function checkno()
    {
        var e = document.getElementById("truckvalue");
        var subcat = e.options[e.selectedIndex].value;
        if(subcat == '6')
        {
            if(document.getElementById('quantity').value < 18 || document.getElementById('quantity').value > 22)
            {
                alert('Value Should Be Between 18 and 22 !!');
                document.getElementById('quantity').value = '';
                return false;
            }
        }
        if(subcat == '10')
        {
            if(document.getElementById('quantity').value < 24 || document.getElementById('quantity').value > 32)
            {
                alert('Value Should Be Between 24 and 32 !!');
                document.getElementById('quantity').value = '';
                return false;
            }
        }
        return false;
    }
    function getPrice()
    {
        
        var e = document.getElementById("mCategory");
        var cat = e.options[e.selectedIndex].value;
        var e = document.getElementById("sCategory");
        var subcat = e.options[e.selectedIndex].value;
        
        $.ajax({
            type: 'GET',
            url: "{{URL::to('/')}}/getPrice",
            async: false,
            data: {cat : cat, subcat: subcat},
            success: function(response)
            {
               	document.getElementById('uPrice').value = response.price;
               	if(response.transportation_cost != null){
					document.getElementById('tc').value = response.transportation_cost;
               	}
               	if(response.royalty != null){
               		document.getElementById('royalty').value = response.transportation_cost;
               	}
				document.getElementById('gst').value = response.gst;
				$('#sandmodal').modal('show');
            }
        });   
    }
    function func_sand(){
    	var elt = document.getElementById("brand");
		var category = elt.options[elt.selectedIndex].text;
		var price = parseInt(document.getElementById('uPrice').value);
		var quantity = parseInt(document.getElementById('i1').value);
		var distance = parseInt(document.getElementById('i2').value);
		var gst = parseInt(document.getElementById('gst').value);
		var tc = parseInt(document.getElementById('tc').value);
		var royalty = parseInt(document.getElementById('royalty').value);
		switch(category){
			case "Chettinad":
					// cement
					var tPrice = (price*quantity) + (gst*quantity*price) + tc;
					var cpb = tPrice/quantity;
					var gstpb = cpb/tc;
					var tcpb = cpb + gstpb;
					var totalPrice = tcpb + quantity;
					var ppt = totalPrice/quantity;
					document.getElementById('total').value = totalPrice;
					document.getElementById('quantity').value = quantity;
					document.getElementById('uPrice').value = ppt;
					document.getElementById('i1').value="";
					document.getElementById('i2').value="";
					break;
			case "Dalmia":
					// cement
					if(quantity <= 100){
						var totalPrice = quantity * price;
						var ppt = price;
					}else if(quantity > 100 && quantity < 250){
						var totalPrice = quantity * price;
						var ppt = price;
					}else if(quantity > 250){
						var totalPrice = quantity * price;
						var ppt = price;
					}
					document.getElementById('total').value = totalPrice;
					document.getElementById('quantity').value = quantity;
					document.getElementById('uPrice').value = ppt;
					document.getElementById('i1').value="";
					document.getElementById('i2').value="";
					break;
			case "Tirumala":
					// steel
					var totalPrice = (price*quantity) + (gst*price*quantity);
					var ppt = totalPrice/quantity;
					document.getElementById('total').value = totalPrice;
					document.getElementById('quantity').value = quantity;
					document.getElementById('uPrice').value = ppt;
					document.getElementById('i1').value="";
					document.getElementById('i2').value="";
					break;
			case "Sunvik":
					// Steel
					var totalPrice = quantity*price;
					var ppt = totalPrice/quantity;
					document.getElementById('total').value = totalPrice;
					document.getElementById('quantity').value = quantity;
					document.getElementById('uPrice').value = ppt;
					document.getElementById('i1').value="";
					document.getElementById('i2').value="";
					break;
			case "Thriveni":
					// sand
					var total = (price * quantity) + ((distance + 25) * 3.8 * quantity) + (20 * quantity);
					var gst = 0.05 * total;
					var totalPrice = total + gst;
					var ppt = totalPrice / quantity;		
					document.getElementById('total').value = totalPrice;
					document.getElementById('quantity').value = quantity;
					document.getElementById('uPrice').value = ppt;
					document.getElementById('i1').value="";
					document.getElementById('i2').value="";
					break;
			case "Stona":
					// sand
					var distance2 = distance + 10;
					var total = (price * quantity) + (distance2 * 5 * quantity) + (80 * quantity);
					var gst = 0.05 * total;
					var totalPrice = total + gst;
					var ppt = totalPrice / quantity;
					document.getElementById('total').value = totalPrice;
					document.getElementById('quantity').value = quantity;
					document.getElementById('uPrice').value = ppt;
					document.getElementById('i1').value="";
					document.getElementById('i2').value="";
					break;
			default:
					document.getElementById('quantity').value = quantity;
					document.getElementById('uPrice').value = price;
					document.getElementById('total').value = quantity * price;
		}
	}
    
    function getSubCat()
    {
    	alert("bmnb");
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

	function checkdate(){
		var today 	     = new Date();
		var day 	  	 = (today.getDate().length ==1?"0"+today.getDate():today.getDate()); //This line by Siddharth
		var month 	  	 = parseInt(today.getMonth())+1;
		month 	  	     = (today.getMonth().length == 1 ? "0"+month : "0"+month);
		var e 			 = parseInt(month);  
		var year 	  	 = today.getFullYear();
		var current_date = new String(year+'-'+month+'-'+day);
	
		//Extracting individual date month and year and converting them to integers
		var val = document.getElementById('rDate').value;
		var c 	= val.substring(0, val.length-6);
		c 	  	= parseInt(c);
		var d 	= val.substring(5, val.length-3);
		d     	= parseInt(d);
		var f   = val.substring(8, val.length);
		f       = parseInt(f);
		var select_date = new String(c+'-'+d+'-'+f);
		if (c < year) {
			alert('Previous dates not allowed');
			document.getElementById('rDate').value = null; 
			document.getElementById('rDate').focus();
			return false; 	
		}
		else if(c === year && d < e){
			alert('Previous dates not allowed');
			document.getElementById('rDate').value = null;
			document.getElementById('rDate').focus(); 
			return false;	
		}
		else if(c === year && d === e && f < day){
			alert('Previous dates not allowed');
			document.getElementById('rDate').value = null;
			document.getElementById('rDate').focus(); 
			return false;	
		}
		else{
			return false;
		}
		//document.getElementById('rDate').value = current_date;  	
  	}
	function initiateOrder(arg)
	{
	    $.ajax({
	        type: 'GET',
	        url: "{{ URL:: to('/') }}/updateStatusReq",
	        data:{id:arg},
	        async:false,
	        success: function(response)
	        {
	            console.log(response);
	            document.getElementById('status-'+arg).innerHTML = 'Order Initiated';
	            alert('Enquiry Initiated !!');
	        }
	    });
	    return false;
	}
	function calculate(){
	var price = parseInt(document.getElementById("uPrice").value);
	var qnty = parseInt(document.getElementById("quantity").value);
		if(document.getElementById("uPrice").value != "" && document.getElementById("quantity").value != ""){
			var total = price * qnty;
			document.getElementById("total").value = total;
		}
	}
	function show(){
		document.getElementById("req").className = "hidden"
		document.getElementById("add").className = "";
		document.getElementById("btn2").className = "pull-right btn btn-sm btn-success";
		document.getElementById("btn1").className = "hidden";

	}
	function hide(){
		document.getElementById("add").className = "hidden";
	 	document.getElementById("req").className = "";
		document.getElementById("btn1").className = "pull-right btn btn-sm btn-success";
		document.getElementById("btn2").className = "hidden";
	}
	var count = 0;
	function getBrands(id,category_name){
		var e = id;
		
	    $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/getBrands",
            async:false,
            data:{cat : e}, 
            success: function(response)
            {
                console.log(response);
                var ans = document.getElementById('brand').innerHTML;
                var name = category_name;
                
               	if(response[0].length != 0){ 
                ans += "<div class='col-md-4'>"+name+"<br>";
                count++;
                for(var i=0;i<response[0].length;i++)
                {
                    ans += "<input type='checkbox' onchange='getSubCat()' value='"+response[0][i].id+"'>"+response[0][i].brand+"<br>";
                }
               
                
	                ans += "</div>";
	                if(count == 3){ 
	                	ans += "<br><hr><hr><hr>";
	                	count =0;
	                }
                }
                document.getElementById('brand').innerHTML = ans;

            }
        });
	}
</script>
@endsection
