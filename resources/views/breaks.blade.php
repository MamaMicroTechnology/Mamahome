@extends('layouts.app')
@section('content')

<div class="container">
    <div class="col-md-9 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading text-center" ><b>BreakTime</b>
            <button type="button" onclick="history.back(-1)" class="bk-btn-triangle pull-right" style="margin-top:-10px;" > <i class="fa fa-arrow-circle-left" style="padding:5px;width:50px;color: black;"></i></button>
            </div>
            <div class ="panel-body">
                       <table class="table table-hover">
                           <thead>
                               <th>Name</th>
                               <th>Date</th>
                               <th>Start Time</th>
                               <th>Stop Time</th>
                               <th>Time Taken</th>
                           </thead>
                            <tbody>
                            @foreach($breaks as $break)
                                   <tr>
                                    <td>{{ $break->name}}</td>
                                    <td>{{ date('d-m-Y',strtotime($break->date))}}</td>
                                    <td>{{ $break->start_time}}</td>
                                    <td>{{ $break->stop_time}}</td>

                                    <td>
                                        @if($break->stop_time != null)
                                        <?php
                                            $A = strtotime($break->start_time);
                                            $B = strtotime($break->stop_time);
                                            $diff = $B - $A;
                                             
                                         ?>
                                         @if(($diff / 60) > 60)
                                             {{ gmdate("H", $diff) }} Hours, {{ gmdate("i", $diff) }} Minutes
                                         @else
                                            {{ $diff / 60 }} minutes</td>
                                         @endif
                                         @endif
                            @endforeach
                            </tbody>
                       </table>
            </div>
        </div>
    </div>
</div>

@if(session('Success'))
<script>
    swal("success","{{ session('Success') }}","success");
</script>
@endif
@if(session('Success'))
<script>
    swal("error","{{ session('error') }}","error");
</script>
@endif
@endsection
