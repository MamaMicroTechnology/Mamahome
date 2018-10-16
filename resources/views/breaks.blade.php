@extends('layouts.app')
@section('content')

<div class="container">
    <div class="col-md-9 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading text-center" ><b>BreakTime</b>
            <button type="button" onclick="history.back(-1)" class="bk-btn-triangle pull-right" style="margin-top:-10px;" > <i class="fa fa-arrow-circle-left" style="padding:5px;width:50px;color: black;"></i></button>
            </div>
            <div class ="panel-body">
              @if(Auth::user()->group_id != 2)
              <form method="GET" action="{{ URL::to('/') }}/breakhistory">
                {{ csrf_field() }}
                <div class="col-md-12">
                            <div class="col-md-3">
                                <label>From Date</label>
                                <input required value = "{{ isset($_GET['from']) ? $_GET['from']: '' }}" type="date" class="form-control" name="from">
                            </div>
                            <div class="col-md-3">
                                <label>To   Date</label>
                                <input required value = "{{ isset($_GET['to']) ? $_GET['to']: '' }}" type="date" class="form-control" name="to">
                            </div>
                           
                        <div class="col-md-3">
                            <label></label>
                            <input type="submit" value="Fetch" class="form-control btn btn-primary">
                        </div>
                    </div> 
                </form>
                @endif
                       <table class="table table-hover">
                           <thead>
                               <th>Date</th>
                               <th>Name</th>
                               <th>Start Time</th>
                               <th>Stop Time</th>
                               <th>Time Taken</th>
                           </thead>
                            <tbody>
                            @foreach($breaks as $break)
                                   <tr>
                                    <td>{{ date('d-m-Y',strtotime($break->date))}}</td>
                                    <td>{{ $break->name}}</td>
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
