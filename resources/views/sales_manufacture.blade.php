@extends('layouts.app')
@section('content')   
    <div class="col-md-12">     
    <div class="col-md-12" >

    <div class="panel panel-default" style="overflow: scroll;">
            <div class="panel-heading" style="background-color:#158942;color:white;font-size:1.4em;">Manufacture Projects List  <p class="pull-right">Count&nbsp;:&nbsp; {{ $projectcount }} </p></div>  
         <div class="panel-body" id="page">
       <table class="table table-hover table-striped">
                <thead>
                  <th>Manufacture Id</th>
                  <th>Manufacture Name</th>
                  <th style="width:15%">Address</th>
                  <th>Contact No.</th>
                 <th>Action</th>
                 <th>History</th>

                
               </thead>
                <tbody>
            @foreach($projects as $project)
<tr>
                   

                   <td  style="text-align:center"><a href="{{ URL::to('/') }}/updateManufacturerDetails?id={{$project->id}}" target="_blank">{{$project->id}}</a></td>
                   <td>{{ $project->proc != null ? $project->proc->name :$project->name }}</td>
                    <td>
                                     <a target="_blank" href="https://maps.google.co.in?q={{ $project->address != null ? $project->address : '' }}">{{$project->address}}</a>
                                    </td>
                   <td>{{ $project->proc != null ? $project->proc->contact :$project->contact_no }}</td>
                    <td><form method="post" action="{{ URL::to('/') }}/confirmedmanufacture" >
                                      {{ csrf_field() }}
                                      <input type="hidden" value="{{ $project->id }}" name="id">
                                      <div>
                                   
                                      <a class="btn btn-sm btn-success" name="addenquiry" href="{{ URL::to('/') }}/manuenquiry?projectId={{ $project->id }}" style="color:white;font-weight:bold;padding: 6px;">Add Enquiry</a>
                                      
                                      @if( $project->confirmed !== "0" ||  $project->confirmed == "true" )
                                   <button  type="button" id="demo"  style="padding: 5.5px;background-color:#e57373;color:white" class="btn btn-sm " {{ $project->confirmed !== "0" ||  $project->confirmed == "true" ? 'checked': ''}}  name="confirmed" onclick="this.form.submit()">Called
                                   <span class="badge">&nbsp;{{  $project->confirmed }}&nbsp;</span>
                                   </button>
                                  @endif
                                   @if( $project->confirmed == "0" ||  $project->confirmed == "false" )
                                   <button style="padding: 5.5px;background-color: #aed581;color:white" id="demo"  type="button" class="btn  btn-sm "  {{ $project->confirmed !== "0" ||  $project->confirmed == "true" ? 'checked': ''}}  name="confirmed" onclick="this.form.submit()">Called
                                    <span class="badge">&nbsp;{{  $project->confirmed }}&nbsp;</span>
                                   </button></div>
                                  @endif
                                  <button  type="button" data-toggle="modal" data-target="#myquestions{{ $project->id }}" class="btn btn-sm btn-warning " style="color:white;font-weight:bold;padding: 6px;width:80px;">Questions</button>
                                </form>
<div id="myquestions{{ $project->id }}" class="modal fade" role="dialog">
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
           <input type="hidden" value="{{ $project->id }}" name="id">
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
<button style="padding: 5.5px;background-color: #757575 ;color: white" data-toggle="modal" data-target="#myModal1{{$project->id}}"   type="button" class="btn  btn-sm "  >
             History </button>
</td>  

</tr>
@endforeach
</tbody>
</table>
@foreach($projects as $project)
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
                                        <td style="padding: 10px;" >Manufacturer Id<Enquiry/td>
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
                                            <td>
                                                  {{ date('h:i:s A', strtotime($project->updated_at)) }}
                                                </td>
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
                                           <!--  <td>
                                              {{ $call->user_id }}
                                            </td> -->
                                           
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
      <center>{{$project->links()}}</center>   
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
</div>

  
  @endsection
