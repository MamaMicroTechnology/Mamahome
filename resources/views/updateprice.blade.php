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

<div class="col-md-12">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                GSTs
                <button type="button" class="btn btn-info btn-xs pull-right" data-toggle="modal" data-target="#myModal">Add/Edit GST</button>    
            </div>
            <div class="panel-body">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>SGST</th>
                            <th>CGST</th>
                            <th>IGST</th>
                        </tr>
                    </thead>
                    @foreach($gstvalue as $gs)
                    <tbody id="gsts">
                        <tr>
                            <td>{{$gs->category}}</td>
                            <td>{{$gs->sgst}}</td>
                            <td>{{$gs->cgst}}</td>
                            <td>{{$gs->igst}}</td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">GST</h4>
      </div>
      <div class="modal-body">
        <form action="{{ URL::to('/') }}/addGST" method="post">
            {{ csrf_field() }}
            <label for="myCategories">Categories</label>
            <select id="myCategories"  name="category" class="form-control">
                <option>--Select Category--</option>
                @foreach($categories as $category)
                <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
            <br>

            <div class="col-md-4">
                <label for="CGST">CGST(%)</label>
                <input type="text" name="cgst" placeholder="CGST" min=1 id="CGST" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="SGST">SGST(%)</label>
                <input type="text" name="sgst" placeholder="SGST" min=1 id="SGST" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="IGST">IGST(%)</label>
                <input type="text" name="igst" placeholder="IGST" min=1 id="IGST" class="form-control">
            </div>
            <div class="col-md-12">
            <br>
                <input type="submit" value="Save" class="btn btn-success form-control btn-sm">
            </div>
            <br>
            <br><br><br>
            <br><br><br>
        </form>
      </div>
      <div class="modal-footer clearfix">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

    
    function getBrands(){
        var e = document.getElementById('myCategories');
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
                document.getElementById('brands').innerHTML = ans;
                $("body").css("cursor", "default");
            }
        });
    }
    function getSubs()
    {
        var e = document.getElementById('myCategories');
        var f = document.getElementById('brands');
        var cat = e.options[e.selectedIndex].value;
        var brand = f.options[f.selectedIndex].value;
        $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/getSubCatPrices",
            async:false,
            data:{cat : cat, brand : brand},
            success: function(response)
            {
                console.log(response);1
                var ans = "<option value=''>--Select--</option>";
                for(var i=0;i<response[1].length;i++)
                {
                    ans += "<option value='" + response[1][i].id + "'>"+response[1][i].sub_cat_name+"</option>";
                }
                document.getElementById('subCategories').innerHTML = ans;
                $("body").css("cursor", "default");
            }
        });
    }
</script>
@endsection