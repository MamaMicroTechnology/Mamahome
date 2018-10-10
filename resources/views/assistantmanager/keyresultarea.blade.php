
<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 2? "layouts.app":"layouts.teamheader");
?>
@extends($ext)
@section('content')

<!-- Modal -->
@if(Auth::user()->group_id != 2)
<form method="POST" action="{{ URL::to('/') }}/addKRA">
    @else
    <form method="POST" action="{{ URL::to('/') }}/teamaddKRA">
    @endif
    {{ csrf_field() }}
    <div id="addKRA" class="modal fade" role="dialog">
      <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="background-color:#f4811f;color:white; ">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add KRA</h4>
          </div>
          <div class="modal-body">
            
            <div class="row">
                <div class="col-md-4">Department</div>
                <div class="col-md-8">
                    <select name="department" class="form-control">
                        <option vlaue="">--Select--</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->dept_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-4">Designation</div>
                <div class="col-md-8">
                    <select name="group" class="form-control">
                        <option value="">--Select--</option>
                        @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-4">Role</div>
                <div class="col-md-8"><input name="role" type="text" class="form-control" placeholder="Role"></div>
            </div><br>
            <div class="row">
                <div class="col-md-4">Goal</div>
                <div class="col-md-8"><input name="goal" type="text" class="form-control" placeholder="Goal"></div>
            </div><br>
            <div class="row">
                <div class="col-md-4">Key result area</div>
                <div class="col-md-8"><input name="kra" type="text" class="form-control" placeholder="Key result area"></div>
            </div><br>
            <div class="row">
                <div class="col-md-4">Key performance area</div>
                <div class="col-md-8"><input name="kpa" type="text" class="form-control" placeholder="Key performance area"></div>
            </div>
            
          </div>
          <div class="modal-footer">
             <div class="row">
                <div class="col-md-6"><input type="submit" value="Save" class="form-control btn btn-success"></div>
                <div class="col-md-6"><input type="reset" value="Clear" class="form-control btn btn-danger"></div>
            </div>
          </div>
        </div>
    
      </div>
    </div>
</form>

<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default" style="border-color:#f4811f">
        <div class="panel-heading" style="background-color:#f4811f;"><b style="color:white;font-size:1.3em">KRA List</b> 
        <a href="{{ URL::to('/') }}/home" class="btn btn-default pull-right" style="margin-top:-3px;" > <i class="fa fa-arrow-circle-left" style="width:30px;"></i></a>
            <button class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#addKRA">Add</button><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        </div>
        <div class="panel-body">
            <table class="table table-hover" border=1>
                <thead>
                    <th style="text-align: center;width:5%">Department Name</th>
                    <th style="text-align: center;width:5%">Designation</th>
                    <th style="text-align: center;width:20%">Role</th>
                    <th style="text-align: center;width:15%">Goal</th>
                    <th style="text-align: center;width:15%">Key Result Area</th>
                    <th style="text-align: center;width:20%">Key Performance Area</th>
                    <th style="text-align: center;width:20%">Action</th>
                </thead>
                <tbody>
                    @foreach($kras as $kra)
                    <tr id="current{{ $kra->group_id }}">
                        <td style="text-align: center;">{{ $kra->dept_name }}</td>
                        <td style="text-align: center;">{{ $kra->group_name }}</td>
                        <td>{{ $kra->role }}</td>
                        <td>{{ $kra->goal }}</td>
                        <td>{{ $kra->key_result_area }}</td>
                        <td>{{ $kra->key_performance_area }}</td>
                        <td style="text-align:center" colspan="2">
                           
                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal{{ $kra->id }}">Edit</button>
                           
                            @if(Auth::user()->group_id != 2)
                            <a href="{{URL::to('/')}}/deletekra?deptid={{$kra->department_id}}&groupid={{$kra->group_id}}" class="btn btn-sm btn-danger">Delete</a>
                            @else
                            <a href="{{URL::to('/')}}/teamdeletekra?deptid={{$kra->department_id}}&groupid={{$kra->group_id}}" class="btn btn-sm btn-danger">Delete</a>
                            @endif
                        </td>    
                    </tr>
                   
                    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@if(Auth::user()->group_id != 2)
@foreach($kras as $kra)
 <div class="modal fade" id="myModal{{ $kra->id }}" role="dialog">
    <div class="modal-dialog">             
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: green;color: white;">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit KRA List</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ URL::to('/') }}/updatekra?deptid={{$kra->department_id}}&groupid={{$kra->group_id}}">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{ $kra->id }}" name="id">
                    <table>
                        <tr>
                        <td>Role</td>
                        <td><input type="text" name="role" value="{{ $kra->role }}" class="form-control input-sm"></td>
                        </tr>
                        <tr>
                        <td>Goal</td>
                        <td><input type="text" name="goal" value="{{ $kra->goal }}" class="form-control input-sm">
                        </td>
                        </tr>
                        <tr>
                        <td>Key Result Area</td>
                        <td><input type="text" name="kra" value="{{ $kra->key_result_area }}" class="form-control input-sm">
                        </td>
                        </tr>  
                        <tr>
                        <td>key performance area</td> 
                             <td><input type="text" name="kpa" value="{{ $kra->key_performance_area }}" class="form-control input-sm">
                        </td>
                        </tr>
                    </table>           
                    <div class="modal-footer">
                         <button class="btn btn-sm btn-success" type="submit">Save</button>
                     </div>
                </form>
             </div>              
         </div>
    </div>
</div>
@endforeach
@else
@foreach($kras as $kra)
 <div class="modal fade" id="myModal{{ $kra->id }}" role="dialog">
    <div class="modal-dialog">             
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: green;color: white;">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit KRA List</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ URL::to('/') }}/teamupdatekra?deptid={{$kra->department_id}}&groupid={{$kra->group_id}}">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{ $kra->id }}" name="id">
                    <table>
                        <tr>
                        <td>Role</td>
                        <td><input type="text" name="role" value="{{ $kra->role }}" class="form-control input-sm"></td>
                        </tr>
                        <tr>
                        <td>Goal</td>
                        <td><input type="text" name="goal" value="{{ $kra->goal }}" class="form-control input-sm">
                        </td>
                        </tr>
                        <tr>
                        <td>Key Result Area</td>
                        <td><input type="text" name="kra" value="{{ $kra->key_result_area }}" class="form-control input-sm">
                        </td>
                        </tr>  
                        <tr>
                        <td>key performance area</td> 
                             <td><input type="text" name="kpa" value="{{ $kra->key_performance_area }}" class="form-control input-sm">
                        </td>
                        </tr>
                    </table>           
                    <div class="modal-footer">
                         <button class="btn btn-sm btn-success" type="submit">Save</button>
                     </div>
                </form>
             </div>              
         </div>
    </div>
</div>
@endforeach
@endif
<div class='b'></div>
<div class='bb'></div>
<div class='message'>
  <div class='check'>
    &#10004;
  </div>
  <p>
    Success
  </p>
  <p>
    @if(session('Success'))
    {{ session('Success') }}
    @endif
  </p>
  <button id='ok'>
    OK
  </button>
</div>


@endsection