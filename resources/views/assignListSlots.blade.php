@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
            <div class="panel-heading" style="color:white;font-size: 15px;"> 
                 @if(Auth::user()->group_id != 22)
                Total Listing Engineers : {{ $totalcount }}
                @else
                Listing Engineers
                @endif
                    @if(session('Error'))
                        <div class="alert-danger pull-right">{{ session('Error')}}</div>
                    @endif
                    <button type="button" onclick="history.back(-1)" class="bk-btn-triangle pull-right" style="margin-top:-10px;" > <i class="fa fa-arrow-circle-left" style="padding:5px;width:50px;color:black;"></i></button>     

                </div>
                <div class="panel-body">
                  
                        <div class="col-md-12">
                            <div class="col-md-8">
                            </div>
                            <div class="col-md-1">
                                 <label>Search :</label>
                            </div>
                            <div class="col-md-3">
                                 <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Names and Phone Number Search" >
                            </div>
                        </div>
                            <br><br><br>
                    <table id="myTable" class="table table-responsive table-striped">
                        <thead>
                            <th style="text-align: center;">Employee Id</th>
                            <th style="text-align: center;">Name</th>
                            <th style="text-align: center;">Ward Assigned</th>
                            <th style="text-align: center;">Previous Assigned Ward</th>  
                            <th style="text-align: center;">Ward Images</th>
                            <th style="text-align: center;">Contact No.</th>
                            <th style="text-align: center;">Action</th>
                        </thead>
                        <tbody >
                        @if(Auth::user()->group_id != 22)
                            @foreach($users as $user)
                            <tr>
                                <td  style="text-align: center;">{{$user->employeeId}}</td>
                               
                                <td  style="text-align: center;">{{$user->name}}</td>
                                <!-- Assign Ward Button -->
                                @if($user->status == 'Completed' || $user->status == null)
                                    <td style="text-align:center;">
                                        <a data-toggle="modal" data-target="#assignWards{{ $user->id }}" class="btn btn-sm btn-primary">
                                            <b>Assign Wards</b>
                                        </a>
                                    </td>
                                @else
                                    <td style="text-align:center">
                                    <a href="{{ URL::to('/')}}/viewwardmap?UserId={{$user->id}} && wardname={{ $user->sub_ward_name }}" data-toggle="tooltip" data-placement="top" title="click here to view map" class="red-tooltip" target="_blank">{{$user->sub_ward_name}}
                                    </a>
                                    </td>  
                                @endif
                                <td style="text-align: center;">
                                    @foreach($subwards as $subward)
                                        @if($subward->id == $user->prev_subward_id)
                                            <a href="{{ URL::to('/')}}/viewwardmap?UserId={{$user->id}} && wardname={{$subward->sub_ward_name}}" data-toggle="tooltip" data-placement="top" title="click here to view map" class="red-tooltip" target="_blank">{{$subward->sub_ward_name}}
                                    </a>
                                        @endif
                                    @endforeach
                                </td>
                                <td style="text-align:center">
                                    <a href="{{ URL::to('/')}}/public/subWardImages/{{$user->sub_ward_image}}" target="_blank">View Image
                                    </a>
                                </td>
                                <!-- <td style="text-align:center">
                                    <a href="{{ URL::to('/')}}/viewwardmap?UserId={{$user->id}} && wardname={{ $user->sub_ward_name }}" target="_blank">View map
                                    </a>                                   
                                </td> -->
                                <td style="text-align:center">
                                    {{ $user->office_phone }}
                                </td>            
                                <!--Completed Button -->
                                @if($user->status == 'Completed')
                                @if(Auth::user()->group_id != 17)
                                    <td style="text-align:center;">
                
                                        <a href="{{URL::to('/')}}/viewReport?UserId={{$user->id}}" class="btn btn-sm btn-primary form-control"><b>Report</b></a>
                                    </td>
                                @else
                                <td style="text-align:center;">Assign Wards</td>
                                @endif
                                @else
                                @if(Auth::user()->group_id != 17)
                                    <td style="text-align:center">
                                        <div class="btn-group">
                                            @if($user->status == null)
                                            @else
                                            <a  class="btn btn-sm btn-success" id="sale" onclick="Subs('{{ $user->id }}')"><b>Completed</b></a>

                                            @endif

                                            <a href="{{URL::to('/')}}/viewReport?UserId={{$user->id}}" class="btn btn-sm btn-primary"><b>Report</b></a>
                                        </div>
                                    </td>
                                @else
                                <td style="text-align:center;">Ward Assigned</td>
                                @endif
                                @endif 
                            </tr>
                            @endforeach
                            @else
                             @foreach($tlUsers as $user)
                            <tr>
                                <td  style="text-align: center;">{{$user->employeeId}}</td>
                               
                                <td  style="text-align: center;">{{$user->name}}</td>
                                <!-- Assign Ward Button -->
                                @if($user->status == 'Completed' || $user->status == null)
                                    <td style="text-align:center;">
                                        <a data-toggle="modal" data-target="#assignWards{{ $user->id }}" class="btn btn-sm btn-primary">
                                            <b>Assign Wards</b>
                                        </a>
                                    </td>
                                @else
                                    <td style="text-align:center">
                                    <a href="{{ URL::to('/')}}/viewwardmap?UserId={{$user->id}} && wardname={{ $user->sub_ward_name }}" target="_blank">{{$user->sub_ward_name}}
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
                                <!-- <td style="text-align:center">
                                    <a href="{{ URL::to('/')}}/viewwardmap?UserId={{$user->id}} && wardname={{ $user->sub_ward_name }}" target="_blank">View map
                                    </a>                                   
                                </td> -->
                                <td style="text-align:center">
                                    {{ $user->office_phone }}
                                </td>            
                                <!--Completed Button -->
                                @if($user->status == 'Completed')
                                @if(Auth::user()->group_id != 17)
                                    <td style="text-align:center;">
                
                                        <a href="{{URL::to('/')}}/viewReport?UserId={{$user->id}}" class="btn btn-sm btn-primary form-control"><b>Report</b></a>
                                    </td>
                                @else
                                <td style="text-align:center;">Assign Wards</td>
                                @endif
                                @else
                                @if(Auth::user()->group_id != 17)
                                    <td style="text-align:center">
                                        <div class="btn-group">
                                            @if($user->status == null)
                                            @else
                                            <a  class="btn btn-sm btn-success" id="sale" onclick="Subs('{{ $user->id }}')"><b>Completed</b></a>
                                            @endif
                                            <a href="{{URL::to('/')}}/viewReport?UserId={{$user->id}}" class="btn btn-sm btn-primary"><b>Report</b></a>
                                        </div>
                                    </td>
                                @else
                                <td style="text-align:center;">Ward Assigned</td>
                                @endif
                                @endif 
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@foreach($users as $user)
<!-- Modal -->
@if(Auth::user()->group_id != 17)
<form method="POST" action="{{ URL::to('/') }}/{{ $user->id }}/assignWards">
{{ csrf_field() }}
@else
<form method="POST" action="{{ URL::to('/') }}/{{ $user->id }}/converterassignWards">
{{ csrf_field() }}
@endif    
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
                <select name="subward" class="form-control" id="subward{{ $user->id }}">
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
<script>
function Subs(arg)
    {
        var e = arg;
      
        $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/sales",
            async:false,
            data:{userId: e },
            success: function(response)
            {
                console.log(response);
                  if(response != 0){
                    window.location = "{{ URL::to('/') }}/completedAssignment?id="+arg;
                  }else{
                    alert('Not Completed. '+ response.balance +' projects remaining.');
                  }
                
            }
        });
    }
    function myFunction()
     {
          var input, filter, table, tr, td, i;
          input = document.getElementById("myInput");
          filter = input.value.toUpperCase();
          table = document.getElementById("myTable");
          tr = table.getElementsByTagName("tr");
          for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                td1 = tr[i].getElementsByTagName("td")[5];
                if (td) {
                  if (td.innerHTML.toUpperCase().indexOf(filter) > -1 || td1.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                  } else {
                    tr[i].style.display = "none";
                  }
                }
      }
}
    </script>
    <script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
     background-color: #00acd6 

});
</script>
@endsection
