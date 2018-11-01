
@extends('layouts.app')
@section('content')   
    <div class="col-md-12">     
    <div class="col-md-12" >

    <div class="panel panel-default" style="overflow: scroll;">
            <div class="panel-heading" style="background-color:#158942;color:white;font-size:1.4em;">Total Project Count :  {{ $projects->total() }}
         <button type="button" onclick="history.back(-1)" class="bk-btn-triangle pull-right" style="margin-top:-7px;" > <i class="fa fa-arrow-circle-left" style="padding:5px;width:50px;color: black;"></i></button>
              
            </div>  
         <div class="panel-body" id="page">
       <table class="table table-hover table-striped">
                <thead>
                  <th>Project Name</th>
                  <th>Project Id</th>
                  <th style="width:15%">Address</th>
                 <th>Procurement Name</th>
                  <th>Contact No.</th>
                 <th>Action</th>
                 @if(Auth::user()->group_id == 23)
                <th>Customers Interested Categories</th>
                 <th>Project Visit</th>
                @endif
                 <th> Customer History</th>

               </thead>
                <tbody>
             <?php $ii=0; ?>
            @foreach($projects as $project)

            
                <tr>
                    <td id="projname-{{$project->project_id}}">{{ $project->project_name }}</td>
                                    <td  style="text-align:center"><a href="{{ URL::to('/') }}/admindailyslots?projectId={{$project->project_id}}&&lename={{ $project->name }}" target="_blank">{{ $project->project_id }}</a></td>
                    <td id="projsite-{{$project->project_id}}">
                                     <a target="_blank" href="https://maps.google.co.in?q={{ $project->siteaddress != null ? $project->siteaddress->address : '' }}">{{ $project->siteaddress != null ? $project->siteaddress->address : '' }}</a>
                                    </td>
                    <td id="projproc-{{$project->project_id}}">
                                        {{ $project->procurementdetails != NULL?$project->procurementdetails->procurement_name:'' }}
                                    </td>
                    <td id="projcont-{{$project->project_id}}"><address>{{ $project->procurementdetails != NULL?$project->procurementdetails->procurement_contact_no:'' }}</address></td>
                    
                   
                   
                     <td><form method="post" action="{{ URL::to('/') }}/confirmedProject" >
                                      {{ csrf_field() }}
                                      <input type="hidden" value="{{ $project->project_id }}" name="id">
                                      <div >
                                      <!-- <button  type="button" data-toggle="modal" data-target="#myModal{{ $project->project_id }}" class="btn btn-sm btn-warning " style="color:white;font-weight:bold;padding: 6px;width:80px;" id="viewdet({{$project->project_id}})">Edit</button> -->
                                      <a class="btn btn-sm btn-success " name="addenquiry" href="{{ URL::to('/') }}/requirements?projectId={{ $project->project_id }}" style="color:white;font-weight:bold;padding: 6px;">Add Enquiry</a>
                                      
                                      @if( $project->confirmed !== "0" ||  $project->confirmed == "true" )
                                   <button  type="button" id="demo"  style="padding: 5.5px;background-color:#e57373;color:white" class="btn btn-sm " {{ $project->confirmed !== "0" ||  $project->confirmed == "true" ? 'checked': ''}}  name="confirmed" onclick="this.form.submit()">Called
                                   <span class="badge">&nbsp;{{  $project->confirmed }}&nbsp;</span>
                                   </button>
                                  @endif
                                   @if( $project->confirmed == "0" ||  $project->confirmed == "false" )
                                   <button style="padding: 5.5px;background-color: #aed581;color:white" id="demo"  type="button" class="btn  btn-sm "  {{ $project->confirmed !== "0" ||  $project->confirmed == "true" ? 'checked': ''}}  name="confirmed" onclick="this.form.submit()">Called
                                    <span class="badge">&nbsp;{{  $project->confirmed }}&nbsp;</span>
                                   </button></div>
                                  @endif
                                  <button  type="button" data-toggle="modal" data-target="#myquestions{{ $project->project_id }}" class="btn btn-sm btn-warning " style="color:white;font-weight:bold;padding: 6px;width:80px;">Questions</button>
                                </form>
<!-- Modal -->  
<div id="myquestions{{ $project->project_id }}" class="modal fade" role="dialog">
  <div class="modal-dialog">
 <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color:rgb(245, 127, 27);color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Select The Questions</h4>
        </div>
        <div class="modal-body">
          <form method="get" action="{{ URL::to('/') }}/storequery ">
            {{ csrf_field() }}
           <input type="hidden" value="{{ $project->project_id }}" name="id">
          <table class="table table-responsive">
            <tr>

              <td><label>Questions :</label></td>
              <td>
                          <select required style="width: 100%" class="form-control" name="qstn">
                                    <option disabled selected>--- Select ---</option>
                                    <option value="NOT INTERESTED">NOT INTERESTED</option>
                                    <option  value="BUSY">BUSY</option>
                                    <option  value="WRONG NO">WRONG NO</option>
                                    <option  value="PROJECT CLOSED">PROJECT CLOSED</option>
                                    <option  value="CALL BACK LATER">CALL BACK LATER</option>
                                    <option value="THEY WILL CALL BACK WHEN REQUIRED">THEY WILL CALL BACK WHEN REQUIRED</option>
                                    <option value="CALL NOT ANSWERED">CALL NOT ANSWERED</option>
                                    <option value="FINISHING">FINISHING</option>
                                    <option  value="SWITCHED OFF">SWITCHED OFF</option>
                                    <option  value="SAMPLE REQUEST">SAMPLE REQUEST</option>
                                    <option  value="MATERIAL QUOTATION">MATERIAL QUOTATION</option>
                                    <option  value="WILL FOLLOW UP AFTER DISCUSSION WITH OWNER">WILL FOLLOW UP AFTER DISCUSSION WITH OWNER</option>
                                    <option  value="DUPLICATE NUMBER">DUPLICATE NUMBER</option>
                                    <option  value="NOT REACHABLE">NOT REACHABLE</option>
                                    <option  value="THEY HAVE REGULAR SUPPLIERS">THEY HAVE REGULAR SUPPLIERS</option>
                                    <option  value="CREDIT FACILITY">CREDIT FACILITY</option>
                                  </select>
                        </td>
                      </tr>
                      <tr>
                        <td><label>Call Remark : </label></td>
                        <td><textarea required style="resize: none;" class="form-control" placeholder="Remarks" name="remarks" ></textarea></td>
                      </tr>
                    </table>
       
      <button type="submit" class=" form-control btn btn-primary">Submit</button>
      </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal end -->
                            
                     

                    </td>
                    @if(Auth::user()->group_id == 23)
                   <td>
                      <button style="padding: 5.5px;background-color: #42c3f3 ;color: white" data-toggle="modal" data-target="#Customer{{ $project->project_id }}"   type="button" class="btn  btn-sm "  >
                                   Customers Interested Categories </button>

                    </td>
                    <td>
                    <form method="post"  action="{{ URL::to('/') }}/confirmedvisit" >
                                      {{ csrf_field() }}
                       <input type="hidden" name="id" value="{{$project->project_id}}">  
                       <input  type="hidden" name="longitude" value="{{ old('longitude') }}" id="longitude"> 
                                    <input  type="hidden" name="latitude" value="{{ old('latitude') }}" id="latitude">
                                    <input id="address" type="hidden" placeholder="Full Address" class="form-control input-sm" name="address" value="{{ old('address') }}">             
                    <button id="myform" style="padding:5.5px;background-color:#074e68;color:white" class="btn btn-sm" name="visit" onclick="getvisitLocation()">Visited
                                   <span class="badge">&nbsp;{{  $project->deleted }}&nbsp;</span>
                                   </button>
                    @endif
                  </form>
                </td>
                    <td>

                      <button style="padding: 5.5px;background-color: #757575 ;color: white" data-toggle="modal" data-target="#myModal1{{ $project->project_id }}"   type="button" class="btn  btn-sm "  >
                                   History </button>

                    </td>   
                  </tr>
@endforeach

</tbody>
</table>
@foreach($projects as $project)
 <!-- Modal -->
  <div class="modal fade" id="myModal1{{ $project->project_id }}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header  " style="background-color:#868e96;padding:5px; " >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"> Customer History </h4>
        </div>
        <div class="modal-body">
              <table class="table table-responsive">
                                      <tr>
                                        <td style="padding: 10px;" >Project Id</td>
                                        <td>:</td>
                                        <td style="padding: 10px;"> {{ $project-> project_id }}</td>
                                      </tr>           
                                      <tr>
                                         <td style="padding: 10px;" > Project Created At</td>
                                         <td>:</td>
                                         <td style="padding: 10px;">{{ date('d-m-Y', strtotime( $project->created_at)) }}</td>
                                          <td>
                                                {{ date('h:i:s A', strtotime($project->created_at)) }}
                                              </td>
                                       </tr>
                                        <tr>
                                           <td> Project Updated At</td>
                                           <td>:</td>
                                           <td >{{ date('d-m-Y', strtotime(  $project->updated_at)) }}</td>
                                            <td>
                                                  {{ date('h:i:s A', strtotime($project->updated_at)) }}
                                                </td>
                                       </tr>
                </table>

                              <table class="table table-responsive table-hover">
                                       <thead>
                                          <!-- <th>User_id</th> -->
                                          <th>No</th>
                                          <th>Called Date</th>
                                          <th>Called Time</th>
                                          <th>Name</th>
                                          <th>Question</th>
                                          <th>Call Remark</th>
                                       </thead>
                                       <tbody>
                                     <label>Call History</label>
                                         <?php $i=1 ?>
                                          @foreach($his as $call)
                                          @if($call->project_id == $project->project_id)
                                          <tr>
                                           <!--  <td>
                                              {{ $call->user_id }}
                                            </td> -->
                                           
                                            <td>{{ $i++ }}</td>
                                            <td>
                                              {{ date('d-m-Y', strtotime($call->called_Time)) }}
                                            </td>
                                            <td>
                                              {{ date('h:i:s A', strtotime($call->called_Time)) }}
                                            </td>
                                            <td>
                                             {{$call->username}}
                                            </td>
                                            <td>
                                              {{ $call->question }}
                                            </td>
                                            <td>
                                              {{ $call->remarks }}
                                            </td>
                                          </tr>
                                      @endif
                                       @endforeach
                                    </tbody>
                        </table>
                                      
        </div>
        <div class="modal-footer" style="padding:1px;">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
    </div>

@endforeach

</div>
        <div class="panel-footer">
                  @if(Auth::user()->group_id == 7)
        <center>{{ $projects->links() }}</center>
                  @else
                  <center>
                       <ul class="pagination">
                          {{ $projects->links() }}
                      </ul> 
                  </center>
                  @endif
         </div>
  </div>
 </div>
  </div>
@foreach($projects as $project)

  <div>
<form action="{{ URL::to('/') }}/addcat" method="POST"
enctype="multipart/form-data" >
        {{ csrf_field() }}
     <div class="modal fade" id="Customer{{ $project->project_id }}" role="dialog">
    <div class="modal-dialog">
      <input type="hidden" name="project_id" value="{{$project->project_id}}">
      <input type="hidden" name="user_id" value="{{Auth::user()->id}}">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header  " style="background-color:#42c3f3;padding:5px; " >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">  Customers Interested Categories </h4>
        </div>
        <div class="modal-body">
                  <div class="row">
                        <h4>&nbsp;&nbsp; Select Category</h4>
                       @foreach($category as $cat)
                         <div class="col-sm-4">
                         <label>
                       <input type="radio" id="cat{{ $cat->id }}"  style=" padding: 5px;" name="cat[]" value="{{$cat->category_name}}">&nbsp;&nbsp;{{$cat->category_name}}
                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       </div><br>
                        @endforeach
                        <textarea style="width:80%;" class="form-control" name="remark" placeholder="Please Enter Customers requirement Information With Quantity"></textarea><br>
                     <center>   <button type="submit" class="btn btn-primary btn-sm">submit Data</button></center>
                        </div>  
                        <table class="table table-responsive table-hover">
                                       <thead>
                                          <!-- <th>User_id</th> -->
                                          <th>No</th>
                                          <th>Date</th>
                                          <th style="width:160px;">Category Added By</th>
                                          <th>Interested Category</th>
                                          <th>Category Information</th>
                                          
                                       </thead>
                                       <tbody>
                                         <?php $i=1 ?>
                                          @foreach($sales as $call)
                                          @if($call->project_id == $project->project_id)
                                          <tr>
                                           <!--  <td>
                                              {{ $call->user_id }}
                                            </td> -->
                                           
                                            <td>{{ $i++ }}</td>
                                            <td>
                                              {{ date('d-m-Y', strtotime($call->created_at)) }}
                                            </td>
                                            <td>
                                            {{ $call->user != null ? $call->user->name :''  }}
                                            </td>
                                            <td>
                                              {{ $call->category }}
                                            </td>
                                            <td>
                                              {{ $call->remark }}
                                            </td>
                                          </tr>
                                      @endif
                                       @endforeach
                                    </tbody>
                        </table>      
        </div>
        <div class="modal-footer" style="padding:1px;">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
    </div>
</form>
</div>
@endforeach
    </div>  
<script type="text/javascript">

//  Reuben

function updatemat(arg)
    {
      var x = confirm('Are You Sure ?');
      if(x)
      {
        var e = document.getElementById('mat-'+arg).value;
        $.ajax({
          type: 'get',
          url: "{{URL::to('/')}}/"+arg+"/updatemat",
          data: {opt: e},
          async: false,
          success: function(response)
          {
            location.reload(true);
          }
        });         
      }
      return false;
    }

// Ends Reuben's line
  
  
    function view(arg){
        document.getElementById('hidepanelright').style.display = 'initial';//Make the whole panel visible
        var x = parseInt(arg);
        document.getElementsByName('addenquiry').id = x;
        document.getElementById('seldetprojname').innerHTML = document.getElementById('projname-'+arg).innerHTML;
        document.getElementById('seldetprojsite').innerHTML = document.getElementById('projsite-'+arg).innerHTML;
        document.getElementById('seldetprojproc').innerHTML = document.getElementById('projproc-'+arg).innerHTML;
        document.getElementById('seldetprojcont').innerHTML = document.getElementById('projcont-'+arg).innerHTML;
        for(var i =0; i<100000; i++)
        {
            if(document.getElementById('table-'+i))
            {
                document.getElementById('table-'+i).style.display = 'initial';
            }
        }
        for(var i=0; i<100000; i++){
            if(i != x)
            {
               if(document.getElementById('table-'+i))
                   document.getElementById('table-'+i).style.display = 'none';
            }
        }
        return false;
    }
    
    function confirmthis(arg)
    {
      var x = confirm('Are You Sure ?');
      if(x){
        var e = document.getElementById("select-"+arg);
        var opt = e.options[e.selectedIndex].value;
        $.ajax({
          type: 'get',
          url: "{{URL::to('/')}}/"+arg+"/confirmthis",
          data: {opt: opt},
          async: false,
          success: function(response)
          {
            location.reload(true);
          }
        });
      }
      return false;
    }

    function checkdate(arg)
    {
      var today        = new Date();
      var day        = (today.getDate().length ==1?"0"+today.getDate():today.getDate()); //This line by Siddharth
      var month        = parseInt(today.getMonth())+1;
      month            = (today.getMonth().length == 1 ? "0"+month : "0"+month);
      var e        = parseInt(month);  //This line by Siddharth
      var year       = today.getFullYear();
      var current_date = new String(year+'-'+month+'-'+day);
      //Extracting individual date month and year and converting them to integers
      var val = document.getElementById(arg).value;
      var c   = val.substring(0, val.length-6);
      c       = parseInt(c);
      var d   = val.substring(5, val.length-3);
      d       = parseInt(d);
      var f   = val.substring(8, val.length);
      f       = parseInt(f);
      var select_date = new String(c+'-'+d+'-'+f);
      if (c < year) {
        alert('Previous dates not allowed');
        document.getElementById(arg).value = null; 
        document.getElementById(arg).focus();
        return false;   
      }
      else if(c === year && d < e){
        alert('Previous dates not allowed');
        document.getElementById(arg).value = null;
        document.getElementById(arg).focus(); 
        return false; 
      }
      else if(c === year && d === e && f < day){
        alert('Previous dates not allowed');
        document.getElementById(arg).value = null;
        document.getElementById(arg).focus(); 
        return false; 
      }
      else{
        return false;
      }
      //document.getElementById('rDate').value = current_date;    
      }

    function confirmstatus(arg)
    {
      var x = confirm('Are You Sure To Confirm Status ?');
      if(x)
      {
        $.ajax({
          type: 'get',
          url: "{{URL::to('/')}}/"+arg+"/confirmstatus",
          data: {opt: arg},
          async: false,
          success: function(response)
          {
            location.reload(true);
          }
        });
      }
      return false;
    }

    function updatestatus(arg)
    {
      var x = confirm('Are You Sure ?');
      if(x)
      {
        var e = document.getElementById('statusproj-'+arg);
        var opt = e.options[e.selectedIndex].value;
        $.ajax({
          type: 'get',
          url: "{{URL::to('/')}}/"+arg+"/updatestatus",
          data: {opt: opt},
          async: false,
          success: function(response)
          {
            location.reload(true);
          }
        });         
      }
      return false;
    }

    function updatelocation(arg)
    {
      var text = document.getElementById('location-'+arg).value;
      var x = confirm('Do You Want To Save The Changes ?');
      if(x)
      {
        var newtext = document.getElementById('location-'+arg).value; 
        $.ajax({
          type: 'get',
          url: "{{URL::to('/')}}/"+arg+"/updatelocation",
          async: false,
          data: {newtext: newtext},
          success: function(response)
          {
            location.reload(true);
          }
        });
      }
      else
      {
        document.getElementById('location-'+arg).value = text;
      }
    }
    
    function updateOwner(arg)
    {
        var x = confirm('Save Changes ?');
        if(x)
        {
            var id = parseInt(arg);
            var name = document.getElementById('ownername-'+arg).value;
            var phone = document.getElementById('ownerphone-'+arg).value;
            var email = document.getElementById('owneremail-'+arg).value;
            
            $.ajax({
               type: 'GET',
               url: "{{URL::to('/')}}/updateOwner",
               data: {name:name, phone:phone, email:email, id:id},
               async: false,
               success: function(response)
               {
                   console.log(response);
               }
            });
        }
    }
        function updateConsultant(arg)
    {
        var x = confirm('Save Changes ?');
        if(x)
        {
            var id = parseInt(arg);
            var name = document.getElementById('consultantname-'+arg).value;
            var phone = document.getElementById('consultantphone-'+arg).value;
            var email = document.getElementById('consultantemail-'+arg).value;
            alert(id);
            $.ajax({
               type: 'GET',
               url: "{{URL::to('/')}}/updateConsultant",
               data: {name:name, phone:phone, email:email, id:id},
               async: false,
               success: function(response)
               {
                   console.log(response);
               }
            });
        }
    }
    function updateContractor(arg)
    {
        var x = confirm('Save Changes ?');
        if(x)
        {
            var id = parseInt(arg);
            var name = document.getElementById('contractorname-'+arg).value;
            var phone = document.getElementById('contractorphone-'+arg).value;
            var email = document.getElementById('contractoremail-'+arg).value;
            
            $.ajax({
               type: 'GET',
               url: "{{URL::to('/')}}/updateContractor",
               data: {name:name, phone:phone, email:email, id:id},
               async: false,
               success: function(response)
               {
                   console.log(response);
               }
            });
        }
    }
    function updateProcurement(arg)
    {
        var x = confirm('Save Changes ?');
        if(x)
        {
            var id = parseInt(arg);
            var name = document.getElementById('procurementname-'+arg).value;
            var phone = document.getElementById('procurementphone-'+arg).value;
            var email = document.getElementById('procurementemail-'+arg).value;
            
            $.ajax({
               type: 'GET',
               url: "{{URL::to('/')}}/updateProcurement",
               data: {name:name, phone:phone, email:email, id:id},
               async: false,
               success: function(response)
               {
                   console.log(response);
               }
            });
        }
    }
    function addrequirement(){
        var id = document.getElementsByName('addenquiry').id;
        window.location.href="{{ URL::to('/') }}/inputview?projectId="+id;
    }
    function count(){
      var ctype1 = document.getElementById('constructionType1');
      var ctype2 = document.getElementById('constructionType2');
      var countinput;
      if(ctype1.checked == true && ctype2.checked == true){
        countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 2;
      }else if(ctype1.checked == true || ctype2.checked == true){
        countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 1;
      }else{
        countinput = document.querySelectorAll('input[type="checkbox"]:checked').length;
      }
      if(countinput == 5){
        $('input[type="checkbox"]:not(:checked)').attr('disabled',true);
        $('#constructionType1').attr('disabled',false);
        $('#constructionType2').attr('disabled',false);
      }else{
        $('input[type="checkbox"]:not(:checked)').attr('disabled',false);
      }
      }
      function fileUpload(){
      var count = document.getElementById('oApprove').files.length;
      if(count > 5){
        document.getElementById('oApprove').value="";
        alert('You are allowed to upload a maximum of 5 files');
      }
    }

 
  </script>
<!--This line by Siddharth -->
<script type="text/javascript">
  function checklength(arg)
  {
    var x = document.getElementById(arg);
    if(x.value)
    {
        if(x.value.length != 10)
        {
            alert('Please Enter 10 Digits in Phone Number');
            document.getElementById(arg).value = '';
            return false;
        }
        else
        {
            if(arg=='oContact')
            {
                var y = document.getElementById('oContact').value;
                $.ajax({
                    type:'GET',
                    url: '{{URL::to('/')}}/checkDupPhoneOwner',
                    data: {arg: y},
                    async: false,
                    success:function(response)
                    {
                        if(response > 0)
                        {
                            if(!confirm("Phone Number Already Exists.\n Click 'ok' if you want to add the same number?"))
                            {
                                document.getElementById('oContact').value="";
                            }
                        }
                    }
                });
            }
            if(arg=='coContact')
            {
                var y = document.getElementById('coContact').value;
                $.ajax({
                    type:'GET',
                    url: '{{URL::to('/')}}/checkDupPhoneConsultant',
                    data: {arg: y},
                    async: false,
                    success:function(response)
                    {
                        if(response > 0)
                        {
                            if(!confirm("Phone Number Already Exists.\n Click 'ok' if you want to add the same number?"))
                            {
                                document.getElementById('coContact').value="";
                                // alert('Phone Number '+ y +' Already Present in Database. Are you sure you want to add the same number?');
                            }
                        }
                    }
                });
            }
            if(arg=='cPhone')
            {
                var y = document.getElementById('cPhone').value;
                $.ajax({
                    type:'GET',
                    url: '{{URL::to('/')}}/checkDupPhoneContractor',
                    data: {arg: y},
                    async: false,
                    success:function(response)
                    {
                        if(response > 0)
                        {
                            if(!confirm("Phone Number Already Exists.\n Click 'ok' if you want to add the same number?"))
                            {
                                document.getElementById('cPhone').value="";
                            }
                            // alert('Phone Number '+y+' Already Stored in Database. Are you sure you want to add the same number?');
                        }
                    }
                });
            }
            if(arg=='eContact')
            {
                var y = document.getElementById('eContact').value;
                $.ajax({
                    type:'GET',
                    url: '{{URL::to('/')}}/checkDupPhoneSite',
                    data: {arg: y},
                    async: false,
                    success:function(response)
                    {
                        if(response > 0)
                        {
                            if(!confirm("Error : Phone Number Already Exists.\n Click 'ok' if you want to add the same number?"))
                            {
                                document.getElementById('eContact').value="";
                                // alert('Phone Number '+ y +' Already Present in Database. Are you sure you want to add the same number?');
                            }
                        }
                    }
                });
            }
            if(arg=='prPhone')
            {
                var y = document.getElementById('prPhone').value;
                $.ajax({
                    type:'GET',
                    url: '{{URL::to('/')}}/checkDupPhoneProcurement',
                    data: {arg: y},
                    async: false,
                    success:function(response)
                    {
                        if(response > 0)
                        {
                            if(!confirm("Error : Phone Number Already Exists.\n Click 'ok' if you want to add the same number?"))
                            {
                                document.getElementById('prPhone').value="";
                                // alert('Phone Number '+ y +' Already Present in Database. Are you sure you want to add the same number?');
                            }
                        }
                    }
                });
            }
        }        
    }
    return false;
  }
  
    function checkPhone(arg, table)
    {
        var temp;
        $.ajax({
            type: 'GET',
            url: '{{URL::to('/')/checkDupPhone',
            data: {arg: arg, table:table},
            async: false,
            success:function(response)
            {
                console.log(response);
                temp = false;
            }
        });
        return temp;
    }
  
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
<!--This line by Siddharth -->
<!-- get location -->
<script src="https://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" charset="utf-8">
  function getvisitLocation(){
      // document.getElementById("getBtn").className = "hidden";
      console.log("Entering getLocation()");
      if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(
        displayCurrentLocation,
        displayError,
        { 
      
          maximumAge: 3000, 
          timeout: 5000, 
          enableHighAccuracy: true 
        });
    }else{
      alert("Oops.. No Geo-Location Support !");
    } 
      //console.log("Exiting getLocation()");
  
    
    function displayCurrentLocation(position){

      //console.log("Entering displayCurrentLocation");
      var latitude  = position.coords.latitude;
      var longitude = position.coords.longitude;
    alert(longitude);
      document.getElementById("longitude").value = longitude;
      document.getElementById("latitude").value  = latitude;
      //console.log("Latitude " + latitude +" Longitude " + longitude);

      getAddressFromLatLang(latitude,longitude);
      //console.log("Exiting displayCurrentLocation");
    }
   
  function  displayError(error){
    console.log("Entering ConsultantLocator.displayError()");
    var errorType = {
      0: "Unknown error",
      1: "Permission denied by user",
      2: "Position is not available",
      3: "Request time out"
    };
    var errorMessage = errorType[error.code];
    if(error.code == 0  || error.code == 2){
      errorMessage = errorMessage + "  " + error.message;
    }
    alert("Error Message " + errorMessage);
    console.log("Exiting ConsultantLocator.displayError()");
  }
  function getAddressFromLatLang(lat,lng){
    //console.log("Entering getAddressFromLatLang()");
   
    var geocoder = new google.maps.Geocoder();
    var latLng = new google.maps.LatLng(lat, lng);
    
    geocoder.geocode( { 'latLng': latLng}, function(results, status) {
        console.log("After getting address");
        // console.log(results);
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[0]) {
        console.log(results);
        document.getElementById("address").value = results[0].formatted_address;
        document.getElementById("myform").form.submit();

      }
    }else{
        alert("Geocode was not successful for the following reason: " + status);
     }
    });
    //console.log("Entering getAddressFromLatLang()");
  }
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU"></script>
<script type="text/javascript">

  function addRow(arg) {
        var table = document.getElementById("bhk"+arg);
        var row = table.insertRow(0);
        var cell3 = row.insertCell(0);
        var cell1 = row.insertCell(1);
        var cell2 = row.insertCell(2);
        var ctype1 = document.getElementById('constructionType1');
        var ctype2 = document.getElementById('constructionType2');
        var existing = document.getElementById('floorNo').innerHTML;
        if(ctype1.checked == true && ctype2.checked == false){
          cell3.innerHTML = "<select name='floorNo[]' class='form-control'>"+existing+"</select>";
          cell1.innerHTML = " <select name=\"roomType[]\" class=\"form-control\">"+
                                                          "<option value=\"1RK\">1RK</option>"+
                                                          "<option value=\"1BHK\">1BHK</option>"+
                                                          "<option value=\"2BHK\">2BHK</option>"+
                                                          "<option value=\"3BHK\">3BHK</option>"+
                                                      "</select>";
          cell2.innerHTML = "<input name=\"number[]\" type=\"text\" class=\"form-control\" placeholder=\"No. of houses\">";
        }
        if(ctype1.checked == false && ctype2.checked == true){
          cell3.innerHTML = "<select name='floorNo[]' class='form-control'>"+existing+"</select>";
          cell1.innerHTML = "<input name=\"roomType[]\" value='Commercial Floor' id=\"\" class=\"form-control\">";
          cell2.innerHTML = "<input type=\"text\" name=\"number[]\" class=\"form-control\" placeholder=\"Floor Size\"></td>";
        }
        if(ctype1.checked == true && ctype2.checked == true){
          // both residential and commercial
          cell3.innerHTML = "<select name='floorNo[]' class='form-control'>"+existing+"</select>";
          cell1.innerHTML = " <select name=\"roomType[]\" class=\"form-control\">"+
                                                          "<option value=\"Commercial Floor\">Commercial Floor</option>"+
                                                          "<option value=\"1RK\">1RK</option>"+
                                                          "<option value=\"1BHK\">1BHK</option>"+
                                                          "<option value=\"2BHK\">2BHK</option>"+
                                                          "<option value=\"3BHK\">3BHK</option>"+
                                                      "</select>";
          cell2.innerHTML = "<input name=\"number[]\" type=\"text\" class=\"form-control\" placeholder=\"No. of houses\">";
        }
    }
    function count(){
      var ctype1 = document.getElementById('constructionType1');
      var ctype2 = document.getElementById('constructionType2');
      var ctype3 = document.getElementById('constructionType3');
      var ctype4 = document.getElementById('constructionType4');
      var countinput;
      if(ctype1.checked == true && ctype2.checked == true && ctype3.checked == false && ctype4.checked == false){
        //   both construction type
        countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 2;
      }else if(ctype1.checked == true && ctype2.checked == true && ctype3.checked == true && ctype4.checked == true){
        //   all construction type and budget type
        countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 4;
      }else if(ctype1.checked == true && ctype2.checked == true && (ctype3.checked == true || ctype4.checked == true)){
        //   both construction type and either budget type
        countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 3;
      }else if((ctype1.checked == true || ctype2.checked == true) && (ctype3.checked == true || ctype4.checked == true)){
        //   
        countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 2;
      }else if(ctype1.checked == true || ctype2.checked == true){
        countinput = document.querySelectorAll('input[type="checkbox"]:checked').length - 1;
      }else{
        countinput = document.querySelectorAll('input[type="checkbox"]:checked').length;
      }
      if(countinput >= 5){
        $('input[type="checkbox"]:not(:checked)').attr('disabled',true);
        $('#constructionType1').attr('disabled',false);
        $('#constructionType2').attr('disabled',false);
        $('#constructionType3').attr('disabled',false);
        $('#constructionType4').attr('disabled',false);
      }else if(countinput == 0){
          return "none";
      }else{
        $('input[type="checkbox"]:not(:checked)').attr('disabled',false);
      }
    }
    function fileUpload(){
      var count = document.getElementById('oApprove').files.length;
      if(count > 5){
        document.getElementById('oApprove').value="";
        alert('You are allowed to upload a maximum of 5 files');
      }
    }

 
        
    

</script> 

<script>
  
  function displayDate(){
    document.getElementById('demo').innerHTML=Date();

  }

</script>

<script>
function myfunction(){
  document.getElementByName('form').submit();
}  
</script>

<script>
function dis(){

    if (document.getElementById("a").checked){
        document.getElementById('b').disabled=true;

}

</script>


  
  @endsection
