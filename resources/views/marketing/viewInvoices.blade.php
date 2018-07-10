@extends('layouts.app')
@section('content')

<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
        <div class="panel-heading">Invoices</div>
        <div class="panel-body">
 <center>  <form action="{{ URL::to('/') }}/viewInvoices" method="get">
          <select class="form-control" name="cat" onchange="form.submit()" style="width:30%;">
              <option value="select">----Select category----</option>
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
                <th>Date</th>
                <th>Req-Id</th>
            </thead>
            @foreach($invoices as $invoice)
                <tr>
                    <td><a href="{{ URL::to('/') }}/invoice?id={{ $invoice->invoice_id }}">{{ $invoice->invoice_id }}</td>
                    <td>{{ $invoice->requirement_id }}</td>
                    <td>{{ $invoice->project_id }}</td>
                    <td>{{ $invoice->deliver_location }}</td>
                    <td>{{ $invoice->customer_name }}</td>
                    <td>{{ $invoice->delivery_date }}</td>
                  
                </tr>
            @endforeach
        </table>
        </div>
    </div>
</div>

@endsection