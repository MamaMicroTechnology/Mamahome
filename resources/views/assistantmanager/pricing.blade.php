@extends('layouts.amheader')
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
						<b>Add Category Details</b>
					</h4>
					<br>
					<form method="POST" action="{{ URL::to('/') }}/insertcat">
					    {{ csrf_field() }}
					    <!--<input type="hidden" name="id" id="id">-->
						<div style="margin-left:5%;margin-right: 5%">
							<table class="table table-responsive">
								<tr style="border-top-style: hidden">
									<td style="width:20%">
										<label> Category </label>
									</td>
									<td style="width:80%">
									    <select onchange="getSubcats()" class="form-control" name="id" id="category">
									        <option value="">--Select--</option>
									        @foreach($categories as $category)
									        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
									        @endforeach
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
                            <td style="width:30%">
                                <label>Select Sub Category : </label>
                            </td>
                            <td style="width:70%">
                                <select id="category1" onchange="getSubs()" class="form-control">
                                    <option>--Select Category--</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
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
                    <tbody id="sub">

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
	function getSubcats()
	{
	    var e = document.getElementById('category');
	    var cat = e.options[e.selectedIndex].value;
	    $("html body").css("cursor", "progress");
	    $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/getSubCatPrices",
            async:false,
            data:{cat : cat},
            success: function(response)
            {
                console.log(response);
                document.getElementById('measure').value = response[0].measurement_unit;
                var ans = '';
                for(var i=0;i<response[1].length;i++)
                {
                    ans += "<option value='"+response[1][i].id+"'>"+response[1][i].sub_cat_name+"</option>";
                }
                document.getElementById('subcategory').innerHTML = ans;
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
                    text += "<tr><td>"+response[1][i].sub_cat_name+"</td><td>"+response[0].measurement_unit+"</td><td>"+response[1][i].price+"</td></tr>";
                }
                document.getElementById('sub').innerHTML = text;
                $("body").css("cursor", "default");
            }
        });    
    }
</script>
@endsection