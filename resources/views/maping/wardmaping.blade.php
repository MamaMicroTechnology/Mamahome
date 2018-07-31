@extends('layouts.app')
@section('content')
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script type="text/javascript" src="{{asset('js/gmaps.js')}}"></script>
  <script src="{{ URL::to('/') }}/js/jscolor.js"></script>
  <!-- <link rel="stylesheet" href="http://twitter.github.com/bootstrap/1.3.0/bootstrap.min.css" /> -->
  <link rel="stylesheet" href="{{ URL::to('/') }}/css/some.css" />
  <link rel="stylesheet" href="{{ URL::to('/') }}/css/app.css" />
  @if($zones->lat != null)
  <script type="text/javascript">
  var count = 0;
    var map, path = [], newpath = [];
    var marker = [];
    var latlng = "{{ $zones-> lat }}";
    $(document).ready(function(){
      var places = latlng.split(",");
        var mymarker = [];
        var latt = 0,lngg = 0;
        for(var i=0;i<places.length;i+=2){
          newpath.push([parseFloat(places[i]), parseFloat(places[i+1])]);
          latt += parseFloat(places[i]);
          lngg += parseFloat(places[i+1]);
        }
        latt = latt/newpath.length;
        lngg = lngg/newpath.length;
        var val = parseInt(document.getElementById('color').value);
        var line = "#"+String(val - 10);
        // for marking maps
        map = new GMaps({
          el: '#map',
          lat: latt,
          lng: lngg,
          click: function(e){
            latitude = e.latLng.lat();
            lognitude = e.latLng.lng();
            path.push([latitude, lognitude]);
            marker[0] = path;
            document.getElementById('path').value = marker;
            polygon = map.removePolylines();
            polygon = map.drawPolyline({
              path: path,
              strokeColor: '#131540',
              strokeOpacity: 0.6,
              strokeWeight: 1
            });
          }
        });

         $("#undo").click(function(){
          path.pop();
            marker[0] = path;
            polygon = map.removePolylines();
            document.getElementById('path').value = marker;
            polygon = map.drawPolyline({
              path: path,
              strokeColor: '#131540',
              strokeOpacity: 0.6,
              strokeWeight: 1
            });
         });

      map.setZoom(11);
      var line = parseInt('{{ $zones->color }}') + 12345;
      map.drawPolygon({
        paths: newpath,
        strokeColor: '#'+line,
        strokeOpacity: 0.6,
        fillColor: '#{{ $zones->color }}',
        strokeWeight: 2
      });
      map.setOptions({draggableCursor:'crosshair'});
      $("#draw").click(function(){
        var val = parseInt(document.getElementById('color').value);
        var color = "#"+document.getElementById('color').value;
        document.getElementById('path').value = marker;
        var line = "#"+String(val - 10);
        count = 1;
        polygon = map.removePolylines();
        polygon = map.removePolygons();
        polygon = map.drawPolygon({
          paths: marker,
          strokeColor: line,
          strokeOpacity: 1,
          strokeWeight: 1,
          fillColor: color,
          fillOpacity: 0.2
        });
      });
    });
  </script>
@else
<script type="text/javascript">
    var map, path = [], newpath = [];
    var marker = [];
    $(document).ready(function(){
        var mymarker = [];
        var val = parseInt(document.getElementById('color').value);
        var line = "#"+String(val - 10);
        // for marking maps
        map = new GMaps({
          el: '#map',
          lat: 12.9716,
          lng: 77.5946,
          click: function(e){
            latitude = e.latLng.lat();
            lognitude = e.latLng.lng();
            path.push([latitude, lognitude]);
            marker[0] = path;
            document.getElementById('path').value = marker;
            polygon = map.removePolylines();
            polygon = map.drawPolyline({
              path: path,
              strokeColor: '#131540',
              strokeOpacity: 0.6,
              strokeWeight: 1
            });
          }
        });
        $("#undo").click(function(){
          path.pop();
            marker[0] = path;
            document.getElementById('path').value = marker;
            polygon = map.removePolylines();
            polygon = map.drawPolyline({
              path: path,
              strokeColor: '#131540',
              strokeOpacity: 0.6,
              strokeWeight: 1
            });
         });
      map.setZoom(10);
      map.setOptions({draggableCursor:'crosshair'});
      $("#draw").click(function(){
        var val = parseInt(document.getElementById('color').value);
        var color = "#"+document.getElementById('color').value;
        document.getElementById('path').value = marker;
        var line = "#"+String(val - 10);
        polygon = map.removePolylines();
        polygon = map.removePolygons();
        polygon = map.drawPolygon({
          paths: marker,
          strokeColor: line,
          strokeOpacity: 1,
          strokeWeight: 1,
          fillColor: color,
          fillOpacity: 0.2
        });
      });
    });
  </script>
@endif
</head>
<body>
<div class="container">
  <div class="row">
    <h1>{{ $page }} Mapping
    </h1>
    <div class="row">
      <div class="span11">
        <div id="map"></div>
      </div>
      <br>
      <div class="col-md-12">
        <form onsubmit="validate()" action="{{ URL::to('/') }}/saveMap" method="POST">
          {{ csrf_field() }}
            <div class="col-md-2">
              {{ $page }}:<br>
                <input type="text" name="name" id="name" value="{{ $zones->name }}" class="form-control">
                <input type="hidden" name="page" value="{{ $page }}">
                <input type="hidden" name="zone" value="{{ $zones->id }}">
            </div>
            <div class="col-md-2">
              Color:
              <input name="color" class="jscolor form-control" id="color" value="{{ $zones->color }}">
              <div id="area"></div>
            </div>
            <div class="col-md-8">
              <br>
              <div class="col-md-8">
                <input type="text" value="{{ $zones->lat }}" name="path" id="path" class="form-control">
              </div>
              <div class="col-md-4 btn-group">
                <button type="button" class="btn btn-primary" id="undo">Undo</button>
                <button type="button" id="draw" class="btn btn-primary">Preview</button>
                <input type="submit" value="Save" class="btn btn-success" id="savebutton">
              </div>
            </div>
        </form>
      </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU"></script>
  </div>
</div>

<script>
  function getWards(){
    var id = document.getElementById('Zones').value;
    var wards = "";
    $.ajax({
        type: 'GET',
        url: "{{URL::to('/')}}/getWards",
        data: {id:id},
        async: false,
        success: function(response)
        {
          for(var i = 0; i < response.length; i++){
            wards += "<option value="+response[i].id+" onclick=makelines('"+response[i].lat+"')>"+response[i].ward_name+"</option>"
          }
          document.getElementById('wards').innerHTML = wards;
          console.log(response);
        }
    });
  }
</script>
@endsection
