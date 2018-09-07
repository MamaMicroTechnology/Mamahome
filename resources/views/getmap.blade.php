<div class="panel panel-default" style="border-color:#0e877f">
<div class="panel-heading" style="background-color:#0e877f;font-weight:bold;font-size:1.3em;color:white"></div>
<div class="panel-body" style="height:500px;max-height:500px">
  <b>Name : </b>{{ $name }}<br><br>
  @foreach($login as $login)
  <b>Field Login Time : </b>{{ $login->logintime }}<br><br>
  <b>Remark(Late Login) : </b>{{ $login->remark }}<br><br>
  <b>Logout :</b>{{ $login->logout }}<br><br>
  @endforeach
   @foreach($ward as $ward)
                <b>Assigned Ward : </b>{{ $ward->sub_ward_name }}
    
    @endforeach
    <br><br>
   <b>Distance :</b>{{ $storoads != null ? $storoads->kms : ""}}<br><br>
    <br><br>
<div id="map" style="width:980PX;height:450px;overflow-y: hidden;overflow-x: hidden;"></div>
</div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" scr="https://maps.google.com/maps/api/js?sensor=false"></script>
@if($storoads == null && $projects == null)
<script type="text/javascript">
    window.onload = function() {
    var locations = new Array();
    var created = new Array();
    var updated = new Array();
    var status = new Array();
    var newpath = [];
    @if($subwardMap != "None")
    var latlng = "{{ $subwardMap->lat }}";
    var col = "{{ $subwardMap->color }}";
    @else
    var latlng = "";
    var col = "456369"
    @endif
    var places = latlng.split(",");
    for(var i=0;i<places.length;i+=2){
          newpath.push({lat: parseFloat(places[i]), lng: parseFloat(places[i+1])});
    }
    var lat = newpath[0].lat;
    var lon = newpath[1].lng;
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: new google.maps.LatLng(lat, lon),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();
   
    var marker, i;
    var subward = new google.maps.Polygon({
        paths:  newpath,
        strokeColor: '#'+col,
        strokeOpacity: 1,
        strokeWeight: 2,
        fillColor: '#'+col,
        fillOpacity: 0.9
      });
  subward.setMap(map);
  }
  </script>
@else

  <script type="text/javascript">
    window.onload = function() {
    var locations = new Array();
    var created = new Array();
    var updated = new Array();
    var status = new Array();
    var newpath = [];
    var snaproad = [];
    var apiKey = "AIzaSyDUmSbzCrMt37QdavPl00t_Bx9jkL04w0Y";
    @if($subwardMap != "None")
    var latlng = "{{ $subwardMap->lat }}";
    var col = "{{ $subwardMap->color }}";
    @else
    var latlng = "";
    var col = "456369"
    @endif
    @if($storoads != null)
        var lists = "{{$storoads->lat_long}}";
        var col = "456369"
    @else
        var lists ="";
        var col = "456369"
    @endif
    var places = latlng.split(",");
    var lat_long = lists.split("|");

    // polygon
    for(var i=0;i<places.length;i+=2){
          newpath.push({lat: parseFloat(places[i]), lng: parseFloat(places[i+1])});
    }
    @if($projects != null)
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 15.5,
      center: new google.maps.LatLng("{{ $projects->latitude }}", "{{ $projects->longitude }}"),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    @endif

    var lat = newpath[0].lat;
    var lon = newpath[1].lng;
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: new google.maps.LatLng(lat, lon),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    // polygon end

    // snaptoraod
    for(var i=0;i<lat_long.length;i+=2){
      snaproad.push({lat: parseFloat(lat_long[i]), lng: parseFloat(lat_long[i+1])});
    }
    // alert(lat_long.length);
    var text="";
    var count=90;
   
    for(var j=0;j<lat_long.length;j++){
      text += lat_long[j];
      if(j >= count || j >= lat_long.length-1){
        $.get('https://roads.googleapis.com/v1/snapToRoads', {
          interpolate: true,
          key: apiKey,
          path: text
        }, function(data) {  
          processSnapToRoadResponse(data);
          drawSnappedPolyline();
          // getAndDrawSpeedLimits();
        });
        // console.log(text);
        // console.log(count);
        text = "";
        count += 90;
      }else{
        text += "|";
      }
    }
    // Store snapped polyline returned by the snap-to-road service.
function processSnapToRoadResponse(data) {
  snappedCoordinates = [];
  placeIdArray = [];
// alert(data.snappedPoints.length);
  for (var i = 0; i < data.snappedPoints.length; i++) {
    var latlng = new google.maps.LatLng(
        data.snappedPoints[i].location.latitude,
        data.snappedPoints[i].location.longitude);
    snappedCoordinates.push(latlng);
    placeIdArray.push(data.snappedPoints[i].placeId);
  }
}
// Draws the snapped polyline (after processing snap-to-road response).
function drawSnappedPolyline() {
  var snappedPolyline = new google.maps.Polyline({
    path: snappedCoordinates,
    strokeColor: 'black',
    strokeWeight: 3
  });

  snappedPolyline.setMap(map);
  snaproad.push(snappedPolyline);
}
// Gets speed limits (for 100 segments at a time) and draws a polyline
// color-coded by speed limit. Must be called after processing snap-to-road
// response.
// function getAndDrawSpeedLimits() {
//   for (var i = 0; i <= placeIdArray.length / 100; i++) {
//     // Ensure that no query exceeds the max 100 placeID limit.
//     var start = i * 100;
//     var end = Math.min((i + 1) * 100 - 1, placeIdArray.length);
//     drawSpeedLimits(start, end);
//   }
// }



    // snaptoraod end



    // marker
    @if($projects != null)
    var infowindow = new google.maps.InfoWindow();
    var marker, i;
    var latitude = "{{ $projects->latitude }}";
    var longitude = "{{ $projects->longitude }}";
    var contentString = "{{ $projects->address }}";
    var infowindow = new google.maps.InfoWindow({
        content: contentString
      });

      marker = new google.maps.Marker({
        position: new google.maps.LatLng(latitude, longitude),
        map: map,
      });
      marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
      @endif
      // marker end

      // marker
    @if($projects->logout_lat != null)
    alert();
    var infowindow = new google.maps.InfoWindow();
    var marker, i;
    var latitude = "{{ $projects->logout_lat }}";
    var longitude = "{{ $projects->logout_long }}";
    var contentString = "{{ $projects->logout_address }}";
    var infowindow = new google.maps.InfoWindow({
        content: contentString
      });
    var icon = {
                url: 'http://www.clker.com/cliparts/B/B/1/E/y/r/marker-pin-google.svg', // url
                scaledSize: new google.maps.Size(60, 50), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(latitude, longitude),
        icon: icon,
        map: map,
      });
      marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
      @endif
      // marker end



    if(newpath.length > 1){
      
      var subward = new google.maps.Polygon({
          paths: newpath,
          strokeColor: '#'+col,
          strokeOpacity: 1,
          strokeWeight: 2,
          fillColor: '#'+col,
          fillOpacity: 0.4
        });
    subward.setMap(map);
    }

  }
  </script>
@endif
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU&callback=map"></script>
