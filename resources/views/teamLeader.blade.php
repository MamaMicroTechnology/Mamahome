@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading" style="color:white">Listing Engineers
                    @if(session('Error'))
                        <div class="alert-danger pull-right">{{ session('Error')}}</div>
                    @endif
                </div>
                <div class="panel-body">
                    <table class="table table-responsive table-striped">
                        <thead>
                            <th style="text-align: center;">Employee Id</th>
                            <th style="text-align: center;">Name</th>
                            <th style="text-align: center;">Ward Assigned</th>
                            <th style="text-align: center;">Previous Assigned Ward</th>  
                            <th style="text-align: center;">Images</th>
                            <th style="text-align: center;">Action</th>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td  style="text-align: center;">{{$user->employeeId}}</td>
                               
                                <td  style="text-align: center;">{{$user->name}}</td>
                                <!-- Assign Ward Button -->
                                @if($user->status == 'Completed')
                                    <td style="text-align:center;">
                                        <a data-toggle="modal" data-target="#assignWards{{ $user->id }}" class="btn btn-sm btn-primary">
                                            <b>Assign Slots</b>
                                        </a>
                                    </td>
                                @else
                                    <td style="text-align:center">{{$user->sub_ward_name}}</td>
                                @endif
                                <td style="text-align: center;">
                                    @foreach($subwards as $subward)
                                        @if($subward->id == $user->prev_subward_id)
                                            {{$subward->sub_ward_name}}
                                        @endif
                                    @endforeach
                                </td>
                                <td style="text-align:center">
                                    <a href="{{ URL::to('/')}}/subwardImages/{{$user->sub_ward_image}}" target="_blank">Click Here To View Image
                                    </a>
                                </td>            
                                <!--Completed Button -->
                                @if($user->status == 'Completed')
                                    <td style="text-align:center;"></td>
                                @else
                                    <td style="text-align:center">
                                        <div class="btn-group">
                                            <a href="{{URL::to('/')}}/completedAssignment?id={{$user->id}}" class="btn btn-sm btn-success"><b>Completed</b></a>
                                            <a href="{{URL::to('/')}}/viewReport?UserId={{$user->id}}" class="btn btn-sm btn-primary"><b>Report</b></a>
                                        </div>
                                    </td>
                                @endif 
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default" style="border-color: green">
                <div class="panel-heading" style="color:white;background-color: green">Main Wards</div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <th style="text-align: center;">Ward Name</th>
                            <th style="text-align: center;">Ward Image</th>
                        </thead>
                        <tbody>
                            @foreach($wards as $ward)
                            <tr>
                                <td style="text-align: center;">{{ $ward->ward_name }}</td>
                                <td style="text-align: center;"><a href="{{ URL::to('/')}}/public/wardImages/{{ $ward->ward_image }}">Image</a></td>
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
