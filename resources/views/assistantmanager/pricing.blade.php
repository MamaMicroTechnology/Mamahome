<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 8? "layouts.app":"layouts.amheader");
?>
@extends($ext)
@section('content')

<div class="col-md-12">
	<div class="col-md-6">
		<div class="panel panel-default" style="border-color:#f4811f">
			<div class="panel-heading text-center" style="background-color:#f4811f">
				<b style="color:white;font-size:1.3em">Add Information</b>
			</div>
			<div class="panel-body">
				<div id="addpage">
					<h4 style="text-align: center">
						<b>Add and Edit Category Details</b>
					</h4>
					<br>
					 @if(Auth::user()->group_id != 8)
					<form method="POST"  name="myform" action="{{ URL::to('/') }}/insertcat">
						@else
						<form method="POST" name="myform" action="{{ URL::to('/') }}/marketinginsertcat">
						@endif
					    {{ csrf_field() }}
					    <!--<input type="hidden" name="id" id="id">-->
						<div style="margin-left:5%;margin-right: 5%">
							<table class="table table-responsive">
								<tr style="border-top-style: hidden">
									<td style="width:20%">
										<label> Category </label>
									</td>
									<td style="width:80%">
									    <select onchange="getBrands()" class="form-control" name="id" id="category">
									        <option value="">--Select--</option>
									        @foreach($categories as $category)
									        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
									        @endforeach
									    </select>
									</td>
								</tr>
								<tr style="border-top-style: hidden">
									<td style="width:20%">
										<label> Brands </label>
									</td>
									<td style="width:80%">
									    <select onchange="getSubcats()" class="form-control" name="id" id="brand">
									        
									    </select>
									</td>
								</tr>
								<tr style="border-top-style: hidden">	
									<td style="width:20%">
										<label> Sub Category</label>
									</td>
									<td style="width:80%">
									    <select class="form-control" name="subcategory" id="subcategory" onchange="getPrice()">
									        
									    </select>
									    <input type="hidden" id='hiddeninput' />
									</td>
								</tr>
								<tr style="border-top-style: hidden">
									<td style="width:20%">
										<label> Measurement Unit </label>
									</td>
									<td style="width:80%">
										<input type="text" id="measure" readonly name="measure" class="form-control">
									</td>
								</tr>
								<tr style="border-top-style: hidden">
									<td style="width:20%">
										<label> Price </label>
									</td>
									<td style="width:80%">
										<input type="text" onkeyup="check('price')" name="price" id="price" class="form-control" placeholder="Amount" />
									</td>
								</tr>
								<tr style="border-top-style: hidden">
									<td style="width:20%">
										<label> GST </label>
									</td>
									<td style="width:80%">
										<input type="text" name="gst" id="gst" oninput="getgst()" class="form-control" placeholder="GST" />
									</td>
								</tr>
								<tr style="border-top-style: hidden">
									<td style="width:20%">
										<label> Transportation Cost </label>
									</td>
									<td style="width:80%">
										<input type="text" name="tc" id="tc" oninput="gettc()" class="form-control" placeholder="Transportation Cost" />
									</td>
								</tr>
								<tr style="border-top-style: hidden">
									<td style="width:20%">
										<label> Royalty </label>
									</td>
									<td style="width:80%">
										<input type="text" name="royalty" oninput="getroyalty()" id="royalty" class="form-control" placeholder="Roylaty (If any)" />
									</td>
								</tr>	
							</table>
							<br>
							<table class="table table-responsive">
								<tr style="border-top-style: hidden">
									<td style="width: 45%" class="text-right">
									<input type="submit" value="Submit" class="btn btn-md btn-success" name="submitbtn" id="submitbtn" style="width:60%;font-weight: bold" />
									</td>
									<td style="width: 45%">
									<input type="reset" value="Reset" name="resetbtn" id="resetbtn" class="btn btn-md btn-warning" style="width:60%;font-weight: bold" />
									</td>
								</tr>
							</table>
						</div>
						<br>		
					</form>
				</div>
			</div>
		</div>
	</div>
    <div class="col-md-6">
        <div class="panel panel-default" style="border-color:green">
            <div class="panel-heading text-center" style="background-color:green">
                <b style="color:white;font-size:1.3em">List of Categories</b>
            </div>
            <div class="panel-body">
                <table class="table table-responsive table-striped">
                    <tbody>
                        <tr>
                            <td style="width:20%">
                                <label>Select Category : </label>
                            </td>
                            <td style="width:30%">
                                <select id="category2" onchange="brands()" class="form-control">
                                    <option>--Select Category--</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width:20%">
                                <label>Select Brand : </label>
                            </td>
                            <td style="width:30%">
                                <select id="brands2" onchange="Subs()" class="form-control">
                                    
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div id='heading'></div>
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Sub-Category</th>
                            <th>Measurement Unit</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody id="sub2">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<script src="http://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        
    });
	
	function check(arg){
	    var input = document.getElementById(arg).value;
	    if(isNaN(input)){
	      	while(isNaN(document.getElementById(arg).value)){
	      	var str = document.getElementById(arg).value;
	      	str     = str.substring(0, str.length - 1);
	      	document.getElementById(arg).value = str;
	      	}
	    }
	    else{
	      	input = input.trim();
	      	document.getElementById(arg).value = input;
	    }
	    return false;
	}
	function edit(arg){
	    var initial = document.getElementById(arg);
	    var getdetails = initial.getElementsByTagName("td");
	    var category = getdetails[0].innerText;
	    var subcategory = getdetails[1].innerText;
	    var measure = getdetails[2].innerText;
	    var price = getdetails[3].innerText;
	    document.getElementById('category').value = category;
	    document.getElementById('subcategory').value = subcategory;
	    document.getElementById('price').value = price;
	    document.getElementById('measure').value = measure;
	    document.getElementById('id').value = arg;
	}
	function Subs()
	{
	    var e = document.getElementById('category2');
	    var f = document.getElementById('brands2');
	    var cat = e.options[e.selectedIndex].value;
	    var brand = f.options[f.selectedIndex].value;
	    $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/getSubCatPrices",
            async:false,
            data:{cat : cat, brand : brand},
            success: function(response)
            {
                console.log(response);
                var ans = "";
                for(var i=0;i<response[1].length;i++)
                {
                    ans += "<tr><td>"+response[1][i].sub_cat_name+"</td><td>"+response[0].measurement_unit+"</td><td>"+response[1][i].price+"</td></tr>";
                }
                document.getElementById('sub2').innerHTML = ans;
                $("body").css("cursor", "default");
            }
        });
	}
	function getSubcats()
	{
	    var e = document.getElementById('category');
	    var f = document.getElementById('brand');
	    var cat = e.options[e.selectedIndex].value;
	    var brand = f.options[f.selectedIndex].value;
	    $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/getSubCatPrices",
            async:false,
            data:{cat : cat, brand : brand},
            success: function(response)
            {
                console.log(response);
                document.getElementById('measure').value = response[0].measurement_unit;
                var ans = "<option value=''>--Select--</option>";
                for(var i=0;i<response[1].length;i++)
                {
                    ans += "<option value='"+response[1][i].id+"'>"+response[1][i].sub_cat_name+"</option>";
                }
                document.getElementById('subcategory').innerHTML = ans;
                $("body").css("cursor", "default");
            }
        });
	}
	function getBrands(){
		var e = document.getElementById('category');
	    var cat = e.options[e.selectedIndex].value;
	    $("html body").css("cursor", "progress");
	    $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/getBrands",
            async:false,
            data:{cat : cat},
            success: function(response)
            {
                console.log(response);
                var ans = "<option value=''>--Select--</option>";
                for(var i=0;i<response[0].length;i++)
                {
                    ans += "<option value='"+response[0][i].id+"'>"+response[0][i].brand+"</option>";
                }
                document.getElementById('brand').innerHTML = ans;
                $("body").css("cursor", "default");
            }
        });
	}
	function brands(){
		var e = document.getElementById('category2');
	    var cat = e.options[e.selectedIndex].value;
	    $("html body").css("cursor", "progress");
	    $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/getBrands",
            async:false,
            data:{cat : cat},
            success: function(response)
            {
                console.log(response);
                var ans = "<option value=''>--Select--</option>";
                for(var i=0;i<response[0].length;i++)
                {
                    ans += "<option value='"+response[0][i].id+"'>"+response[0][i].brand+"</option>";
                }
                document.getElementById('brands2').innerHTML = ans;
                $("body").css("cursor", "default");
            }
        });
	}
	function getPrice()
	{
	    var e = document.getElementById('category');
	    var cat = e.options[e.selectedIndex].value;
	    var sube = document.getElementById('subcategory');
	    var subcat = sube.options[sube.selectedIndex].value;
	    $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/getPrice",
            async:false,
            data:{cat : cat, subcat: subcat },
            success: function(response)
            {
                document.getElementById('price').value = response.price;
                document.getElementById('gst').value = response.gst;
                document.getElementById('tc').value = response.transportation_cost;
                document.getElementById('royalty').value = response.royalty;
            }
	    });
	    return false;
	}
	function getSubs()
    {
        var e = document.getElementById('category1');
        var cat = e.options[e.selectedIndex].value;
        var name = e.options[e.selectedIndex].text;
        document.getElementById('heading').innerHTML = "<b style='font-size:1.3em;'>List of Sub-categories for : "+name+"</b><hr>";
        document.getElementById('sub').innerHTML = "Loading subcategories...";
        $("html body").css("cursor", "progress");
        $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/amgetSubCatPrices",
            async:false,
            data:{cat : cat},
            success: function(response)
            {
                var text = "";
                for(var i=0; i < response[1].length; i++)
                {
                    text += "<tr><td>"+response[1][i].sub_cat_name+"</td><td>"+response[0].measurement_unit+"</td><td>"+response[1][i].price+"</td><td>"+response[1][i].gst+"</td><td>"+response[1][i].transportation_cost+"</td><td>"+response[1][i].royalty+"</td></tr>";
                }
                document.getElementById('sub').innerHTML = text;
                $("body").css("cursor", "default");
            }
        });    
    }

</script>
<script type="text/javascript">
	 function getgst()
	{
		var gsts=document.myform.gst.value;
			if(isNaN(gsts)){
				document.getElementById('gst').value="";
				myform.gst.focus();
		     }
	}
	function gettc()
	{
		var tcs=document.myform.tc.value;
			if(isNaN(tcs)){
				document.getElementById('tc').value="";
				myform.tc.focus();
		     }
	}
	function getroyalty()
	{
		var royaltys=document.myform.royalty.value;
			if(isNaN(royaltys)){
				document.getElementById('royalty').value="";
				myform.royalty.focus();
		     }
	}
</script>
@endsection