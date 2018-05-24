<div class="panel panel-default" style="border-color:green">
<div class="panel-heading" style="background-color:green;font-weight:bold;font-size:1.3em;color:white">{{ $asset }} Details <button type="button" class="btn btn-danger btn-sm pull-right" data-toggle="modal" data-target="#myModal">ADD</button></div>
<div class="panel-body" style="height:500px;max-height:500px;overflow-x: scroll;overflow-y: scroll;">
 <table class="table table-hover table-bordered" style="width:25%;">
            <tbody>
                <thead>
                    <th colspan="2" style="text-align: center;">Total Count Information</th>
                </thead>
                <tr >
                    <td><label>Assigned {{ $asset }} </label></td>
                    <td>{{$rcount}}</td>
                   

                </tr>
               
                <tr >
                    <td><label>Remaining {{ $asset }}</label></td>
                    <td>{{$remaining}}</td>
                   
                </tr>
                 <tr  >
                    <td><label>Total {{ $asset }}s </label></td>
                    <td>{{$tcount}}</td>
                   
                   
                </tr>
            </tbody>
        </table>
    <table class="table table-hover">
    <thead>
        <th>Name</th>
        <th>Serial No.</th>
        <th>Asset Image</th>
        <th>Description</th>
        <th>Company</th>
        <th>Date</th>
        <th>Bill</th>
        <th>Remark</th>
        <th>Action</th>
        <th>Status</th>
       
    </thead>
    <tbody>
    @foreach($mh as $mh)
    <tr>
        <td>{{ $mh->name }} </td>
        <td>{{ $mh->sl_no }} </td>
        <td><a href="{{ URL::to('/')}}/public/assettype/{{ $mh->asset_image}}"  target="_blank">image</a></td>
        <td style="width:20%">{{ $mh->description }} </td>
        <td>{{ $mh->company }} </td>
        <td>{{ date('d-m-Y ', strtotime("$mh->date")) }} </td>
        <td><a href="{{ URL::to('/')}}/public/assetbill/{{ $mh->bill}}"  target="_blank">image</a></td>
        <td>{{ $mh->remark}}</td>
        <td style="width:15%;">
            <a href="{{ URL::to('/') }}/editasset?Id={{ $mh->id }}" class="btn btn-xs btn-success" >Edit</a>
            <a href="{{ URL::to('/') }}/deleteassets?Id={{ $mh->id }}" class="btn btn-xs btn-danger">Delete</a>
        </td>
        <td>{{ $mh->status }}</td>
    </tr>
    @endforeach
    </tbody>
    </table>
   

    <!-- Modal -->
          <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header" style="background-color: green;color:white;">
                  <button type="button" class="close" data-dismiss="modal" style="color: white">&times;</button>
                  <h4 class="modal-title">Add {{ $asset }} Details</h4>
                </div>
                     <form method="POST" name="myform" action="{{URL::to('/')}}/inputasset?asset={{$asset}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                            <div class="modal-body">
                                <table class="table table-responsive table-hover">
                                            <tbody>
                                                <tr>
                                                    <td ><label>  Name of the Asset: </label></td>
                                                    <td ><input required type="text" name="lname" placeholder=" Model name"  class="form-control" style="width:60%" /></td>
                                                </tr>
                                                 <tr>
                                                    <td ><label> Serial_No:</label></td>
                                                    <td ><input  type="text" name="slno" placeholder="Serial no" class="form-control" style="width:60%" /></td>
                                                </tr>
                                                 <tr>
                                                    <td ><label> Upload asset Image:</label></td>
                                                    <td ><input required type="file" name="upload"  class="form-control" accept="image/*" style="width:60%" /></td>
                                                </tr>
                                                <tr>
                                                    <td ><label> Description:</label></td>
                                                    <td ><textarea required rows="3"  type="text" name="desc" placeholder="Description" class="form-control" style="width:60%;resize: none;" /></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td ><label> Company:</label></td>
                                                    <td ><input  type="type" name="cmp" placeholder="Brand name" class="form-control" style="width:60%" /></td>
                                                </tr>
                                                <tr>
                                                    <td ><label>Purchased Date:</label></td>
                                                    <td ><input required type="date" name="tdate"  class="form-control" style="width:60%" /></td>
                                                </tr>
                                                <tr>
                                                    <td ><label> Bill:</label></td>
                                                    <td ><input type="file" name="bill"  class="form-control" accept="image/*" style="width:60%" /></td>
                                                </tr>
                                                <tr>
                                                    <td ><label> Remark:</label></td>
                                                    <td ><textarea  placeholder="Remark"  required type="type" cols="3" name="remark"  class="form-control" style="width:60%;resize: none;" /></textarea></td>
                                                </tr>
                                            </tbody>
                                </table>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-success" >Save</button>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                    </form>
             </div>  
        </div>
    </div>
 
 <!-- Modal -->
<div id="report" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:20%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background-color: green;color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Count</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
