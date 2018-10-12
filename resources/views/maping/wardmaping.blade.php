<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('js/gmaps.js')}}"></script>
 <div class="col-md-12">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading" style="color:white;font-size: 15px;">Map Of &nbsp;&nbsp;
                    @if(session('Error'))
                        <div class="alert-danger pull-right">{{ session('Error')}}</div>
                    @endif
                    <a  href="{{URL::to('/')}}/viewallProjects" class="btn btn-sm btn-danger pull-right">Back</a>    

                </div>
                <div class="panel-body">
                    <div id="map" style="width:100%;height:400px;"></div>
                </div>
               </div>
             </div>
          </div>
       </div>
<script type="text/javascript" scr="https://maps.google.com/maps/api/js?sensor=false"></script>
<script>
function myMap() {
      var mapProp= {
          center:new google.maps.LatLng(12.9755324,77.610114),
          zoom:5,
      };
var path = [];
var newpath = [];
var map=new google.maps.Map(document.getElementById("map"),mapProp);
          $(document).ready(function(){

      map = new GMaps({
        el: '#map',
        zoom: 11,
        lat: 12.9716,
        lng: 77.5946,
        click: function(e){
          latitude = e.latLng.lat();
          lognitude = e.latLng.lng();
          // console.log(latitude,lognitude);
          path.push([latitude, lognitude]);
          document.getElementById('path').value = path;
          // console.log(path);
          // polygon = map.drawPolyline({
          //   path: path,
          //   strokeColor: '#131540',
          //   strokeOpacity: 0.6,
          //   strokeWeight: 6
          // });
        }
      });
    });
    for(var i=0;i<path.length;i+=2){
          newpath.push({lat: parseFloat(path[i]), lng: parseFloat(path[i+1])});
    }
          // console.log(newpath);
        var directionsService = new google.maps.DirectionsService;

        document.getElementById('submit').addEventListener('click', function() {
          calculateAndDisplayRoute(directionsService);
        });
      

      function calculateAndDisplayRoute(directionsService) {
        alert();
        var waypts = [];
        for(var i=1; i<path.length; i++){
          waypts.push(path[i]);
        }
        console.log(waypts);
        directionsService.route({
          origin: path[0],
          destination: path[0],
          waypoints: waypts,
          optimizeWaypoints: true,
          travelMode: 'DRIVING'
        }, function(response, status) {
          console.log(resonse);
          // if (status === 'OK') {
          //   directionsDisplay.setDirections(response);
          //   var route = response.routes[0];
          //   var summaryPanel = document.getElementById('directions-panel');
          //   summaryPanel.innerHTML = '';
          //   // For each route, display summary information.
          //   for (var i = 0; i < route.legs.length; i++) {
          //     var routeSegment = i + 1;
          //     summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
          //         '</b><br>';
          //     summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
          //     summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
          //     summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
          //   }
          // } else {
          //   window.alert('Directions request failed due to ' + status);
          // }
        });
 
   }     
}
</script>
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU&callback=myMap"></script></script> -->
  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjnJY74MIHYFBW8V2-c4mL3KCJXZ4_2mw&callback=myMap">
    </script>
  <div class="col-md-4">
  <input type="submit" name="submit" id="submit" class="form-control">
</div>
  <div class="col-md-4">
                <input type="text" value="" name="path" style="width:1000px;height: 100px;" id="path" class="form-control">
                
  </div>
  <div class="col-md-4">
                <input type="text" name="waypoints" id="waypoints" class="form-control">
  </div>
</div>
