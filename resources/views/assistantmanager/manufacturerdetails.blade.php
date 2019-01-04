
<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 8? "layouts.app":"layouts.amheader");
?>
@extends($ext)
@section('content')


<div class="col-md-12">
        <div class="col-md-12">
        <div class="panel panel-default" style="border-color:#f68121">
            <div class="panel-heading" style="background-color:#f68121">
                <b style="color:white;font-size:1.2em">Vendor's Information</b>
                <div class="btn-group pull-right">
                    @if(Auth::user()->group_id != 8)
                    <a class="btn btn-sm btn-info" href="{{ URL::to('/') }}/addvendortype" id="btn2" name="btn2" style="color:white;"><b>Add Vendor Type</b></a>
                    @else
                    <a class="btn btn-sm btn-info" href="{{ URL::to('/') }}/marketingvendortype" id="btn2" name="btn2" style="color:white;"><b>Add Vendor Type</b></a>
                    @endif
                    <button class="btn-sm btn btn-primary" data-toggle="modal" data-target="#addManufacturer">Add New Vendor</button>
                    <a class="btn btn-sm btn-danger" href="{{ url()->previous() }}" id="btn1" style="color:white;"><b>Back</b></a>
                 </div>
            </div>
            <div class="panel-body" style="overflow-x: scroll;">
                <div class="col-md-3">
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
                        <th>Vendor Type</th>
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
                            <td>{{ $detail->vendor_type }}</td>
                            <td>{{ $detail->category }}</td>
                            <td>{{ $detail->cin }}</td>
                            <td>{{ $detail->gst }}</td>
                            <td>{{ $detail->registered_office }}</td>
                            <td>@if($detail->pan != NULL) <a href="{{ URL::to('/') }}/pan/{{ $detail->pan }}">View</a>@endif</td>
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
</div>
<!-- Modal -->
@if(Auth::user()->group_id != 8)
<form method="POST" action="{{ URL::to('/') }}/addmanufacturer" enctype="multipart/form-data">
@else
    <form method="POST" action="{{ URL::to('/') }}/marketingaddmanufacturer" enctype="multipart/form-data">
 @endif       
    <div id="addManufacturer" class="modal fade" role="dialog">
      <div class="modal-dialog modal-md">
    
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="background-color:blue">
            <button type="button" class="close" data-dismiss="modal" style="color:black"><b style="color:black">&times;</b></button>
            <h4 class="modal-title" ><b style="color:white;text-align:center">Add New Vendor</b></h4>
          </div>
          <div class="modal-body" style="max-height: 500px; overflow-y:scroll;">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4">Type</div>
                    <div class="col-md-8">
                        <select class="form-control" name="vendortype" required>
                            <option value="" disabled selected>-- SELECT --</option>
                            @foreach($vendor as $type)
                                <option value="{{$type->id}}">{{$type->vendor_type}}</option>
                            @endforeach
                        </select>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Company Name</div>
                    <div class="col-md-8"><input type="text" placeholder="Company Name" name="companyName" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Category</div>
                    <div class="col-md-8">
                        <select required name="category" id="category2" class="form-control input-sm" required>
                            <option value="">--Select--</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Select State</div>
                    <div class="col-md-8">
                        <select name="state" class="form-control input-sm" required>
                            <option value="">--Select--</option>
                            <option value="1">karnataka</option>
                            <option value="2">Tamil nadu</option>
                        </select>
                    </div>
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
                    <div class="col-md-8"><input type="file" placeholder="PAN" name="pan" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Production Capacity</div>
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
                    <div class="col-md-4">Managing Director Name</div>
                    <div class="col-md-8"><input type="text" placeholder="Managing Director" name="md" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Managing Director Contact Number</div>
                    <div class="col-md-8"><input type="text" placeholder="Managing Director" name="mdContactNo" id="mdContactNo" onkeyup="checknumber('mdContactNo')" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">CEO Name</div>
                    <div class="col-md-8"><input type="text" placeholder="CEO" name="ceoname" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">CEO Contact</div>
                    <div class="col-md-8"><input type="text" placeholder="CEO Contact Number" name="ceoContactNo" id="ceoContactNo" maxlength="10" onkeyup="checknumber('ceoContactNo')" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">General Manager Name</div>
                    <div class="col-md-8"><input type="text" placeholder="CEO Contact Number" name="gmContact" id="gmContact" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">General Manager Contact</div>
                    <div class="col-md-8"><input type="text" placeholder="CEO Contact Number" name="gmContactNo" id="gmContactNo" maxlength="10" onkeyup="checknumber('gmContactNo')" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Sales Contact Name</div>
                    <div class="col-md-8"><input type="text" placeholder="Sales Contact" name="salesContact" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Sales Contact Number</div>
                    <div class="col-md-8"><input type="text" placeholder="Sales Contact" name="salesContactNo" id="salesContactNo" maxlength="10" onkeyup="checknumber('salesContactNo')" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Finance Contact Name</div>
                    <div class="col-md-8"><input type="text" placeholder="Finance Contact" name="financeContact" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Finance Contact Number</div>
                    <div class="col-md-8"><input type="text" placeholder="Finance Contact" name="financeContactNo" id="financeContactNo" maxlength="10" onkeyup="checknumber('financeContactNo')" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Quality Department Name</div>
                    <div class="col-md-8"><input type="text" placeholder="Quality Department" name="qualityDept" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Quality Department Contact</div>
                    <div class="col-md-8"><input type="text" placeholder="Quality Department" name="qualityDeptNo" id='qualityDeptNo' maxlength="10" onkeyup="checknumber('qualityDeptNo')" class="form-control input-sm"></div>
                </div><br>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-success">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
    
      </div>
    </div>
</form>

<div class='b'></div>
<div class='bb'></div>
<div class='message'>
  <div class='check'>
    &#10004;
  </div>
  <p>
    Success
  </p>
  <p>
    @if(session('Success'))
    {{ session('Success') }}
    @endif
  </p>
  <button id='ok'>
    OK
  </button>
</div>

<script>
        function brands(){
        var e = document.getElementById('category2');
        var cat = e.options[e.selectedIndex].value;
        $("html body").css("cursor", "progress");
        $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/getBrands",
            async:false,
            data:{cat : cat},
            success: function(response)
            {
                console.log(response);
                var ans = "<option value=''>--Select--</option>";
                for(var i=0;i<response[0].length;i++)
                {
                    ans += "<option value='"+response[0][i].id+"'>"+response[0][i].brand+"</option>";
                }
                document.getElementById('brands2').innerHTML = ans;
                $("body").css("cursor", "default");
            }
        });
    }
    function checknumber(arg){
	    var input = document.getElementById(arg).value;
	    if(isNaN(input)){
	      	while(isNaN(document.getElementById(arg).value)){
	      	var str = document.getElementById(arg).value;
	      	str     = str.substring(0, str.length - 1);
	      	document.getElementById(arg).value = str;
	      	}
	    }
	    else{
	      	input = input.trim();
	      	document.getElementById(arg).value = input;
	    }
	    return false;
	}
    function displaycategory() {
      var input, filter, table, tr, td, i;
      input = document.getElementById("category");
      filter = input.value.toUpperCase();
      table = document.getElementById("manufacturer");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
        if (td) {
          if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }else{
            tr[i].style.display = "";
        }       
      }
    }
</script>
@endsection