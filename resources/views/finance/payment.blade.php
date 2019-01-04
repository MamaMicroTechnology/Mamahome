@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div  class="col-md-3"  style="border: 2px solid gray;;height: 50%;">
    <center><label>Payment Details</label></center>
    Order Id : {{$id}}<br>
    Customer Total Amount : {{$total}}<br><br>
    @if($payments != null)
        <?php
          $pending = ( $total - $payments->totalamount);
        ?>
          Payment Mode : {{$payments->payment_mode}}<br>
          Amount Received : {{$payments->totalamount}}RS/-<br>
          Delivery Amount : {{$payments->damount}}/-<br>
         <br>
    @endif
    @if($payhistory != null)
      @foreach($payhistory as $pay)
          Payment Mode : {{$pay->payment_mode}}<br>
          Amount Received : {{$pay->totalamount}}RS/-<br>
          Delivery Amount : {{$pay->damount}}/-<br><br>
      @endforeach
      <?php
          $var = [];
          for($i= 0 ; $i<sizeof($payhistory) ; $i++){

            $amt =$payhistory[$i]['totalamount'];
            array_push($var,$amt);

          }
          $s = array_sum($var);
            if($payments != null){

          $pending = ( $total - $payments->totalamount - $s);
            }
        ?>
    @endif
     @if($payments != null)
        @if($pending == 0)
             <label class="alert-success">Payment Completed</label>
         @else
        <label class="alert-danger">Pending Amount : {{$pending}}RS/-</label>
        @endif
     @endif
  </div>
<div class="col-md-8">
<div class="panel panel-primary">
    <div class="panel-heading" align="center">Payment Method</div>
    <div class="panel-body">
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home"><b>Cash</b></a></li>
    <li><a data-toggle="tab" href="#menu1"><b>RTGS/NEFT</b></a></li>
    <li><a data-toggle="tab" href="#menu2"><b>Cheque</b></a></li>
    <!-- <li><a data-toggle="tab" href="#menu3"><b>Cash In Hand</b></a></li> -->
  </ul>

            <div class="tab-content">
              <br><br>
              <div id="home" class="tab-pane fade in active">
                <!-- radio select -->
<script type="text/javascript">
function ShowHideDiv(){
        var chkYes = document.getElementById("chkYes");
        var dvPassport = document.getElementById("cashdep");
        dvPassport.style.display = chkYes.checked ? "block" : "none";
        var chkYes = document.getElementById("chkNo");
        var dvPassport = document.getElementById("cashcol");
        dvPassport.style.display = chkYes.checked ? "block" : "none";
    }
function ShowHideDiv1(){
        var chkYes = document.getElementById("chkNo");
        var dvPassport = document.getElementById("cashcol");
        dvPassport.style.display = chkYes.checked ? "block" : "none";
        var chkYes = document.getElementById("chkYes");
        var dvPassport = document.getElementById("cashdep");
        dvPassport.style.display = chkYes.checked ? "block" : "none";
}
</script>
<label for="chkYes">
    <input type="radio" id="chkYes" name="chkPassPort" onclick="ShowHideDiv()" />
    Cash Deposit
</label>
<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
<label for="chkNo">
    <input type="radio" id="chkNo" name="chkPassPort" onclick="ShowHideDiv1()" />
    Cash Collection
</label>
<hr/>
<!-- end -->  <div id="cashdep" style="display: none">
                <form action="{{ URL::to('/') }}/savePaymentDetails?id= {{$id}}&&mid={{$mid}}&&pid={{$pid}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input name="method" class="hidden" value="CASH">
               <table class="table table-responsive table-striped" border="1" >
                        <tr>
                          <td>Bank Name :</td>
                        <td><input  class="form-control" name="bankname" type="text" placeholder="Bank Name"></td>
                        </tr>
                        <tr>
                        <td>Branch Name :</td>
                        <td><input  class="form-control" name="branchname" type="text" placeholder="Branch Name"></td>
                        </tr>
                        <tr>
                        <td>Cash Deposit Date :</td>
                        <td><input required class="form-control" type="date" name="date"></td>
                        </tr>
                        <tr>
                        <td>Cash Deposit Slip :</td>
                        <td><input required multiple type="file" name="payment_slip[]" id="payment_slip" accept="image/*" class="form-control input-sm" ></td>
                        </tr>
                        <tr>
                        <td>Deposit Amount :</td>
                        <td><input required class="form-control" name="totalamount" type="text" placeholder="Enter Amount"></td>
                        </tr>
                        <tr>
                          <td>Delivery charges(Driver) :</td>
                          <td><input class="form-control" name="damount" type="text" placeholder="Enter Amount"></td>
                        </tr>
                        <tr>
                          <td>Notes:</td>
                          <td><textarea name="notes" style="resize: none;"  cols="2" rows="2" placeholder="Notes" class="form-control"></textarea></td>
                        </tr>
                </table>
                        <button type="submit" class="form-control btn btn-success">Save</button>
                      </form>
              </div>
                <div id="cashcol" style="display: none">
                  <form action="{{ URL::to('/') }}/savePaymentDetails?id= {{$id}}&&mid={{$mid}}&&pid={{$pid}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                  <input name="method" class="hidden" value="CASH IN HAND">
                <table class="table table-responsive table-striped" border="1">
                  <tr>
                    <td>Cash Holder Name:</td>
                        <td>
                          <select class="form-control" name="name">
                          <option value="">--Select--</option>
                          @foreach($users as $user)
                          <option {{ isset($_GET['user']) ? $_GET['user'] == $user->id ? 'selected' : '' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                          @endforeach
                        </select>
                        </td>
                  </tr>
                <tr>
                          <td>Cash Recieved Date :</td>
                        <td><input required class="form-control" name="date" type="date"></td>
                </tr>
                <tr>
                          <td>Total Amount :</td>
                        <td><input required class="form-control" name="totalamount" type="number"></td>
                </tr>
                <tr>
                          <td>Delivery charges(Driver) :</td>
                          <td><input class="form-control" name="damount" type="number" placeholder="Enter Amount"></td>
                </tr>
                <tr>
                          <td>Notes:</td>
                          <td><textarea name="notes" style="resize: none;" cols="2" rows="2" placeholder="Notes" class="form-control"></textarea></td>
                </tr>
              </table>
              <button type="submit" class="form-control btn btn-success">Save</button>
              </form>
                </div>
              </div>
              <div id="menu1" class="tab-pane fade">
                <form action="{{ URL::to('/') }}/savePaymentDetails?id= {{$id}}&&mid={{$mid}}&&pid={{$pid}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input name="method" class="hidden" value="RTGS">
                <table class="table table-responsive table-striped" border="1">
                        <tr>
                        <td>Refernce Number/Account Number :</td>
                        <td><input required class="form-control" type="texct" name="accnum" placeholder="Account Number"></td>
                        </tr>
                        <tr>
                        <td>Branch Name/Center :</td>
                        <td><input required name="accname" type="text" class="form-control input-sm" placeholder="Branch Name" ></td>
                        </tr>
                        <tr>
                          <td>Transaction Date :</td>
                        <td><input required class="form-control" name="date" type="date"></td>
                        </tr>
                        <tr>
                          <td>Upload file :</td>
                          <td><input multiple type="file" name="rtgs_file[]" id="payment_slip" accept="image/*" class="form-control input-sm" ></td>
                        </tr>
                        <tr>
                          <td>RTGS Amount :</td>
                          <td><input required class="form-control" name="totalamount" type="text" placeholder="Enter Amount"></td>
                        </tr>
                        <tr>
                          <td>Delivery charges(Driver) :</td>
                          <td><input class="form-control" name="damount" type="text" placeholder="Enter Amount"></td>
                        </tr>
                        <tr>
                          <td>Notes:</td>
                          <td><textarea name="notes" style="resize: none;" cols="2" rows="2" placeholder="Notes" class="form-control"></textarea></td>
                        </tr>
                </table>
                        <button type="submit" class="form-control btn btn-success">Save</button>
              </form>
              </div>
              <div id="menu2" class="tab-pane fade">
                <form action="{{ URL::to('/') }}/savePaymentDetails?id= {{$id}}&&mid={{$mid}}&&pid={{$pid}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input name="method" class="hidden" value="CHEQUE">
                <table class="table table-responsive table-striped" border="1">  
                        <tr>
                          <td>Bank Name :</td>
                        <td><input  class="form-control" name="bankname" type="text" placeholder="Bank Name"></td>
                        </tr>
                        <tr>
                        <td>Branch Name :</td>
                        <td><input class="form-control" name="branchname" type="text" placeholder="Branch Name"></td>
                        </tr>
                        <tr>
                          <td>Cheque Number :</td>
                          <td><input required class="form-control" name="cheque_num" type="text" placeholder="Cheque Number"></td>
                        </tr>
                        <tr>
                          <td>Cheque Date :</td>
                        <td><input required class="form-control" name="date" type="date"></td>
                        </tr>
                        <tr>
                          <td>Amount :</td>
                          <td><input required class="form-control" name="totalamount" type="text" placeholder="Enter Amount"></td>
                        </tr>
                        <tr>
                          <td>Delivery charges(Driver) :</td>
                          <td><input class="form-control" name="damount" type="text" placeholder="Enter Amount"></td>
                        </tr>
                        <tr>
                          <td>Notes:</td>
                          <td><textarea name="notes" style="resize: none;" cols="2" rows="2" placeholder="Notes" class="form-control"></textarea></td>
                        </tr>
                </table>
                        <button type="submit" class="form-control btn btn-success">Save</button>
                </form>
              </div>
             <!--  <div id="menu3" class="tab-pane fade">
              <form action="{{ URL::to('/') }}/savePaymentDetails?id= {{$id}}&&mid={{$mid}}&&pid={{$pid}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                
            </form>
              </div> -->
            </div>
          </div>
    </div>
  </div>
</div>
@if(session('Success'))
<script>
    swal("Success","{{ session('Success') }}","success");
</script>
@endif
@endsection
