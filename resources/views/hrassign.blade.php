<div class="panel panel-default" style="border-color:green">
<div class="panel-heading" style="background-color:green;font-weight:bold;font-size:1.3em;color:white">Employees On {{ $dept }}</div>
<div class="panel-body" style="height:500px;max-height:500px;overflow-x:hidden; overflow-y:scroll;">
<table class="table table-hover">
<thead>
    <th>Emp Id</th>
    <th>Name</th>
    <th>Designation</th>
    <th>Assign Assets</th>
   
</thead>
<tbody>
@foreach($users as $user)
    <tr>
        <td>{{ $user->employeeId}}</td>
        <td>{{ $user->name}}</td>
        <td>{{ $user->group->group_name }}</td>
        <td>
            <a class="btn btn-primary" href="{{ URL::to('/') }}/assignEmployee?UserId={{ $user->employeeId }}" >Assign</a>
        </td>
       
    </tr>
@endforeach
</tbody>
</table>
</div>
</div>