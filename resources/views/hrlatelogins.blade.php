
@extends('layouts.app')
@section('content')
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading text-center" ><b>Late Logins</b></div>
            <div class ="panel-body">
              <form method="GET" action="{{ URL::to('/') }}/loginhistory">
                <div class="col-md-12">
                    {{ csrf_field() }}
                            <div class="col-md-2">
                                <label>From Date</label>
                                <input required value = "{{ isset($_GET['from']) ? $_GET['from']: '' }}" type="date" class="form-control" name="from">
                            </div>
                            <div class="col-md-2">
                                <label>To   Date</label>
                                <input required value = "{{ isset($_GET['to']) ? $_GET['to']: '' }}" type="date" class="form-control" name="to">
                            </div>
                           
                        <div class="col-md-2">
                            <label></label>
                            <input type="submit" value="Fetch" class="form-control btn btn-primary">
                        </div>
                    </div> 
                </form>     
                       <table class="table table-hover">
                           <thead>
                               <th>Date</th> 
                               <th>Name</th>
                               <th>Login Time</th>
                               <th>Logout Time</th>
                               <th>Late Login Remark</th>
                               <th>Early Logout remark</th>
                               <th>Admin Approval</th>
                               <th>Action</th>
                           </thead>
                            <tbody>
                          
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ date('d-m-Y',strTotime($user->logindate)) }}</td>
                                    <td style="width:10%">{{ $user->name}}</td>
                                    <td>{{ $user->logintime}}</td>
                                    <td>{{ $user->logout != null ? $user->logout  : " "}}</td>
                                    <td style="width:20%">{{ $user->remark}}</td>
                                    <td style="width:10%">{{ $user->logout_remark}}</td>
                                    <td>{{ $user->adminapproval}}</td>
                                        @if( $user->hrapproval == "Pending" )
                                        <td>
                                        <div class="btn-group">
                                            <form action="{{ URL::to('/') }}/hrapprove" method="post">
                                                 {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{ $user->user_id }}">
                                             <input type="hidden" name="logindate" value="{{ $user->logindate }}">
                                            <button type="submit" class="btn btn-success btn-sm" style="width:90%;">
                                                Approve
                                            </button>
                                            </form>
                                            <form action="{{ URL::to('/') }}/hrreject" method="post">
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
                                        <td style="padding-right :60px;">{{ $user->hrapproval}}</td>
                                        @endif

                                </tr>
                            @endforeach
                            </tbody>
                       </table>
            </div>
        </div>
    </div>
@if(session('Success'))
<script>
    swal("success","{{ session('Success') }}","success");
</script>
@endif
@if(session('error'))
<script>
    swal("error","{{ session('error') }}","error");
</script>
@endif
@endsection
