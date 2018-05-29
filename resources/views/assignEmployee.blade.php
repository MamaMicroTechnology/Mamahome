@extends('layouts.app')
@section('content')

<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading" style="background-color: green;color: white;padding-bottom: 20px;">Asset Info
      <a class="pull-right btn btn-sm btn-danger" href="{{url()->previous()}}">Back</a>
        <span class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <a href="{{ URL::to('/')}}/signature" type="button" class="btn btn-sm btn-primary pull-right" >Take Signature</a>
           <span class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;</span>
         <button type="button" class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#modelsim">Assign SIM</button>
          <span class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;</span>
         <input type="button" class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#myaddModal" value="Assign">

        </div>
        <div class="panel-body" style="overflow-x: hidden;overflow-y: scroll;overflow-x: scroll;max-height: 500px;height: 500px;">
            <table class="table table-responsive">
                <tr>
                    <td>Name</td>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <td>Designation</td>
                    <td>{{ $user->group->group_name }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <td>Assets</td>
                    <td>
                        @if($assetInfos != NULL )
                        <table class="table table-responsive">
                            <thead>
                                <th>Type</th>
                                 <th>Model Name</th>
                                <th>Serial No.</th>
                                <th>Description</th>
                                <th>Assign Date</th>
                                <th>Remark</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach($assetInfos as $assetInfo)
                                <tr>
                                    @if($assetInfo->asset_type != "SIMCard")
                                    <td>{{ $assetInfo->asset_type }}</td>
                                    <td>{{ $assetInfo->name}}
                                    <td>{{$assetInfo->serial_no}}</td>
                                    <!-- <td><a href="{{ URL::to('/')}}/public/assettype/{{ $assetInfo->image}}"  target="_blank"> image</a></td> -->
                                    <td style="width: 20%;">{{ $assetInfo->description }}</td>
                                    <td>{{ date( 'd-m-Y' , strtotime($assetInfo->assign_date))}}</td>
                                    <td>{{$assetInfo->remark}}</td>
                                    <td>
                                        <form method="POST" action="{{ URL::to('/') }}/deleteAsset">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{ $assetInfo->id }}">
                                            <input type="submit" value="Delete" class="btn btn-xs btn-danger"> 
                                        </form>

                                    </td>
                                    <!-- <td> <input type="submit" value="Edit" style="width: 80%" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModal{{ $assetInfo->id}}"></td> -->
                                    <td>
                                        <a class="btn btn-xs btn-success" href="{{ URL::to('/') }}/preview?Id={{ $assetInfo->employeeId }} && id={{ $assetInfo->id }}">Preview</a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                       
                    </td>
                <tr>
                    <td>Asset SIM</td>
                    <td>
                        @if($assetInfos != NULL )
                        <table class="table table-responsive">
                            <thead>
                                <th>Type</th>
                                <th>SIMCard Brand/Provider </th>
                                <th>Simcard Number</th>
                                <th>Remark</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                 @foreach($assetInfos as $assetInfo)
                                <tr>
                                    @if($assetInfo->asset_type == "SIMCard")
                                    <td>{{ $assetInfo->asset_type }}</td>
                                    <td>{{ $assetInfo->provider}}</td>
                                    <td>{{ $assetInfo->sim_number }}</td>
                                    <td>{{ $assetInfo->sim_remark }}</td>
                                    <td><form method="POST" action="{{ URL::to('/') }}/deletesim">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{ $assetInfo->id }}">
                                                <input type="submit" value="Delete" class="btn btn-xs btn-danger"> 
                                        </form></td>
                                    <td>
                                        <a class="btn btn-xs btn-success" href="{{ URL::to('/') }}/preview?Id={{ $assetInfo->employeeId }}&& id={{ $assetInfo->id }}">Preview</a>
                                    </td>
                                    @endif
                                </tr>
                                 @endforeach
                            </tbody>
                        </table>
                        @endif
                        </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div id="myaddModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background-color:rgb(244, 129, 31);color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Assign</h4>
      </div>
      <div class="modal-body">
             <form method="POST" action="{{ URL::to('/') }}/amedit/saveAssetInfo" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="userId" value="{{ $user->employeeId }}">
                <table id="asset" class="table table-responsive">
                    
                    <tbody>
                        <tr>
                            <td><label>Asset Type:</label></td>
                            <td>
                                <select required class="form-control" name="type[]" id="type" onchange="getname()">
                                    <option value="">--Select--</option>
                                    @foreach($assets as $asset)
                                    <option value="{{$asset->id}}">{{ $asset->type }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Model Name<label></td>
                            <td> <select name="mname" id="mname" required class="form-control" onchange="getserial()" ></select></td>

                        </tr>

                        <tr>
                            <td><label>Serial No:</label></td>
                           <td> <select name="number" id="number" required class="form-control" ></select></td>
                        </tr>
                       
                       <tr>
                            <td><label>Description:</label></td>
                                <td> <input  name="details" id="desc" required class="form-control" onclick="getdesc()"></td>
                            </td>
                        </tr>
                         <tr>
                            <td><label>Employee Signature:</label></td>
                            <td><input required type="file" name="emp_image"  class="form-control" accept="image/*" ></td>
                        </tr>
                        <tr>
                            <td><label>Asset Manager Signature:</label></td>
                            <td><input required type="file" name="manager_image"  class="form-control" accept="image/*" ></td>
                        </tr>
                        <tr>
                            <td><label>Remark:</label></td>
                             <td><textarea required class="form-control" placeholder="Remark" name="remark[]" style="resize: none;" ></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Assign_Date:</label></td>
                             <td><input required type="date" name="tdate"  class="form-control"  /></td>

                        </tr>
                    </tbody>
                </table>
                <center><input type="submit" class=" btn btn-md btn-success" value="Save"></center>
            </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>

  </div>
</div>


<!-- Modal -->
<div id="modelsim" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
     <div class="modal-content">
      <div class="modal-header" style="background-color:rgb(244, 129, 31);color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Assign</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ URL::to('/') }}/savesiminfo" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="userId" value="{{ $user->employeeId }}">
                <table id="asset" class="table table-responsive">
                    
                    <tbody>
                    
                    <tr>
                        <td><label>SIMCard Number</label></td>
                        <td><select required class="form-control" name="number" id="num" onchange="getbrand()" style="width:60%">
                                    <option value="">--Select--</option>
                                    @foreach($sim as $sim)
                                    <option value="{{$sim->id}}">{{ $sim->sim_number }}</option>
                                    @endforeach
                                </select></td>
                    </tr>
                    <tr>
                        <td ><label>SIMCard Brand/Provider </label></td>
                        <td ><input required type="text" name="sim" id="sim" class="form-control" style="width:60%" /></td>
                    </tr>
                    <tr>
                            <td><label>Employee Signature:</label></td>
                            <td><input required type="file" name="emp_image"  class="form-control" accept="image/*" style="width:60%"></td>
                    </tr>
                    <tr>
                        <td><label>Asset Manager Signature:</label></td>
                        <td><input required type="file" name="manager_image"  class="form-control" accept="image/*" style="width:60%"></td>
                    </tr>
                    <tr>
                        <td ><label> Remark:</label></td>
                        <td ><textarea required placeholder="Remark"  required type="type" cols="3" name="sremark"  class="form-control" style="width:60%;resize: none;" /></textarea></td>                
                    </tr>
                    </tbody>
                </table>
                <center><input type="submit" class=" btn btn-md btn-success" value="Save"></center>
            </form>
      </div>
    </div>

  </div>
</div>


<!-- Modal -->
   @foreach($assetInfos as $assetInfo)
  <div class="modal fade" id="myModal{{ $assetInfo->id}}" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color:rgb(244, 129, 31);color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Asset Info</h4>
        </div>
          <form method="POST" action="{{URL::to('/')}}/saveassetinfo?Id={{$assetInfo->id}}">
                {{ csrf_field() }}
                    <input type="hidden" value="{{ $assetInfo->id }}" name="id">
                    <div class="modal-body"> 
                                <table class="table table-responsive">
                                    <tbody>
                                         <tr>
                                            <td><label>Serial No.</label></td>
                                            <td><input type="text" class="form-control" value="{{$assetInfo->serial_no}}" name="serial_no" style="width: 50%;"></td>
                                        </tr>
                                        <tr>
                                            <td><label>Description</label></td>
                                            <td><input type="text" class="form-control" value="{{ $assetInfo->description }}" name="desc" style="width: 50%;resize: none;"></td>
                                        </tr>
                                        <tr>
                                            <td><label>Remark</label></td>
                                            <td><input type="text" class="form-control" value="{{$assetInfo->remark}}" name="remark" style="width: 50%;resize: none;"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><button type="submit" class="btn btn-success" >save</button></td>
                                    </tbody>
                                </table>
                    </div>
            </form>
            <div class="modal-footer">
            </div>
      </div>
    </div>
  </div>
@endforeach
<script>
function getbrand(){
     var x = document.getElementById('num');
     var name = x.options[x.selectedIndex].value;
   
     $.ajax({
                    type:'GET',
                    url:"{{URL::to('/')}}/getbrand",
                    async:false,
                    data:{name : name},
                    success: function(response)
                    {
                       
                         console.log(response);
                         for(var i=0;i<response.length;i++)
                        {
                           var text = response[i].provider;
                          
                         
                        }
                         document.getElementById('sim').value = text;   
                    }
                });
            }
function getname(){
        var x = document.getElementById('type');
        var name = x.options[x.selectedIndex].value;
                $.ajax({
                    type:'GET',
                    url:"{{URL::to('/')}}/getname",
                    async:false,
                    data:{name : name},
                    success: function(response)
                    {
                        console.log(response);
                        
                        var ans = "<option value=''>--Select--</option>";
                        for(var i=0;i<response.length;i++)
                        {
                            ans += "<option value='"+response[i].id+"'>"+response[i].name+"</option>";
                        }
                        document.getElementById('mname').innerHTML = ans;
                    }
                });

            }
function getserial()
    {
        var y = document.getElementById("type");
        var serial = y.options[y.selectedIndex].value;
        var z = document.getElementById("mname").value;
        $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/getserial",
            async:false,
            data:{serial : serial, z: z},
            success: function(response)
            {

                
                 console.log(response);
                 
                 for(var i=0;i<response.length;i++)
                        {
                          var  text = "<option value='"+response[i].id+"'>"+response[i].sl_no+"</option>";
                        }
                  document.getElementById('number').innerHTML = text;

               
            }
        });    
    }
function getdesc(){

       var x = document.getElementById("type");
        var desc = x.options[x.selectedIndex].value;
        var z = document.getElementById("number").value;
       
                $.ajax({
                    type:'GET',
                    url:"{{URL::to('/')}}/getdesc",
                    async:false,
                    data:{desc : desc,z: z},
                    success: function(response)
                    {

                         console.log(response);
                         
                         for(var i=0;i<response.length;i++)
                        {
                           var text = response[i].description;
                         
                        }
                         document.getElementById('desc').value = text;
                        
                    }
                });
            }
</script>       
@endsection
