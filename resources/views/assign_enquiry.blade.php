<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 1? "layouts.teamheader":"layouts.app");
?>
@extends($ext)
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="border-color:#f4811f">
                <div class="panel-heading text-center" style="background-color:#f4811f"><b style="color:white;font-size:1.3em">Assign Enquiry</b>
                    @if(session('Error'))
                        <div class="alert-danger pull-right">{{ session('Error')}}</div>
                    @endif
                       <button type="button" onclick="history.back(-1)" class="bk-btn-triangle pull-right" style="margin-top:-10px;" > <i class="fa fa-arrow-circle-left" style="padding:5px;width:50px;color:black;"></i></button>   
                </div>
                <div class="panel-body">
                 
             <div class="panel-body">
    <form method="POST" name="myform" action="{{ URL::to('/') }}/enquirystore" enctype="multipart/form-data">

  {{ csrf_field() }}
             <table class="table table-responsive table-striped table-hover" class="table">
              
                        <thead>
                            <th style="width:15%">Name</th>
                            <th style="width:15%">Designation</th>
                            <th style="width:15%">Action </th>
                            <th></th>
                          </thead>
                          @if(Auth::user()->group_id != 22)
                          @foreach($users as $user)  
                           <tr>
                            <td>{{$user->name}}</td>
                            <td>{{ $user->group_name }}</td>
                           
                             <td><button onclick="makeUserId('{{ $user->id }}')" type="button" style="background-color: #00e676;color: white" data-toggle="modal" id="#myModal"  data-target="#myModal"  class="btn  pull-left">Assign</button></td>
                          </tr>         
                           @endforeach
                           @else
                            @foreach($tlUsers as $user)  
                           <tr>
                            <td>{{$user->name}}</td>
                            <td>{{ $user->group_name }}</td>
                            <td><button onclick="makeUserId('{{ $user->id }}')" type="button" style="background-color: #00e676;color: white" data-toggle="modal" id="#myModal"  data-target="#myModal"  class="btn  pull-left">Assign</button></td>
                          </tr>         
                           @endforeach
                           @endif



                          <input type="hidden" name="user_id" id="userId">
                   
                </table>
 <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background-color:#f4811f;color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select Ward and Category</h4>
      </div>
      <div class="modal-body" >
        <div id="first">
        <div id="wards">  
        <div class="row">
        @foreach($wards as $ward)
        <div class="col-sm-2">
          <label>
            <input  onclick="hide('{{ $ward->id }}')"  data-toggle="modal" data-target="#myModal{{ $ward->id }}" type="checkbox" value="{{ $ward->ward_name }}"  name="ward[]">&nbsp;&nbsp;{{ $ward->ward_name }}
          </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          </div>
        @endforeach
        </div>
    </div>
  </div>
  @foreach($wardsAndSub as $subward)
  <div id="subwards{{ $subward['ward'] }}" class="hidden">
    <h4 class="modal-title">Choose SubWard </h4>
    <span class="pull-right"><button id="back{{ $subward['ward'] }}" onclick="back('{{$subward['ward'] }}')" type="button" class="hidden">Back</button></span>
    <label class="checkbox-inline"><input id="check{{ $subward['ward'] }}" type="checkbox" name="sub" value="submit" onclick="checkall('{{$subward['ward']}}');">All</label>
    <br><br>    
    <div id="ward{{ $subward['ward'] }}">
      <div class="row"> 
        @foreach($subward['subwards'] as $subs)
        <div class="col-sm-2" >
          <label class="checkbox-inline">
            <input  type="checkbox"  name="subward[]" value="{{$subs->sub_ward_name}}">
            &nbsp;&nbsp;{{$subs->sub_ward_name}}
          </label>&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        @endforeach
      </div>
    </div>
  </div>
  @endforeach 
  <div class="row">
  <div class="col-md-12">
  <div class="col-md-2">
         <h4>&nbsp;&nbsp; Assign Date</h4>
          <input type="date" name="dateenq" class="form-control" style="width: 130%"> 
  </div>
  <div class="col-md-10">        
        <h4>&nbsp;&nbsp; Select Category</h4>
       @foreach($category as $cat)
         <div class="col-sm-6">
         <label>
       <input type="checkbox" id="cat{{ $cat->id }}" onclick = "displaybrand( {{ $cat->id }})"; style=" padding: 5px;" name="cat[]" value="{{$cat->category_name}}">&nbsp;&nbsp;{{$cat->category_name}}
        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       </div>
        @endforeach
  </div>
  </div>
</div>
</div>
<p class="text-center"><button onclick="return confirm('Are you sure you Select The Category');" type="submit" class="btn btn-primary">Submit Data</button></p>                                        
@foreach($category as $cat)
<div class="hidden" id="brand{{ $cat->id }}">
  @foreach($brands as $brand)
    @if($brand->category_id == $cat->id)
    <label>&nbsp;&nbsp;&nbsp;    
      <input data-toggle="modal" data-target="#myModal2" type="checkbox" id="sub_cat{{$brand->id}}" onclick="clickbrand( {{ $brand->id }} )"; name="brand[]" style=" padding: 5px;" value=" {{ $brand->brand}}">&nbsp;&nbsp;  {{ $brand->brand}} <span style="color:green;">[{{$cat->category_name}}]</span>
    </label>
    @endif
  @endforeach
</div>
@endforeach
</div>
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
  
@if(session('message'))
<script>
    swal("success","{{ session('message') }}","success");
</script>
@endif

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
  if(document.getElementById('check'+arg).checked == true){
    for (var i = 0; i < clist.length; ++i) 
    { 
      clist[i].checked = true; 
    }
  }else{
    for (var i = 0; i < clist.length; ++i) 
    { 
      clist[i].checked = false; 
    }
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
function submitassign(){
  alert();
    if(document.getElementById('cat').checked == true){
      alert("1");
       
    }else{
       alert("2");
    }
}
</script>  
<script>
    function clickbrand(arg){
        if(document.getElementById('sub_cat'+arg).checked == true){
            document.getElementById('sub'+arg).className = "";
        }
    }
    function makeUserId(arg){
      document.getElementById('userId').value = arg;
    }
</script>
