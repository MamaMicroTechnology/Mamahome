
<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 2? "layouts.app":"layouts.teamheader");
?>
@extends($ext)
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <div class="panel panel-default" style="border-color:#f4811f">
                <div class="panel-heading text-center" style="background-color:#f4811f"><b style="color:white;font-size:1.3em">Assign Stages</b>
                    @if(session('Error'))
                        <div class="alert-danger pull-right">{{ session('Error')}}</div>
                    @endif
                <a  href="javascript:history.back()" class="btn btn-sm btn-danger pull-right">Back</a>    
                </div>
                <div class="panel-body">
            
    <form method="POST" action="{{ url('/store')}}" enctype="multipart/form-data">
                    
                    {{ csrf_field() }}
            <div class="panel-body">
                <table class="table table-responsive table-striped table-hover">
                        <thead>
                            <th style="width:15%">Name</th>
                            <th style="width:15%">Designation</th>
                            <th style="width:15%">Assign Stage</th>
                            <th style="width:15%">Previously Assigned  Stage </th>
                            <th style="text-align:center">Action</th>
                          </thead>

                        <tbody>
                            
                           @foreach($users as $user)
                           <tr>
                           <td>{{$user->name}}</td>
                           <td>{{ $user->group_name }}</td>
                           <td><input type="hidden" name="list" value="{{$user->name}}">
                           <td>
                          <a data-toggle="modal" data-target="#assignstages" class="btn btn-sm btn-primary">Assign Stages</a>
                           
                           </td>
                           <td style="text-align:center">
                           @if($user->status1 == 'Not Completed')
                                    {{ $user->prev_assign}}
                                  @else
                                    {{ $user->prev_assign}}
                                  @endif
                                </td><!-- Previous date -->
                                
                                <td style="text-align:center"> 
                                  
                                    <a href="" class="btn btn-sm btn-success"  onclick="{{ URL::to('/') }}/salescompleted; " > Completed </a>
                                   
                                  
                                </td>
                           
                           @endforeach
                            
                                   
                      
                         
                       </tbody>
                       
                    
                </table>
               
            </div>
            </form> 



                                        {{$users->links()}}

        </div>
        </div>
        </div>
        </div>
        </div>
@foreach($users as $user)
<!-- Modal -->
<form method="POST"  action="{{ url('/store')}}">
{{ csrf_field() }}    
    <div id="assignstages" class="modal fade" role="dialog">
      <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="background-color:#f4811f">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><b style="color:white;font-size:1.3em">Assign Stages</b></h4>
          </div>
          <div class="modal-body">
            <label>Choose Satges :</label><br>
    <select  id="status"  name="status" class=" input-sm"  onchange="loadsubwards('{{ $user->id }}')">
                                   <option value="">--Select--</option>
                                   <option value="Planning">Planning</option>
                                   <option value="Digging">Digging</option>
                                   <option value="Foundation">Foundation</option>
                                   <option value="Pillars">Pillars</option>
                                   <option value="Walls">Walls</option>
                                   <option value="Roofing">Roofing</option>
                                   <option value="Electrical">Electrical</option>
                                    <option value="Plumbing">Plumbing</option>
                                   <option value="Plastering">Plastering</option>
                                   <option value="Flooring">Flooring</option>
                                   <option value="Carpentry">Carpentry</option>
                                   <option value="Paintings">Paintings</option>
                                   <option value="Fixtures">Fixtures</option>
                                   <option value="Completion">Completion</option>
                                   <option value="Completion">Closed</option>

                                
                </select>
            
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success pull-left">Assign</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
</form>
@endforeach
<script type="text/javascript">
    function loadsubwards(arg)
    {
        var x = document.getElementById('ward'+arg);
       }
</script>
@endsection



