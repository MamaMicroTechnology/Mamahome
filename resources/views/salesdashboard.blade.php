@extends('layouts.leheader')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <a href="{{ URL::to('/') }}/projectsUpdate" id="updates" class="form-control btn btn-primary {{ count($assignment) == 0? 'disabled': ''}}">Project Updates</a><br><br>
            <a href="{{ URL::to('/') }}/registrationrequests" id="reports" class="form-control btn btn-primary {{ count($assignment) == 0? 'disabled': ''}}">Registry Requests <span class="badge">&nbsp; {{ $reqcount }} &nbsp;</span></a><br><br>
            <a href="{{ URL::to('/') }}/followupproject" class="form-control btn btn-primary {{ count($assignment) == 0? 'disabled': ''}}">Follow up projects</a><br><br>
            <a href="{{ URL::to('/') }}/kra" class="form-control btn btn-primary">KRA</a><br><br>
        </div>
    </div>
</div>
@endsection
