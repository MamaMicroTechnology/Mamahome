@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default" style="border-color:#f4811f">
                <div class="panel-heading text-center" style="background-color:#f4811f"><b style="color:white;font-size:1.3em">Assign Date</b>
                    @if(session('Error'))
                        <div class="alert-danger pull-right">{{ session('Error')}}</div>
                    @endif
                <a  href="javascript:history.back()" class="btn btn-sm btn-danger pull-right">Back</a>    
                </div>
                <div class="panel-body">
            
    
                    
    <form method="POST" id="assign" action="{{ url('/datestore')}}" >
    {{ csrf_field() }}
    <input type="hidden" id="username" name="name">
    <input type="hidden" id="dateassigned" name="assigndate">
    </form>
               <div class="panel-body">
                <table class="table table-responsive table-striped table-hover">
                        <thead>
                            <th style="width:15%">Name</th>
                            <th style="width:15%">Designation</th>
                            <th style="width:15%">Assign Date</th>
                            <th></th>
                          </thead>
                        <tbody>
                           @foreach($users as $user)
                           <tr>
                            <td>{{$user->name}}</td>
                            <td>{{ $user->group_name }}</td>
                            <input type="hidden" id= "user{{ $user->id }}" name="name" value="{{$user->id}}">
                            <td> <input type="date" id="date{{ $user->id }}" name="assigndate" class="form-control input-sm"></td>
                            <td><button type="button" onclick="save('{{$user->id}}')" class="btn btn-success pull-left">Assign</button></td>
                          </tr>         
                           @endforeach
                       </tbody>
                      
                </table>
               
            </div>
  
 {{$users->links()}}

                  </div>
              </div>
          </div>
    </div>
</div>

<script>
    function save(arg){
        document.getElementById('username').value = document.getElementById('user'+arg).value;
        document.getElementById('dateassigned').value = document.getElementById('date'+arg).value;
        document.getElementById('assign').submit();
    }
</script>
@endsection



