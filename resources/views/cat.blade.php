@extends('layouts.app')

@section('content')
<div class="col-md-10 col-md-offset-2">
    <div class="col-md-10">
        <div class="panel panel-default" style="border-color:#337ab7">
            <div class="panel-heading text-center" style="background-color:#337ab7">
                <b style="color:white">Assign Category</b>
            </div>
            <div class="panel-body">
             <form action="{{ URL::to('/') }}/postcat" method="POST" enctype="multipart/form-data"> 
                    {{ csrf_field() }}
                <div class="col-md-2">
                 <h4><b>Select Category</b></h4>
                    <select id="category2" onchange="brands()" class="form-control" name="cat">
                        <option>--Select Category--</option>
                        @foreach($categories as $category)

                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- <div class="col-md-2">
                  <h4><b>Select Brand</b></h4>
                    <select id="brands2" onchange="Subs()" class="form-control" name="brand">
                        
                    </select>
                </div>
                 <div class="col-md-2">
                   <h4><b>Select Sub Category</b></h4>
                    <select id="sub2"  class="form-control" name="subcat">
                        
                    </select>
                </div>
                <div class="col-md-1">
                   <h4><b>Quantity</b></h4>
                    <input type="text" name="quan" class="form-control" required> 
                 </div>
                  <div class="col-md-2">
                   <h4><b>Team Leader Price</b></h4>
                    <input type="text" name="stl" class="form-control" required> 
                 </div>
                 <!--  <div class="col-md-2">
                   <h4><b>Asst-TLs Price</b></h4>
                    <input type="text" name="asstl" class="form-control" required> <br>
                 </div> --> 
                  <div class="col-md-2">
                   <h4><b>Select User</b></h4>
                    <select class="form-control" name="user_id">
                      <option value="">--Select User--</option>
                      @foreach($users as $user)
                      <option value="{{$user->id}}">{{$user->name}}</option>
                      @endforeach
                    </select>
                 </div> 


  
                  <div class="col-md-2">
                   
                    <button type="submit"  class="form-control btn btn-primary" value="submi" style="margin-top:40px;">Submit Data</button> 
                 </div> 

            </div>
            </form>
<table  class="table" border="1">
                <thead>
                    <tr>
                        <th>SLNO</th>
                        <th>User Name</th>
                        <th>Category</th>
                        <th>Created On</th>
                        <!-- <th>Designation</th> -->
                        <th>Updated On</th>
                      
                    </tr>
                </thead>

                <tbody>
                  <?php 
                  $i = 1;
                  ?>
                  @foreach($cat as $cate)
                  <td>{{$i++}}</td>
                  <td>{{ $cate->user != null ? $cate->user->name :''  }}</td>
                  <td>{{ $cate->category != null ? $cate->category->category_name :''  }}</td>
                  <td>{{$cate->created_at}}</td>
                  <td>{{$cate->updated_at}}</td>

                   </tbody>
                   @endforeach
                   </table>

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
                var ans = "<option value=''>--Select--</option>";

               
                for(var i=0;i<response[1].length;i++)
                {
                     ans += "<option value='"+response[1][i].id+"'>"+response[1][i].sub_cat_name+"</option>";
                   
                }
                document.getElementById('sub2').innerHTML = ans;
                $("body").css("cursor", "default");
            }
        });
    }
</script>
@endsection