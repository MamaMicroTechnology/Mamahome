<style>
    .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<div class="panel panel-default" style="border-color:green">
<div class="panel-heading" style="background-color:green;font-weight:bold;font-size:1.3em;color:white">Employees on {{ $dept }}</div>
<div class="panel-body" style="height:500px;max-height:500px;overflow-x:hidden; overflow-y:scroll;">
<table class="table table-hover">
<thead>
    <th>Emp Id</th>
    <th>Name</th>
    <th>Dept.</th>
    <th>Designation</th>
    <th>Contact</th>
    <th>Attendance/Reports</th>
    <th>Emp. Details</th>
    <th>Verification</th>
    <th></th>
</thead>
<tbody>
@foreach($users as $user)
    <tr>
        <td>{{ $user->employeeId}}</td>
        <td>{{ $user->name}}</td>
        <td>{{ $user->department->dept_name }}</td>
        <td>{{ $user->group->group_name }}</td>
        <td>{{ $user->office_phone }}</td>
        <td>
            @if($user->id == 85)
            <a href="{{ URL::to('/') }}/amattendance?userId={{ $user->employeeId }}">
                Attendance
            </a>
            @elseif($user->department->dept_name == "Operation" && $user->group->group_name == "Listing Engineer")
            <a href="{{ URL::to('/') }}/amdate?uid={{ $user->id }}">
                Report
            </a>
            @else
            <a href="{{ URL::to('/') }}/amattendance?userId={{ $user->employeeId }}">
                Attendance
            </a>
            @endif
        </td>
        <td><a href="{{ URL::to('/') }}/ameditEmployee?UserId={{ $user->employeeId }}">Edit</a> &nbsp;|&nbsp;<a href="{{ URL::to('/') }}/amviewEmployee?UserId={{ $user->employeeId }}">View</a></td>
        <td>
            <label class="switch">
                <input {{ $user->verification_status != NULL? $user->verification_status == "Verified"?'checked': '' : 'disabled' }}  id="{{ $user->employeeId }}" type="checkbox" onchange="updateUser('{{ $user->employeeId }}')">
                <span class="slider round"></span>
            </label>
        </td>
        <td>
            <form method="post" action="{{ URL::to('/') }}/inactiveEmployee">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $user->employeeId }}">
                <input type="submit" value="Mark Inactive" class="btn btn-sm btn-danger">
            </form>
    </tr>
@endforeach
</tbody>
</table>
</div>
</div>

<script>
    function updateUser(arg)
    {
        var userId = arg;
        $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/updateUser",
            async:false,
            data:{userId : userId},
            success: function(response)
            {
                alert(response);
            }
        });    
    }
</script>