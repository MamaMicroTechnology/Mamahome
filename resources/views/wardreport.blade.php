
@extends('layouts.app')
@section('content')
<br>
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-success">
    <div class="panel-heading">

        <?php 

                      $s = [];
                     foreach ($projectscount as $view ) {
                             $m = count($view['projectcount']);
                              array_push($s,$m);
                     }
                   
                   $f = array_sum($s);

                   ?>
       Total No Of Subward Assigned  :&nbsp;<?php print_r($f) ?>
    </div>
    <div class="panel-body">
        <div class="col-md-10">
            <form method="GET" action="{{ URL::to('/') }}/wardreport">
             <div class="col-md-4">
            <label>Select Ward</lable>
                <select required class="form-control" name="ward">
                    <option value="">--Select--</option>
                @foreach($wards as $ward)
                    <option value="{{ $ward->id}}">{{ $ward->ward_name }}</option>
                @endforeach
                </select>
              </div>
              <div class="col-md-3">
                                <label>From </label>
                                <input value = "{{ isset($_GET['from']) ? $_GET['from']: '' }}" type="date" class="form-control" name="from">
                            </div>
                            <div class="col-md-3">
                                <label>To </label>
                                <input  value = "{{ isset($_GET['to']) ? $_GET['to']: '' }}" type="date" class="form-control" name="to">
                            </div><br><br><br>
            <br>
                <button class="btn btn-primary form-control" type="submit">Fetch</button>
            </form><br><br>
            @if(session('Error'))
                <p class="alert alert-error">{{ session('Error') }}</p>
            @endif
            <table class="table table-hover" border="1">
                <thead>
                    <th class="text-center">Slno</th>
                    <th class="text-center">SubWard Name</th>
                    <th class="text-center">SubWard Asssign  Count</th>
                </thead>
                <?php
                $i =1; 
                ?>
                <tbody>
                    @foreach($projectscount as $view)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$view['wardname']}}</td>
                        <td>{{count($view['projectcount'])}}</td>
                        
                    </tr>
                   @endforeach
                   
                </tbody>
            </table> 
         
        </div>
    </div>
</div>
</div>
@endsection
