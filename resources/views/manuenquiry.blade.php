<?php
$user = Auth::user()->group_id;
$ext = ($user == 4? "layouts.amheader":"layouts.app");
?>
@extends($ext)
@section('content')
<div class="col-md-12">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default" style="border-color: #f4811f">
<div class="panel-heading" style="background-color: #f4811f;text-align:center">
<b style="font-size: 1.3em;color:white;">Enquiry Sheet</b>
<br><br>
</div>
<div class="panel-body">
<form method="POST" id="sub" name="myform" action="{{URL::to('/')}}/manuinputdata">
{{csrf_field()}}
@if(SESSION('success'))
<div class="text-center alert alert-success">
<h3 style="font-size:1.8em">{{SESSION('success')}}</h3>
</div>
@endif
@if(session('NotAdded'))
<div class="alert alert-danger alert-dismissable">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
{{ session('NotAdded') }}
</div>
@endif
<table class="table table-responsive table-hover">
<tbody>
<tr>
<td style="width:30%"><label> Requirement Date* : </label></td>
<td style="width:70%"><input  type="date" name="edate"
id="edate" class="form-control" style="width:30%" required="" /></td>
</tr>
<tr>
@if(!isset($_GET['projectId']))
<td><label>Contact Number* : </label></td>
<td><input required type="text" name="econtact" id='econtact'
maxlength="10" onkeyup="check('econtact')" onblur="getProjects()"
placeholder="10 Digits Only" class="form-control" /><div
id="error"></div></td>
@else
<td><label>Contact Number: </label></td>
<td >{{ $projects->proc !=
NULL?$projects->proc->contact:$projects->contact_no }}</td>
@endif
</tr>
<!-- <tr>
<td><label>Name* : </label></td>
<td><input required type="text" name="ename" id="ename"
class="form-control"/></td>
</tr> -->
<tr>
@if(!isset($_GET['projectId']))

<td><label>Manufacturer ID : </label></td>
<td >
<input type="hidden" value="{{ $projects->id }}" name="manu_id">
<input type="hidden" value="{{ $projects->sub_ward_id }}" name="sub_ward_id">

{{ $projects->id }}</td>
@endif
</tr>
<!-- model end -->
@if(Auth::user()->group_id == 6 || Auth::user()->group_id == 7 ||  Auth::user()->group_id == 11 || Auth::user()->group_id == 17)
<tr>
    <td><label>Initiator* : </label></td>
    <td>
        <select required class="form-control" name="initiator">
            <option value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
        </select>
    </td>
</tr>
@else
<tr>
    <td><label>Initiator* : </label></td>
    <td>
    <select required class="form-control" name="initiator">
    <option value="">--Select--</option>
    @foreach($users as $user)
    <option value="{{ $user->id }}">{{ $user->name }}</option>
    @endforeach
    </select>
    </td>
</tr>
@endif
<tr>
    <td><label>Location* : </label></td>
    <td>
    @if(isset($_GET['projectId']))
    <input type="text" value="{{ $projects->address!= Null ?
    $projects->address : '' }}" name="elocation"
    id="elocation" class="form-control" />
    @else
    <input type="text" name="elocation" id="elocation" class="form-control" />
    @endif
    </td>
</tr>

<tr>
    <td><label>Select Products* : </label></td>
    <td>
    <select  class="form-control" name="product"  id="product">
    <option value="">--Select--</option>
    <option value="CEMENT">CEMENT</option>
    <option value="SAND">SAND</option>
    <option value="AGGREGATES">AGGREGATES</option>
</select>
    </td>
</tr>

<tr>
    <td><label>Billing And Shipping Address : </label></td>
    <td><button required type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal4">
 Address
</button>
<!-- The Modal -->
<div class="modal" id="myModal4">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Billing And Shipping Address </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
       
        <label>Blling Adderss</label>
            <textarea required class="form-control" type="text" name="billadress" cols="70" rows="7" style="resize:none;">
        </textarea>
            
       <br>
        <label>Shipping Adderss &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><br><br>
        <div class="col-md-12">
            <div class="col-md-9">
               <label><input type="radio" name="name" id="ss" onclick="myfunction()">&nbsp;&nbsp;&nbsp;same Address</label><br><br>
            </div>
            
        </div>
        <label id="sp1">Shipping Adderss</label>
            <textarea  required class="form-control" id="sp" type="text" name="ship" cols="70" rows="7" style="resize:none;">
        </textarea>
           <script type="text/javascript">
               function myfunction(){
          
                document.getElementById('sp').style.display = "none";
                document.getElementById('sp1').style.display = "none";
               }


           </script> 
       <br>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Save</button>
      </div>
</div>

      <!-- Modal footer -->

    </div>
  </div>



    </td>
</tr>
<tr>
<tr>
            <td><label>Total Quantity : </label></td>
            <td><input type="text" onkeyup="checkthis('totalquantity')" name="totalquantity" placeholder="Enter Quantity In Only Numbers" id="totalquantity"  class="form-control" /></td>

</tr>
<td><label>Remarks :</label></td>
<td>
<textarea style="resize: none;" rows="4" cols="40" name="eremarks"
id="eremarks" class="form-control" /></textarea>
</td>
</tr>
</tbody>
</table>
<input type="hidden" id="measure" name="measure">
<div class="text-center">
<button type="button" name="" id="" class="btn btn-md btn-success"
style="width:40%" onclick="submitinputview()"  >Submit</button>
<input type="reset" name="" class="btn btn-md btn-warning" style="width:40%" />
</div>
</form>
</div>
</div>
</div>
</div>
<script src="http://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
function check(arg){
    var input = document.getElementById(arg).value;
    if(isNaN(input)){
               document.getElementById(arg).value = "";
    }
    document.getElementById('econtact').style.borderColor = '';
   
    if(input){
       
        if(isNaN(input)){
            
            while(isNaN(document.getElementById(arg).value)){
                var str = document.getElementById(arg).value;
                str = str.substring(0, str.length - 1);
                document.getElementById(arg).value = str;
            }
        }
    }
}


</script>
<script type="text/javascript">
function getquantity()
{
    var quan=document.myform.equantity.value;
    if(isNaN(quan)){
        document.getElementById('equantity').value="";
        myform.equantity.focus();
    }
}
</script>

<script>
function quan(arg){
    if(parseInt(document.getElementById('quan'+arg).value) < parseInt(document.getElementById('quantity'+arg).value)){
        alert("Minimum"+ document.getElementById('quantity'+arg).value + "quantity");
        document.getElementById('quan'+arg).value ="";
    }
}
</script>
<script>
function submitinputview(){
     if(document.getElementById("totalquantity").value == ""){
            window.alert("You Have Not Entered Total Quantity");
          }
      else if(document.getElementById("product").value == ""){
            window.alert("You Have Not Select Product");
          }else if(document.getElementById("edate").value == ""){
            window.alert("You Have Not Select date");
          }
        else{
            document.getElementById("sub").submit();
        }
}
</script>

@endsection

