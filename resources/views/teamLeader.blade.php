@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Listing Engineers
                    @if(session('Error'))
                        <div class="alert-danger pull-right">{{ session('Error')}}</div>
                    @endif
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <th>Employee Id</th>
                            <th>Name</th>
                            <th>Wards Assigned</th>
                            <th>Images</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <div class="hidden">{{ $true = 0 }}</div>
                            <tr>
                                <td>{{ $user->employeeId }}</td>
                                <td>{{ $user->name }}</td>
                                <td>
                                    @foreach($subwardsAssignment as $subward)
                                    @if($user->id == $subward->user_id)
                                        {{ $subward->subward->sub_ward_name}}
                                        <div class="hidden">{{ $true = 1 }}</div>
                                    @endif
                                    @endforeach
                                    @if($true == 0)
                                    <a href="#" data-toggle="modal" data-target="#assignWards{{ $user->id }}">Assign Wards</a>
                                    @endif
                                </td>
                                <td>
                                    @foreach($subwardsAssignment as $subward)
                                    @if($user->id == $subward->user_id)
                                    <a href="{{ URL::to('/') }}/public/subWardImages/{{ $subward->subward->sub_ward_image }}">Click here to view image</a>
                                    @endif
                                    @endforeach
                                </td>
                                <td><a href="{{ URL::to('/') }}/viewReport?UserId={{ $user->id }}" class="btn btn-primary btn-xs">View</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Main Wards</div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <th>Ward Name</th>
                            <th>Ward Image</th>
                        </thead>
                        <tbody>
                            @foreach($wards as $ward)
                            <tr>
                                <td>{{ $ward->ward_name }}</td>
                                <td><a href="{{ URL::to('/')}}/public/wardImages/{{ $ward->ward_image }}">Image</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($users as $user)
<!-- Modal -->
<form method="POST" action="{{ URL::to('/') }}/{{ $user->id }}/assignWards">
{{ csrf_field() }}    
    <div id="assignWards{{ $user->id }}" class="modal fade" role="dialog">
      <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Assign Wards</h4>
          </div>
          <div class="modal-body">
            Choose Wards:<br>
            <select name="subward" class="form-control">
                <option value="">--Select--</option>
                @foreach($subwards as $subward)
                <option value="{{ $subward->id }}">{{ $subward->sub_ward_name }}</option>
                @endforeach
            </select>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success pull-left">Assign</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
</form>
@endforeach
@endsection
