
<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 26? "finance.layouts.headers":"layouts.app");
?>
@extends($ext)
@section('content')
<div class="col-md-12 ">
    <table class="table table-responsive" border=1>
        <!-- <th>Ward Name</th> -->
        <th>Requirement Date</th>
        <th>Project Id</th>
        <th>Order Id</th>
        <th>Category</th>
        <th>Quantity</th>
        <th>Payment Details</th>
        @if(Auth::user()->group_id != 22)
        <th>Confirm Payment</th>
        <th>MAMAHOME Invoice</th>
        @endif
        @foreach($orders as $order)
        <tr style="{{ date('Y-m-d') == $order->requirement_date ? 'background-color:#ccffcc': '' }}">
            <td>{{ date('d M, y',strtotime($order->requirement_date)) }}</td>
             <td style="text-align:center"><a href="{{ URL::to('/') }}/admindailyslots?projectId={{$order->project_id}}&&lename=" target="_blank">{{ $order->project_id }}</a></td>
            <td>{{ $order->id }}</td>
            <td>{{ $order->main_category }}</td>
            <td>{{ $order->quantity }}</td>
            <td>
                @if($order->payment_status == "Payment Received")
                <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal{{ $order->id }}">
                    Payment Details
                    <span class="badge">{{ $counts[$order->id] }}</span>    
                </button>
                @endif
            </td>
              @if(Auth::user()->group_id != 22)
            <td>
            <?php 
                $rec =count($order->confirm_payment); 
             ?> 
                @if($rec == 0)
                 <div class="btn-group">
                                <!-- <a class="btn btn-xs btn-success" href="{{URL::to('/')}}/confirmpayment?id={{ $order->id }}">Confirm</a> -->
                               <button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#payment{{$order->id}}"> Confirm</button>
                                <button class="btn btn-xs btn-danger pull-right" data-toggle="modal" data-target="#clear{{$order->id}}">Cancel</button>
                </div>
                 @else
                 Payment Confirmed
                 @endif             
            </td>
            <td>
                @if($order->clear_for_delivery == "No")
                <form id="theForm" action="{{ URL::to('/') }}/clearOrderForDelivery" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <button class="btn btn-primary btn-xs">Clear For Delivery</button>
                </form>
                @else
                    
            <?php 
                $rec =count($order->confirm_payment); 
             ?> 
                @if($rec == 1)
                    <div class="btn-group">
    <a type="button" href="{{ route('downloadInvoice',['id'=>$order->id]) }}" class="btn btn-primary btn-xs">PROFORMA</a>
    <a type="button" href="{{ route('downloadTaxInvoice',['id'=>$order->id]) }}" class="btn btn-success btn-xs">TAX</a>
    <a type="button"  href="{{ route('downloadpurchaseOrder',['id'=>$order->id]) }}" class="btn btn-danger btn-xs">PUCHASE</a>
  </div>
                    @else
                    
                    <div class="btn-group">
    <a disabled type="button" href="{{ route('downloadInvoice',['id'=>$order->id]) }}" class="btn btn-primary btn-xs">PROFORMA</a>
    <a disabled type="button" href="{{ route('downloadTaxInvoice',['id'=>$order->id]) }}" class="btn btn-success btn-xs">TAX</a>
    <a disabled type="button"  href="{{ route('downloadpurchaseOrder',['id'=>$order->id]) }}" class="btn btn-danger btn-xs">PUCHASE</a>
  </div>
                   
                    @endif
                @endif
            </td>
            @endif
        </tr>
                    
        @endforeach
    </table>
    <center>
        {{ $orders->links() }}
    </center>
</div>
    @foreach($orders as $order)
        <!-- Modal -->
                    <div id="payment{{$order->id}}" class="modal fade" role="dialog">
                      <div class="modal-dialog" style="width:50%">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header" style="background-color: #5cb85c;color:white">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Confirm Payment</h4>
                          </div>
                          <div class="modal-body">
                                <table class="table table-responsive table-striped" border="1">
                                    <tr>
                                        <td>Payment Mode :</td>
                                        <td>{{ $order->payment_mode }}</td>   
                                    </tr>
                                    <tr>
                                        <td>Category :</td>
                                        <td>{{ $order->main_category }}</td>
                                    </tr>
                                    <tr>
                                        <td>Quantity :</td>
                                        <td>{{ $order->quantity }}</td>
                                    </tr>
                                </table>
                           <form action="{{ URL::to('/') }}/saveunitprice?id={{$order->id}}" method="post">
                            {{ csrf_field() }}
                            @foreach($mamaprices as $price)
                                @if($price->order_id == $order->id)
                            <label> Total Quantity : </label>
                            <input required type="text" class="form-control" name="quantity" value="{{$price->quantity}}" id="quan" onkeyup="checkthis('quan')">
                            <br>
                            <!-- <input type="radio" name="unit" value="tons" checked>Tons
                            <input type="radio" name="unit" value="bags"> Bags
                            <br></br> -->
                            <label>Mamahome price(Per Unit) : </label>
                            <input required type="text" id="unit"  class="form-control" name="price" value="{{$price->mamahome_price}}"  onkeyup="checkthis1('unit')">
                            <label>Manufacturer Price(Per Unit) : </label>
                            <input required type="text" id="unit"  class="form-control" name="price" value="{{$price->manufacturer_price}}" onkeyup="checkthis1('unit')">
                            <br>
                            <p class="alert-success">Total Mamahome Price :{{$price->mamatotal}}</p>
                            <p class="alert-success">Total manufacturer Price :{{$price->manutotal}}</p>
                            <br>
                            <label>Enter Mamahome Price : </label>
                              <input required id="txtNumber" type="text" name="mamatotal" maxlength="9" placeholder="Enter Mamahome Total Price" onkeyup="NumToWord(this.value,'lblWord');" class="form-control" />
                             <label class=" alert-success pull-right" id="lblWord"></label> <br>
                              <label>Enter Manufacturer Price : </label>
                              <input required id="txtNumber" class="form-control" type="text" name="manutotal" maxlength="9" placeholder="Enter Manufacturer Total Price" onkeyup="NumToWord1(this.value,'lblWord1');" />
                             <label class=" alert-success pull-right" id="lblWord1"></label> 
                             <br>
                              <input type="text" name="dtow1" class="hidden" value="" id="dtow1">
                              <input type="text" name="dtow2" class="hidden" value="" id="dtow2">
                              
                            <button  type="submit" class="btn btn-sm btn-success" style="text-align: center;">Confirm</button>
                            <br>
                            @endif
                            @endforeach
                           </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
<!-- Modal -->
<div id="clear{{$order->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
       <p>Are You Sure You Want To Cancel This Payment?</p>

       <a href="{{URL::to('/')}}/storedetails?value=yes" type="button" class=" btn btn-sm btn-success" >Select Other Payment Method</a>
                    <a href="{{URL::to('/')}}/storedetails?value=no"  onclick="show()" class=" btn btn-sm btn-danger " href="{{url()->previous()}}" >Cancel the Order</a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- modal end -->
        <div id="myModal{{ $order->id }}" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header" style="background-color: #337ab7;color:white;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Payment Details</h4>
                </div>
                <div class="modal-body">
                    @foreach($payments as $payment)
            @if($payment->order_id == $order->id)
            <table class="table table-responsive table-striped" border="1">
              <tr>
                <td>OrderId :</td>
                <td>{{$payment->order_id}}</td>
              </tr>
              <tr>
                <td>Payment Mode :</td>
                <td>{{ $payment->payment_mode }}</td>
              </tr>
              <tr>
                <td>Date :</td>
                <td>{{$payment->date}}</td>
              </tr>
              @if($payment->payment_mode == "CASH")
              <tr>
                <td>Cash Deposit Slip :</td>

                <td>
                    <!-- <img src="{{ URL::to('/') }}/payment_details/{{ $payment->file }}" alt="" class="img img-responsive"> -->
                    <?php
                                                     $images = explode(",", $payment->file );
                                                    ?>
                                                   <div class="col-md-12">
                                                       @for($i = 0; $i < count($images); $i++)
                                                           <div class="col-md-3">
                                                                <img height="350" width="350" id="project_img" src="{{ URL::to('/') }}/public/payment_details/{{ $images[$i] }}" class="img img-thumbnail">
                                                           </div>
                                                       @endfor
                                                    </div>
                </td>
              </tr>
              @endif
              @if($payment->payment_mode == "RTGS")
              <tr>
                <td>Reference Number :</td>
                <td>{{$payment->account_number}}<br></td>
              </tr>
              <tr>
                <td>Branch Name :</td>
                <td>{{$payment->branch_name}}<br></td>
              </tr>
              @endif
              @if($payment->payment_mode == "CHEQUE")
              <tr>
                <td>Cheque Number :</td>
                <td>{{$payment->cheque_number}}
                </td>
              </tr>
              @endif
              <tr>
                <td>Amount :</td>
                <td>{{$payment->totalamount}}/-</td>
              </tr>
              <tr>
                <td>Delivery Charges :</td>
                <td>{{$payment->damount}}/-</td>
              </tr>
              <tr>
                <td>Note :</td>
                <td>{{$payment->payment_note}}</td>
              </tr>
            </table>
            <!-- <img src="{{ URL::to('/') }}/payment_details/{{ $payment->file }}" alt="" class="img img-responsive"> -->
            @endif 
            @endforeach  
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            Messages: <br>
                            @foreach($messages as $message)
                                @if($message->to_user == $order->id)
                                    <p
                                        style="width:70%;
                                            border-style:ridge;
                                            padding:10px;
                                            border-width:2px;
                                            border-radius:10px;
                                            {{ $message->from_user == Auth::user()->id ? 'border-bottom-left-radius:0px;' : 'border-bottom-right-radius:0px;' }}
                                            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
                                            "
                                            class="text-justify {{ $message->from_user == Auth::user()->id ? 'pull-right' : 'pull-left' }}">
                                        @foreach($users as $user)
                                            @if($user->id == $message->from_user)
                                                <b>- {{ $user->name }} : </b><br>
                                            @endif
                                        @endforeach
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $message->body }}
                                        <br>
                                        <span class="pull-right"><i>{{ $message->created_at->diffforHumans() }}</i></span>
                                    </p>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-md-12">
                            <form action="{{ URL::to('/') }}/sendMessage" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="orderId" value="{{ $order->id }}">    
                                <div class="input-group">
                                    <input type="text" name="message" id="message" placeholder="Type Your Message Here" class="form-control">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-success">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            </div>
        </div>
    @endforeach
@if(session('Success'))
<script>
    swal('Success',"{{ session('Success') }}",'success');
</script>
@endif
<script type="text/javascript">
    function checkthis(arg){
    var input = document.getElementById(arg).value;
    if(isNaN(input)){
        
               document.getElementById(arg).value = "";
    }
}
 function checkthis1(arg){
    var input = document.getElementById(arg).value;
    if(isNaN(input)){
        
               document.getElementById(arg).value = "";
    }
}
</script>
<script type="text/javascript">
  function onlyNumbers(evt) {
    var e = event || evt; // For trans-browser compatibility
    var charCode = e.which || e.keyCode;

    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function NumToWord(inputNumber, outputControl) {
    var str = new String(inputNumber)
    var splt = str.split("");
    var rev = splt.reverse();
    var once = ['Zero', ' One', ' Two', ' Three', ' Four', ' Five', ' Six', ' Seven', ' Eight', ' Nine'];
    var twos = ['Ten', ' Eleven', ' Twelve', ' Thirteen', ' Fourteen', ' Fifteen', ' Sixteen', ' Seventeen', ' Eighteen', ' Nineteen'];
    var tens = ['', 'Ten', ' Twenty', ' Thirty', ' Forty', ' Fifty', ' Sixty', ' Seventy', ' Eighty', ' Ninety'];

    numLength = rev.length;
    var word = new Array();
    var j = 0;

    for (i = 0; i < numLength; i++) {
        switch (i) {

            case 0:
                if ((rev[i] == 0) || (rev[i + 1] == 1)) {
                    word[j] = '';
                }
                else {
                    word[j] = '' + once[rev[i]];
                }
                word[j] = word[j];
                break;

            case 1:
                aboveTens();
                break;

            case 2:
                if (rev[i] == 0) {
                    word[j] = '';
                }
                else if ((rev[i - 1] == 0) || (rev[i - 2] == 0)) {
                    word[j] = once[rev[i]] + " Hundred ";
                }
                else {
                    word[j] = once[rev[i]] + " Hundred and";
                }
                break;

            case 3:
                if (rev[i] == 0 || rev[i + 1] == 1) {
                    word[j] = '';
                }
                else {
                    word[j] = once[rev[i]];
                }
                if ((rev[i + 1] != 0) || (rev[i] > 0)) {
                    word[j] = word[j] + " Thousand";
                }
                break;

                
            case 4:
                aboveTens();
                break;

            case 5:
                if ((rev[i] == 0) || (rev[i + 1] == 1)) {
                    word[j] = '';
                }
                else {
                    word[j] = once[rev[i]];
                }
                if (rev[i + 1] !== '0' || rev[i] > '0') {
                    word[j] = word[j] + " Lakh";
                }
                 
                break;

            case 6:
                aboveTens();
                break;

            case 7:
                if ((rev[i] == 0) || (rev[i + 1] == 1)) {
                    word[j] = '';
                }
                else {
                    word[j] = once[rev[i]];
                }
                if (rev[i + 1] !== '0' || rev[i] > '0') {
                    word[j] = word[j] + " Crore";
                }                
                break;

            case 8:
                aboveTens();
                break;

            //            This is optional. 

            //            case 9:
            //                if ((rev[i] == 0) || (rev[i + 1] == 1)) {
            //                    word[j] = '';
            //                }
            //                else {
            //                    word[j] = once[rev[i]];
            //                }
            //                if (rev[i + 1] !== '0' || rev[i] > '0') {
            //                    word[j] = word[j] + " Arab";
            //                }
            //                break;

            //            case 10:
            //                aboveTens();
            //                break;

            default: break;
        }
        j++;
    }

    function aboveTens() {
        if (rev[i] == 0) { word[j] = ''; }
        else if (rev[i] == 1) { word[j] = twos[rev[i - 1]]; }
        else { word[j] = tens[rev[i]]; }
    }

    word.reverse();
    var finalOutput = '';
    for (i = 0; i < numLength; i++) {
        finalOutput = finalOutput + word[i];
    }
    document.getElementById("dtow1").value = finalOutput;
    document.getElementById(outputControl).innerHTML = finalOutput;
}
function NumToWord1(inputNumber, outputControl) {
    var str = new String(inputNumber)
    var splt = str.split("");
    var rev = splt.reverse();
    var once = ['Zero', ' One', ' Two', ' Three', ' Four', ' Five', ' Six', ' Seven', ' Eight', ' Nine'];
    var twos = ['Ten', ' Eleven', ' Twelve', ' Thirteen', ' Fourteen', ' Fifteen', ' Sixteen', ' Seventeen', ' Eighteen', ' Nineteen'];
    var tens = ['', 'Ten', ' Twenty', ' Thirty', ' Forty', ' Fifty', ' Sixty', ' Seventy', ' Eighty', ' Ninety'];

    numLength = rev.length;
    var word = new Array();
    var j = 0;

    for (i = 0; i < numLength; i++) {
        switch (i) {

            case 0:
                if ((rev[i] == 0) || (rev[i + 1] == 1)) {
                    word[j] = '';
                }
                else {
                    word[j] = '' + once[rev[i]];
                }
                word[j] = word[j];
                break;

            case 1:
                aboveTens();
                break;

            case 2:
                if (rev[i] == 0) {
                    word[j] = '';
                }
                else if ((rev[i - 1] == 0) || (rev[i - 2] == 0)) {
                    word[j] = once[rev[i]] + " Hundred ";
                }
                else {
                    word[j] = once[rev[i]] + " Hundred and";
                }
                break;

            case 3:
                if (rev[i] == 0 || rev[i + 1] == 1) {
                    word[j] = '';
                }
                else {
                    word[j] = once[rev[i]];
                }
                if ((rev[i + 1] != 0) || (rev[i] > 0)) {
                    word[j] = word[j] + " Thousand";
                }
                break;

                
            case 4:
                aboveTens();
                break;

            case 5:
                if ((rev[i] == 0) || (rev[i + 1] == 1)) {
                    word[j] = '';
                }
                else {
                    word[j] = once[rev[i]];
                }
                if (rev[i + 1] !== '0' || rev[i] > '0') {
                    word[j] = word[j] + " Lakh";
                }
                 
                break;

            case 6:
                aboveTens();
                break;

            case 7:
                if ((rev[i] == 0) || (rev[i + 1] == 1)) {
                    word[j] = '';
                }
                else {
                    word[j] = once[rev[i]];
                }
                if (rev[i + 1] !== '0' || rev[i] > '0') {
                    word[j] = word[j] + " Crore";
                }                
                break;

            case 8:
                aboveTens();
                break;

            //            This is optional. 

            //            case 9:
            //                if ((rev[i] == 0) || (rev[i + 1] == 1)) {
            //                    word[j] = '';
            //                }
            //                else {
            //                    word[j] = once[rev[i]];
            //                }
            //                if (rev[i + 1] !== '0' || rev[i] > '0') {
            //                    word[j] = word[j] + " Arab";
            //                }
            //                break;

            //            case 10:
            //                aboveTens();
            //                break;

            default: break;
        }
        j++;
    }

    function aboveTens() {
        if (rev[i] == 0) { word[j] = ''; }
        else if (rev[i] == 1) { word[j] = twos[rev[i - 1]]; }
        else { word[j] = tens[rev[i]]; }
    }

    word.reverse();
    var finalOutput = '';
    for (i = 0; i < numLength; i++) {
        finalOutput = finalOutput + word[i];
    }
    document.getElementById("dtow2").value = finalOutput;
    document.getElementById(outputControl).innerHTML = finalOutput;
}
</script>
<script src="http://www.ittutorials.in/js/demo/numtoword.js; type="text/javascript"></script>
@endsection