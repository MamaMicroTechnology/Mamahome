@extends('layouts.app')
@section('content')

<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading text-center" ><b>Late Logins</b></div>
            @if(SESSION('success'))
                <div class="text-center alert alert-success">
                <h4 style="font-size:1em">{{SESSION('success')}}</h4>
                </div>
                @endif
            <div class ="panel-body">

                       
                       <table class="table table-hover">
                           <thead>
                               <th>name</th>
                               <th>Login Time</th>
                               <th>Late Login Remark</th>
                               <th>Action</th>
                           </thead>
                            <tbody>
                            @foreach($users as $user)
                                   <tr>
                                    <td>{{ $user->name}}</td>
                                    <td>{{ $user->logintime}}</td>
                                    <td>{{ $user->remark}}</td>
                                    <td>
                                    
                                        <div class="btn-group">
                                            <form action="{{ URL::to('/') }}/approve" method="post">
                                                 {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{ $user->user_id }}">
                                            <button type="submit" class="btn btn-success btn-sm" style="width:90%;">
                                                Approve
                                            </button>
                                            </form>
                                            <form action="{{ URL::to('/') }}/reject" method="post">
                                                 {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{ $user->user_id }}">
                                            <button href="{{ URL::to('/') }}/reject" type="button" class="btn btn-danger btn-sm" style="width:90%;margin-top:-82%;margin-left:90%;   ">
                                                Reject
                                            </button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>    
                            @endforeach
                            </tbody>
                       </table>
               
            </div>
        </div>
    </div>
</div>
@endsection