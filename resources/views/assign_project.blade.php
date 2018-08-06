@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="border-color:#f4811f">
                <div class="panel-heading text-center" style="background-color:#f4811f"><b style="color:white;font-size:1.3em">Assign Project</b>
                    @if(session('Error'))
                        <div class="alert-danger pull-right">{{ session('Error')}}</div>
                    @endif
            
                     <a href="javascript:history.back()" class="btn btn-sm btn-danger pull-right">Back</a>
                    
                </div>
                <div class="panel-body">  
                     @if (session()->has('success'))
                    <center><h4 style="color:green;size:20px;">{{ session('success') }}</h4></center>
                    @endif
                 
             <div class="panel-body">
             <table class="table table-responsive table-striped table-hover" class="table">
                        <thead>
                            <th style="width:15%">Name</th>
                            <th style="width:15%">Designation</th>
                            <th style="width:15%">Previously Assigned Wards </th>
                            <th style="width:15%">Previously Assigned Sub Ward </th>
                            <th style="width:15%">Previously Assigned Date </th>
                            <th style="width:15%">Previously Assigned Stage </th>
                            <th style="width:15%">Count Of Projects</th>
                           <th style="width:15%">Action </th>
                           <th></th>

                           <th style="width:15%">Status </th>
                            
                          </thead>
                           <tr>
                          @if(Auth::user()->group_id != 22)
                          @foreach($users as $user)  
                            <td>{{$user->name}}</td>
                            <td>{{ $user->group_name }}</td>
                           
                            <input type="hidden"  name="user_id" value="{{ $user->id }}">
                             <td>{{ $user->prv_ward }}</td>
                             <td>{{ $user->prv_subward }}</td>
                             <td>{{ $user->prv_date }}</td>
                             <td>{{ $user->prv_stage }}</td>
                             <td>
                              @foreach($assignstage as $qq)
                              @if($user->id == $qq->user_id)
                                  {{ $qq->count }}
                             @endif
                             @endforeach
                             </td>
                             <td><button onclick="makeUserId('{{ $user->id }}')" type="button" style="background-color: #00e676;color: white" data-toggle="modal" id="#myModal"  data-target="#myModal"  class="btn  pull-left">Assign</button></td>
                             <td><button  type="button" style="background-color: #757575;color: white" data-toggle="modal" id="#myModal5"  data-target="#myModal5{{ $user->id }}"  class="btn  pull-left">Assign Time</button></td>
                              @foreach($assignstage as $qq)
                              @if($user->id == $qq->user_id)
                              @if($qq->remark != NULL)
                             <td><button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal{{$user->id }}">Reject</button></td>
                             @else
                             <td><button disabled class="btn btn-primary btn-sm ">Accept</button></td>
                             @endif
                             @endif
                            @endforeach
                         
                          </tr> 
 <!-- The Modal -->
<div class="modal" id="myModal{{$user->id}}">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header"  style="background-color:#f4811f;padding:2px">
        <h4 class="modal-title">Task Reject Message</h4>
        <button type="button" class="close" data-dismiss="modal>&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
         @foreach($assignstage as $qq)
         @if($user->id == $qq->user_id)
          
          <b style="font-size:20px;">Message:</b><br> <br>
          <span style="font-size:15px;text-align:left; font-style: bold;" > {{ $qq->remark }} </span>
         @endif
         @endforeach
      </div>

      <!-- Modal footer -->
      <div class="modal-footer" style="padding: 1px;">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
@endforeach
@else
 @foreach($tlUsers as $user)  
                            <td>{{$user->name}}</td>
                            <td>{{ $user->group_name }}</td>
                           
                            <input type="hidden"  name="user_id" value="{{ $user->id }}">
                             <td>{{ $user->prv_ward }}</td>
                             <td>{{ $user->prv_subward }}</td>
                             <td>{{ $user->prv_date }}</td>
                             <td>{{ $user->prv_stage }}</td>
                             <td>
                              @foreach($assignstage as $qq)
                              @if($user->id == $qq->user_id)
                                  {{ $qq->count }}
                             @endif
                             @endforeach
                             </td>
                             <td><button onclick="makeUserId('{{ $user->id }}')" type="button" style="background-color: #00e676;color: white" data-toggle="modal" id="#myModal"  data-target="#myModal"  class="btn  pull-left">Assign</button></td>
                             <td><button  type="button" style="background-color: #757575;color: white" data-toggle="modal" id="#myModal5"  data-target="#myModal5{{ $user->id }}"  class="btn  pull-left">Assign Time</button></td>
                              @foreach($assignstage as $qq)
                              @if($user->id == $qq->user_id)
                              @if($qq->remark != NULL)
                             <td><button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal{{$user->id }}">Reject</button></td>
                             @else
                             <td><button disabled class="btn btn-primary btn-sm ">Accept</button></td>
                             @endif
                             @endif
                            @endforeach
                         
                          </tr> 
 <!-- The Modal -->
<div class="modal" id="myModal{{$user->id}}">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header"  style="background-color:#f4811f;padding:2px">
        <h4 class="modal-title">Task Reject Message</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
         @foreach($assignstage as $qq)
         @if($user->id == $qq->user_id)
          
          <b style="font-size:20px;">Message:</b><br> <br>
          <span style="font-size:15px;text-align:left; font-style: bold;" > {{ $qq->remark }} </span>
         @endif
         @endforeach
      </div>

      <!-- Modal footer -->
      <div class="modal-footer" style="padding: 1px;">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
@endforeach
 @endif  
 </table>
    
    @foreach($users as $user)
<div class="modal" id="myModal5{{ $user->id }}">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header" style="background-color:#f4811f;padding:2px" >
          <h4 class="modal-title">Set Time And Instructions</h4>
          <button type="button" class="close" data-dismiss="modal" style="width:50%">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         <form action="{{ URL::to('/') }}/projectstore1" id="time" enctype="multipart/form-data" method="post" >
          {{ csrf_field() }}
           <input type="hidden"  name="user_id" value="{{ $user->id }}">
         <div class="container">
           <div class="row">
             <div class="col-sm-6">
             <b> Set Time  </b> <input type="time" name="settime" class="form-control" required style="width:50%"><br><br>
           <b>Instructions</b> <textarea type="text" name="inc" cols="5" rows="7" class="form-control"   style="width:90%;resize:none;"></textarea>
             </div>
           </div><br>
           <button type="submit" value="submit" id="time" onclick="submit()" class="btn btn-primary">Submit</button>
         </div>  


         </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>      
    @endforeach       

<form method="POST" name="myform" action="{{ URL::to('/') }}/projectstore" enctype="multipart/form-data">
  {{ csrf_field() }}
  <input type="hidden" id="userId" name="user_id">
 <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background-color: rgb(244, 129, 31);padding:5px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Choose Wards</h4>
      </div>
      <div class="modal-body">
        <div id="first">
        <div id="wards">  
        <div class="row">
        @foreach($wards as $ward)
        <div class="col-sm-2">
          <label>
            <input  onclick="hide('{{ $ward->id }}')"  style=" padding: 5px;" data-toggle="modal" data-target="#myModal{{ $ward->id }}" type="checkbox" value="{{ $ward->ward_name }}"  name="ward[]">&nbsp;&nbsp;{{ $ward->ward_name }}
          </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          </div>
        @endforeach
        </div>
        </div>
        </div>
         @foreach($wardsAndSub as $ward)
          <div id="subwards{{ $ward['ward'] }}" class="hidden">
            <h4 class="modal-title">Choose SubWard </h4>
            <label class="checkbox-inline"><input id="check{{ $ward['ward'] }}" type="checkbox" name="sub" value="submit" onclick="checkall('{{$ward['ward']}}');">All</label>
          <br><br>    
          <div id="ward{{ $ward['ward'] }}">
          <div class="row"> 
              @foreach($ward['subWards'] as $subward)
              <div class="col-sm-2" >
                    <label class="checkbox-inline">
                      
                      <input  type="checkbox"  name="subward[]" value="{{$subward->sub_ward_name}}">
                      &nbsp;&nbsp;{{$subward->sub_ward_name}}
                     </label>&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
              @endforeach
          </div>
          </div>
              
          </div>
          <button id="back{{ $ward['ward'] }}" onclick="back('{{$ward['ward'] }}')" type="button" class="hidden">Back</button>
          @endforeach
          <div class="page">
            <!-- Assign stages  -->
            <div id="second" class="hidden">
                 <div class="container">
                     <div class="row">
                       <div class="col-sm-12"> 
                       <h4 style="background-color:#9e9e9e;color:white;border: 1px solid gray;width:25%;font-family: Times;padding:5px;border-radius: 5px;">Assign Stage</h4><br>&nbsp;&nbsp;&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;&nbsp;      <input id="selectall" onClick="selectAll(this)" type="checkbox" value="ALL"><span style="font-size:15px">&nbsp;&nbsp; ALL</span><br><br>
                          <table>
                             <tr id="sp">
                             <div class="checkbox">
                            <lable><td style=" padding:0px 40px 0px 40px;" ><input type="checkbox" name="stage[]" value="Planning">&nbsp;&nbsp;Planning</td>
                                 <td  style=" padding:0px 40px 0px 40px;"><input type="checkbox" name="stage[]" value="Digging">&nbsp;&nbsp;Digging</td>
                                 <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Foundation">&nbsp;&nbsp;Foundation</td>
                                 <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Pillars">&nbsp;&nbsp;Pillars</td>
                                 <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Walls">&nbsp;&nbsp;Walls</td></lable>
                                 </div>
                             </tr>    
                               <tr id="sp">
                             <div class="checkbox">
                            <lable>     <td  style=" padding:20px 40px 20px 40px;"><input type="checkbox" name="stage[]" value="Roofing">&nbsp;&nbsp;Roofing</td>
                                 <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Electrical">&nbsp;&nbsp;Electrical</td>
                                 <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Plumbing">&nbsp;&nbsp;Plumbing</td>
                                 <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Plastering">&nbsp;&nbsp;Plastering</td>
                                 <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Flooring">&nbsp;&nbsp;Flooring</td></lable>
                                 </div>
                             </tr>  
                              <tr id="sp">
                             <div class="checkbox">
                            <lable>     <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Carpentry">&nbsp;&nbsp;Carpentry</td>
                                 <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Paintings">&nbsp;&nbsp;Paintings</td>
                                 <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Fixtures">&nbsp;&nbsp;Fixtures</td>
                                <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Completion">&nbsp;&nbsp;Completion</td>
                                 <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Closed">&nbsp;&nbsp;Closed</td></lable>
                                 </div>
                             </tr>    
                            </table>
                          </div>
                    </div><br>

            <div class="row">
              <div class="col-sm-6">  
              <h4 style="background-color:#9e9e9e;width: 50%; color:white;border: 1px solid gray;padding:5px;border-radius: 5px;">Project Listed date</h4>
              <input style="width:40%;" type="date" name="assigndate" class="form-control input-sm" id="datepicker">
              </div>
              <div class="col-sm-4">
               <h4 style="background-color:#9e9e9e;width: 50%; color:white;border: 1px solid gray;padding:5px;border-radius: 5px;">Select Quality</h4>
              <select style="width:40%;" class="form-control" name="quality">
                <option value="">--Select--</option>
                <option value="Unverified">Unverified</option>
                <option  value="Genuine">Genuine</option>
                <option value="Fake">Fake</option>
              </select>  
              </div>
            </div> <br>                                                      
            <h4 style="background-color:#9e9e9e; color:white;border: 1px solid gray;width:25%; padding:5px;border-radius: 5px;">Project Type </h4>

            <div class="row">
            <div class="col-md-2">
            <h5 style="color:black;">Basement From</h5>
                 <input  name="basement"  pattern="[0-9]+" title="Enter the number only" type="text"  class="form-control input-sm" placeholder="Basement" id="email">
            </div>
                  <div class="col-md-2">
                   <h5 style="color:black;">Basement To</h5>
                 <input  name="base" pattern="[0-9]+" title="Enter the number only" type="text"  class="form-control input-sm" placeholder="Basement" id="email">
                 </div>
                <div class="col-md-2">
                <h5 style="color:black;">Floor From</h5>
                <input name="Floor"  type="text" pattern="[0-9]+" title="Enter the number only" class="form-control" placeholder="Floor">
               </div>
               <div class="col-md-2">
                <h5 style="color:black;">Floor To</h5>
                <input name="Floor2"  type="text" pattern="[0-9]+" title="Enter the number only" class="form-control" placeholder="Floor">
               </div>
              </div>
              <div class="row">
               <div class="col-md-2">
               <h5 style="color:black;">Total From</h5>
               <input  name="project_type" pattern="[0-9]+" title="Enter the number only"   type="text" class="form-control" placeholder="total">
              </div>
               <div class="col-md-2">
               <h5 style="color:black;">Total To</h5>
               <input  name="total" pattern="[0-9]+" title="Enter the number only"   type="text" class="form-control" placeholder="total">
              </div>
              </div>
              <div class="row">
              <div class="col-sm-4">
              <h4 style="background-color:#9e9e9e; width: 50%; color:white;border: 1px solid gray;padding:5px;border-radius: 5px;">Project Size</h4>
              <div class="col-sm-6">
              <h5  style="color:black;">From</h5>
              <input type="text" class="form-control" pattern="[0-9]+" title="Enter the number only" name="project_size" placeholder="Project Size in sq ft">
              </div>
              <div class="col-sm-6">
              <h5 style="color:black;">To</h5>
              <input type="text" class="form-control" pattern="[0-9]+" title="Enter the number only" name="projectsize" placeholder="Project Size in sq ft">
              </div>
              </div>
              <div class="col-sm-4">
              <h4 style="background-color:#9e9e9e;width: 50%;color:white;border: 1px solid gray;padding:5px;border-radius: 5px;">Budget </h4>
              <div class="col-sm-6">
              <h5 style="color:black;">From</h5>
              <input type="text" class="form-control" pattern="[0-9]+" title="Enter the number only" name="budget" placeholder="Budget Min 10lac">
              </div>
              <div class="col-sm-6">
              <h5 style="color:black;">To</h5>
              <input type="text" class="form-control" pattern="[0-9]+" title="Enter the number only" name="budgetto" placeholder="Budget Min 10lac">
              </div>
              </div>
             <!--  <div class="col-sm-3">
                <h4 style="color:#398439;">Contract</h4>
                <select class="form-control" name="contract_type" id="contract" >
                    <option   value="" disabled selected>--- Select ---</option>
                    <option    value="Labour Contract">Labour Contract</option>
                    <option  value="Material Contract">Material Contract</option>
                </select>
              </div> -->
              </div><br><br>
                <div class="row">
                    <div class="col-sm-3">
                      <h4 style="background-color:#9e9e9e;color:white;border: 1px solid gray;padding:5px;border-radius: 5px;">Construction Type</h4>
                      <label required class="checkbox-inline"><input id="constructionType1" name="constraction_type[]" type="checkbox" value="Residential">&nbsp;&nbsp;Residential</label><br>
                      <label required class="checkbox-inline"><input id="constructionType2" name="constraction_type[]" type="checkbox" value="Commercial">&nbsp;&nbsp;Commercial</label> 
                    </div> 
                  <div class="col-sm-2">
                    <h4 style="background-color:#9e9e9e;color:white;border: 1px solid gray;padding:5px;border-radius: 5px;">RMC </h4>      
                    <label required class="checkbox-inline"><input id="rmc" type="checkbox" name="rmc[]" value="Yes">&nbsp;&nbsp;&nbsp;&nbsp;Yes</label><br>
                    <label required class="checkbox-inline"><input id="rmc2" type="checkbox" name="rmc[]" value="No">&nbsp;&nbsp;&nbsp;&nbsp;No</label>
                  </div>
                  <div class="col-sm-2">
                    <h4 style="background-color:#9e9e9e;color:white;border: 1px solid gray;padding:5px;border-radius: 5px;">Budget Type </h4>
                    <label required class="checkbox-inline"><input id="constructionType3" name="budget_type[]" type="checkbox" value="Structural">&nbsp;&nbsp;Structural</label><br>
                    <label required class="checkbox-inline"><input id="constructionType4" name="budget_type[]" type="checkbox" value="Finishing">&nbsp;&nbsp;Finishing </label>     
                  </div>  
                  <div class="col-sm-2">
                    <h4 style="background-color:#9e9e9e;color:white;border: 1px solid gray;padding:5px;border-radius: 5px;">Contract</h4>
                    <label required class="checkbox-inline"><input id="constructionType3" name="contract_type[]" type="checkbox" value="Labour Contract">&nbsp;&nbsp;Labour Contract</label><br>
                    <label required class="checkbox-inline"><input id="constructionType4" name="contract_type[]" type="checkbox" value="Material Contract">&nbsp;&nbsp;Material Contract </label>     
                  </div>    
                </div>
                </div><br><br>
                <center>
                  <button type="submit" id="submit" class="btn btn-success">Submit Data</button>
                </center>
              <!--  </form> -->                               
            </div>
          </div>
            <ul class="pager">
                <li id="prev" class="previous hidden"><a onclick="pagePrevious()" href="#">Previous</a></li>
                <li id="next" class="next"><a href="#" onclick="pageNext()">Next</a></li>
             </ul>
      <!-- <div class="modal-footer" style="background-color: rgb(21, 137, 66);">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> -->
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
@endsection

<script>
function makeUserId(arg){
  document.getElementById("userId").value = arg;
}
 var current = "first";
  function pageNext(){


         if(current == 'first')
        {
                document.getElementById("first").className = "hidden";
                document.getElementById("second").className = "";
                document.getElementById("prev").className = "previous";
                document.getElementById("next").className = "hidden";
                current = "second";
        }   
     else { 
            document.getElementById("second").className = "next";
            document.getElementById("third").className = "";
            current = "third";
            document.getElementById("prev").className = "hidden";
                document.getElementById("next").className = "hidden";
            // document.getElementById("next").className = "hidden";
          }
  
   } 
 
 function pagePrevious()
 {
        document.getElementById("next").className = "next";
        document.getElementById("prev").className = "previous";
         if(current == 'third'){
            document.getElementById("third").className = "hidden";
            document.getElementById("second").className = "";
            document.getElementById('headingPanel').innerHTML = 'Assign Stages';
            current = "second"
        }else if(current == 'second'){
            document.getElementById("second").className = "hidden";
            document.getElementById("first").className = "";
            document.getElementById('headingPanel').innerHTML = 'Assign Wards';
            current = "first"
        }
       else{
            document.getElementById("next").className = "disabled";
        }
      }
</script>



<style type="text/css">
  hr.style-two {
border: 0;
height: 0;
border-top: 1px solid rgba(0, 0, 0, 0.1);
border-bottom: 1px solid rgba(255, 255, 255, 0.3);
}
</style>
<script>
function check(arg){
    var input = document.getElementById(arg).value;
    if(input){
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
    if(arg == 'ground' || arg == 'basement'){
      var basement = parseInt(document.getElementById("basement").value);
      var ground   = parseInt(document.getElementById("ground").value);
      if(!isNaN(basement) && !isNaN(ground)){
        var floor    = 'B('+basement+')' + ' + G + ('+ground+') = ';
        sum          = basement+ground+1;
        floor       += sum;
      
        if(document.getElementById("total").innerHTML != null)
          document.getElementById("total").innerHTML = floor;
        else
          document.getElementById("total").innerHTML = '';
      }
    }
  }
    return false;
  }
</script>
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
    clist[i].checked = true; 
}else{
  for (var i = 0; i < clist.length; ++i) 
    clist[i].checked = false; 
}
  
}
function submit(){
  document.getElementById('time').submit();
}
</script>