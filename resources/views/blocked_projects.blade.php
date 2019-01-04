<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 7? "layouts.sales":"layouts.app");
?>
@extends($ext)
@section('content')
	
           
<div class="col-md-12">
        <div class="col-md-12">
          <div class="panel panel-default" style="overflow: scroll;">
            <div class="panel-heading" style="background-color:#158942;color:white;font-size:1.4em;font-weight:bold">Blocked Project List : {{count($projects)}}</div>  
            <div class="panel-body">
             <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Project id.." title="Type in a name" class="form-control">
              <table class="order-table table table table-hover" id="myTable">
                <thead>
                    <th>Project Id</th>
                  <th>Procurement Name</th>
                  <th>Contact No.</th>
                  <th>Construction Type</th>
            <th>Sub-Ward Number</th>
            <th>Project Status</th>
            <th>Quality</th>
            <th>Address</th>
                  <th>Action</th>
                </thead>
              @foreach($projects as $project)
              <tr>
                    <td style="text-align:center"><a href="{{URL::to('/')}}/showThisProject?id={{$project-> project_id}}" >{{ $project->project_id }}</a></td>
                    
                    <td id="projproc-{{$project->project_id}}">
                                        {{ $project->procurementdetails != NULL?$project->procurementdetails->procurement_name:'' }}
                                    </td>
                    <td id="projcont-{{$project->project_id}}"><address>{{ $project->procurementdetails != NULL?$project->procurementdetails->procurement_contact_no:'' }}</address></td>
                    <td>{{ $project->construction_type }}</td>
              
              <td>
                {{ $project->subward != null ? $project->subward->sub_ward_name:' ' }}
                                    </a></td>
              <td>{{ $project->project_status }}</td>
              <td>{{ $project->quality }}</td>
              <td>{{ $project->siteaddress != null ? $project->siteaddress->address : ' ' }}</td>

                    <td>

                    <div class="btn-group btn-group-xs">
                                   <form action="{{ url('/toggle-approve1')}}" method="post">
                                 {{csrf_field()}}
                                  <input value="off" type="hidden" name="deleted">
                                  <input type="hidden" name="id1" value="{{$project->project_id}}">
                                  <button type="submit" data-toggle="tooltip"onclick="return confirm('Are you sure you want to Block this Project?');"  button class="btn btn-sm" style="background-color:#F57F1B;color:white;font-weight:bold">UnBlock
                               </button>
                              </form>
                            </div>
                    </td>
                  </tr>
                                
                  @endforeach
                </tbody>
              </table>
                </table>
                </div>
                </div>
                </div>
                </div>


<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>



 @endsection