@extends('layouts.app')
@section('content')
<div class="">
  <div class="col-md-12">
    <div class="panel panel-primary">
      <div class="panel-heading" style="padding:10px;">

  <button type="button" class="btn btn-warning btn-sm pull-left" data-toggle="modal" data-target="#myModal">Upload Exel File</button>
  <button type="button" class="btn btn-success btn-sm pull-left" data-toggle="modal" data-target="#myModal10">Add Account Head</button>
  <button type="button" class="btn btn-info btn-sm pull-left" data-toggle="modal" data-target="#myModal11">Add Sub Account Head</button>

<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color:rgb(70, 141, 221);font-weight:bold;">File</h4>
        </div>
        <div class="modal-body">
        <form action="{{ URL::to('/') }}/test" method="post" enctype="multipart/form-data"> 
          {{csrf_field()}}
          
          <label style="color:rgb(70, 141, 221);font-weight:bold;">Exel file
          <input type="file" name="acc" class="form-control">
          </label>
          <label style="color:rgb(70, 141, 221);font-weight:bold;">Bank Type
            <select class="form-control" name="bank" id="subward">
                   <option value="">---Select--</option>
                   <option value="Axis">Axis Bank</option>
                   <option value="HDFC">HDFC Bank</option>
                </select>
              </label>
          <button class="btn btn-warning btn-sm" type="submit">Submit</button>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
<div class="container">

  <!-- Modal -->
  <div class="modal fade" id="myModal10" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color:rgb(70, 141, 221);font-weight:bold;">Account Head </h4>
        </div>
        <div class="modal-body">
        <form action="{{ URL::to('/api') }}/testhead" method="post" enctype="multipart/form-data"> 
          {{csrf_field()}}
          
          <label style="color:rgb(70, 141, 221);font-weight:bold;">Account Head
          <input type="text" name="achead" class="form-control" required>
          </label>
        <!--    <label style="color:rgb(70, 141, 221);font-weight:bold;">Sub Head
          <input type="text" name="subhead" class="form-control" required>
          </label> -->
           <label style="color:rgb(70, 141, 221);font-weight:bold;">Debit/Credit
           <select class="form-control" name="crdr" id="subward" required>
                   <option value="">---Select--</option>
                   <option value="Debit">Debit</option>
                   <option value="Credit">Credit</option>
                </select>
          </label>
            
          <button class="btn btn-warning btn-sm" type="submit">Submit</button>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
<div class="container">

  <!-- Modal -->
  <div class="modal fade" id="myModal11" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color:rgb(70, 141, 221);font-weight:bold;">Sub Account Head </h4>
        </div>
        <div class="modal-body">
        <form action="{{ URL::to('/api') }}/subtesthead" method="post" enctype="multipart/form-data"> 
          {{csrf_field()}}
           <label style="color:rgb(70, 141, 221);font-weight:bold;">Account Head
           <select class="form-control" name="accounthead" id="" required>
                   <option value="">---Select--</option>
                   @foreach($acc as $account)
                   <option value="{!! $account->id !!}">{!! $account->name !!}</option>
                   @endforeach
                </select>
          </label>
           <label style="color:rgb(70, 141, 221);font-weight:bold;">Sub Account Head
          <input type="text" name="subhead" class="form-control" required>
          </label>
            
          <button class="btn btn-warning btn-sm" type="submit">Submit</button>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

        </div>
<form action="{{ URL::to('/') }}/legderdetails" method="post">
          {{csrf_field()}}
          @if(SESSION('success'))
<div class="text-center alert alert-success">
<h3 style="font-size:1.8em">{{SESSION('success')}}</h3>
</div>
@endif
      <div class="panel-body">
          <div class="col-md-12">
              <div class="col-md-2">
                <label>Date</label>
                <input value = "{{ isset($_GET['from']) ? $_GET['from']: '' }}" type="date" class="form-control" name="date">
              </div>
              <div class="col-md-2">
                <label>Transaction Particulars</label>
                <input  type="text" class="form-control" name="Transaction" placeholder="Transaction Particulars">
              </div>
               <div class="col-md-2">
                <label>Amount(INR)</label>
                <input  type="text" class="form-control" name="money" placeholder="Amount(INR)">
              </div>
             <!--  <div class="col-md-2">
                <label>Debit/Credit</label>
                <select class="form-control" name="drcr" id="subward">
                   <option value="">---Select--</option>
                   <option value="Debit">Debit</option>
                   <option value="Credit">Credit</option>
                </select>
              </div> -->
               <div class="col-md-2">
                <label>Bank Name</label>
                <select class="form-control" name="bank" id="subward">
                   <option value="">---Select--</option>
                   <option value="Axis">Axis Bank</option>
                   <option value="HDFC">HDFC Bank</option>
                </select>
              </div>
              <div class="col-md-2">
                <label>Branch Name</label>
                <input  type="text" class="form-control" name="branch" placeholder="Branch name">
              </div>
           <div class="col-md-2"><br>
                <label>Debit/Credit </label>
                <select class="form-control" name="crdr"  required>
                   <option value="">---Select--</option>
                   <option value="Debit">Debit</option>
                   <option value="Credit">Credit</option>
                </select>
              </div>
              <div class="col-md-2"><br>
                <label>Accounts Head </label>
                <select class="form-control" name="acchead" id="mydad" onchange="Subs()">
                   <option value="">---Select--</option>
                   @foreach($acc as $account)
                   <option value="{!! $account->id !!}">{!! $account->name !!}</option>
                   @endforeach

                </select>
              </div>
               <div class="col-md-2"><br>
                <label>Sub Accounts Head </label>
               <select id="sub2"  class="form-control" name="brand" onchange="assetinfo()">
                        
                    </select>
              </div>
               <div class="col-md-2"><br>
                <label>Select Asset</label>
               <select id="asset"  class="form-control" name="name">
                        
                    </select>
              </div>
               <div class="col-md-2"><br>
                <label>Remarks</label>
                <textarea class="form-control" name="remark" placeholder="Remarks"></textarea>    
              </div>
                <div class="col-md-2"><br>
                <label></label>
                <button  type="submit" class="form-control btn-success btn-sm" >Submit</button>
              </div>
          </div>
      </div>
    </form>
      <table class="table table-responsive table-striped table-hover">
      <thead>
        <tr>
        <th style="color:rgb(70, 141, 221);font-weight:bold;">Date</th>
        <th style="color:rgb(70, 141, 221);font-weight:bold;">Transaction Particulars</th>
        <th style="color:rgb(70, 141, 221);font-weight:bold;">Amount(INR)</th>
        <th style="color:rgb(70, 141, 221);font-weight:bold;">Debit/Credit</th>
        <th style="color:rgb(70, 141, 221);font-weight:bold;">Bank Name</th>
        <th style="color:rgb(70, 141, 221);font-weight:bold;">Branch Name</th>
        <th style="color:rgb(70, 141, 221);font-weight:bold;">Account Head </th>
        <th style="color:rgb(70, 141, 221);font-weight:bold;">Sub Account Head </th>

        <th style="color:rgb(70, 141, 221);font-weight:bold;">Remarks </th>
        <th style="color:rgb(70, 141, 221);font-weight:bold;">Action </th>

 </tr>
      </thead>

      <tbody>
        @foreach($ledger as $led)
        <tr>
        <td> {{ date('d-m-Y', strtotime($led->val_date)) }}</td>
        <td>{{$led->Transaction}}</td>
        <td>
          {{number_format(round($led->amount))}}</td>
        <td>{!! $led->debitcredit !!}</td>
        <td>{{$led->bank}}</td>
        <td>{{$led->branch}}</td>
        <td>{!! $led->acc != null ? $led->acc->name : '' !!}</td>
        <td>{!! $led->sub != null ? $led->sub->Subaccountheads : '' !!}</td>
        <td>{{$led->remark}}</td>
        <td>
         <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal15{{$led->id}}">Edit</button>
         <!-- Modal -->
  <div class="modal fade" id="myModal15{{$led->id}}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color:rgb(70, 141, 221);font-weight:bold;">Edit
         <span class="pull-right">Type : {!! $led->debitcredit !!} </span>
          </h4>
        </div>
        <div class="modal-body">
        <form action="{{ URL::to('/') }}/testedit" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
           <label style="color:rgb(70, 141, 221);font-weight:bold;">Account Head
             <select class="form-control" name="acchead" id="mymom{{$led->id}}" onchange="yadav('{{$led->id}}')" style="width:200px;">
                   <option value="">---Select--</option>
                   @foreach($acc as $account)
                   <option  value="{!! $account->id !!}">{!! $account->name !!}</option>
                   @endforeach

                </select>
          
          </label>
          <label style="color:rgb(70, 141, 221);font-weight:bold;">Sub Account Head
             <select id="subacc{{$led->id}}"  class="form-control" name="br" style="width:200px;">
             </select>
          </label><br>
          <input type="hidden" name="id" value="{{$led->id}}">
          <label style="color:rgb(70, 141, 221);font-weight:bold;">Date
          <input type="text" name="date" class="form-control" value="{{ date('d-m-Y', strtotime($led->val_date)) }}" style="width:100%;">
          </label>
            <label style="color:rgb(70, 141, 221);font-weight:bold;">Transaction Particulars
          <input type="text" name="trans" class="form-control" value="{{$led->Transaction}}">
          </label>
            <label style="color:rgb(70, 141, 221);font-weight:bold;">Amount(INR)
          <input type="text" name="amount" class="form-control" value=" {{number_format(round($led->amount))}}">
          </label>
            <label style="color:rgb(70, 141, 221);font-weight:bold;">Debit/Credit
          <input type="text" name="dr" class="form-control" value="{{$led->debitcredit}}">
          </label>
            <label style="color:rgb(70, 141, 221);font-weight:bold;">Bank Name
          <input type="text" name="bank" class="form-control" value="{{$led->bank}}">
          </label>
           <label style="color:rgb(70, 141, 221);font-weight:bold;">Branch Name
          <input type="text" name="branch" class="form-control" value="{{$led->branch}}">
          </label>
          <label style="color:rgb(70, 141, 221);font-weight:bold;">Remarks 
          <input type="text" name="remark" class="form-control" value="{{$led->remark}}">
          </label>
            
          <button class="btn btn-warning btn-sm" type="submit">Submit</button>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
        </td>
      </tr>
    @endforeach
      </tbody>
      </table>
      <div class="panel-footer">
        
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function Subs()
    {
        var e = document.getElementById('mydad');
        // var f = document.getElementById('brands2');
        var cat = e.options[e.selectedIndex].value;
        
        // var brand = f.options[f.selectedIndex].value;
        $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/getsubaccounthead",
            async:false,
            data:{cat : cat},
            success: function(response)
            {
                console.log(response);
                var ans = "<option value=''>--Select--</option>";

               console.log(response.length);
                for(var i=0;i<response.length;i++)
                {
                     ans += "<option value='"+response[i].id+"'>"+response[i].  Subaccountheads+"</option>";
                   
                }
                document.getElementById('sub2').innerHTML = ans;
                $("body").css("cursor", "default");
            }
        });
    }


function assetinfo()
    {
        var e = document.getElementById('sub2');
        var cat = e.options[e.selectedIndex].value;

if(cat == 1){
        $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/userinfo",
            async:false,
            data:{cat : cat},
            success: function(response)
            {
                console.log(response);
                var ans = "<option value=''>--Select--</option>";

               console.log(response.length);
                for(var i=0;i<response.length;i++)
                {
                     ans += "<option value='"+response[i].id+"'>"+response[i]. name+"</option>";
                   
                }
                document.getElementById('asset').innerHTML = ans;
                $("body").css("cursor", "default");
            }
        });
        }else{
           alert("NO Asset nedded ");
        }
    }




    function yadav(arg)
    {

        var e = document.getElementById('mymom'+arg);
                // var f = document.getElementById('brands2');
        var cat = e.options[e.selectedIndex].value;
        // var brand = f.options[f.selectedIndex].value;
        $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/getsubaccounthead",
            async:false,
            data:{cat : cat},
            success: function(response)
            {
                console.log(response);
                var ans = "<option value=''>--Select--</option>";

               console.log(response.length);
                for(var i=0;i<response.length;i++)
                {
                     ans += "<option value='"+response[i].id+"'>"+response[i].  Subaccountheads+"</option>";
                   
                }
                document.getElementById('subacc'+arg).innerHTML = ans;
                $("body").css("cursor", "default");
            }
        });
    }
</script>
@endsection