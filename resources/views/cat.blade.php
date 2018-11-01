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
                    <select  class="form-control" name="cat"  required>
                        <option>--Select Category--</option>
                        @foreach($categories as $category)

                        <option value="{{ $category->id }}">{{ $category->category_name }}&nbsp;[&nbsp;&nbsp;Projects : &nbsp;{{$nofprojects[$category->id] }}&nbsp;&nbsp;Enquiries:&nbsp;&nbsp;{{$nofenquirys[$category->id]}}]</option>
                        @endforeach
                    </select>
                </div>
                  <div class="col-md-2">
                   <h4><b>Category Officers</b></h4>
                    <select required class="form-control" name="user_id" required>
                      <option value="">-- Category Officers--</option>
                      @foreach($users as $user)
                      <option value="{{$user->id}}">{{$user->name}}</option>
                      @endforeach
                    </select>
                 </div> 

               <div class="col-md-4">
                   <h4><b>Set Instructions</b></h4>
                   <textarea type="text" name="ins" style="width:100%;">
                     
                   </textarea>
                 </div> 
  
                  <div class="col-md-2">
                   
                    <button type="submit"  class="form-control btn btn-primary" value="submi" style="margin-top:40px;">Assign</button> 
                 </div> 

            </div>
            </form>
<table  class="table" border="1">
                <thead>
                    <tr>
                        <th>SLNO</th>
                        <th>Category Officer Name</th>
                        <th>Category</th>
                        <th>Previous Category</th>
                        <th>Created On</th>
                        <th>Updated On</th>
                        <th>Instructions</th>

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
                  <td>{{ $cate->prev }}</td>
                  <td>{{$cate->created_at->format('d-m-Y') }}</td>
                  <td>{{$cate->updated_at->format('d-m-y')}}</td>
                  <td>{{$cate->instraction}}</td>
                  
                    
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

</script>
@endsection