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
                        <th>Registered Office</th>
                        <th>PAN</th>
                        <th>Production Capacity</th>
                        <th>Factory Location</th>
                        <th>Warehouse Location</th>
                        <th>MD</th>
                        <th>CEO</th>
                        <th>Sales Contact</th>
                        <th>Finance Contact</th>
                        <th>Quality Department</th>
                    </thead>
                    <tbody>
                        <?php $count = 0; $count1 = 0; ?>
                        @foreach($mfdetails as $detail)
                        <tr>
                            <td>{{ $detail->company_name }}</td>
                            <td>{{ $detail->category }}</td>
                            <td>{{ $detail->cin }}</td>
                            <td>{{ $detail->gst }}</td>
                            <td>{{ $detail->registered_office }}</td>
                            <td>{{ $detail->pan }}</td>
                            <td>{{ $detail->production_capacity }}</td>
                            <td>{{ $detail->factory_location }}</td>
                            <td>{{ $detail->ware_house_location }}</td>
                            <td>{{ $detail->md }}</td>
                            <td>{{ $detail->ceo }}</td>
                            <td>{{ $detail->sales_contact }}</td>
                            <td>{{ $detail->finance_contact }}</td>
                            <td>{{ $detail->quality_department }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</div>

<!-- Modal -->
<form method="POST" action="{{ URL::to('/') }}/addmanufacturer">
    <div id="addManufacturer" class="modal fade" role="dialog">
      <div class="modal-dialog modal-md">
    
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modal Header</h4>
          </div>
          <div class="modal-body" style="max-height: 500px; overflow-y:scroll;">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4">Company Name</div>
                    <div class="col-md-8"><input type="text" placeholder="Company Name" name="companyName" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Category</div>
                    <div class="col-md-8"><input type="text" placeholder="Category" name="category" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Corporate Identity No.</div>
                    <div class="col-md-8"><input type="text" placeholder="Corporate Identity No." name="cin" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">GST</div>
                    <div class="col-md-8"><input type="text" placeholder="GST" name="gst" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Registered Office</div>
                    <div class="col-md-8"><input type="text" placeholder="Registered Office" name="regOffice" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">PAN</div>
                    <div class="col-md-8"><input type="text" placeholder="PAN" name="pan" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Producation Capacity</div>
                    <div class="col-md-8"><input type="text" placeholder="Production Capacity" name="productionCapacity" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Factory Location</div>
                    <div class="col-md-8"><input type="text" placeholder="Registered Office" name="factoryLocation" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Ware House Location</div>
                    <div class="col-md-8"><input type="text" placeholder="Ware House Location" name="warehouselocation" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Managing Director</div>
                    <div class="col-md-8"><input type="text" placeholder="Managing Director" name="md" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">CEO</div>
                    <div class="col-md-8"><input type="text" placeholder="CEO" name="ceo" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Sales Contact</div>
                    <div class="col-md-8"><input type="text" placeholder="Sales Contact" name="salesContact" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Finance Contact</div>
                    <div class="col-md-8"><input type="text" placeholder="Finance Contact" name="financeContact" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Quality Department</div>
                    <div class="col-md-8"><input type="text" placeholder="Quality Department" name="qualityDept" class="form-control input-sm"></div>
                </div><br>
          </div>
        </div>
    
      </div>
    </div>
</form>
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