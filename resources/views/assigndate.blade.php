@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <div class="panel panel-default" style="border-color:#f4811f">
                <div class="panel-heading text-center" style="background-color:#f4811f"><b style="color:white;font-size:1.3em">Assign Date</b>
                    @if(session('Error'))
                        <div class="alert-danger pull-right">{{ session('Error')}}</div>
                    @endif
                <a  href="javascript:history.back()" class="btn btn-sm btn-danger pull-right">Back</a>    
                </div>
                <div class="panel-body">
            
    
                    
                <form method="POST" action="{{ url('/datestore')}}" > 
                {{ csrf_field() }}     
            <div class="panel-body">
                <table class="table table-responsive table-striped table-hover">
                        <thead>
                            <th style="width:15%">Name</th>
                            <th style="width:15%">Designation</th>
                            <th style="width:15%">Assign Date</th>
                           <!--  <th style="width:15%">Previously Assigned  Stage </th>
                            <th style="text-align:center">Action</th> -->
                          </thead>

                        <tbody>
                       
                        
                           @foreach($users as $user)
                           
                           <tr>
                           <td>{{$user->name}}</td>
                           <td>{{ $user->group_name }}</td>
                           <td><input type="hidden" name="name" value="{{$user->name}}">
                           <td>
                          <!--  <td>
                          <a data-toggle="modal" data-target="#date" class="btn btn-sm btn-primary">Assign Date</a>
                           
                           </td> -->
                          <td> <input type="date"    name="assigndate" class=" input-sm"></td>
                        <td><button type="submit" class="btn btn-success pull-left">Assign</button></td>
                           @endforeach
                            
                          </tr>         
                          
                         
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


@endsection



