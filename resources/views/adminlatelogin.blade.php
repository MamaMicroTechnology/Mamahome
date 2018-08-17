@extends('layouts.app')
@section('content')

    <div class="col-md-12">
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
                               <th>Date</th> 
                               <th>name</th>
                               <th>Login</th>
                               <th>Logout</th>
                               <th>Late Login Remark</th>
                               <th>Status</th>
                               <th>Action</th>
                           </thead>
                            <tbody>
                          
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ date('d-m-Y',strTotime($user->logindate)) }}</td>
                                    <td>{{ $user->name}}</td>
                                    <td>{{ $user->logintime}}</td>
                                    <td>{{$user->logout != null ? date('h:i' ,strTotime($user->logout)) : " "}}</td>
                                    <td>{{ $user->remark}}</td>
                                    <td>{{ $user->tlapproval}}</td>
                                        @if( $user->adminapproval == "Pending" )
                                        <td>
                                        <div class="btn-group">
                                            <form action="{{ URL::to('/') }}/adminapprove" method="post">
                                                 {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{ $user->user_id }}">
                                             <input type="hidden" name="logindate" value="{{ $user->logindate }}">
                                            <button type="submit" class="btn btn-success btn-sm" style="width:90%;">
                                                Approve
                                            </button>
                                            </form>
                                            <form action="{{ URL::to('/') }}/adminreject" method="post">
                                                 {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{ $user->user_id }}">
                                            <input type="hidden" name="logindate" value="{{ $user->logindate }}">
                                            <button type="submit" class="btn btn-danger btn-sm" style="width:90%;margin-top:-81%;margin-left:90%;">
                                                Reject
                                            </button>
                                        </form>
                                        </div>
                                        </td>
                                        @else
                                        <td style="padding-right :60px;">{{ $user->adminapproval}}</td>
                                        @endif
                                </tr>
                            @endforeach
                            </tbody>
                       </table>
            </div>
        </div>
    </div>
@endsection
