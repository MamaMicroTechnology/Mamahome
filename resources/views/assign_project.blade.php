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
                 
             <div class="panel-body">
             <table class="table table-responsive table-striped table-hover" class="table">
                        <thead>
                            <th style="width:15%">Name</th>
                            <th style="width:15%">Designation</th>
                            <th style="width:15%">Previously Assigned Wards </th>
                            <th style="width:15%">Previously Assigned Sub Ward </th>
                            <th style="width:15%">Previously Assigned Date </th>
                            <th style="width:15%">Previously Assigned Stage </th>
                           <th style="width:15%">Action </th>
                            <th></th>
                          </thead>
                          @foreach($users as $user)  
                           <tr>
                            <td>{{$user->name}}</td>
                            <td>{{ $user->group_name }}</td>
                           
                            <input type="hidden"  name="user_id" value="{{ $user->id }}">
                             <td>{{ $user->prv_ward }}</td>
                             <td>{{ $user->prv_subward }}</td>
                             <td>{{ $user->prv_date }}</td>
                             <td>{{ $user->prv_stage }}</td>
                             <td><button onclick="makeUserId('{{ $user->id }}')" type="button"  data-toggle="modal" id="#myModal"  data-target="#myModal"  class="btn btn-success pull-left">Assign</button></td>
                          </tr>         
                           @endforeach
                   
                </table>
           

<form method="POST" name="myform" action="{{ URL::to('/') }}/projectstore" enctype="multipart/form-data">
  {{ csrf_field() }}
  <input type="hidden" id="userId" name="user_id">
 <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background-color: rgb(244, 129, 31);">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Choose Wards</h4>
      </div>
      <div class="modal-body">
        <div id="first">
        <div id="wards">
        @foreach($wards as $ward)
          <label>
            <input  onclick="hide('{{ $ward->id }}')"  style=" padding: 5px;" data-toggle="modal" data-target="#myModal{{ $ward->id }}" type="checkbox" value="{{ $ward->ward_name }}"  name="ward[]">&nbsp;&nbsp;{{ $ward->ward_name }}
          </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        @endforeach
        </div>
        </div>
          @foreach($wards as $ward)
          <div id="subwards{{ $ward->id }}" class="hidden">
            <h4 class="modal-title">Choose SubWard </h4>
            <input type="checkbox" name="sub" value="submit" onclick="checkall('{{$ward->id}}');">All
         
          <br>    
          <div id="ward{{ $ward->id }}">
              @foreach($subwards as $subward)
              @if($subward->ward_id == $ward->id)
                    <label>
                      
                      <input  type="checkbox"  name="subward[]" value="{{$subward->sub_ward_name}}">
                      &nbsp;&nbsp;{{$subward->sub_ward_name}}

                    </label>&nbsp;&nbsp;&nbsp;&nbsp;
              @endif
              @endforeach
          </div>
              
          </div>
          <button id="back{{ $ward->id }}" onclick="back('{{$ward->id }}')" type="button" class="hidden">Back</button>
          @endforeach
          <div class="page">
            <!-- Assign stages  -->
            <div id="second" class="hidden">
                 <div class="container">
                     <div class="row">
                       <div class="col-sm-12"> 
                       <h3 style="color:#398439;">Assign Stage</h3>&nbsp;&nbsp;&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;     <input id="selectall" onClick="selectAll(this)" type="checkbox" value="ALL"><span style="color:orange;font-size:15px">&nbsp;&nbsp; ALL</span>
                          <table>
                             <tr id="sp">
                             <div class="checkbox">
                            <lable><td style=" padding:20px 40px 20px 40px;" ><input type="checkbox" name="stage[]" value="Planning">&nbsp;&nbsp;Planning</td>
                                 <td  style=" padding:20px 40px 20px 40px;"><input type="checkbox" name="stage[]" value="Digging">&nbsp;&nbsp;Digging</td>
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
                    </div>

            <div class="row">
              <div class="col-sm-6">  
              <h3 style="color:#398439;">Project Listed date</h3>

              <input style="width:40%;" type="date" name="assigndate" class="form-control input-sm" id="datepicker">
              </div>
            </div> <br>                                                      
            <h3 style="color:#398439;">Project Type </h3>
            <div class="row">
            <div class="col-md-2">
            <h5 style="color:#398439;">Basement</h5>
                 <input  name="basement" type="text" autocomplete="off" class="form-control input-sm" placeholder="Basement" id="email">
                 </div>
                                                  
               <div class="col-md-2">
                <h5 style="color:#398439;">Ground</h5>
                <input name="Floor"  type="text" class="form-control" placeholder="Floor">
               </div>
               <div class="col-md-3">
               <h5 style="color:#398439;">Total</h5>
               <input  name="project_type"    type="text" class="form-control" placeholder="total">
              </div>
            </div>
              <div class="row">
              <div class="col-sm-3">
              <h3 style="color:#398439;">Project Size</h3>
              <input type="text" class="form-control" name="project_size" placeholder="Project Size in sq ft">
              </div>
              <div class="col-sm-3">
              <h3 style="color:#398439;">Budget </h3>
              <input type="text" class="form-control" name="budget" placeholder="Budget Min 10lac">
              </div>
              <div class="col-sm-3">
                <h3 style="color:#398439;">Contract</h3>
                <select class="form-control" name="contract_type" id="contract" >
                    <option   value="" disabled selected>--- Select ---</option>
                    <option    value="Labour Contract">Labour Contract</option>
                    <option  value="Material Contract">Material Contract</option>
                </select>
              </div>
              </div><br><br>
                <div class="row">
                    <div class="col-sm-4">
                      <h3 style="color:#398439;">Contraction Type</h3>
                      <label required class="checkbox-inline"><input id="constructionType1" name="constraction_type[]" type="checkbox" value="Residential">&nbsp;&nbsp;Residential</label><br>
                      <label required class="checkbox-inline"><input id="constructionType2" name="constraction_type[]" type="checkbox" value="Commercial">&nbsp;&nbsp;Commercial</label> 
                    </div> 
                  <div class="col-sm-3">
                    <h3 style="color:#398439;">RMC </h3>      
                    <label><input id="rmc" type="radio" name="rmc" value="Yes">&nbsp;&nbsp;&nbsp;&nbsp;Yes</label><br>
                    <label><input id="rmc2" type="radio" name="rmc" value="No">&nbsp;&nbsp;&nbsp;&nbsp;No</label>
                  </div>
                  <div class="col-sm-3">
                    <h3 style="color:#398439;">Budget Type </h3>
                    <label required class="checkbox-inline"><input id="constructionType3" name="budget_type[]" type="checkbox" value="Structural">&nbsp;&nbsp;Structural</label><br>
                    <label required class="checkbox-inline"><input id="constructionType4" name="budget_type[]" type="checkbox" value="Finishing">&nbsp;&nbsp;Finishing </label>     
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
alert(clist);
for (var i = 0; i < clist.length; ++i) 
{ 
  clist[i].checked = "checked"; 
  }
  
}
</script>