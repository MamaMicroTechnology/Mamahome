@extends('layouts.amheader')
@section('title','Print Invoice')
@section('content')
<?php $count = 0; ?>
<div class="col-md-12">
	<div class="panel panel-default" style="border-color:black">
		<div class="panel-heading" style="background-color:#f58120" id="panelhead">
            <label style="color:white;font-size:1.6em">Invoice</label>
            <button onclick="printthis()" class="btn btn-md btn-primary pull-right" style="width:10%;font-size:1.2em"><b>Print</b></a>
            <button onclick="downloadpdf()" class="btn btn-md pull-right" style="width:15%;font-size:1.2em;background-color:#168942;color:white"><b>Download As PDF</b></button>
		</div>
		<div class="panel-body" id='panelbody'><br>
		<center>
			<img src="{{URL::to('/')}}/logo.png" id="image" />
			<p style="font-size: 2em; font-weight: bold">INVOICE</p><br><br>
		</center>	
		<div class="row">
		    <div class="col-sm-6">
		        <b>BILL TO</b><br>
		        {{ $invoice->customer_name }}<br>
		        {{ $rec->road_name }}<br>
		        {{ $invoice->deliver_location }}
		    </div>
		    <div class="col-sm-6">
		        <div class="col-sm-4">
		            <b>Date</b><br>
		            <b>Invoice No.</b><br>
		            <b>GST</b><br>
		            <b>Email</b>
		        </div>
		        <div class="col-sm-8">
		            {{ $invoice->invoice_date }}<br>
		            {{ $invoice->invoice_number }}<br>
		            29AAKCM5956GIZX<br>
		            info@mamahome360.com
		        </div>
		    </div>
		</div>
		<br><br>
		<table class="table table-responsive">
		    <thead>
		        <th>S.No.</th>
		        <th>Description</th>
		        <th>Quantity</th>
		        <th>Unit</th>
		        <th>Price Per {{ $requirements->measurement_unit }}</th>
		        <th>Amount (INR)</th>
		    </thead>
		    <tbody>
		        <tr>
		            <td>{{ ++$count }}</td>
		            <td>{{ $requirements->material_spec }} ({{ $requirements->main_category }})</td>
		            <td>{{ $requirements->quantity }} {{ $requirements->measurement_unit }}</td>
		            <td></td>
		            <td>{{ $requirements->unit_price }}</td>
		            <td>{{ $invoice->amount_received }}</td>
		        </tr>
		    </tbody>
		</table>
			<div style="width:100%">
				<p style="font-weight: bold">MAMA HOME Pvt Ltd</p>
				<p>#363, 19th Main Road 1st Block,<br>Rajajinagar, Bangalore-560010<br>Ph: 9110636146<br>Email: info@mamahome360.com
			</div>
			<br>
			<br><br>
			<p><b>GST : </b>_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</p>
			<p><b>CIN : </b>_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</p>
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			<div class="col-md-12">
			    <p>Terms and Conditions</p>
			</div>
			<div class="col-md-12">
			    <div class="col-md-10 col-md-offset-1">
			        <!--<p style="font-size:1.5em">PO can be cancelled before the transit from the Manufacturer place</p>-->
			    </div>
			</div>
		</div>
	</div>
	
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
<script type="text/javascript">
    function downloadpdf()
    {
        document.getElementById('panelhead').style.display = 'none';
        var doc = new jsPDF();
        var html = document.getElementById('panelbody').innerHTML;
        doc.text(html, 10, 10);
        doc.save('invoice.pdf');
        return false;
    }
    function printthis()
    {
        document.getElementById('panelhead').style.display = 'none';
        window.print();
        location.reload(true);
        return false;
    }
</script>
@endsection