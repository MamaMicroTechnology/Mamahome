<?php
  $user = Auth::user()->group_id;
  if(Auth::user()->group_id != 11){
  $ext = ($user == 6? "layouts.leheader":"layouts.app");
    }
    else{
         $ext = "layouts.leheader";
    }
?>
@extends($ext)
@section('content')

<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading" style="background-color: green;color:white;">KRA List
        <a href="javascript:history.back()" class="btn btn-sm btn-danger pull-right">Back</a>
        </div>
        <div class="panel-body">
            <table class="table table-hover" border=1>
                <thead>
                    <th>Department Name</th>
                    <th>Designation</th>
                    <th>Role</th>
                    <th>Goal</th>
                    <th>Key Result Area</th>
                    <th>Key Performance Area</th>
                </thead>
                <tbody>
                    @foreach($kras as $kra)
                    <tr>
                        <td>{{ $kra->dept_name }}</td>
                        <td>{{ $kra->group_name }}</td>
                        <td>{{ $kra->role }}</td>
                        <td>{{ $kra->goal }}</td>
                        <td>{{ $kra->key_result_area }}</td>
                        <td>{{ $kra->key_performance_area }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection