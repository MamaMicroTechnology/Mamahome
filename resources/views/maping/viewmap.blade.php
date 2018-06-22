@extends('layouts.app')
@section('content')
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script type="text/javascript" src="{{asset('js/gmaps.js')}}"></script>
  <script src="{{ URL::to('/') }}/js/jscolor.js"></script>
  <!-- <link rel="stylesheet" href="http://twitter.github.com/bootstrap/1.3.0/bootstrap.min.css" /> -->
  <link rel="stylesheet" href="{{ URL::to('/') }}/css/some.css" />
  <link rel="stylesheet" href="{{ URL::to('/') }}/css/app.css" />
  <script type="text/javascript">
    var count = 0;
    var map, path = [], newpath = [];
    var marker = [],latlng, places;
    var latt, lngg;
    $(document).ready(function(){
      map = new GMaps({
        el: '#map',
        lat: 12.9716,
        lng: 77.5946,
      });
      
    @foreach($zones as $zone)
      latlng = "{{ $zone-> lat }}";
      places = latlng.split(",");
      path = [];
      newpath = [];
      latt = 0;
      lngg = 0;
      // for marking maps
      for(var i=0;i<places.length;i+=2){
        newpath.push([parseFloat(places[i]), parseFloat(places[i+1])]);
        latt += parseFloat(places[i]);
        lngg += parseFloat(places[i+1]);
      }
      latt = latt/newpath.length;
      lngg = lngg/newpath.length;
      map.setZoom(11);
      var line = parseInt('{{ $zone->color }}') + 12345;
      map.drawPolygon({
        paths: newpath,
        strokeColor: '#'+line,
        strokeOpacity: 0.6,
        fillColor: '#{{ $zone->color }}',
        strokeWeight: 2
      });
      map.drawOverlay({
          lat: latt,
          lng: lngg,
          layer: 'overlayLayer',
          content: '<div class="overlay">{{ $zone->name }}</div>',
          verticalAlign: 'top',
          horizontalAlign: 'center'
        });
    @endforeach
    });
  </script>
</head>
<body>
<div class="container">
  <div class="row">
    <div class="row">
      <div class="span11">
        <div id="map" style="height:500px;"></div>
      </div>
      <br>
      
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU"></script>
  </div>
</div>

<!-- <script>
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
</script> -->
@endsection
