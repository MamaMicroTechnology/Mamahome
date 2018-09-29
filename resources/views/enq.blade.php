<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 4? "layouts.amheader":"layouts.app");
?>
@extends($ext)

@section('content')

<div class="">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                    <a href="{{ URL::to('/') }}/inputview" class="btn btn-danger btn-sm pull-left">Add Enquiry</a>
                    <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <p class="pull-left" style="padding-left: 50px;" id="display" >
                </p>
                    
                Enquiry Data
                    <a class="pull-right btn btn-sm btn-danger" href="{{url()->previous()}}">Back</a>
                    
                
            </div>
            <div class="panel-body" style="overflow-x: auto">
            
                    
            @if(Auth::user()->group_id == 1)
                <form method="GET" action="{{ URL::to('/') }}/adenquirysheet">
            @elseif(Auth::user()->group_id == 17)
                <form method="GET" action="{{ URL::to('/') }}/scenquirysheet">
            @else
                <form method="GET" action="{{ URL::to('/') }}/tlenquirysheet">
            @endif
                    <div class="col-md-12">
                            <div class="col-md-2">
                                <label>From (Enquiry Date)</label>
                                <input value = "{{ isset($_GET['from']) ? $_GET['from']: '' }}" type="date" class="form-control" name="from">
                            </div>
                            <div class="col-md-2">
                                <label>To (Enquiry Date)</label>
                                <input  value = "{{ isset($_GET['to']) ? $_GET['to']: '' }}" type="date" class="form-control" name="to">
                            </div>
                            <div class="col-md-2">
                                <label>Wards</label>
                                <select class="form-control" name="ward">
                                    <option value="">--Select--</option>
                                    <option value="">All</option>
                                    @foreach($data->ward as $ward)
                                    <option {{ isset($_GET['ward']) ? $_GET['ward'] == $ward->id ? 'selected' : '' : '' }} value="{{ $ward->id }}">{{ $ward->sub_ward_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        <div class="col-md-2">
                            <label>Initiator</label>
                            <select class="form-control" name="initiator">
                                <option value="">--Select--</option>
                                <option value="">All</option>
                                @foreach($initiators as $initiator)
                                <option {{ isset($_GET['initiator']) ? $_GET['initiator'] == $initiator->id ? 'selected' : '' : '' }} value="{{ $initiator->id }}">{{ $initiator->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Category:</label>
                            <select id="categ" class="form-control" name="category">
                                <option value="">--Select--</option>
                                <option value="">All</option>
                                @foreach($category as $category)
                                <option {{ isset($_GET['category']) ? $_GET['category'] == $category->category_name ? 'selected' : '' : '' }} value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label></label>
                            <input type="submit" value="Fetch" class="form-control btn btn-primary">
                        </div>
                    </div>
                </form>
                
                <br><br><br><br>
                <div class="col-md-6">
                    <div class="col-md-2">
                        Status:
                    </div>
                    <div class="col-md-4">
                        <select id="myInput" required name="status" onchange="myFunction()" class="form-control input-sm">
                            <option value="">--Select--</option>
                            <option value="all">All</option>
                            <option value="Enquiry On Process">Enquiry On Process</option>
                            <option value="Enquiry Confirmed">Enquiry Confirmed</option>
                        </select>
                    </div>
                  </div>
<!-- 
                  <div class="col-md-6">
                    <div class="col-md-2">
                        Ward:
                    </div>
                    <div class="col-md-4">
                        <select id="myInput" required name="status" onchange="myFunction1()" class="form-control input-sm">
                            <option value="">--Select--</option>
                            @if(Auth::user()->group_id != 22)
                            <option value="all">All</option>
                            @endif
                            @foreach($mainward as $wards2)
                            <option value="{{$wards2->id}}">{{$wards2->ward_name}}</option>
                            @endforeach
                        </select>
                    </div>
                  </div> -->
                  @if($data->totalenq == 0)
                   <h2 style="color: green;">Enquiry's are Not Found</h2>
                  @endif
                <table id="myTable" class="table table-responsive table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="text-align: center">Project_Id</th>
                            <th style="text-align: center">Ward Name</th>
                            <th style="text-align: center">Name</th>
                            <th style="text-align: center">Requirement Date</th>
                            <th style="text-align: center">Enquiry Date</th>
                            <th style="text-align: center">Contact</th>
                            <th style="text-align: center">Product</th>
                            <th style="text-align: center">Old Quantity</th>
                            <th style="text-align: center">Enquiry Quantity</th>
                            <th style="text-align: center">Total Quantity</th>
                            <th style="text-align: center">Initiator</th>
                            <th style="text-align: center">Converted by</th>
                            <th style="text-align: center">Last Update</th>
                            <th style="text-align: center">Status</th>
                            <th style="text-align: center">Remarks</th>
                            <th style="text-align: center">Update Status</th>
                            <th style="text-align: center">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $pro=0; $con=0; $total=0; $sum=0; $sum1=0; $sum2=0; ?>
                        @foreach($data->enquiries as $enquiry)

                            @if($enquiry->status == "Enquiry On Process")
                            <?php   $pro++; ?>
                                <?php $sum = $sum + $enquiry->total_quantity; 
                                 ?>
                                
                            @endif

                            @if($enquiry->status == "Enquiry Confirmed")
                            <?php   $con++; 
                             ?>

                                
                                    <?php $sum1 = $sum1 + $enquiry->total_quantity; 
                                     ?>
                                

                            @endif

                            @if($enquiry->status == "Enquiry Confirmed" || $enquiry->status == "Enquiry On Process")
                            <?php  $total++; 
                            ?>
                                
                                    <?php $sum2 = $sum2 + $enquiry->total_quantity; 
                                     ?>
                                
                            @endif
                        @endforeach
                        
                        @foreach($data->enquiries as $enquiry)
                        @if($enquiry->status != "Not Processed")
                    
                            <td style="text-align: center">
                                <a target="_blank" href="{{URL::to('/')}}/showThisProject?id={{$enquiry -> project_id}}">
                                    <b>{{$enquiry -> project_id }}</b>
                                </a> 
                            </td>
                            <td style="text-align: center">{{$subwards2[$enquiry->project_id]}}</td>
                            <td style="text-align: center">{{$enquiry -> procurement_name}}</td>
                            <td style="text-align: center">{{$newDate = date('d/m/Y', strtotime($enquiry->requirement_date)) }}</td>
                            <td style="text-align: center">{{ date('d/m/Y', strtotime($enquiry->created_at)) }}</td>
                            <td style="text-align: center">{{$enquiry -> procurement_contact_no }}</td>
                            <td style="text-align: center">{{$enquiry -> main_category}} ({{ $enquiry->sub_category }}), {{ $enquiry->material_spec }}</td>
                            <td style="text-align: center">
                                <?php $quantity = explode(", ",$enquiry->quantity); ?>
                                @for($i = 0; $i<count($quantity); $i++)
                                {{ $quantity[$i] }}<br>
                                @endfor
                            </td>
                            <td style="text-align: center">{{ $enquiry->enquiry_quantity }}</td>
                            <td style="text-align: center">{{ $enquiry->total_quantity }}</td>
                            <td style="text-align: center">{{$enquiry -> name}}</td>
                            <td style="text-align: center">
                            @foreach($data->users as $convert)
                                @if($enquiry->converted_by == $convert->id)
                                {{ $convert->name}}
                                @endif
                            @endforeach
                            </td>
                            <td style="text-align: center">
                                {{ date('d/m/Y', strtotime($enquiry->updated_at)) }}
                                @foreach($data->users as $convert)
                                @if($enquiry->updated_by == $convert->id)
                                 {{ $convert->name}} 
                                @endif
                            @endforeach
                            </td>
                            <td style="text-align: center">
                                {{ $enquiry->status}}
                            </td>
                            <td style="text-align: center" onclick="edit('{{ $enquiry->id }}')" id="{{ $enquiry->id }}">
                                <form method="POST" action="{{ URL::to('/') }}/editEnquiry">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{$enquiry->id}}" name="id">
                                    <input onblur="this.className='hidden'; document.getElementById('now{{ $enquiry->id }}').className='';" name="note" id="next{{ $enquiry->id }}" type="text" size="35" class="hidden" value="{{ $enquiry->notes }}"> 
                                    <p id="now{{ $enquiry->id }}">{{$enquiry->notes}}</p>
                                </form>
                            </td>
                            
                            <td>
                                <form method="POST" action="{{ URL::to('/') }}/editEnquiry">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{$enquiry->id}}" name="id">
                                    
                                    <select required name="status" onchange="this.form.submit();" style="width:100px;">
                                        <option value="">--Select--</option>
                                        <option>Enquiry On Process</option>
                                        <option>Enquiry Confirmed</option>
                                        <option>Enquiry Cancelled</option>
                                    </select>
                                    
                                </form>
                            </td>
                            <td>
                                <a href="{{ URL::to('/') }}/editenq?reqId={{ $enquiry->id }}" class="btn btn-xs btn-primary">Edit</a>
                            </td>
                            
                        </tr>

                        @endif
                        @endforeach   
                        
                    </tbody>
                    <!--  <tr>
                        <td style="text-align    : center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center">Total</td>
                            <td style="text-align: center">{{ $totalofenquiry }}</td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                    </tr> -->
                    
                </table>
                <!-- <table>
                    <tbody>
                        <tr>total</tr>
                    </tbody>
                </table> -->
            </div>
            <div class="panel-footer">
                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function edit(arg){
        document.getElementById('now'+arg).className = "hidden";
        document.getElementById('next'+arg).className = "";
        document.getElementById('next'+arg).focus();
    }
    function editm(arg){
        document.getElementById('noww'+arg).className = "hidden";
        document.getElementById('nextt'+arg).className = "form-control";
    }
</script>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript">
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");

  filter = input.value.toUpperCase();

  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  // Loop through all table rows, and hide those who don't match the search query
  
  if(filter == "ALL"){
    for (i = 0; i < tr.length; i++) {
        tr[i].style.display = "";
      }
    }else{
        for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[13];
        if (td) {
          if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    if(document.getElementById("myInput").value  == "Enquiry On Process"){
        
        if(document.getElementById("categ").value  != "All"){
        
                document.getElementById("display").innerHTML = "Enquiry On Process  :  {{  $pro }}   /  Quantity On Process : {{ $sum }} "
         }
    }
    else if(document.getElementById("myInput").value == "Enquiry Confirmed"){
        if(document.getElementById("categ").value  != "All"){
        document.getElementById("display").innerHTML = "Enquiry Confirmed  :  {{  $con }}   /   Quantity On Confirmed : {{ $sum1 }}"
        }
    }
    else {

        if(document.getElementById("categ").value  != "All"){
        document.getElementById("display").innerHTML = "Total Enquiry Count  :  {{  $total }}   /   Total Quantity  :  {{ $sum2 }}  "
        }
    }


    // if(document.getElementById("myInput").value  == "Enquiry On Process"){

    //  if(document.getElementById("categ").value  == "All Category"){
            
    //  document.getElementById("display").innerHTML = "Enquiry On Process  :  {{  $pro }}"
    //  }
    // }
    // else if(document.getElementById("myInput").value == "Enquiry Confirmed"){
        
    //  if(document.getElementById("categ").value  == "All Category"){
    //  document.getElementById("display").innerHTML = "Enquiry Confirmed  :  {{  $con }}"
    //  }
    // }
    // else {
    //  if(document.getElementById("categ").value  == "All Category"){
    //  document.getElementById("display").innerHTML = "Total Enquiry Count  :  {{  $total }}"
    // }
    // }
}
</script>
@endsection
