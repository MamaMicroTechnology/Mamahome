<?php
  $user = Auth::user()->group_id;
  $ext = ($user == 4? "layouts.amheader":"layouts.app");
?>
@extends($ext)
@section('content')

<div class="container">
    <div class="col-md-12">
    <div class="panel panel-default" style="border-color:rgb(244,129,31);text-align: center;">
                    <div class="panel-heading" style="background-color:rgb(244,129,31);color:white;">Begin adding the products by category and brand followed by sub-category</div>
    
                <td style=""></td>
     </div>      
</div>
</div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="panel panel-default" style="border-color:green;">
                    <div class="panel-heading" style="background-color:green;color:white;">Category</div>
                    <div class="panel-body" style="height:400px; max-height: 400px; overflow-y: scroll;">
                        <form method="post" action="{{ URL::to('/') }}/addCategory">
                            {{ csrf_field() }}
                            <div class="col-md-4">
                                <input required type="text" placeholder="Category" name="category" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" required name="measurement">
                                    <option value="" disabled selected>-Select-</option>
                                    <option value="Ton">Ton</option>
                                    <option value="Bags">Bags</option>
                                    <option value="No">No</option>
                                    <option value="Sq.ft">Sq. Ft</option>
                                    <option value="Ltr.">Ltr</option>
                                    <option value="Meter">Meter</option>
                                    <option value="CUM">CUM</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Save" class="form-control btn btn-primary">
                            </div>
                        </form>
                        <br><br>
                        <table class="table table-hover">
                            <tr>
                            <td>Category</td>
                            <td>Action</td>
                            </tr>
                            @foreach($categories as $category)
                            <tr id="current{{ $category->id }}">
                                <td>{{ $category->category_name }}</td>
                                <td>
                                <form method="POST" action="{{ URL::to('/') }}/deleteCategory">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $category->id }}" name="id">
                                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                </form>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="editcategory('{{ $category->id }}')">Edit</button>
                                </td>
                            </tr>
                            <tr class="hidden" id="edit{{ $category->id }}">
                                
                                <td colspan=3>
                                <form method="POST" action="{{ URL::to('/') }}/updateCategory">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $category->id }}" name="id">
                                    <div class="input-group">
                                        <input type="text" name="name" value="{{ $category->category_name }}" class="form-control input-sm">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-success" type="submit">Save</button>
                                        </div>
                                    </div>
                                </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="panel panel-default" style="border-color:green;">
                    <div class="panel-heading" style="background-color:green;color:white;">Brand</div>
                    <div class="panel-body" style="height:400px; max-height: 400px; overflow-y: scroll;">
                        <form method="post" action="{{ URL::to('/') }}/addBrand">
                            {{ csrf_field() }}
                            <div class="col-md-4">
                                <select name="cat" class="form-control">
                                    <option value="">--Category--</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input required type="text" placeholder="Brand" name="brand" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Save" class="form-control btn btn-primary">
                            </div>
                        </form>
                        <br><br>
                        <table class="table table-hover">
                            <tr>
                            <td>Category</td>
                            <td>Brand</td>
                            <td>Action</td>
                            </tr>
                            @foreach($brands as $brand)
                            <tr id="currentb{{ $brand->id }}">
                                <td>{{ $brand->category_name }}</td>
                                <td>{{ $brand->brand }}</td>
                                <td>
                                <form method="POST" action="{{ URL::to('/') }}/deletebrand">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $brand->id }}" name="id">
                                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                </form>
                                </td>
                                <td><button class="btn btn-sm btn-primary" onclick="editbrand('{{ $brand->id }}')">Edit</button></td>
                            </tr>
                             <tr class="hidden" id="editb{{ $brand->id }}">
                                
                                <td colspan=3>
                                <form method="POST" action="{{ URL::to('/') }}/updateBrand">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $brand->id }}" name="id">
                                    <div class="input-group">
                                        <input type="text" name="name" value="{{ $brand->brand }}" class="form-control input-sm">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-success" type="submit">Save</button>
                                        </div>
                                    </div>
                                </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default" style="border-color:green;">
                    <div class="panel-heading" style="background-color:green;color:white;">Sub Category
                        <button style="background-color:black" class="btn btn-xs  pull-right" data-toggle="modal" data-target="#addCategory"><span class="glyphicon glyphicon-plus"></span></button>
                    </div>
                    <div class="panel-body" style="height:400px; max-height: 400px; overflow-y: scroll;">
                        <table class="table table-hover">
                            <tr>
                            <td>Category</td>
                            <td>Brand</td>
                            <td>Sub Category</td>
                             <td>Action</td>
                            </tr>
                            @foreach($subcategories as $subcategory)
                            <tr id="currentsub{{ $subcategory->id }}">
                                <td>{{ $subcategory->category->category_name }}</td>
                                 <td>{{ $subcategory->brand }}</td>
                                 <td>{{ $subcategory->sub_cat_name }}</td>
                                <td>
                                    <form method="POST" action="{{ URL::to('/') }}/deleteSubCategory">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $subcategory->id }}" name="id">
                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                                <td><button class="btn btn-sm btn-primary" onclick="editsubcategory('{{ $subcategory->id }}')">Edit</button></td>
                            </tr>
                            <tr id="editsub{{ $subcategory->id }}" class="hidden">
                                <td colspan=3>
                                <form method="POST" action="{{ URL::to('/') }}/updateSubCategory">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $subcategory->id }}" name="id">
                                    <div class="input-group">
                                        <input type="text" name="name" value="{{ $subcategory->sub_cat_name }}" 
                                        class="form-control input-sm"><br><br>
                                        <input type="text" name="Quantity" value="{{ $subcategory->Quantity }}" 
                                        class="form-control input-sm" style="width: 50%">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-success" type="submit">Save</button>
                                        </div>
                                    </div>
                                </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<form method="post" action="{{ URL::to('/') }}/addSubCategory">
    {{ csrf_field() }}
  <div class="modal fade" id="addCategory" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#f4811f;color:white;fon-weight:bold">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Category</h4>
        </div>
        <div class="modal-body">
            <select class="form-control" required name="category" onchange="getBrands()" id="category">
                <option value="">-Select-</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
            </select><br>
            <select class="form-control" required name="brand" id="brand">
                
            </select><br>
            <input required type="text" placeholder="Sub Category" name="subcategory" class="form-control"><br>
            <input required type="text" placeholder="Minimum Quantity" name="Quantity" class="form-control" style="width:30%;">
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Add</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
</form>
<div class='b'></div>
<div class='bb'></div>
<div class='message'>
  <div class='check'>
    &#10004;
  </div>
  <p>
    Success
  </p>
  <p>
    @if(session('Success'))
    {{ session('Success') }}
    @endif
  </p>
  <button id='ok'>
    OK
  </button>
</div>
<script>
    function editcategory(arg){
        document.getElementById('current'+arg).className = "hidden";
        document.getElementById('edit'+arg).className = "";
    }
    function editbrand(arg){
        document.getElementById('currentb'+arg).className = "hidden";
        document.getElementById('editb'+arg).className = "";
    }
    function editsubcategory(arg){
        document.getElementById('currentsub'+arg).className = "hidden";
        document.getElementById('editsub'+arg).className = "";
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
</script>
@endsection