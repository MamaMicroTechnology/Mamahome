
@extends('layouts.app')
@section('content')
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading" style="background-color: green;"><p style="color: white">
				Search project and Get Quotation
                 </p>
				  <a onclick="history.back(-1)" class="btn btn-default pull-right" style="margin-top:-30px;" > <i class="fa fa-arrow-circle-left" style="padding:5px;width:50px;"></i></a>
			</div>
			<div class="panel-body" style="overflow-x: scroll;">
				
				<form method="GET" action="{{ URL::to('/') }}/getprojects">
					<div class="col-md-12">
						<div class="col-md-2">
							<select required name="quot" onchange="getSubwards()" id="ward" class="form-control">
								<option value="">--Select--</option>
							<option value="Project">Project</option>
							<option value="Manufacturer">Manufacturer</option>
							</select>
						</div>
						<div class="col-md-4">
							<input required type="text" name="id" placeholder="Enter Project Id/Manufacturer Id" class="form-control">
						</div>
						<div class="col-md-2">
							<input type="submit" class="form-control" value="Fetch">
						</div>
					</div>
				</form>
				<br><br><br>
				<table class="table table-hover" border="1"> 
					<thead>
						<tr>
							<th style="text-align: center">Project_Id</th>
							<th style="text-align: center">Requirement Date</th>
							<th style="text-align: center">Enquiry Date</th>
							<th style="text-align: center">Contact</th>
							<th style="text-align: center">Product</th>
							<th style="text-align: center">Quantity</th>
							<th style="text-align: center">Total Quantity</th>
							<th style="text-align: center">Initiator</th>
							<th style="text-align: center">Status</th>
							<th style="text-align: center">Remarks</th>
							<th style="text-align: center">Quotation</th>
						</tr>
					</thead>
					@if($enquiries != null)
						@foreach($enquiries  as $enquiry)
					<tbody>
						<tr>
							<td style="text-align: center">
								@if($enquiry -> project_id == null)
		                            <a href="{{ URL::to('/') }}/updateManufacturerDetails?id={{ $enquiry->manu_id }}">Manufacturer {{$enquiry -> manu_id}}</a>
		                         @else
								<a target="_blank" href="{{URL::to('/')}}/showThisProject?id={{$enquiry -> project_id}}">
									<b>{{$enquiry->project_id }}</b>
								</a> 
	                            @endif
							</td>
							<td style="text-align: center">{{$newDate = date('d/m/Y', strtotime($enquiry->requirement_date)) }}</td>
							<td style="text-align: center">{{ date('d/m/Y', strtotime($enquiry->created_at)) }}</td>
							<td style="text-align: center">{{ $enquiry->procurementdetails != null ? $enquiry->procurementdetails->procurement_contact_no : '' }}
							 {{ $enquiry->proc != null ? $enquiry->proc->contact :''  }}</td>
							<td style="text-align: center;width: 30px;" ><b>{{$enquiry->brand}}</b><br>{{$enquiry -> main_category}} ({{ $enquiry->sub_category }}), {{ $enquiry->material_spec }} {{ $enquiry->product }} 
							</td>
							<td style="text-align: center">
								<?php $quantity = explode(", ",$enquiry->quantity); ?>
								@for($i = 0; $i<count($quantity); $i++)
								{{ $quantity[$i] }}<br>
								@endfor
							</td>
							<td style="text-align: center">{{ $enquiry->total_quantity }}</td>
							<td style="text-align: center">{{ $enquiry->user != null ? $enquiry->user->name : '' }}</td>
							<td style="text-align: center">
								{{ $enquiry->status}}
							</td>
							<td style="text-align: center">
								{{ $enquiry->notes}}
							</td>
							@if($enquiry->quotation == null)
							<td><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#quotation{{$enquiry->id}}{{$enquiry->manu_id}}">Get Quotation</button></td>
							@else
							<td><a type="button" href="{{ route('downloadquotation',['id'=>$enquiry->id,'manu_id'=>$enquiry->manu_id]) }}" style="background-color: #42413b;color:white" class="btn btn-sm">QUOTATION</a></td>
							@endif
						</tr>	
					</tbody>
					@endforeach
				</table>
				@foreach($enquiries  as $enquiry)
					<!-- Modal -->
						<div id="quotation{{$enquiry->id}}{{$enquiry->manu_id}}" class="modal fade" role="dialog">
						  <div class="modal-dialog">

						    <!-- Modal content-->
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h4 class="modal-title">Quotation</h4>
						      </div>
						      <div class="modal-body">
						      		
						     <form action="{{ URL::to('/') }}/generatequotation?id={{$enquiry->id}}&&manu_id={{$enquiry->manu_id}}&&pid={{$enquiry->project_id}}" method="post">
                            {{ csrf_field() }}
                            @foreach($enquiries as $enq )
               
                                @if($enq->id == $enquiry->id)
                           	<input type="hidden"  name="dtow1" id="dtow1{{$enq->id}}" value="">
                            <input type="hidden" name="dtow2" id="dtow2{{$enq->id}}" value="">
                            <input type="hidden" name="dtow3" id="dtow3{{$enq->id}}" value="">
                            		
                            <table class="table table-responsive table-striped" border="1">
                            	<tr>
                            		<td>Description Of Goods : </td>
                            		<td><input type="text" name="description" value="{{$enq->brand}}" class="form-control"></td>
                            	</tr>
                            	<tr>
                            		<td>Ship Address : </td>
                            		<td><input required type="text" class="form-control" value="{{$enq->ship}}" name="ship"></td>
                            	</tr>
                            	<tr>
                            		<td>Bill Address : </td>
                            		<td><input required type="text" class="form-control" value="{{$enq->billadress}}" name="bill"></td>
                            	</tr>
                            	<tr>
                            		<td> Total Quantity :</td>
                            		<td><input required type="number" class="form-control" name="quantity" placeholder="quantity" id="quan{{$enq->id}}"  value="{{$enq->total_quantity}}"></td>
                            	</tr>
                            	<tr>
                            		<td>Unit :</td>
                            		<td>
                            			<input type="radio" name="unit" value="tons" >Tons
			                            <input type="radio" name="unit" value="Bags" checked> Bags
                            		</td>
                            	</tr>
                            	<tr>
                            		<td>Price(Per Unit) :</td>
                            		<td><input required type="number" id="unit{{$enq->id}}"  class="form-control" name="price" placeholder="Unit Price" onkeyup="getcalculation('{{$enquiry->id}}')"></td>
                            	</tr> 
                            	<tr>
                                        <td>Unit Price without GST :</td>
                                        <td>&nbsp;&nbsp;&nbsp;RS.<label class=" alert-success pull-left" id="withoutgst{{$enq->id}}"></label>/-
                                           <input class="hidden" id="withoutgst1{{$enq->id}}" type="text"  name="withoutgst"  value="">
                                       </td>
                           		 </tr>
                            	 <tr>
                                        <td>Total Amount : </td>
                                        <td>
                                              &nbsp;&nbsp;&nbsp;RS .<label class=" alert-success pull-left" id="display{{$enq->id}}"></label>/-
                                              <input class="hidden" id="display1{{$enq->id}}" value="" name="display">
                                              <label class=" alert-success pull-right" id="lblWord{{$enq->id}}"></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>CGST(14%) : </td>
                                        <td>
                                              &nbsp;&nbsp;&nbsp;CGST <label class=" alert-success pull-left" id="cgst{{$enq->id}}"></label>/-
                                              <input class="hidden" id="cgst1{{$enq->id}}" value="" name="cgst">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>SGST(14%) : </td>
                                        <td>
                                             &nbsp;&nbsp;&nbsp;SGST <label class=" alert-success pull-left" id="sgst{{$enq->id}}"></label>/-
                                              <input class="hidden" id="sgst1{{$enq->id}}" value="" name="sgst">
                                        </td>
                                    </tr>
                                    <tr>
                                      <td>Total Tax :</td>
                                      <td>&nbsp;&nbsp;&nbsp;<label class=" alert-success pull-left" id="totaltax{{$enq->id}}"></label>Total
                                      	<input class="hidden" id="totaltax1{{$enq->id}}" value="" name="totaltax">
                                        <label class=" alert-success pull-right" id="lblWord1{{$enq->id}}"></label>
                                      </td>
                                    </tr>
                                    <tr>
                                        <td>Amount (Including GST) :</td>
                                        <td>
                                              &nbsp;&nbsp;&nbsp;RS .<label class=" alert-success pull-left" id="withgst{{$enq->id}}"></label>/-
                                              <input class="hidden" type="text" id="withgst1{{$enq->id}}" name="withgst" value="">
                                              <label class=" alert-success pull-right" id="lblWord2{{$enq->id}}"></label>
                                        </td>
                                    </tr>         
                            </table>
			                    <center><button type="submit" class="btn btn-sm btn-success" onclick="finalsubmit('{{$enq->id}}')">Confirm</button>
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
					@endforeach
				@endif
			</div>
		</div>
	</div>
<script type="text/javascript">
	function NumToWord(inputNumber, outputControl,arg){
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
    document.getElementById("dtow1"+arg).value = finalOutput;
    document.getElementById(outputControl).innerHTML = finalOutput;
}
function NumToWord1(inputNumber, outputControl,arg) {
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
    document.getElementById("dtow2"+arg).value = finalOutput;
    document.getElementById(outputControl).innerHTML = finalOutput;
}
function NumToWord2(inputNumber, outputControl,arg){
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
    document.getElementById('dtow3'+arg).value = finalOutput;
    document.getElementById(outputControl).innerHTML = finalOutput;
}
function getcalculation(arg){
var x =document.getElementById('unit'+arg).value;
var y = document.getElementById('quan'+arg).value;
var withoutgst = (x /1.28);
var t = (withoutgst * y);
var f = Math.round(t);
var gst = (t * 14)/100;
var sgt = (t * 14)/100;
var withgst = (gst + sgt + t);
var final = Math.round(withgst);
var tt = (gst + sgt);
var totaltax = Math.round(tt);
document.getElementById('display'+arg).innerHTML = t;
document.getElementById('display1'+arg).value = f;
document.getElementById('cgst'+arg).innerHTML = gst;
document.getElementById('sgst'+arg).innerHTML = sgt;
document.getElementById('cgst1'+arg).value = gst;
document.getElementById('sgst1'+arg).value = sgt;
document.getElementById('withgst'+arg).innerHTML = withgst;
document.getElementById('withgst1'+arg).value = final;
document.getElementById('withoutgst'+arg).innerHTML = withoutgst;
document.getElementById('withoutgst1'+arg).value = withoutgst;
document.getElementById('totaltax'+arg).innerHTML = tt;
document.getElementById('totaltax1'+arg).value = totaltax;

}
function finalsubmit(arg){
  var input =  document.getElementById('display1'+arg).value;
  var output = document.getElementById('totaltax1'+arg).value;
  var inout = document.getElementById('withgst1'+arg).value;
  document.getElementById('display1'+arg).addEventListener("click", NumToWord(input,'lblWord'+arg,arg));
  document.getElementById('totaltax1'+arg).addEventListener("click", NumToWord1(output,'lblWord1'+arg,arg));
  document.getElementById('withgst1'+arg).addEventListener("click", NumToWord2(inout,'lblWord2'+arg,arg));
}
</script>
@endsection