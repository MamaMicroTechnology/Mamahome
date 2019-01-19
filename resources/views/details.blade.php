
@extends('layouts.app')
@section('content')
<br>
<div class="col-md-10 col-md-offset-2">
<div class="panel panel-success">
    <div class="panel-heading">
    </div>
    <div class="panel-body" style="overflow-x:scroll;overflow-y:scroll;">
            <form method="post" action="{{ URL::to('/') }}/storeproject">
              {{ csrf_field() }}  
        <div class="col-md-2">
            <center>Type of Customer </center>
                <select required class="form-control" name="type">
                    <option value="">--Select--</option>
                  
                    <option value="project">Projects</option>
                    <option value="Manufacturer">Manufacturer</option>
                </select>
        </div>
        <div class="col-md-4">
            <center>Enter Projects Example: 1924,2345,....... </center>
               <input type="text" name="projectids" class="form-control">
        </div>
         <div class="col-md-6">
            <p>List Of Team Members </p>
               
       <select name="user_id"  class="form-control" style="width: 30%;">
                          <option value="">--Select--</option>
                          
                          @foreach($users as $user)  
                            <option value="{{ $user->id }}">{{$user->name}}</option>
                           @endforeach
                            </select>
            <br>
        </div>
                <button style="width:50%;" class="btn btn-primary form-control" type="submit">Submit</button>
            </form>

            <table class="table table-responsive"  class="table">
                        <thead>
                            <th style="width:15%">Name</th>
                            <th style="width:15%">Type </th>
                            <th style="width:15%">Action </th>

                            <th style="width:15%">Assigned Ids</th>
                          </thead>
                          @foreach($projects as $project)
                            <tr>
                            <td>{{$project->user != null ? $project->user->name : ''}}</td>
                            <td>{{ $project->type }}</td>
                              <td>
                <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete{{ $project->id }}">Delete</button>

                <!-- Modal -->
                <div class="modal fade" id="delete{{ $project->id }}" role="dialog">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Delete</h4>
                          {{$project->id}}
                      </div>
                      <div class="modal-body">
                        <p>Are you sure you want to delete this project?</p>
                      </div>
                      <div class="modal-footer">
                        <input type="hidden" name="type" value="{{$project->type}}">
                        <a class="btn btn-danger pull-left" href="{{ URL::to('/') }}/deleteuser?projectId={{ $project->id }}">Yes</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                      </div>
                    </div>
                  </div>
                </div>
              </td>            
                            <td>{{ $project->project_id }}</td>
                          </tr>

                          @endforeach
                      </table>    
        @if(session('success'))
          <script>
            swal("Success","{{ session('success')}}","success");
          </script>
 @endif
 @if(session('NotAdded'))
          <script>
            swal("Error","{{ session('NotAdded')}}","error");
          </script>
  @endif
@endsection
