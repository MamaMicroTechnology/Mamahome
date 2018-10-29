
<?php
    $use = Auth::user()->group_id;
    $ext = ($use == 1? "layouts.teamheader":"layouts.app");
?>
@extends($ext)
@section('content')
    <div class="col-md-12">
        <div class="panel panel-primary">
        <div class="panel-heading text-center" style="padding:-20px;">
                        <center ><h5>{{$dd}} Manufacturer Details: &nbsp;&nbsp;&nbsp;{{$count}}</h5></center>
                 <button type="button" onclick="history.back(-1)" class="bk-btn-triangle pull-right" style="margin-top:-35px;" > <i class="fa fa-arrow-circle-left" style="padding:5px;width:50px;color: black;"></i></button>
                 <form action="{{ URL::to('/') }}/viewManufacturer" method="GET">
                 <select class="form-control pull-left" style="width:12%;margin-top:-40px;" onchange="this.form.submit()" name="type">
                     <option>--Manufacuturer Type--</option>
                     <option value="RMC">RMC</option>
                     <option value="BLOCKS">BLOCKS</option>
                     <option value="M-SAND">M-SAND</option>
                     <option value="AGGREGATES">AGGREGATES</option>
                 </select>
            </div>
            <div class="panel-body" style="overflow-x: auto">
        <style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    padding: 8px;

}

tr:nth-child(even) {
    background-color: #dddddd;
}

</style>
        <table class="table table-responsive table-striped table-hover" cellspacing="50">
           <thead class="thead-dark">
        <tr>
            <th>Manufacturer Id</th>
            <th>SubWard Name</th>
            <th>listing Engineer Name</th> 
            <th>Plant Name</th>
            <th>Phone No.</th>
           <!--  <th>Manufacturer Image</th> -->
            <th>Cement Requirement</th>
            <th>Sand Requirement</th>
            <th>Aggregates Requirement</th>
            <th>Remarks</th>
            <th style="width:400px;padding-left: 100px;">Action</th>
            <th>History</th>  
        </tr>
    </thead>
        @foreach($manufacturers as $manufacturer)
            <tr>
                <td>
                  <a href="{{ URL::to('/') }}/updateManufacturerDetails?id={{ $manufacturer->id }}">{{$manufacturer->id}}</a>
                </td>
                <td>
                      <a href="{{ URL::to('/')}}/manufacturemap?id={{ $manufacturer->id }} && subwardid={{ $manufacturer->sub_ward_id }}" data-toggle="tooltip" data-placement="top" title="click here to view map" class="red-tooltip" target="_blank">
                        {{$manufacturer->subward != null ? $manufacturer->subward->sub_ward_name :'' }}
                      </a> 
                </td>
               
                <td> {{$manufacturer->user != null ? $manufacturer->user->name :'' }}</td>
                <td>{{ $manufacturer->plant_name }}</td>
                 <td> {{$manufacturer->proc != null ? $manufacturer->proc->contact : $manufacturer->contact_no  }}</td>
              
                <td>{{ $manufacturer->cement_requirement }}&nbsp; {{ $manufacturer->cement_requirement_measurement }}</td>
                <td>{{ $manufacturer->sand_requirement }}&nbsp; {{ $manufacturer->cement_requirement_measurement }}</td>
                <td>{{ $manufacturer-> aggregates_required }}&nbsp; {{ $manufacturer->cement_requirement_measurement }}</td>
                <td>{{$manufacturer->remarks}}</td>
                <td>
                  <form method="post" action="{{ URL::to('/') }}/confirmedmanufacture" >
                  {{ csrf_field() }}
                  <input type="hidden" value="{{ $manufacturer->id }}" name="id">
                  <div>
                    <a class="btn btn-sm btn-success" name="addenquiry" href="{{ URL::to('/') }}/manuenquiry?projectId={{ $manufacturer->id }}" style="color:white;font-weight:bold;padding: 6px;">Add Enquiry</a>
                                      
                      @if( $manufacturer->confirmed !== "0" ||  $manufacturer->confirmed == "true" )
                        <button  type="button" id="demo"  style="padding: 5.5px;background-color:#e57373;color:white" class="btn btn-sm " {{ $manufacturer->confirmed !== "0" ||  $manufacturer->confirmed == "true" ? 'checked': ''}}  name="confirmed" onclick="this.form.submit()" type="submit">
                          Called
                          <span class="badge">&nbsp;{{  $manufacturer->confirmed }}&nbsp;</span>
                        </button>
                      @endif
                      @if( $manufacturer->confirmed == "0" ||  $manufacturer->confirmed == "false" )
                        <button style="padding: 5.5px;background-color: #aed581;color:white" id="demo"  type="button" class="btn  btn-sm "  {{ $manufacturer->confirmed !== "0" ||  $manufacturer->confirmed == "true" ? 'checked': ''}}  name="confirmed" onclick="this.form.submit()" type="submit">Called
                          <span class="badge">&nbsp;{{  $manufacturer->confirmed }}&nbsp;</span>
                        </button></div>
                      @endif
                      <button  type="button" data-toggle="modal" data-target="#myquestions{{ $manufacturer->id }}" class="btn btn-sm btn-warning " style="color:white;font-weight:bold;padding: 6px;width:80px;">Questions</button>
                  </form>
                  <div id="myquestions{{ $manufacturer->id }}" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                   <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header" style="background-color:rgb(245, 127, 27);color: white;">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Select The Questions</h4>
                          </div>
                          <div class="modal-body">
                            <form method="get" action="{{ URL::to('/') }}/manustorequery ">
                              {{ csrf_field() }}
                             <input type="hidden" value="{{ $manufacturer->id }}" name="id">
                            <table class="table table-responsive">
                              <tr>
                                <td><label>Questions :</label></td>
                                <td>
                                  <select required style="width: 100%" class="form-control" name="qstn">
                                    <option disabled selected>--- Select ---</option>
                                    <option value="NOT INTERESTED">NOT INTERESTED</option>
                                    <option  value="BUSY">BUSY</option>
                                    <option  value="WRONG NO">WRONG NO</option>
                                    <option  value="PROJECT CLOSED">PROJECT CLOSED</option>
                                    <option  value="CALL BACK LATER">CALL BACK LATER</option>
                                    <option value="THEY WILL CALL BACK WHEN REQUIRED">THEY WILL CALL BACK WHEN REQUIRED</option>
                                    <option value="CALL NOT ANSWERED">CALL NOT ANSWERED</option>
                                    <option value="FINISHING">FINISHING</option>
                                    <option  value="SWITCHED OFF">SWITCHED OFF</option>
                                    <option  value="SAMPLE REQUEST">SAMPLE REQUEST</option>
                                    <option  value="MATERIAL QUOTATION">MATERIAL QUOTATION</option>
                                    <option  value="WILL FOLLOW UP AFTER DISCUSSION WITH OWNER">WILL FOLLOW UP AFTER DISCUSSION WITH OWNER</option>
                                    <option  value="DUPLICATE NUMBER">DUPLICATE NUMBER</option>
                                    <option  value="NOT REACHABLE">NOT REACHABLE</option>
                                    <option  value="THEY HAVE REGULAR SUPPLIERS">THEY HAVE REGULAR SUPPLIERS</option>
                                    <option  value="CREDIT FACILITY">CREDIT FACILITY</option>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td><label>Call Remark : </label></td>
                                <td><textarea required style="resize: none;" class="form-control" placeholder="Remarks" name="remarks" ></textarea></td>
                              </tr>
                            </table>                   
                            <button type="submit" class=" form-control btn btn-primary">Submit</button>
                          </form>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </td>
    <td>
<button style="padding: 5.5px;background-color: #757575 ;color: white" data-toggle="modal" data-target="#myModal1{{$manufacturer->id}}"   type="button" class="btn  btn-sm "  >
             History </button>
</td> 
</tr> 
 @endforeach
</table>
@foreach($manufacturers as $project)
<div class="modal fade" id="myModal1{{$project->id}}" role="dialog">
    <div class="modal-dialog">
  <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header  " style="background-color:#868e96;padding:5px; " >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"> Customer History </h4>
        </div>
        <div class="modal-body">
         <table class="table table-responsive">
           <tr>
             <td style="padding: 10px;" >Manufacturer Id</td>
             <td>:</td>
             <td style="padding: 10px;"> {{ $project-> id }}</td>
           </tr>           
            <tr>
              <td style="padding: 10px;" > Manufacturer Created At</td>
              <td>:</td>
              <td style="paddiEnquiryng: 10px;">{{ date('d-m-Y', strtotime( $project->created_at)) }}</td>
              <td>
                  {{ date('h:i:s A', strtotime($project->created_at)) }}
              </td>
            </tr>
              <tr>
                <td> Manufacturer Updated At</td>
                <td>:</td>
                <td >{{ date('d-m-Y', strtotime(  $project->updated_at)) }}</td>
                <td>{{ date('h:i:s A', strtotime($project->updated_at)) }}</td>
               </tr>
          </table>
         <table class="table table-responsive table-hover">
            <thead>
                <!-- <th>User_id</th> -->
                <th>Serial No</th>
                <th>Called Date</th>
                <th>Called Time</th>
                <th> Name </th>
                <th>Question</th>
                <th>Call Remark</th>
            </thead>
                <tbody>
                 <label>Call History</label>
                 <?php $i=1 ?>
                  @foreach($his as $call)
                  @if($call->manu_id == $project->id)
                  <tr>
                    <td>{{ $i++ }}</td>
                  <td>
                    {{ date('d-m-Y', strtotime($call->called_Time)) }}
                  </td>
                  <td>
                    {{ date('h:i:s A', strtotime($call->called_Time)) }}
                  </td>
                  <td>
                   {{$call->username}}
                  </td>
                  <td>
                    {{ $call->question }}
                  </td>
                  <td>
                    {{ $call->remarks }}
                  </td>
                </tr>
                 @endif
                 @endforeach
               </tbody>
   </table>
                                      
        </div>
        <div class="modal-footer" style="padding:1px;">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
    </div>
    @endforeach
    </div>
</div>
</div>
<!-- <script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
     background-color: #00acd6 

});

</script> -->
@endsection
