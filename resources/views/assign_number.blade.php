@extends('layouts.app')

@section('content')
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading" style="background-color: green;color: white;pa">Assign Stage
        <a class="pull-right btn btn-sm btn-danger" href="{{url()->previous()}}">Back</a>
        </div>
        <div class="panel-body">
        	 @if (session('Success'))
                        <div class="alert alert-success">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ session('Success') }}
                        </div>
               @endif
               @if(session('NotAdded'))
                          <div class="alert alert-danger alert-dismissable">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          {{ session('NotAdded') }}
                          </div>
                @endif
									
						 <table class="table table-responsive table-striped table-hover" class="table">
                        <thead>
                            <th style="width:15%">Name</th>
                            <th style="width:15%">Designation</th>
                            <th style="width:15%">Previously Assigned Stage </th>
                           <th style="width:15%">Action </th>
                           
                          </thead>
                          @foreach($users as $user)  
                           <tr>
                            <td>{{$user->name}}</td>
                            <td>{{ $user->group_name }}</td>
                             <td>{{ $user->stage }}</td>
                             <td><button onclick="makeUserId('{{ $user->id }}')" type="button" style="background-color: #00e676;color: white" data-toggle="modal" id="#myModal"  data-target="#myModal"  class="btn  pull-left">Assign</button></td>
                             <input type="hidden"  name="user_id" value="{{ $user->id }}">
                          </tr>         
                           @endforeach
                   
                </table>  	
		
      <form method="POST" name="myform" action="{{ URL::to('/') }}/storenumber" enctype="multipart/form-data">
     {{ csrf_field() }}
     <input type="hidden" id="userId" name="user_id">
      <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog">
                  <div class="modal-dialog" style="width: 70%;" >

                    <!-- Modal content-->
                    <div class="modal-content" >
                      <div class="modal-header" style="background-color:rgb(244, 129, 31);color:white">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="text-align: center;">Select Stages</h4>
                      </div>
                      <div class="modal-body">
                                    
                                
                                 
                                  <div class="row">
                                 <div class="col-sm-12">
                                    <table>
                                       <tr id="sp">
                                       <div class="checkbox">
                                      <lable><td style=" padding:20px 40px 20px 40px;" ><input type="checkbox" name="stage[]" value="Planning">&nbsp;&nbsp;Planning</td>
                                           <td  style=" padding:20px 40px 20px 40px;"><input type="checkbox" name="stage[]" value="Digging">&nbsp;&nbsp;Digging</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Foundation">&nbsp;&nbsp;Foundation</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Pillars">&nbsp;&nbsp;Pillars</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Walls">&nbsp;&nbsp;Walls</td></lable>
                                         </div>
                                       </tr>    
                                         <tr id="sp">
                                       <div class="checkbox">
                                      <lable><td  style=" padding:20px 40px 20px 40px;"><input type="checkbox" name="stage[]" value="Roofing">&nbsp;&nbsp;Roofing</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Electrical">&nbsp;&nbsp;Electrical</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Plumbing">&nbsp;&nbsp;Plumbing</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Plastering">&nbsp;&nbsp;Plastering</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Flooring">&nbsp;&nbsp;Flooring</td></lable>
                                           </div>
                                       </tr>  
                                        <tr id="sp">
                                       <div class="checkbox">
                                      <lable>     <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Carpentry">&nbsp;&nbsp;Carpentry</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Paintings">&nbsp;&nbsp;Paintings</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Fixtures">&nbsp;&nbsp;Fixtures</td>
                                          <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Completion">&nbsp;&nbsp;Completion</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Closed">&nbsp;&nbsp;Closed</td></lable>
                                           </div>
                                       </tr>    
                                      </table>
                                    </div>
                              </div>


                               <div class="modal-footer">
                                 <button type="submit" class="btn btn-success">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>

                    </div>  
                  </div>
                </div>
              </div>
            </form>
           </div>
		</div>
</div>
<script type="text/javascript">
  function makeUserId(arg){
  document.getElementById("userId").value = arg;
  
}
</script>
@endsection