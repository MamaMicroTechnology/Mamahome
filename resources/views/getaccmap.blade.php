<div class="panel panel-default" style="border-color:#0e877f">
<div class="panel-heading" style="background-color:#0e877f;font-weight:bold;font-size:1.3em;color:white">
 <div style="margin-left: 20px;">{{ $ward ? $ward : "No Ward"}} {{ isset($_GET['$ward']) ? date('d/m/Y', strtotime($_GET['$ward'])) : '' }}</div>
 <div style="margin-left: 600px;margin-top: -20;" id="currentTime" ></div>
</div><br>
<div style="margin-left: 600px;" class="col-md-2">
  <form method="GET" action="{{ URL::to('/') }}/getmaphistory1">
                <input type="hidden" value="{{$name}}" name="name">
                <label>Select Date : </label>
                <input required value = "{{ isset($_GET['getmap']) ? $_GET['getmap']: '' }}" type="date" class="form-control" name="getmap">
                <input type="submit" value="Fetch" class="form-control btn btn-primary">
  </form>
</div>
<table style="margin-left: 600px;" class="table" border="1">
   <tbody>
      <tr>
        <td>Red Marker</td>
        <td>Login Location</td>
      </tr>
      <tr>
        <td>Blue Marker</td>
        <td>Logout Location</td>
      </tr>
      <tr>
        <td>Pink Pin</td>
        <td>more than 20mins</td>
      </tr>
      <tr>
        <td>Red Pin</td>
        <td>more than 40mins</td>
      </tr>
    </tbody>
</table>
<div style="margin-top: -130px;">
  <b>Name : </b>{{ $name }}<br><br>
  @foreach($login as $login)
  <b>Field Login Time : </b>{{ $login->logintime }}<br><br>
  <b>Field Logout Time:</b>{{ $login->logout }}<br><br>
  <b>Remark(Late Login) : </b>{{ $login->remark }}<br><br>
  <b>Approved By :</b><br><br>
  @endforeach
     <!-- <b>Distance :</b>{{ $storoads != null ? $storoads->kms : ""}} -->
     <br><br><br>
</div>
<br><br>
<div  class="panel-body" style="height:500px;max-height:500px">
<div style="margin-left: 900px;">{{ isset($_GET['getmap']) ? date('d/m/Y', strtotime($_GET['getmap'])) : '' }}</div>
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
    var apiKey = "AIzaSyDCg8dn05JGK3ZSiy3Mx7kEOMeoWMQLYaE";
    @if($subwardMap != "None")
    var latlng = "{{ $subwardMap->lat }}";
    var col = "{{ $subwardMap->color }}";
    @else
    var latlng = "";
    var col = "456369";
    @endif
    @if($storoads != null)
        var lists = "{{$storoads->lat_long}}";
        var col = "456369"
        var time = "{{$storoads->time }}";
    @else
        var lists ="";
        var col = "456369";
        var time = "";
    @endif
    var places = latlng.split(",");
     var lat_long = lists.split("|");
      var times = time.split(",");
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


   @if($subwardMap != "None")
    var lat = newpath[0].lat;
    var lon = newpath[1].lng;
    @else
    var lat = "12.9716";
    var lon = "77.5946";
    @endif
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: new google.maps.LatLng(lat, lon),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });



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

      var timemarker = [];
    // stopmarker
    for(var k=0; k<times.length-1;k++){
       var  A = times[k];
      var   B = times[k+1];
  
       var timeA = Number(A.split(':')[0])*60*60+Number(A.split(':')[1])*60;
       var timeB = Number(B.split(':')[0])*60*60+Number(B.split(':')[1])*60;
         var timeConvert = A.match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [timeConvert];
        if (timeConvert.length > 1) { // If timeConvert format correct
          timeConvert = timeConvert.slice (1);  // Remove full string match value
          timeConvert[5] = +timeConvert[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
          timeConvert[0] = +timeConvert[0] % 12 || 12; // Adjust hours
        }
        var timeConvert2 = B.match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [timeConvert2];
        if (timeConvert2.length > 1) { // If timeConvert2 format correct
          timeConvert2 = timeConvert2.slice (1);  // Remove full string match value
          timeConvert2[5] = +timeConvert2[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
          timeConvert2[0] = +timeConvert2[0] % 12 || 12; // Adjust hours
        }
        if(timeB >= timeA+2400){
            // var infowindow = new google.maps.InfoWindow();
            var mark, i;
            var contentString ="From" +" "+ timeConvert +"<br>"+"To"+" "+ timeConvert2 ;

            var infowindow1 = new google.maps.InfoWindow({
                content: contentString
              });
            var icon = {
                 url: 'http://pngimage.net/wp-content/uploads/2018/06/location-emoji-png.png', // url
                scaledSize: new google.maps.Size(50, 40), // scaled size
                origin: new google.maps.Point(0,0), // origin
               anchor: new google.maps.Point(17, 34)  // anchor
            };
           var ltlg = lat_long[k].split(",");
          
           timemarker.push({lat: parseFloat(ltlg[0]), lng: parseFloat(ltlg[1])});
              mark = new google.maps.Marker({
                position: new google.maps.LatLng(ltlg[0],ltlg[1]),
                 icon: icon,
                map: map,
              });
              mark.addListener('click', function() {
               
                  infowindow1.open(map, mark);
                });
      }
      else if(timeB >= timeA+1200){
      
            // var infowindow = new google.maps.InfoWindow();
            var marker1, i;
            var contentString ="From" +" "+ timeConvert +"<br>"+"To"+" "+ timeConvert2 ;

            var infowindow2 = new google.maps.InfoWindow({
                content: contentString
              });
            var icon = {
                url: 'http://icongal.com/gallery/image/446881/map_marker_ball_pink.png', // url
                scaledSize: new google.maps.Size(50, 40), // scaled size
                origin: new google.maps.Point(0,0), // origin
               anchor: new google.maps.Point(17, 34)  // anchor
            };
           var ltlg = lat_long[k].split(",");
          
           timemarker.push({lat: parseFloat(ltlg[0]), lng: parseFloat(ltlg[1])});
              marker1 = new google.maps.Marker({
                position: new google.maps.LatLng(ltlg[0],ltlg[1]),
                 icon: icon,
                map: map,
              });
              marker1.addListener('click', function() {
               
                  infowindow2.open(map, marker1);
                });
      }
      else{
       
      }
    }
    // stopmarker end
    
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
    strokeColor: "#1f5dc1",
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

     @if($projects != null)
    // var infowindow = new google.maps.InfoWindow();
    var marker2, i;
    var latitude = "{{ $projects->latitude }}";
    var longitude = "{{ $projects->longitude }}";
    var contentString = "{{ $projects->address }}";
    var infowindow3 = new google.maps.InfoWindow({
        content: contentString
      });

      marker2 = new google.maps.Marker({
        position: new google.maps.LatLng(latitude, longitude),
        map: map,
      });
      marker2.addListener('click', function() {
          infowindow3.open(map, marker2);
        });
    @endif

    // marker
    @if($projects != null)
     @if($projects->logout_lat != null)
    // var infowindow = new google.maps.InfoWindow();
    var marker3, i;
    var latitude = "{{ $projects->logout_lat }}";
    var longitude = "{{ $projects->logout_long }}";
    var contentString = "{{ $projects->logout_address }}";
    var infowindow4 = new google.maps.InfoWindow({
        content: contentString
      });
    var icon = {
                url: 'http://www.clker.com/cliparts/B/B/1/E/y/r/marker-pin-google.svg', // url
                scaledSize: new google.maps.Size(60, 50), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };
      marker3 = new google.maps.Marker({
        position: new google.maps.LatLng(latitude, longitude),
        icon: icon,
        map: map,
      });
      marker3.addListener('click', function() {
          infowindow4.open(map, marker3);
        });
      @endif
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
<script>
  function doDate()
  {
      var str = "";

      var days = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
      var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

      var now = new Date();

      str += days[now.getDay()] + ", " + now.getDate() + " " + months[now.getMonth()] + " " + now.getFullYear() + " " + now.getHours() +":" + now.getMinutes() + ":" + now.getSeconds();
      document.getElementById("currentTime").innerHTML = str;
  }

  setInterval(doDate, 1000);
</script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCg8dn05JGK3ZSiy3Mx7kEOMeoWMQLYaE&callback=map"></script>
