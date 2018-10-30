@extends('layouts.app')
@section('content')

<div class="container">
    <div class="col-md-9 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading text-center" ><b>Late Logins</b></div>
            <div class ="panel-body">
                       <table class="table table-hover">
                           <thead>
                               <th>Name</th>
                               <th>Login Time</th>
                               <th>Logout Time</th>
                               <th>Late Login Remark</th>
                               <th>Action</th>
                           </thead>
                            <tbody>
                            @foreach($users as $user)
                                   <tr>
                                    <td>{{ $user->name}}</td>
           
                                    <td>{{ $user->logintime}}</td>
                                    <td>{{ $user->logout != null ? $user->logout : " " }}</td>
                                    <td>{{ $user->remark}}</td>
                                    
                                        @if( $user->tlapproval == "Pending" )
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
                                            <button type="submit" class="btn btn-danger btn-sm" style="width:90%;margin-top:-81%;margin-left:90%;">
                                                Reject
                                            </button>
                                        </form>
                                        </div>
                                        </td>
                                        @else
                                        <td style="padding-right :60px;">{{ $user->tlapproval}}</td>
                                        @endif
                                </tr>
                            @endforeach
                            </tbody>
                       </table>
            </div>
        </div>
    </div>
</div>

@if(session('Success'))
<script>
    swal("success","{{ session('Success') }}","success");
</script>
@endif
@if(session('Success'))
<script>
    swal("error","{{ session('error') }}","error");
</script>
@endif
@endsection
