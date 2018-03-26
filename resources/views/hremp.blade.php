<div class="panel panel-default">
<div class="panel-heading">Employees on {{ $dept }}</div>
<div class="panel-body" style="height:500px;max-height:500px;overflow-x:hidden; overflow-y:scroll;">
<table class="table table-hover">
<thead>
    <th>Emp Id</th>
    <th>Name</th>
    <th>Dept.</th>
    <th>Office Phone</th>
    <th>Acceptance</th>
    <th>Designation</th>
</thead>
<tbody>
@foreach($users as $user)
    <tr>
        <td>{{ $user->employeeId}}</td>
        <td><a href="{{ URL::to('/') }}/viewEmployee?UserId={{ $user->employeeId }}">{{ $user->name}}</a></td>
        <td>
            @if($user->department != NULL)
                {{ $user->department->dept_name }}
            @endif
        </td>
        <td>
            @if($user->confirmation == 0)
             User has not accepted the company policy.
             @elseif($user->confirmation == 1)
             User has accepted company policy<br>but waiting for admin's approval.
             @else
             User has accepted company policy<br>and has been approved by admin.
             @endif
        </td>
        <td>{{ $user->group->group_name }}</td>
        <td>{{ $user->office_phone }}</td>
        @if($page == "anr")
        <td>
        @if($user->department_id != 10)
            @if($user->department->dept_name == "Operation" && $user->group->group_name == "Listing Engineer")
            <a href="{{ URL::to('/') }}/{{ $user->id }}/date">
                Report
            </a>
            @else
            <a href="{{ URL::to('/') }}/{{ $user->employeeId }}/attendance">
                Attendance
            </a>
            @endif
        @else
            @if($user->group->group_name == "Listing Engineer")
            <a href="{{ URL::to('/') }}/{{ $user->id }}/date">
                Report
            </a>
            @else
            <a href="{{ URL::to('/') }}/{{ $user->employeeId }}/attendance">
                Attendance
            </a>
            @endif
        @endif
        </td>
        @endif
        @if($page == "hr" && $user->department != NULL)
        <td>
            <div class="btn-group">
                <a href="{{ URL::to('/') }}/viewEmployee?UserId={{ $user->employeeId }}" class="btn btn-sm btn-primary">View</a>
                <a href="{{ URL::to('/') }}/editEmployee?UserId={{ $user->employeeId }}" class="btn btn-sm btn-success">Edit</a>
            </div>
        </td>
        @endif
    </tr>
@endforeach
</tbody>
</table>
</div>
</div>