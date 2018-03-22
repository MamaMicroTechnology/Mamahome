@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default" style="border-color:green">
            <div class="panel-heading text-center" style="background-color:green">
                <b style="color:white">List of Categories</b>
            </div>
            <div class="panel-body">
                <div class="col-md-4">
                    <select id="category2" onchange="brands()" class="form-control">
                        <option>--Select Category--</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select id="brands2" onchange="Subs()" class="form-control">
                        
                    </select>
                </div>
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

<script type="text/javascript">
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
</script>
@endsection