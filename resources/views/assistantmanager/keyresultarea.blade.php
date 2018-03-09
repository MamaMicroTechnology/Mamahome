@extends('layouts.amheader')

@section('content')

<!-- Modal -->
<form method="POST" action="{{ URL::to('/') }}/addKRA">
    {{ csrf_field() }}
    <div id="addKRA" class="modal fade" role="dialog">
      <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
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

<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default" style="border-color:#f4811f">
        <div class="panel-heading" style="background-color:#f4811f"><b style="color:white;font-size:1.3em">KRA List</b> <button class="btn btn-md btn-success pull-right" data-toggle="modal" data-target="#addKRA">Add</button></div>
        <div class="panel-body">
            <table class="table table-hover" border=1>
                <thead>
                    <th>Department Name</th>
                    <th>Designation</th>
                    <th>Role</th>
                    <th>Goal</th>
                    <th>Key Result Area</th>
                    <th>Key Performance Area</th>
                </thead>
                <tbody>
                    @foreach($kras as $kra)
                    <tr>
                        <td>{{ $kra->dept_name }}</td>
                        <td>{{ $kra->group_name }}</td>
                        <td>{{ $kra->role }}</td>
                        <td>{{ $kra->goal }}</td>
                        <td>{{ $kra->key_result_area }}</td>
                        <td>{{ $kra->key_performance_area }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
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