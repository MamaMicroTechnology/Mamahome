@extends('layouts.amheader')
@section('content')

<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading" style="background-color: green;color: white;">Asset Info
        <a class="pull-right btn btn-sm btn-danger" href="{{url()->previous()}}">Back</a>
        <span class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;</span>
         <input type="button" class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#myaddModal" value="ADD Asset">
        </div>
        <div class="panel-body" style="overflow-x: hidden;overflow-y: scroll;">
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
                        @if($assetInfos != NULL)
                        <table class="table table-responsive">
                            <thead>
                                <th>Type</th>
                                <th>Seria No.</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Assign_Date</th>
                                <th>Remark</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach($assetInfos as $assetInfo)
                                <tr>
                                    <td>{{ $assetInfo->asset_type }}</td>
                                    <td>{{$assetInfo->serial_no}}</td>
                                    <td><a href="{{ URL::to('/')}}/public/assettype/{{ $assetInfo->image}}"  target="_blank"> image</a></td>
                                    <td>{{ $assetInfo->description }}</td>
                                    <td>{{ date('d-m-Y h:m:s ' , strtotime($assetInfo->assign_date))}}</td>
                                    <td>{{$assetInfo->remark}}</td>
                                    <td>
                                        <form method="POST" action="{{ URL::to('/') }}/deleteAsset">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{ $assetInfo->id }}">
                                            <input type="submit" value="Delete" class="btn btn-xs btn-danger"> 
                                        </form>

                                    </td>
                                    <td> <input type="submit" value="Edit" style="width: 80%" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModal{{ $assetInfo->id}}"></td>
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
        <h4 class="modal-title">Add Aseet</h4>
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
                                <select required class="form-control" name="type[]">
                                    <option value="">--Select--</option>
                                    @foreach($assets as $asset)
                                    <option value="{{$asset->type}}">{{ $asset->type }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Serial No:</td>
                            <td><input type="text" name="serial_no[]"  class="form-control" placeholder="Serial No" ></td>
                        </tr>
                        <tr>
                            <td>Upload Image:</td>
                            <td><input required type="file" name="image"  class="form-control" accept="image/*" ></td>
                        </tr>
                       <tr>
                            <td>Description:</td>
                            <td>
                                <textarea required class="form-control" placeholder="Asset description" name="details[]"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Remark:</td>
                             <td><textarea required class="form-control" placeholder="Remark" name="remark[]" ></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Assign_Date:</td>
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
                                            <td><input type="text" class="form-control" value="{{ $assetInfo->description }}" name="desc" style="width: 50%;"></td>
                                        </tr>
                                        <tr>
                                            <td><label>Remark</label></td>
                                            <td><input type="text" class="form-control" value="{{$assetInfo->remark}}" name="remark" style="width: 50%;"></td>
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
<!-- <script>
    function addRow() {
            var table = document.getElementById("asset");
            var row = table.insertRow(0);
            var cell1 = row.insertCell(-1);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);

            cell1.innerHTML = "<select required class=\"form-control\" name=\"type[]\"><option value=\"\">--Select--</option>@foreach($assets as $asset)<option value=\"{{$asset->type}}\">{{ $asset->type }}</option>@endforeach </select>";
            cell2.innerHTML = "<input required class=\"form-control\" placeholder=\"Serial No\" name=\"serial_no[]\">";
            cell3.innerHTML = "<input required class=\"form-control\" type=\"file\" name=\"image\" accept=\"image/*\" >";
            cell4.innerHTML = "<textarea required class=\"form-control\" placeholder=\"Asset Description\" name=\"details[]\"></textarea>";
            cell5.innerHTML = "<textarea required class=\"form-control\" placeholder=\"Remark\" name=\"remark[]\"></textarea>";
            cell6.innerHTML = "<input required class=\"form-control\" type=\"date\" name=\"tdate\">";
        } 
        function deleteRow() {
            document.getElementById("asset").deleteRow(0);
        }
</script> -->
@endsection