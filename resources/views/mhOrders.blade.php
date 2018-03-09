@extends('layouts.app')
@section('content')
 <div class="container">
     <div class="row">
         <div class="panel panel-default">
             <div class="panel-heading">Orders</div>
             <div class="panel-body">
                 <table class="table table-hover">
                     <thead>
                         <th>Invoice Number</th>
                         <th>Project Id</th>
                         <th>Name</th>
                         <th>Address</th>
                         <th>Sub Ward</th>
                         <th>Date</th>
                         <th>Payment Method</th>
                         <th>Amount</th>
                         <th>Transaction Details</th>
                         <th>Description</th>
                     </thead>
                     <tbody>
                     @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->invoice_number }}</td>
                            <td>{{ $invoice->project_id }}</td>
                            <td>{{ $invoice->customer_name }}</td>
                            <td>{{ $invoice->deliver_location }}</td>
                            <td>{{ $invoice->sub_ward }}</td>
                            <td>{{ $invoice->invoice_date }}</td>
                            <td>{{ $invoice->payment_method }}</td>
                            <td>{{ $invoice->amount_received }}</td>
                            <td>{{ $invoice->transactional_details }}</td>
                            <td>{{ $invoice->main_category }} - {{ $invoice->sub_category }} ({{ $invoice->material_spec }})</td>
                        </tr>
                     @endforeach
                     </tbody>
                 </table>
             </div>
         </div>
     </div>
 </div>
@endsection