@extends('layouts.app')

@section('content')

<div class="col-md-10 col-md-offset-1">
        <center>Manufacturer's Information</center><br>
        <div class="panel panel-danger">
            <div class="panel-heading">
                Details
                  <a class="pull-right btn btn-sm btn-danger" href="{{URL::to('/')}}/home" id="btn1" style="color:white;"><b>Back</b></a>
            </div>
            <div style="overflow-x: scroll;" class="panel-body">
                <div class="col-md-3" >
                    <select id="category" onchange="displaycategory()" class="form-control input-sm">
                        <option>--Category Wise--</option>
                        @foreach($category as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <table id="manufacturer" class="table table-responsive" border=1><br>
                    <thead>
                        <th>Company Name</th>
                        <th>Category</th>
                        <th>CIN</th>
                        <th>GST</th>
                        <th>PAN</th>
                        <th>Address</th>
                        <th>MD</th>
                        <th>CEO</th>
                        <th>Sales Contact</th>
                        <th>Finance Contact</th>
                        <th>Quality Department</th>
                        <th>Production Capacity</th>
                    </thead>
                    <tbody>
                        <?php $count = 0; $count1 = 0; ?>
                        @foreach($mfdetails as $detail)
                        <tr>
                            <td>{{ $detail->company_name }}</td>
                            <td>{{ $detail->category }}</td>
                            <td>{{ $detail->cin }}</td>
                            <td>{{ $detail->gst }}</td>
                            <td>@if($detail->pan != NULL) <a href="{{ URL::to('/') }}/pan/{{ $detail->pan }}">View</a>@endif</td>
                            <td>
                                Registered office: {{ $detail->registered_office != NULL ? $detail->registered_office:'' }}<br>
                                Wear House : {{ $detail->ware_house_location != NULL ? $detail->ware_house_location:'' }}<br>
                                Factory Location : {{ $detail->factory_location != NULL ? $detail->factory_location:'' }}
                            </td>
                            <td>{{ $detail->md }}</td>
                            <td>{{ $detail->ceo }}</td>
                            <td>{{ $detail->sales_contact }}</td>
                            <td>{{ $detail->finance_contact }}</td>
                            <td>{{ $detail->quality_department }}</td>
                            <td>{{ $detail->production_capacity }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</div>

<script>
    function displaycategory() {
      var input, filter, table, tr, td, i;
      input = document.getElementById("category");
      filter = input.value.toUpperCase();
      table = document.getElementById("manufacturer");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
          if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }       
      }
    }
</script>
@endsection