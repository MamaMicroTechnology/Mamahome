<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Mamahome</title>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script type="text/javascript" src="{{asset('js/gmaps.js')}}"></script>
  <script src="{{ URL::to('/') }}/js/jscolor.js"></script>
  <link rel="stylesheet" href="http://twitter.github.com/bootstrap/1.3.0/bootstrap.min.css" />
  <link rel="stylesheet" href="{{ URL::to('/') }}/css/some.css" />
  <link rel="stylesheet" href="{{ URL::to('/') }}/css/app.css" />
  <script type="text/javascript">
    var map;
    var path = [];
    var latitude;
    var lognitude;
    var latilong = [];
    var marker = [];
    $(document).ready(function(){
      map = new GMaps({
        el: '#map',
        zoom: 11,
        lat: 12.9716,
        lng: 77.5946,
        click: function(e){
          latitude = e.latLng.lat();
          lognitude = e.latLng.lng();
          path.push([latitude, lognitude]);
          marker[0] = path;
          polygon = map.drawPolyline({
            path: path,
            strokeColor: '#131540',
            strokeOpacity: 0.6,
            strokeWeight: 6
          });
        }
      });
      map.setOptions({draggableCursor:'crosshair'});
      $("#draw").click(function(){
        var val = parseInt(document.getElementById('color').value);
        var color = "#"+document.getElementById('color').value;
        document.getElementById('path').value = marker;
        var line = "#"+String(val - 10);
        polygon = map.removePolylines();
        polygon = map.drawPolygon({
          paths: marker,
          strokeColor: line,
          strokeOpacity: 1,
          strokeWeight: 3,
          fillColor: color,
          fillOpacity: 0.2
        });
        });
      });
      function display(arg,col){
        var places = arg.split(",");
        var newpath = [];
        var mymarker = [];
        var ncol = parseInt(col);
        for(var i=0;i<places.length;i+=2){
          newpath.push([parseFloat(places[i]), parseFloat(places[i+1])]);
        }
        var val = parseInt(document.getElementById('color').value);
        var line = "#"+String(val - 10);
        mymarker[0] = newpath;
        polygon = map.removePolygons();
        polygon = map.drawPolygon({
          paths: mymarker,
          strokeColor: line,
          strokeOpacity: 1,
          strokeWeight: 3,
          fillColor: ncol,
          fillOpacity: 0.2
        });
        document.getElementById('path').value = marker;
      }
  </script>
</head>
<body>
<div class="container">
  <div class="row">
    <h1>Ward Mapping
    </h1>
    <div class="row">
      <div class="span11">
        <div id="map"></div>
      </div>
      <br>
      <form action="{{ URL::to('/') }}/saveMap" method="POST">
      {{ csrf_field() }}
      <div class="col-md-6">
        <div class="col-md-6">
          Zone:
          <select size="5" required name="zone" id="Zones" class="form-control">
            @foreach($zones as $zone)
            <option onclick="display('{{ $zone->lat }}','{{ $zone->color}}')" style="border-bottom: 2px solid;border-top: 2px solid; padding: 5px;" value="{{ $zone->id }}">{{ $zone->zone_name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          Color:
          <input name="color" class="jscolor form-control" id="color" value="354987">
          <div id="area"></div>
        </div>
        <div class="col-md-3">
          <br>
          <button type="button" id="draw" class="btn btn-primary">Preview</button>
        </div>
      </div>  
      <input type="hidden" name="path" id="path" class="form-control"><br>
      <input type="submit" value="Save" class="btn btn-success">
      </form>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU"></script>
  </div>
</div>
</body>
</html>
