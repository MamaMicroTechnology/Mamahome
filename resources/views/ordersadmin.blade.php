@extends('layouts.app')
@section('title','Orders')

@section('content')
<div class="col-md-12">
    <div class="panel panel-primary" style="overflow-x: scroll;">
        <div class="panel-heading text-center">
            <b style="color:white;font-size:1.4em">Orders</b>
           <button type="button" onclick="history.back(-1)" class="btn btn-default pull-right" style="margin-top:-3px;" > <i class="fa fa-arrow-circle-left" style="width:30px;"></i></button>
            <h4 class="pull-left" style="margin-top: -0.5px;">Total Count : {{ $view->total() }}</h4>

        </div>
        <div id="myordertable" class="panel-body">
            <form action="orders" method="get">
                <div class="input-group col-md-3 pull-right">
                    <input type="text" class="form-control pull-left" placeholder="Enter project id" name="projectId" id="projectId">
                    
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-success">Search</button>
                    </div>
                </div>
            </form>
             
            <br><br>
            <table class="table table-responsive table-striped" border="1">
                <thead>
                    <tr>
                        <th>Project ID</th>
                        <th>Order Id</th>
                        <th>Generated By</th>
                        <th>Required</th>
                        <th>Quantity</th>
                        <!-- <th>Logistics Coordinator</th> -->
                        <th>Requirement Date</th>
                        <th>Payment Status</th>
                        <th>Payment Mode</th>
                        <th>Dispatch Status</th>
                       <!--  <th>Delivery Status</th> -->
                        <!-- <th>Print Invoice</th> -->
                        <th> Confirm Order </th>
                       
                        <th>Get Purchase Order</th>
          
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($view as $rec)
                    <tr style="{{ $rec->order_status == 'Order Cancelled' ? 'background-color: #ffbaba;' : '' }}" id="row-{{$rec->id}}">
                        <td>
                            <a href="{{URL::to('/')}}/showThisProject?id={{$rec->project_id}}">{{$rec -> project_id}}</a>
                        </td>
                        <td>{{ $rec->orderid }}  </td>
                        <td>{{$rec->name}}</td>
                        <td>
                            {{$rec -> main_category}}<br>
                            {{$rec -> sub_category}}<br>
                            {{$rec -> brand}}<br>
                        </td>
                        <td>{{$rec->quantity}} {{$rec->measurement_unit}}</td>
                        <td>{{ date('d-m-Y',strtotime($rec -> requirement_date)) }}</td>
                        <td class="text-center" id="paymenttd-{{$rec->orderid}}">
                            @if($rec->ostatus == "Payment Received")
                                {{ $rec->ostatus }}
                            @else
                                {{ $rec->ostatus }}
                            @endif
                        </td>
                        <td>
                            @if($rec->ostatus == "Payment Received")
                                <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#paymentModal{{ $rec->orderid }}">
                                    {{ $rec->payment_mode }}
                                    <span class="badge">{{ $counts[$rec->orderid] }}</span>
                                </button>
                            @elseif($rec->order_status != "Order Cancelled")
                                <a href="{{URL::to('/')}}/paymentmode?id={{$rec->orderid}}" target="_blank" class="btn btn-success btn-xs">Payment Details</a>
                            @endif

                            
                             
      
</div>
<!-- Modal -->
                    <div id="payment{{$rec->orderid}}" class="modal fade" role="dialog">
                      <div class="modal-dialog" style="width:30%">

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
                                        <td>{{ $rec->payment_mode }}</td>   
                                    </tr>
                                    <tr>
                                        <td>Category :</td>
                                        <td>{{ $rec->main_category }}</td>
                                    </tr>
                                    <tr>
                                        <td>Quantity :</td>
                                        <td>{{ $rec->quantity }}</td>
                                    </tr>
                                </table>
                           <form action="{{ URL::to('/') }}/confirmOrder?id={{$rec->orderid}}" method="post">
                            {{ csrf_field() }}
                            <label> Total Quantity : </label>
                            <input required type="number" class="form-control" name="quantity" placeholder="quantity" id="quan" onkeyup="checkthis('quan')">
                            <br>
                            <input type="radio" name="unit" value="tons" >Tons
                            <input type="radio" name="unit" value="bags" checked> Bags
                            <br></br>
                            <label>Price(Per Unit) : </label>
                            <input required type="number" id="unit"  class="form-control" name="mamaprice" placeholder="Unit Price" onkeyup="checkthis1('unit')">
                            <br>
                            <!-- <label>Manufacturer Price(Per Unit) : </label>
                            <input  required type="number" id="unit"  class="form-control" name="manuprice" placeholder="Unit Price" onkeyup="checkthis1('unit')"> -->
                            <center><button type="submit" class="btn btn-sm btn-success" type="">Confirm</button></center>
                            <br>
                           </form>
                          </div>
                          <div class="modal-footer">
                            <button  type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>

<!-- payment details modal -->
<!-- Modal -->
<div id="purchase{{$rec->orderid}}" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background-color: green;color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align: center;">Purchase Order</h4>
      </div>
      <div class="modal-body">
        <form action="{{ URL::to('/') }}/savesupplierdetails?id={{$rec->orderid}}" method="post">
            {{ csrf_field() }}
        <input type="text" class="hidden" value="" id="dtow{{$rec->orderid}}" name="dtow" >
        <input type="text" class="hidden" value="" id="dtow1{{$rec->orderid}}" name="dtow1" >
       <table class="table table-responsive table-striped" border="1">
                                    <tr>
                                        <td>Supplier Name :</td>
                                        <!-- <td><textarea required type="text" name="sname" class="form-control" rows="5" style="resize: none;"></textarea></td> -->
                                        <td> 
                                        <select class="form-control" id="name{{$rec->orderid}}" name="name" onchange="getaddress('{{$rec->orderid}}')">
                                            <option value="">--Select--</option>
                                            @foreach($manusuppliers as $manu)
                                            <option {{ isset($_GET['manu']) ? $_GET['manu'] == $manu->company_name ? 'selected' : '' : '' }} value="{{ $manu->manufacturer_id }}">{{ $manu->company_name }}</option>
                                            @endforeach
                                        </select>
                                      </td>

                                    </tr>
                                    <tr>
                                      <td>Registered Office :
                                      </td>
                                      <td><input required type="text" class="form-control" name="address" id="address{{$rec->orderid}}" name="address" value=""></td>
                                    </tr>
                                    <tr>
                                        <td>GST :</td>
                                        <td><input required type="text" id="suppliergst{{$rec->orderid}}" name="gst" value="" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td>Description of Goods : </td>
                                        <td><input required type="text" name="desc" id="category{{$rec->orderid}}" class="form-control" value=""></td>
                                    </tr>
                                    <tr>
                                        <td>Quantity :</td>
                                        <td><input required type="number" name="quantity" class="form-control" id="qu{{$rec->orderid}}"></td>
                                    </tr>
                                     <tr>
                                        <td>Unit:</td>
                                        <td><input type="radio" name="unit" value="tons" >Tons
                                            <input type="radio" name="unit" value="bags" checked> Bags
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Unit Price :</td>
                                        <td><input required type="number" id="unitprice{{$rec->orderid}}" name="uprice" class="form-control" onkeyup="showthis('{{$rec->orderid}}')">
                                       </td>
                                    </tr>
                                    <tr>
                                          <td>Unit Price without GST :</td>
                                        <td>&nbsp;&nbsp;&nbsp;SGST <label class=" alert-success pull-left" id="withoutgst{{$rec->orderid}}"></label>/-
                                            <input class="hidden" id="withoutgst1{{$rec->orderid}}" type="text" name="unitwithoutgst" value="">
                                       </td>
                                    </tr>
                                    <tr>
                                        <td>Total Amount : </td>
                                        <td>
                                              &nbsp;&nbsp;&nbsp;RS .<label class=" alert-success pull-left" id="display{{$rec->orderid}}"></label>/-
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>CGST(14%) : </td>
                                        <td>
                                              &nbsp;&nbsp;&nbsp;CGST <label class=" alert-success pull-left" id="cgst{{$rec->orderid}}"></label>/-
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>SGST(14%) : </td>
                                        <td>
                                             &nbsp;&nbsp;&nbsp;SGST <label class=" alert-success pull-left" id="sgst{{$rec->orderid}}"></label>/-
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Amount (Including GST) :</td>
                                        <td>
                                              &nbsp;&nbsp;&nbsp;RS .<label class=" alert-success pull-left" id="withgst{{$rec->orderid}}"></label> /-
                                        </td>
                                    </tr>
                                    <tr class="hidden">
                                        <td>Amount :</td>
                                        <td><input id="amount{{$rec->orderid}}" required type="text" name="amount" maxlength="9" placeholder="quantity * unit price" onclick="NumToWord(this.value,'lblWord{{$rec->orderid}}','{{ $rec->orderid }}');" class="form-control" />
                             <label class=" alert-success pull-right" id="lblWord{{$rec->orderid}}"></label></td>
                             
                                    </tr>
                                    <tr class="hidden">
                                        <td>Enter Total Amount : </td>
                                       <td><input required id="tamount{{$rec->orderid}}" type="text" name="totalamount" maxlength="9" placeholder="CGST + SGST +Amount" onclick="NumToWord1(this.value,'lblWord1{{$rec->orderid}}','{{ $rec->orderid }}');" class="form-control" />
                             <label class=" alert-success pull-right" id="lblWord1{{$rec->orderid}}"></label></td>
                                    </tr>
        </table>
        <button onclick="gothr('{{$rec->orderid}}')" class="btn btn-success">Submit</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
                             <!-- The Modal -->
      <div class="modal" id="paymentModal{{ $rec->orderid }}">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header" style="width:100%;padding:2px;background-color:green;">
        <center>  <h4 class="modal-title" style="color: white;">Payment Details</h4></center>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            @foreach($paymentDetails as $payment)
            @if($payment->order_id == $rec->orderid)
            <table class="table table-responsive table-striped" border="1">
              <tr>
                <td>OrderId :</td>
                <td>{{$payment->order_id}}</td>
              </tr>
              <tr>
                <td>Payment Mode :</td>
                <td>{{ $payment->payment_mode }}</td>
              </tr>
              @if($payment->payment_mode == "CASH")
              <tr>
                <td>Cash Deposit Slip :</td>
                <td>
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
               <tr>
                <td>Cash Deposite Date :</td>
                <td>{{ date('d-m-Y',strtotime($payment->date))}}</td>
              </tr>
              @endif
              @if($payment->payment_mode == "RTGS")
               <tr>
                <td>Date :</td>
                <td>{{date('d-m-Y',strtotime($payment->date))}}</td>
              </tr>
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
                <td>Cheque Deposit Date :</td>
                <td>{{date('d-m-Y',strtotime($payment->date))}}</td>
              </tr>
              <tr>
                <td>Cheque Number :</td>
                <td>{{$payment->cheque_number}}
                </td>
              </tr>
              @endif
              @if($payment->payment_mode == "CASH IN HAND")
              <!-- <tr>
                <td>Cash Holder Name : </td>
                <td>{{$payment->cash_holder}}</td>
              </tr> -->
                 <tr>
                <td> Cash Received Date :</td>
                <td>{{date('d-m-Y',strtotime($payment->date))}}</td>
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
                        @if($message->to_user == $rec->orderid)
                            <p
                                style="width:70%;
                                    border-style:ridge;
                                    padding:10px;
                                    border-width:2px;
                                    border-radius:10px;
                                    {{ $message->from_user == Auth::user()->id ? 'border-bottom-left-radius:0px;' : 'border-bottom-right-radius:0px;' }}
                                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);"
                                    class="text-justify {{ $message->from_user == Auth::user()->id ? 'pull-right' : 'pull-left' }}">
                                @foreach($chatUsers as $user)
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
                        <input type="hidden" name="orderId" value="{{ $rec->orderid }}">    
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
        <!-- Modal footer -->
        <div class="modal-footer" style="padding:2px">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  
</div>
</td>

                        <td>
                            @if($rec->dispatch_status)
                            {{$rec->dispatch_status}}
                            @elseif(!$rec->dispatch_status)
                            Not Yet Dispatched
                            @endif
                        </td>
                        
                        <!-- <td>
                            <a href="{{URL::to('/')}}/{{$rec->orderid}}/printLPO" target="_blank" class="btn btn-sm btn-primary" >Print Invoice</a>
                        </td> -->
                        <td>
                            @if($rec->order_status == "Enquiry Confirmed" && ($rec->ostatus == "Payment Received"))
                            <div class="btn-group">
                                <!-- <a class="btn btn-xs btn-success" href="{{URL::to('/')}}/confirmOrder?id={{ $rec->orderid }}">Confirm</a> -->
                                <button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#payment{{$rec->orderid}}"> Confirm</button>
                                <button class="btn btn-xs btn-danger pull-right" onclick="cancelOrder('{{ $rec->orderid }}')">Cancel</button>
                            </div>
                            @else
                           {{ $rec->order_status }}
                            @endif
                          </td>
                         
                          <td>
                     
                            @if($rec->purchase_order == "yes")
                            <a href="{{ route('downloadpurchaseOrder',['id'=>$rec->orderid]) }}" class="btn btn-sm" style="background-color: rgb(204, 102, 153);color:white;">Purchase Order</a>
                          @else
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#purchase{{$rec->orderid}}">Get Purchase Order</button>
                         @endif
                     </td>
                        
                       <td>
                        @if($rec->order_status == "Enquiry Confirmed")
                            <a href="{{ URL::to('/') }}/editenq?reqId={{ $rec->id }}" class="btn btn-xs btn-primary">Edit</a>
                        @endif
                           @if($rec->clear_for_delivery == "Yes")
                            <a href="{{ URL::to('/') }}/viewProformaInvoice?id={{ $rec->orderid }}" class="btn btn-primary btn-xs">View Proforma Invoice</a>
                            <a href="{{ URL::to('/') }}/viewPurchaseOrder?id={{ $rec->orderid }}" class="btn btn-primary btn-xs">View Purchase Order</a>
                            @endif
                       </td>

                    </tr>
                    @endforeach
                </tbody>    
            </table>
            <br>
            <center>{{$view->links()}}</center>    
        </div>
    </div>
</div>


<script type="text/javascript">
    
    function pay(arg)
    {
        var e = document.getElementById("selectPayment-"+arg);
        var strUser = e.options[e.selectedIndex].value;
        var ans = confirm('Are You Sure ? Note: Changes Made Once CANNOT Be Undone');
        if(ans){
            $.ajax({
                type: 'GET',
                url: "{{URL::to('/')}}/updateampay",
                data: {payment: strUser, id: arg},
                async: false,
                success: function(response){
                    console.log(response);
                }
            });
        }
        return false;
    }

    function updateDispatch(arg)
    {
        var e = document.getElementById("selectdispatch-"+arg);
        var strUser = e.options[e.selectedIndex].value;
        var ans = confirm('Are You Sure ? Note: Changes Made Once CANNOT Be Undone');
        if(ans){
            $.ajax({
                type: 'GET',
                url: "{{URL::to('/')}}/updateamdispatch",
                data: {dispatch: strUser, id: arg},
                async: false,
                success: function(response){
                    console.log(response);    
                }
            });
        }
        return false;    
    }
    
    function confirmOrder(arg)
    {
        var ans = confirm('Are You Sure To Confirm This Order ?');
        if(ans)
        {
            $.ajax({
               type:'GET',
               url: "{{URL::to('/')}}/confirmOrder",
               data: {id : arg},
               async: false,
               success: function(response)
               {
                   console.log(response);
                        alert(response);
                   $("#myordertable").load(location.href + " #myordertable>*", "");
               }
            });
        }    
    }
    
    function cancelOrder(arg)
    {
        var ans = confirm('Are You Sure To Cancel This Order ?');
        if(ans)
        {
            $.ajax({
                type:'GET',
                url: "{{URL::to('/')}}/cancelOrder",
                data: {id : arg},
                async: false,
                success: function(response)
                {
                   console.log(response);
                   $("#myordertable").load(location.href + " #myordertable>*", "");
                }
            });
        }
    }
</script>
<script type="text/javascript">
    function paymethod(){
        var input = document.getElementById("payment_mode").value;
       if(input == "RTGS"){
            document.getElementById("input1").className = "";
       }
       else if(input == "CASH"){
            document.getElementById("payment_slip").className = "";
            document.getElementById("lb1").className = "";
            document.getElementById("input1").className = "";
       }
       
    }
</script>
<script type="text/javascript">
function NumToWord(inputNumber, outputControl ,arg){
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
    document.getElementById('dtow'+arg).value = finalOutput;
    document.getElementById(outputControl).innerHTML = finalOutput;
}
function NumToWord1(inputNumber, outputControl ,arg) {
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
    document.getElementById('dtow1'+arg).value = finalOutput;
    document.getElementById(outputControl).innerHTML = finalOutput;
}
function showthis(arg){
var x =document.getElementById('unitprice'+arg).value;
var y = document.getElementById('qu'+arg).value;
var withoutgst = (x /1.28);
var i = parseFloat(withoutgst).toFixed(2);
var t = (withoutgst * y);
var f = Math.round(t);
var gst = (t * 14)/100;
var sgt = (t * 14)/100;
var withgst = (gst + sgt + t);
var final = Math.round(withgst);
document.getElementById('display'+arg).innerHTML = t;
document.getElementById('cgst'+arg).innerHTML = gst;
document.getElementById('sgst'+arg).innerHTML = sgt;
document.getElementById('withgst'+arg).innerHTML = withgst;
document.getElementById('withoutgst'+arg).innerHTML = i;
document.getElementById('withoutgst1'+arg).value = i;
document.getElementById('amount'+arg).value = f;
document.getElementById('tamount'+arg).value = final;
// document.getElementById('display'+arg).innerHTML = gst;
}
function gothr(arg){
  var input =  document.getElementById('amount'+arg).value;
  var output = document.getElementById('tamount'+arg).value;
  document.getElementById('amount'+arg).addEventListener("click", NumToWord(input,'lblWord'+arg,arg));
  document.getElementById('tamount'+arg).addEventListener("click", NumToWord1(output,'lblWord1'+arg,arg));
}
function getaddress(arg){
  var x = document.getElementById('name'+arg);
  var name = x.options[x.selectedIndex].value;
  var x = arg;
  $.ajax({
                    type:'GET',
                    url:"{{URL::to('/')}}/getgst",
                    async:false,
                    data:{name : name , x : x},
                    success: function(response)
                    {
                       
                         console.log(response);
                         for(var i=0;i<response.length;i++)
                        {
                           var text = response[i].cin;
                        }
                        var id = response.id;
                        var name = response.res;
                        var gst = response.gst;
                        var cat = response.category;
                         console.log(document.getElementById('address'+id).value = name); 
                         console.log(document.getElementById('suppliergst'+id).value = gst); 
                         // console.log(document.getElementById('category'+id).value = cat); 
                    }
                });
            }
</script>
<script src="http://www.ittutorials.in/js/demo/NumToWord.js; type="text/javascript"></script>
@endsection
