@extends('layouts.app')
@section('content')
 <div class="col-md-12">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading" style="color:white;font-size: 15px;">Map Of &nbsp;&nbsp;{{ $_GET['subward'] }}
                    @if(session('Error'))
                        <div class="alert-danger pull-right">{{ session('Error')}}</div>
                    @endif
                    <a  href="{{URL::to('/')}}/viewallProjects" class="btn btn-sm btn-danger pull-right">Back</a>    

                </div>
                <div class="panel-body">
                	   <div id="map" style="width:1050px;height:530px"></div>
                </div>
               </div>
             </div>
          </div>
       </div>
<script type="text/javascript" scr="https://maps.google.com/maps/api/js?sensor=false"></script>
       @if(count($projects) == 0)
       <script type="text/javascript">
          window.onload = function() { 
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
    // console.log(newpath);
    var lat = newpath[0].lat;
    var lon = newpath[1].lng;
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 13,
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
       </script>
 @else
 <script type="text/javascript">
    window.onload = function() { 
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
    // console.log(newpath);
    var lat = newpath[0].lat;
    var lon = newpath[1].lng;
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 13,
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

   // marker
   @foreach($projects as $project)
  
    // var infowindow = new google.maps.InfoWindow();
    var marker3, i;
    var latitude = "{{ $project->latitude }}";
    var longitude = "{{ $project->longitude }}";
    var contentString = "{{ $project->address }}";
    var infowindow3 = new google.maps.InfoWindow({
        content: contentString
      });

      marker3 = new google.maps.Marker({
        position: new google.maps.LatLng(latitude, longitude),
        map: map,
      });
      marker3.addListener('click', function() {
       
          infowindow3.open(map, marker3);
        });
    
      @endforeach
      // marker end

  }  
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU&callback=myMap"></script></script>
@endif
@endsection