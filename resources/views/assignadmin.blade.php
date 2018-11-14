@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading" style="color:white">Listing Engineers
                    @if(session('Error'))
                        <div class="alert-danger pull-right">{{ session('Error')}}</div>
                    @endif
                </div>
                <div class="panel-body" style=" height:500px;max-height:500px;overflow-y:scroll; overflow-x: hidden;">
                    <table class="table table-responsive table-striped">
                        <thead>
                            <th style="text-align: center;">Employee Id</th>
                            <th style="text-align: center;">Name</th>
                            <th style="text-align: center;">Ward Assigned</th>
                            <th style="text-align: center;">Previous Assigned Ward</th>  
                            <th style="text-align: center;">Ward Images</th>
                            <th style="text-align: center;">Contact No.</th>
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
                                            <b>Assign Wards</b>
                                        </a>
                                    </td>
                                @elseif($user->status == 'Not Completed')
                                    <td style="text-align:center">{{$user->sub_ward_name}}</td>
                                @else
                                    <td style="text-align:center;">
                                        <a data-toggle="modal" data-target="#assignWards{{ $user->id }}" class="btn btn-sm btn-primary">
                                            <b>Assign Wards</b>
                                        </a>
                                    </td>
                                @endif
                                <td style="text-align: center;">
                                    @foreach($subwards as $subward)
                                        @if($subward->id == $user->prev_subward_id)
                                            {{$subward->sub_ward_name}}
                                        @endif
                                    @endforeach
                                </td>
                                <td style="text-align:center">
                                    <a href="{{ URL::to('/')}}/public/subWardImages/{{$user->sub_ward_image}}" target="_blank">View Image
                                    </a>
                                </td>
                                <td style="text-align:center">
                                    {{ $user->office_phone }}
                                </td>            
                                <!--Completed Button -->
                                @if( $user->status == 'Completed')
                                    <td style="text-align:center;">
                                        <a href="{{URL::to('/')}}/viewReport?UserId={{$user->id}}" class="btn btn-sm btn-primary form-control"><b>Report</b></a>
                                    </td>
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
            <label>Choose Ward :</label><br>
                <select name="ward" class="form-control" id="ward{{ $user->id }}" onchange="loadsubwards('{{ $user->id }}')">
                    <option value="">--Select--</option>
                    @foreach($wards as $ward)
                    <option value="{{ $ward->id }}">{{ $ward->ward_name }}</option>
                    @endforeach
                </select>
                <br>
                
                <label>Choose Subward :</label><br>
                <select name="subward" class="form-control" id="subward{{ $user->id }}" required>
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


<script type="text/javascript">
    function loadsubwards(arg)
    {
        var x = document.getElementById('ward'+arg);
        var sel = x.options[x.selectedIndex].value;
        if(sel)
        {
            $.ajax({
                type: "GET",
                url: "{{URL::to('/')}}/loadsubwards",
                data: { ward_id: sel },
                async: false,
                success: function(response)
                {
                    if(response == 'No Sub Wards Found !!!')
                    {
                        document.getElementById('error'+arg).innerHTML = '<h4>No Sub Wards Found !!!</h4>';
                        document.getElementById('error'+arg).style,display = 'initial';
                    }
                    else
                    {
                        var html = "<option value='' disabled selected>---Select---</option>";
                        for(var i=0; i< response.length; i++)
                        {
                            html += "<option value='"+response[i].id+"'>"+response[i].sub_ward_name+"</option>";
                        }
                        document.getElementById('subward'+arg).innerHTML = html;
                    }
                    
                }
            });
        }
    }
</script>
@endsection
