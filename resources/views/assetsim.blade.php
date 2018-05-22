
<div class="panel panel-default" style="border-color:green">
<div class="panel-heading" style="background-color:green;font-weight:bold;font-size:1.3em;color:white" >{{ $asset }} Details
<button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#myModal">ADD</button></div>
<div class="panel-body" style="height:500px;max-height:500px;overflow-x:hidden; overflow-y:scroll;">
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
        <th>Provider</th>
        <th>SIMCard Number</th>
        <th>Remark</th>
        <th>Action</th>
        <th>Status</th>
       
    </thead>
    <tbody>
    @foreach($mh as $mh)
    <tr>
        <td>{{ $mh->provider }} </td>
        <td>{{ $mh->sim_number }} </td>
        <td>{{ $mh->sim_remark }} </td>
        <td>
              <form method="POST" action="{{ URL::to('/') }}/deleteassetsimcard">
	                {{ csrf_field() }}
	                <input type="hidden" name="id" value="{{ $mh->id }}">
	                <input type="submit" value="Delete" class="btn btn-xs btn-danger"> 
	           </form>

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
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add {{ $asset }} Details</h4>
        </div>
        <form method="POST" name="myform" action="{{URL::to('/')}}/assetsimcard?asset={{$asset}}" enctype="multipart/form-data">
                        {{csrf_field()}}
        <div class="modal-body">
          <table class="table table-responsive table-hover">
                <tbody>
                    <tr>
                        <td ><label>SIMCard Brand/Provider </label></td>
                        <td ><input required type="text" name="sim" id="sim"  placeholder="Provider Name" title="Please enter characters only" class="form-control" pattern="[A-Za-z]+" style="width:60%" /></td>
                    </tr>
                    <tr>
                    	<td><label>SIMCard Number</label></td>
                    	<td><input required type="text" name="number" minlength="10" maxlength="10" id="number" placeholder="+91"  oninput="getnumber()" class="form-control" style="width:60%"></td>
                    </tr>
                    <tr>
                        <td ><label> Remark:</label></td>
                        <td ><textarea required  placeholder="Remark"  required type="type" cols="3" name="sremark"  class="form-control" style="width:60%;resize: none;" /></textarea></td>                
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
 </div>
<table class="table table-hover">
<thead>
    
</thead>
<tbody>

</tbody>
</table>
</div>
<script>
    function updateUser(arg)
    {
        var userId = arg;
        $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/updateUser",
            async:false,
            data:{userId : userId},
            success: function(response)
            {
                alert(response);
            }
        });    
    }
</script>
<script type="text/javascript">
	 function getnumber()
	{
		
		var num=document.myform.number.value;

			if(isNaN(num)){
				document.getElementById('number').value="";
				myform.number.focus();
		     }
	}
</script>