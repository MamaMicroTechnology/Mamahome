@extends('layouts.amheader')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default" style="border-color:#f4811f">
                <div class="panel-heading text-center" style="background-color:#f4811f"><b style="color:white;font-size:1.3em">Listing Engineers</b>
                    @if(session('Error'))
                        <div class="alert-danger pull-right">{{ session('Error')}}</div>
                    @endif
                <a href="{{url()->previous()}}" class="btn btn-sm btn-danger pull-right">Back</a>    
                </div>
                <div class="panel-body">
                  
                    <table class="table table-responsive table-striped table-hover">
                        <thead>
                            <th style="width:15%">Employee Id</th>
                            <th style="width:20%;">Name</th>
                            <th style="width:22.5%;text-align:center">Dates Assigned</th>
                            <th style="width:27.5%;text-align:center;">Previously Assigned Date</th>
                            <th style="text-align:center">Action</th>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->employeeId }}</td>
                                <td style="text-align:left">{{ $user->name }}</td>
                                <td style="text-align: center">
                                    @if($user->status == 'Not Completed')
                                      {{date("d / m / Y", strtotime($user->assigned_date))}}
                                    @else
                                      <a data-toggle="modal" data-target="#assignWards{{ $user->id }}" class="btn btn-sm btn-primary">Assign Slots</a>
                                    @endif
                                </td>
                                <td style="text-align:center">
                                  @if($user->status == 'Not Completed')
                                    {{date("d / m / Y", strtotime($user->updated_at))}}
                                  @else
                                    {{date("d / m / Y", strtotime($user->assigned_date))}}
                                  @endif
                                </td><!-- Previous date -->
                                
                                <td style="text-align:center"> 
                                  @if($user->status == 'Not Completed')
                                    <a href="{{URL::to('/')}}/completethis?userid={{$user->id}}" class="btn btn-sm btn-success">Completed</a>
                                  @else
                                    Completed
                                  @endif
                                </td>
                            
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class='b'></div>
<div class='bb'></div>
<div class='message'>
  <div class='check'>
    &#10004;
  </div>
  <p>
    Success
  </p>
  <p>
    @if(session('Success'))
    {{ session('Success') }}
    @endif
  </p>
  <button id='ok'>
    OK
  </button>
</div>

@foreach($users as $user)
<!-- Modal -->
<form method="POST" action="{{ URL::to('/') }}/{{ $user->id }}/assignthisSlot">
{{ csrf_field() }}    
    <div id="assignWards{{ $user->id }}" class="modal fade" role="dialog">
      <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="background-color:#f4811f">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><b style="color:white;font-size:1.3em">Assign Daily Slots</b></h4>
          </div>
          <div class="modal-body">
            Choose Dates:<br>
            <input type="date" name="date" class="form-control">
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
