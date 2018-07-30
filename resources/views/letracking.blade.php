@extends('layouts.app')
@section('content')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script type="text/javascript" src="{{asset('js/gmaps.js')}}"></script>
  <script src="{{ URL::to('/') }}/js/jscolor.js"></script>
  <!-- <link rel="stylesheet" href="http://twitter.github.com/bootstrap/1.3.0/bootstrap.min.css" /> -->
  <link rel="stylesheet" href="{{ URL::to('/') }}/css/some.css" />
  <link rel="stylesheet" href="{{ URL::to('/') }}/css/app.css" />
  @if(isset($_GET['userId']))
    <script type="text/javascript">
        var track = [];
        @foreach($track as $trac)
            track.push([{{ round($trac->latitude,4) }},{{ round($trac->longitude,4) }}]);
        @endforeach
        var map;
        $(document).ready(function(){
        map = new GMaps({
            el: '#map',
            lat: 12.9716,
            lng: 77.5946,
            click: function(e){
            console.log(e);
            }
        });
        map.setZoom(16);
        path = track;

        map.drawPolyline({
            path: path,
            strokeColor: '#131540',
            strokeOpacity: 0.6,
            strokeWeight: 2
        });
        });
    </script>
    @else
    <script type="text/javascript">
    var map;
    $(document).ready(function(){
      map = new GMaps({
        el: '#map',
        lat: 12.9716,
        lng: 77.5946,
        zoomControl : true,
        zoomControlOpt: {
            style : 'SMALL',
            position: 'TOP_LEFT'
        },
        panControl : false,
        streetViewControl : false,
        mapTypeControl: false,
        overviewMapControl: false
      });
      map.setZoom(11);
    });
  </script>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" style="max-height:550px; height:550px; overflow-y: scroll;">
              @if(Auth::user()->group_id != 22)
                @foreach($users as $user)
                <a style="font-family:'Times New Roman'" class="list-group-item"
                    href="{{ URL::to('/') }}/{{ Auth::user()->id == 1 ? 'letracking' : 'tltracking' }}?userId={{ $user->id }}">
                    {{ $user->employeeId }} {{ $user->name }}
                </a>
                @endforeach
                @else
                 @foreach($tlUsers as $user)
                <a style="font-family:'Times New Roman'" class="list-group-item"
                    href="{{ URL::to('/') }}/{{ Auth::user()->id == 1 ? 'letracking' : 'tltracking' }}?userId={{ $user->id }}">
                    {{ $user->employeeId }} {{ $user->name }}
                </a>
                @endforeach
                @endif
            </div>
            <div class="col-md-10">
              <div style="height:550px;" id="map"></div>
            </div>
        </div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU"></script>
@endsection