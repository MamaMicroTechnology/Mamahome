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
            strokeWeight: 1
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
          strokeWeight: 1,
          fillColor: color,
          fillOpacity: 0.2
        });
        });
        $("#draw2").click(function(){
        var val = parseInt(document.getElementById('color2').value);
        var color = "#"+document.getElementById('color2').value;
        document.getElementById('path2').value = marker;
        var line = "#"+String(val - 10);
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
      var newpath = [];
      function display(arg,col){
        newpath = [];
        var places = arg.split(",");
        var mymarker = [];
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
          strokeWeight: 1,
          fillColor: "#"+col,
          fillOpacity: 0.2
        });
        document.getElementById('path').value = marker;
      }
      function makelines(arg){
        polygon = map.removePolygons();
        polygon = map.removePolylines();
        polygon = map.drawPolyline({
          path: newpath,
          strokeColor: '#131540',
          strokeOpacity: 0.6,
          strokeWeight: 1
        });
        if(arg != "null"){
          var places = arg.split(",");
          var mymarker = [];
          var latti = 0;
          var longt = 0;
          for(var i=0;i<places.length;i+=2){
            mymarker.push([parseFloat(places[i]), parseFloat(places[i+1])]);
            latti += parseFloat(places[i]);
            longt += parseFloat(places[i+1]);
          }
          map.setCenter({ lat: latti/(places.length/2), lng: longt/(places.length/2)});
          map.setZoom(13);
          polygon = map.drawPolyline({
            path: mymarker,
            strokeColor: '#131540',
            strokeOpacity: 0.6,
            strokeWeight: 1
          });
        }
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
      <div class="col-md-6">
        <form action="{{ URL::to('/') }}/saveMap" method="POST">
          {{ csrf_field() }}
            <div class="col-md-6">
              Zone:
              <select onchange="getWards()" size="5" required name="zone" id="Zones" class="form-control">
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
            </div>
          <input type="hidden" name="path" id="path" class="form-control"><br>
          <button type="button" id="draw" class="btn btn-primary">Preview</button>
          <input type="submit" value="Save" class="btn btn-success">
        </form>
      </div>
      <div class="col-md-6">
        <form action="{{ URL::to('/') }}/saveWardMap" method="POST">
          {{ csrf_field() }}
            <div class="col-md-6">
              Ward:
              <select size="5" required name="ward_id" id="wards" class="form-control">
                
              </select>
            </div>
            <div class="col-md-3">
              Color:
              <input name="color" class="jscolor form-control" id="color2" value="354987">
              <div id="area"></div>
            </div>
          <input type="hidden" name="path" id="path2" class="form-control"><br>
          <button type="button" id="draw2" class="btn btn-primary">Preview</button>
          <input type="submit" value="Save" class="btn btn-success">
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

</body>
</html>
