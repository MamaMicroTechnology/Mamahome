@extends('layouts.app')
@section('content')

<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
        <div class="panel-heading"><center>Total Invoices : {{  $invoice }}</center></div>
        <div class="panel-body">
          <b>Category Wise Invoices : {{$total}}</b>
 <center>  <form action="{{ URL::to('/') }}/viewInvoices" method="get" >
        <b> Select Category:</b>   <select class="form-control" name="cat" onchange="form.submit()" style="width:30%;">
              <option value="select">----Select category----</option>
              <option value="ALL">ALL</option>

              @foreach($cat as $cate)
              <option value="{{ $cate->category_name }}">{{ $cate->category_name }}</option>
              @endforeach

          </select>
</form></center>
        <table class="table table-hover">
            <thead>
                <th>Invoice No</th>
                <th>OrderId</th>
                <th>ProjectId</th>
                <th>Location</th>
                <th>Name</th>
                <th>Delivery Date</th>
               
            </thead>
            @foreach($inc as $invoice)
                <tr>
                    <td><a href="{{ URL::to('/') }}/invoice?id={{ $invoice->invoice_id }}">{{ $invoice->invoice_id }}</td>
                    <td>{{ $invoice->requirement_id }}</td>
                    <td>
                        
                    <a href="{{ URL::to('/') }}/admindailyslots?projectId={{ $invoice->project_id }}" target="_blank">{{ $invoice->project_id }} </a>
                    </td>
                    
                    <td>{{ $invoice->deliver_location }}</td>
                    <td>{{ $invoice->customer_name }}</td>
                    <td>
                       {{ date('d-m-Y', strtotime($invoice->delivery_date)) }}
                    </td>
                 </tr>
            @endforeach
         </table>
        </div>
    </div>
</div>

@endsection
