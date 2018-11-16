
@extends('layouts.app')
@section('content')
<br>
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-success">
    <div class="panel-heading">
       {{-- Total No Of Projects In Zone 1 : {{$totalProjects}}--}}
    </div>
    <div class="panel-body">
        <div class="col-md-6">
            <center>Select Ward</center>
            <form method="GET" action="{{ URL::to('/') }}/projectandward">
                <select required class="form-control" name="ward">
                    <option value="">--Select--</option>
                    <option value="All">All</option>
                @foreach($wards as $ward)
                    <option value="{{ $ward->id}}">{{ $ward->ward_name }}</option>
                @endforeach
                </select><br>
                <button class="btn btn-primary form-control" type="submit">Fetch</button>
            </form>
            <br>
            @if(session('Error'))
                <p class="alert alert-error">{{ session('Error') }}</p>
            @endif
            <table class="table table-hover" border="1">
                <thead>
                    <th class="text-center">Slno</th>
                    <th class="text-center">SubWard Name</th>
                    <th class="text-center">Project Count</th>
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
