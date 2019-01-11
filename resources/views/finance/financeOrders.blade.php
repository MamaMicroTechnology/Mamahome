<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 26? "finance.layouts.headers":"layouts.app");
?>
@extends($ext)
@section('content')
 <form action="financeDashboard" method="get">
                <div class="input-group col-md-3 pull-right">
                    <input type="text" class="form-control pull-left" placeholder="Enter project id" name="projectId" id="projectId">
                    
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-success">Search</button>
                    </div>
                </div>
            </form>
             
            <br><br>
<div class="col-md-12 ">
    <table class="table table-responsive" border=1>
        <th>Requirement Date</th>
        <th>Project Id</th>
        <th>Order Id</th>
        <th>Category</th>
        <th>Quantity</th>
        <th>Payment Details</th>
        @if(Auth::user()->group_id != 22)
        <th> Generate Invoice</th>
        <th>MAMAHOME Invoice</th>
        @endif
        @foreach($orders as $order)
        <tr style="{{ date('Y-m-d') == $order->requirement_date ? 'background-color:#ccffcc': '' }}">
            <td>{{ date('d M, y',strtotime($order->requirement_date)) }}</td>
             <td style="text-align:center"><a href="{{ URL::to('/') }}/admindailyslots?projectId={{$order->project_id}}&&lename=" target="_blank">{{ $order->project_id }}</a>
              @if($order-> project_id == null)
                            <a href="{{ URL::to('/') }}/updateManufacturerDetails?id={{ $order->manu_id }}">Manufacturer{{$order->manu_id}}</a>
              @endif
             </td>
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
                  <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#payment{{$order->id}}">Edit</button>
                 @endif             
            </td>
            <td>
                
                    
            <?php 
                $rec =count($order->confirm_payment); 
              
             ?> 
                @if($rec == 1)
                    <div class="btn-group">
    <a type="button" href="{{ route('downloadInvoice',['id'=>$order->id,'manu_id'=>$order->manu_id]) }}" class="btn btn-primary btn-xs">PROFORMA</a>
    <a type="button" href="{{ route('downloadTaxInvoice',['id'=>$order->id,'manu_id'=>$order->manu_id]) }}" class="btn btn-success btn-xs">TAX</a>
    <!-- <a type="button"  href="{{ route('downloadpurchaseOrder',['id'=>$order->id]) }}" class="btn btn-danger btn-xs">PUCHASE</a> -->
  </div>
               @else
                    <div class="btn-group">
    <a disabled type="button" href="{{ route('downloadInvoice',['id'=>$order->id]) }}" class="btn btn-primary btn-xs">PROFORMA</a>
    <a disabled type="button" href="{{ route('downloadTaxInvoice',['id'=>$order->id]) }}" class="btn btn-success btn-xs">TAX</a>
    <!-- <a disabled type="button"  href="{{ route('downloadpurchaseOrder',['id'=>$order->id]) }}" class="btn btn-danger btn-xs">PUCHASE</a> -->
  </div>
            
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
                            <h4 class="modal-title">Generate Invoice</h4>
                          </div>
                          <div class="modal-body">
                           <form action="{{ URL::to('/') }}/saveunitprice?id={{$order->id}}&&manu_id={{$order->manu_id}}" method="post">
                            {{ csrf_field() }}
                           <!--  <input class="hidden" type="text" name="dtow1" id="dtow1{{$order->id}}" value="">
                            <input type="hidden" name="dtow2" id="dtow2{{$order->id}}" value="">
                            <input type="hidden" name="dtow3" id="dtow3{{$order->id}}" value="">
                            <input type="hidden" name="dtow4" id="dtow4{{$order->id}}" value=""> -->

                             @foreach($mamaprices as $price )  
                            @if($price->order_id == $order->id)
                           <table class="table table-responsive table-striped" border="1">
                            <input  type="hidden" name="g1" id="g1{{$order->id}}" value="{{$price->cgstpercent}}">
                            <input type="hidden" name="g2" id="g2{{$order->id}}" value="{{$price->sgstpercent}}">
                            <input type="hidden" name="g3" id="g3{{$order->id}}" value="{{$price->gstpercent}}">
                            <input type="hidden" name="i1" id="i1{{$order->id}}" value="{{$price->igstpercent}}">
                            
                           
                           <tr>
                            <?php 
                                     $rec =count($order->confirm_payment); 
                             ?>  
                              <td>Description of Goods : </td>
                             @if($rec == 0)
                                  <td><input required type="text" name="desc" class="form-control" value="{{ $order->main_category }}"></td>
                             @else
                                  <td><input required type="text" name="desc" class="form-control" value="{{$price->description}}"></td>
                                  @endif
                           </tr>
                              <?php 
                                     $rec =count($order->confirm_payment); 
                             ?> 
                         @if($rec == 0)
                                   @foreach($reqs as $req)
                                    @if($req->id == $order->req_id)
                                          <tr>
                                              <td>Billing Address : </td> 
                                              <td><textarea  required type="text" name="bill" class="form-control" style="resize: none;" rows="5">{{$req->billadress}}</textarea></td>
                                          </tr>
                                          <tr>
                                              <td>Shipping Address : </td> 
                                               @if($order-> project_id == null)
                                               <td><textarea required type="text" name="ship" class="form-control" style="resize: none;" rows="5">{{$req->manu != null ? $req->manu->address : ''}}</textarea></td>
                                               @else
                                              <td><textarea required type="text" name="ship" class="form-control" style="resize: none;" rows="5">{{$req->siteaddress != null ? $req->siteaddress->address : ''}}</textarea></td>
                                              @endif
                                          </tr>
                                        @endif
                                       @endforeach  
                         @else
                              <tr>
                                  <td>Billing Address : </td> 
                                  <td><textarea  required type="text" name="bill" class="form-control" style="resize: none;" rows="5">{{$price->billaddress}}</textarea></td>
                              </tr>
                              <tr>
                                  <td>Shipping Address : </td> 
                                  <td><textarea required type="text" name="ship" class="form-control"  style="resize: none;" rows="5">{{$price->shipaddress}}</textarea></td>
                              </tr>
                         @endif
                           <tr>
                             <td>Total Quantity : </td>
                             <td><input required type="number" class="form-control" name="quantity" value="{{$price->quantity}}" id="quan{{$order->id}}"></td>
                           </tr>
                            <tr>
                              <td>Unit of Measurement : </td>
                              <td><input  type="text" name="unit" value="{{$price->unit}}" class="form-control" readonly>
                           
                            </tr>
                            <tr>
                              <td>Price(Per Unit) : </td>
                              <td><input required type="number" id="unit{{$order->id}}"  class="form-control" name="price" value="{{$price->mamahome_price}}"  onkeyup="getcalculation('{{$order->id}}')"></td>
                            </tr>  
                            <tr>
                                        <td>Unit Price without GST :</td>
                                        <td>&nbsp;&nbsp;&nbsp;RS.<label class=" alert-success pull-left" id="withoutgst{{$order->id}}"></label>/-
                                            <input readonly id="withoutgst1{{$order->id}}" type="text" name="unitwithoutgst"  value="{{$price->unitwithoutgst}}">
                                       </td>
                              </tr>
                                    <tr>
                                        <td>Total Amount : </td>
                                        <td>
                                              &nbsp;&nbsp;&nbsp;RS .<label class=" alert-success pull-left" id="display{{$order->id}}"></label>/-
                                              <input readonly id="amount{{$order->id}}" type="text" name="tamount" value="{{$price->totalamount}}">
                                              <label class=" alert-success pull-right" id="lblWord{{$order->id}}"></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>CGST({{$price->cgstpercent}}%) : </td>
                                        <td>
                                              &nbsp;&nbsp;&nbsp;CGST <label class=" alert-success pull-left" id="cgst{{$order->id}}"></label>/-
                                              <input readonly  id="cgst1{{$order->id}}" type="text" name="cgst" value="{{$price->cgst}}">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>SGST({{$price->sgstpercent}}%) : </td>
                                        <td>
                                             &nbsp;&nbsp;&nbsp;SGST <label class=" alert-success pull-left" id="sgst{{$order->id}}"></label>/-
                                             <input readonly  id="sgst1{{$order->id}}" type="text" name="sgst" value="{{$price->sgst}}">
                                        </td>
                                    </tr>
                                    <tr>
                                      <td>Total Tax :</td>
                                      <td>&nbsp;&nbsp;&nbsp;<label class=" alert-success pull-left" id="totaltax{{$order->id}}"></label>Total
                                        <input readonly id="totaltax1{{$order->id}}" type="text" name="totaltax" value="{{$price->totaltax}}">
                                        <label class=" alert-success pull-right" id="lblWord1{{$order->id}}"></label>
                                      </td>
                                    </tr>
                                    <tr>
                                        <td>IGST({{$price->igstpercent}}%) : </td>
                                        <td>
                                             &nbsp;&nbsp;&nbsp;IGST<label class=" alert-success pull-left" id="igst{{$order->id}}"></label>/-
                                             <input readonly  id="igst1{{$order->id}}" type="text" name="igst" value="{{$price->igst}}">
                                             <label class=" alert-success pull-right" id="lblWord3{{$order->id}}"></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Amount (Including GST) :</td>
                                        <td>
                                              &nbsp;&nbsp;&nbsp;RS .<label class=" alert-success pull-left" id="withgst{{$order->id}}"></label> /-
                                              <input readonly id="amountwithgst{{$order->id}}" type="text" name="gstamount" value="{{$price->amountwithgst}}">
                                              <label class=" alert-success pull-right" id="lblWord2{{$order->id}}"></label>
                                        </td>
                                    </tr>
                           
                            </table>
                            <center>
                            <button class="btn btn-sm btn-success" style="text-align: center;">Confirm</button></center>
                            @endif
                            @endforeach
                           </form>
                          </div>
                          <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal">Close</button>
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
                <td>{{ date('d-m-Y',strtotime($payment->date))}}</td>
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
                <td>RTGS Image: </td>
                  <td>
                      <?php
                             $images = explode(",", $payment->rtgs_file );
                            ?>
                           <div class="col-md-12">
                               @for($i = 0; $i < count($images); $i++)
                                   <div class="col-md-3">
                                        <img height="350" width="350" id="project_img" src="{{ URL::to('/') }}/public/rtgs_files/{{ $images[$i] }}" class="img img-thumbnail">
                                   </div>
                               @endfor
                            </div>
                  </td>
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
                <td>Cheque Number :</td>
                <td>{{$payment->cheque_number}}
                </td>
              </tr>
              @endif
              @if($payment->payment_mode == "CASH IN HAND")
              <tr>
                <td>Cash Holder Name :</td>
               <td>{{$payment->user != null?$payment->user->name :''}}</td>
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
            @foreach($payhistory as $payment)
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
                <td>Cash Deposit Date :</td>
                <td>{{ date('d-m-Y',strtotime($payment->date))}}</td>
              </tr>
              @endif
              @if($payment->payment_mode == "RTGS")
              <tr>
                  <td>RTGS Image: </td>
                  <td>
                      <?php
                             $images = explode(",", $payment->rtgs_file );
                            ?>
                           <div class="col-md-12">
                               @for($i = 0; $i < count($images); $i++)
                                   <div class="col-md-3">
                                        <img height="350" width="350" id="project_img" src="{{ URL::to('/') }}/public/rtgs_files/{{ $images[$i] }}" class="img img-thumbnail">
                                   </div>
                               @endfor
                            </div>
                  </td>
              </tr>
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
              <tr>
                <td>Cash Holder Name : </td>
                <td>{{$payment->user != null?$payment->user->name :''}}</td>
              </tr>
                 <tr>
                <td> Cash Received Date :</td>
                <td>{{date('d-m-Y',strtotime($payment->date))}}</td>
              </tr>
              @endif
              <tr>
                <td>Total Amount :</td>
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
function getcalculation(arg){
var x =document.getElementById('unit'+arg).value;
var y = document.getElementById('quan'+arg).value;
var g1 = document.getElementById('g1'+arg).value;
var g2 = document.getElementById('g2'+arg).value;
var g3 = document.getElementById('g3'+arg).value;
var g4 = document.getElementById('g1'+arg).value;
var g5 = document.getElementById('g2'+arg).value;
var i1 = document.getElementById('i1'+arg).value;
var i2 = document.getElementById('i1'+arg).value;


var withoutgst = (x /g3);
var t = (withoutgst * y);
var f = Math.round(t);
var gst = (t * g1)/100;
var sgt = (t * g2)/100;
var igst = (t * i1)/100;
var gst1 = (t * g4)/100;
var sgt1 = (t * g5)/100;
var ig = (t * i2)/100;
var igst1 = Math.round(ig);
var withgst = (gst + sgt + t + igst);
var final = Math.round(withgst);
var tt = (gst + sgt);

var totaltax = Math.round(tt);
document.getElementById('display'+arg).innerHTML = t;
document.getElementById('cgst'+arg).innerHTML = gst;
document.getElementById('sgst'+arg).innerHTML = sgt;
document.getElementById('igst'+arg).innerHTML = igst;
document.getElementById('withgst'+arg).innerHTML = withgst;
document.getElementById('withoutgst'+arg).innerHTML = withoutgst;
document.getElementById('withoutgst1'+arg).value = withoutgst;
document.getElementById('amount'+arg).value = f;
document.getElementById('cgst1'+arg).value = gst1;
document.getElementById('sgst1'+arg).value = sgt1;
document.getElementById('igst1'+arg).value = igst1;
document.getElementById('totaltax'+arg).innerHTML = tt;
document.getElementById('totaltax1'+arg).value = totaltax;
document.getElementById('amountwithgst'+arg).value = final;
}
// function finalsubmit(arg){
//   var input =  document.getElementById('amount'+arg).value;
//   var output = document.getElementById('totaltax1'+arg).value;
//   var inout = document.getElementById('amountwithgst'+arg).value;
//   var tax = document.getElementById('igst1'+arg).value;
//   document.getElementById('amount'+arg).addEventListener("click", NumToWord(input,'lblWord'+arg,arg));
//   document.getElementById('totaltax1'+arg).addEventListener("click", NumToWord1(output,'lblWord1'+arg,arg));
//   document.getElementById('amountwithgst'+arg).addEventListener("click", NumToWord2(inout,'lblWord2'+arg,arg));
//   document.getElementById('igst1'+arg).addEventListener("click", NumToWord3(tax,'lblWord3'+arg,arg));

// }
</script>
<script src="http://www.ittutorials.in/js/demo/numtoword.js; type="text/javascript"></script>
@endsection
