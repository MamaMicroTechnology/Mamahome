@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="border-color:#f4811f">
                <div class="panel-heading text-center" style="background-color:#f4811f"><b style="color:white;font-size:1.3em">Assign Enquiry</b>
                    @if(session('Error'))
                        <div class="alert-danger pull-right">{{ session('Error')}}</div>
                    @endif
                     <a href="javascript:history.back()" class="btn btn-sm btn-danger pull-right">Back</a>    
                </div>
                <div class="panel-body">
                 
             <div class="panel-body">
    <form method="POST" name="myform" action="{{ URL::to('/') }}/enquirystore" enctype="multipart/form-data">
             <table class="table table-responsive table-striped table-hover" class="table">
                        <thead>
                            <th style="width:15%">Name</th>
                            <th style="width:15%">Designation</th>
                            <th style="width:15%">Action </th>
                            <th></th>
                          </thead>
                          @foreach($users as $user)  
                           <tr>
                            <td>{{$user->name}}</td>
                            <td>{{ $user->group_name }}</td>
                           
                             <td><button onclick="makeUserId('{{ $user->id }}')" type="button" style="background-color: #00e676;color: white" data-toggle="modal" id="#myModal"  data-target="#myModal"  class="btn  pull-left">Assign</button></td>
                          </tr>         
                           @endforeach
                   
                </table>
  {{ csrf_field() }}
  <input type="hidden" id="userId" name="user_id">
 <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background-color: rgb(244, 129, 31);padding:5px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Select Wards and category's</h4>
      </div>
      <div class="modal-body" >
        <div id="first">
        <div id="wards">  
        <div class="row">
        @foreach($wards as $ward)
        <div class="col-sm-2">
          <label>
            <input  onclick="hide('{{ $ward->id }}')"  style=" padding: 5px;" data-toggle="modal" data-target="#myModal{{ $ward->id }}" type="checkbox" value="{{ $ward->ward_name }}"  name="ward[]">&nbsp;&nbsp;{{ $ward->ward_name }}
          </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          </div>
                            <input type="hidden"  name="user_id" value="{{ $user->id }}">
        @endforeach
        </div>
    </div>
        </div>

         @foreach($wards as $ward)
          <div id="subwards{{ $ward->id }}" class="hidden">
            <h4 class="modal-title">Choose SubWard </h4>
          <span class="pull-right"><button id="back{{ $ward->id }}" onclick="back('{{$ward->id }}')" type="button" class="hidden">Back</button></span>
            <input type="checkbox" name="sub" value="submit" onclick="checkall('{{$ward->id}}');">All
         
          <br><br>    
          <div id="ward{{ $ward->id }}">
          <div class="row"> 
              @foreach($subwards as $subward)
              @if($subward->ward_id == $ward->id)
              <div class="col-sm-2" >
                    <label class="checkbox-inline">
                      
                      <input  type="checkbox"  name="subward[]" value="{{$subward->sub_ward_name}}">
                      &nbsp;&nbsp;{{$subward->sub_ward_name}}
                     </label>&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
              @endif
                   
              @endforeach
          </div>
          </div>
          </div>
          @endforeach
         <div class="row"> 
         <h4>Select Category</h4>
       @foreach($category as $cat)
      
         <div class="col-sm-4">
         <label>
       <input type="checkbox" id="cat{{ $cat->id }}" onclick = "displaybrand( {{ $cat->id }})"; style=" padding: 5px;" name="cat[]" value="{{$cat->category_name}}">&nbsp;&nbsp;{{$cat->category_name}}
        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       </div>
        @endforeach
        </div>
</div>
<center><button type="submit" class="btn btn-primary">Submit Data</button></center>                                        
@foreach($category as $cat)
<div class="hidden" id="brand{{ $cat->id }}">
       @foreach($brands as $brand)
       @if($brand->category_id == $cat->id)
       <label>&nbsp;&nbsp;&nbsp;    
         <input type="checkbox" id="sub_cat{{$brand->id}}" onclick="clickbrand( {{ $brand->id }} )"; name="brand[]" style=" padding: 5px;" value=" {{ $brand->brand}}">&nbsp;&nbsp;  {{ $brand->brand}}
       </label>
       @endif
       @endforeach
       </div>
@endforeach
 @foreach($brands as $brand)
<div class="hidden" id="sub{{ $brand->id }}">
       @foreach($sub as $subs)
       @if($brand->brand_id == $subs->brand_id)
       <label>&nbsp;&nbsp;&nbsp;    
         <input type="checkbox" name="sub[]"  style=" padding: 5px;" value=" {{ $subs->sub_cat_name}}">&nbsp;&nbsp;  {{ $subs->sub_cat_name}}
       </label>
       @endif
       @endforeach
   </div>
@endforeach
  </div>
</div>
</div> 
</form>   
</div>
  {{$users->links()}} 
  </div>
</div>
</div>
</div>
</div> 
   <!-- model -->
 @endsection          

 <script type="text/javascript">

function hide(arg){
  document.getElementById('wards').className = "hidden";
  document.getElementById('subwards'+arg).className = "";
  document.getElementById('back'+arg).className = "btn btn-primary pull-left";
}
function back(arg){
  document.getElementById('wards').className = "";
  document.getElementById('subwards'+arg).className = "hidden";
  document.getElementById('back'+arg).className = "hidden";
}
</script>



<script language="JavaScript">
  function selectAll(source) {
    checkboxes = document.getElementsByName('stage[]');
    for(var i in checkboxes)
      checkboxes[i].checked = source.checked;
  }
</script>

<script>
function checkall(arg){
var clist = document.getElementById('ward'+arg).getElementsByTagName('input');

for (var i = 0; i < clist.length; ++i) 
{ 
  clist[i].checked = "checked"; 
  }
  
}
</script>   
<script>
function displaybrand(arg){
    if(document.getElementById('cat'+arg).checked == true){
        document.getElementById('brand'+arg).className="";
    }else{
        document.getElementById('brand'+arg).className = "hidden";
    }
}
</script>  
<script>
    function clickbrand(arg){
        if(document.getElementById('sub_cat'+arg).checked == true){
            document.getElementById('sub'+arg).className = "";
        }
    }
</script>