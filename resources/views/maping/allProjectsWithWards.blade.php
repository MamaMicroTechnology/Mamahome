<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mamahome</title>
    <script type="text/javascript" src="{{asset('js/gmaps.js')}}"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<br>
<form action="{{ URL::to('/') }}/allProjectsWithWards" method="get">
    <div class="col-md-2">
        <label for="wards">Select Wards:</label>
        <select required name="wards" class="form-control" id="wards">
            @foreach($wards as $ward)
            <option {{ isset($_GET['wards']) ? $_GET['wards'] == $ward->id ? 'selected' : '' : '' }} value="{{ $ward->id }}">{{ $ward->ward_name }}</option>
            @endforeach
        </select>
        <label for="quality">Select Quality:</label>
        <select required name="quality" class="form-control" id="quality">
            <option {{ isset($_GET['quality']) ? $_GET['quality'] == "Genuine" ? 'selected' : '' : ''}} value="Genuine">Genuine</option>
            <option {{ isset($_GET['quality']) ? $_GET['quality'] == "Fake" ? 'selected' : '' : ''}} value="Fake">Fake</option>
        </select>
        <br>
        <input type="submit" value="Fetch" class="btn btn-primary form-control">
        <br><br>
        @if(isset($_GET['wards']))
            Total Projects : {{ count($projects) }}
        @endif
    </div>
</form>
    <div class="col-md-2">
    </div>
    <div class="col-md-10" style="border-style: ridge;">
        <div id="map" style="width:100%;height:600px"></div>
    </div>
    @if(isset($_GET['wards']))
    <script type="text/javascript" scr="https://maps.google.com/maps/api/js?sensor=false"></script>

    <script type="text/javascript">
    window.onload = function() {
    var locations = new Array();
    var created = new Array();
    var updated = new Array();
    var status = new Array();
    var newpath = [];
    var mysubpath = [];
    var latlng = [];
    var col = [];
    var places = [];
    var quality = [];
    @if($wardMaps != "None")
        var latlng = "{{ $wardMaps->lat }}";
        var col = "{{ $wardMaps->color }}";
    @else
        var latlng = "";
        var col = "456369"
    @endif
    var places = latlng.split(",");
    for(var i=0;i<places.length;i+=2){
          newpath.push({lat: parseFloat(places[i]), lng: parseFloat(places[i+1])});
    }
    @foreach($projects as $project)
        locations.push(["<a href=\"https://maps.google.com/?q={{ $project->address }}\">{{$project->project_id}}, {{ $project->address }}</a>",{{ $project->latitude}}, {{ $project->longitude }}]);
        created.push("{{ $project->created_at}}");
        updated.push("{{ $project->updated_at}}");
        quality.push("{{ $project->quality }}");
        // alert(quality);
    @endforeach

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: new google.maps.LatLng(locations[0][1], locations[0][2]),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {
        if(quality[i] == "Genuine"){
            var icon = {
                url: "http://www.free-icons-download.net/images/green-map-marker-icon-50710.png", // url
                scaledSize: new google.maps.Size(50, 50), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };
            marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
            icon: icon
            });
        }
        // else{
        //     marker = new google.maps.Marker({
        //     position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        //     map: map,
        //     icon: 'nothing'
        //     });
        // }
        if(quality[i] == "Fake"){
            var icon = {
                url: "https://images.vexels.com/media/users/3/136303/isolated/preview/7dbfd48c913dc03cf834af0525429826-location-marker-icon-by-vexels.png", // url
                scaledSize: new google.maps.Size(50, 50), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };
            marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
            icon: icon
            });
        }

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
            infowindow.setContent(locations[i][0]);
            infowindow.open(map, marker);
        }
        })(marker, i));
    }
    var subward = new google.maps.Polygon({
        paths: newpath,
        strokeColor: '#'+col,
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#'+col,
        fillOpacity: 0.35
      });
  subward.setMap(map);
    }
    </script>
    @endif
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU&callback=myMap"></script>
</body>
</html>