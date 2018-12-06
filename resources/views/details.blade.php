
@extends('layouts.app')
@section('content')
<br>
<div class="col-md-10 col-md-offset-2">
<div class="panel panel-success">
    <div class="panel-heading">
    </div>
    <div class="panel-body">
            <form method="GET" action="{{ URL::to('/') }}/details">
        <div class="col-md-2">
            <center>Type of Customer </center>
                <select required class="form-control" name="type">
                    <option value="">--Select--</option>
                    <option value="Manufacturer">Manufacturer</option>
                    <option value="project">Projects</option>
                    
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

            <table class="table table-responsive table-striped table-hover" class="table">
                        <thead>
                            <th style="width:15%">Name</th>
                            <th style="width:15%">Assigned Ids</th>
                            <th style="width:15%">Type </th>
                          </thead>
                          @foreach($projects as $project)
                            <tr>
                            <td>{{$project->user != null ? $project->user->name : ''}}</td>
                            <td>{{ $project->project_id }}</td>
                            <td>{{ $project->type }}</td>

                          </tr>
                          @endforeach
                      </table>    
       
@endsection
