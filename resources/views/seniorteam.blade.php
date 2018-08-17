@extends('layouts.app')
@section('content')

<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading text-center" >
            <b>
              @if(  $name == "Team Lead")
            Senior {{ $name}}</b></div>
            @else
            {{ $name}}</b></div>
            @endif
            @if(SESSION('success'))
                <div class="text-center alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <h4 style="font-size:1em">{{SESSION('success')}}</h4>
                </div>
                @endif
            <div class ="panel-body">

                       
                       <table class="table table-hover">
                           <thead>
                               <th>Login Date</th>
                               <th>Name</th>
                               <th>Login Time</th>
                               <th>Logout Time</th>
                               <th>Late Login Remark</th>
                           </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>

                                    <td>{{ $user->logindate != null ? date('d-m-Y',strTotime($user->logindate)) : " "}}</td>
                                    <td>{{ $user->name}}</td>
                                    <td>{{ $user->logintime}}</td>
                                    <td>{{  date('h:i' ,strTotime($user->logout)) }}</td>
                                    <td>{{ $user->remark}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                       </table>
            </div>
        </div>
    </div>
</div>
@endsection
