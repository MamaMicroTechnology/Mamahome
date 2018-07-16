@extends('layouts.app')
@section('content')

<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
        <div class="panel-heading"><center>Total Invoices : {{  $invoice }}</center></div>
        <div class="panel-body">
          
<table class="table table-hover">
            <thead>
                <th>Invoice No</th>
                <th>OrderId</th>
                <th>ProjectId</th>
                <th>Location</th>
                <th>Name</th>
                <th>Delivery Date</th>
               
            </thead>
            @foreach($x as $invoice)
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
