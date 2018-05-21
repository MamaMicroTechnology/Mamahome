@extends('layouts.app')
@section('content')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script type="text/javascript" src="{{asset('js/gmaps.js')}}"></script>
  <script src="{{ URL::to('/') }}/js/jscolor.js"></script>
  <!-- <link rel="stylesheet" href="http://twitter.github.com/bootstrap/1.3.0/bootstrap.min.css" /> -->
  <link rel="stylesheet" href="{{ URL::to('/') }}/css/some.css" />
  <link rel="stylesheet" href="{{ URL::to('/') }}/css/app.css" />
    <script type="text/javascript">
        var track = [];
        @foreach($track as $trac)
            track.push([{{ $trac->latitude }},{{ $trac->longitude }}]);
        @endforeach
        var map;
        $(document).ready(function(){
        map = new GMaps({
            el: '#map',
            lat: 12.2342442,
            lng: 77.234234234,
            click: function(e){
            console.log(e);
            }
        });

        path = track;

        map.drawPolyline({
            path: path,
            strokeColor: '#131540',
            strokeOpacity: 0.6,
            strokeWeight: 2
        });
        });
    </script>
    @foreach($users as $user)
        <a href="{{ URL::to('/') }}/letracking?userId={{ $user->id }}">{{ $user->employeeId }} {{ $user->name }}</a><br>
    @endforeach
    <div class="span11">
      <div id="map"></div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU"></script>
@endsection