@extends('layouts.app')

@section('content')
<div class="col-md-6 col-md-offset-3">
	<div class="panel panel-default" style="border-color:black">
		<div class="panel-heading" style="background-color:#f58120" id="panelhead">
            <label style="color:white;font-size:1.6em">Invoice for {{ $rec->project_name }}</label>
            <button onclick="printthis()" class="btn btn-md btn-primary pull-right" style="width:10%;font-size:1.2em"><b>Print</b></a>
            <!--<button onclick="" class="btn btn-md pull-right" style="width:15%;font-size:1.2em;background-color:#168942;color:white"><b>Download As PDF</b></button>-->
		</div>
		<div class="panel-body" id='panelbody'><br>
			<img src="{{URL::to('/')}}/logo.png" id="image" />
			<p class="pull-right" style="font-size: 2em; font-weight: bold">INVOICE</p><br><br>
			<div style="width:100%">
				<p style="font-weight: bold">MAMA HOME Pvt Ltd</p>
				<p>#363, 19th Main Road 1st Block,<br>Rajajinagar, Bangalore-560010<br>Ph: 9110636146<br>Email: info@mamahome360.com
			</div>
			<br>
			<table class="table table-responsive">
			    <tbody>
			        <tr>
			            <td style="width:30%"><b>BILL TO</b></td>
			            <td style="width:30%"><b>SHIP TO</b></td>
			            <td style="width:40%;text-align:center">Invoice No: <b>{{ $id }}</b></td>
			        </tr>
			        <tr>
			            <td>{{ $rec->project_name }},<br>{{ $rec->siteaddress->address }}</td>
			            <td>{{ $rec->project_name }},<br>{{ $rec->siteaddress->address }}</td>
			            <td></td>
			        </tr>
			    </tbody>
			</table>
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<table class="table table-responsive" border="1">
						<thead>
							<th>Item Name</th>
							<th>Quantity</th>
							<th>Price</th>
						</thead>
						<tbody>
							<tr>
								<td>{{ $order->main_category }}:<br>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									{{ $order->sub_category }}
									@if($order->brand != null)
										({{ $order->brand }})
									@endif
								</td>
								<td><br>{{ $order->quantity }}</td>
								<td><br>{{ $order->unit_price * $order->quantity }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<br><br>
			<p><b>GST : </b>_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</p>
			<p><b>CIN : </b>_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</p>
			<br><br><br>
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