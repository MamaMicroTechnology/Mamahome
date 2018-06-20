@extends('layouts.leheader')
@section('content')

  @if($ldate < $lodate)
  <div>You are ahead of time.</div>
  @elseif($ldate > $outtime)
  <div>You are done for today. Take a rest.</div>
  @else

<div class="container">
    <div class="row">
      @if($subwards)
      <div class="col-md-3"> 
         You are in {{$subwards->sub_ward_name}}<br><br>
        @if(Auth::user()->group_id == 6 && Auth::user()->department_id == 1)
         <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/listingEngineer">Add New Project</a><br><br>
         <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/roads">Update Project</a><br><br>
         <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/requirementsroads">Project Enquiry</a><br><br>
         <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/reports">My Report</a><br><br>
         <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/lcoorders">Orders</a><br><br>
         <a href="{{ URL::to('/') }}/kra" class="form-control btn btn-primary">KRA</a><br><br>
         @elseif(Auth::user()->group_id == 1 && Auth::user()->department_id == 0)
         <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/listingEngineer">Add New Project</a><br><br>
         <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/roads">Update Project</a><br><br>
         <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/requirementsroads">Project Enquiry</a><br><br>
         <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/reports">My Report</a><br><br>
         <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/lcoorders">Orders</a><br><br>
         <a href="{{ URL::to('/') }}/kra" class="form-control btn btn-primary">KRA</a><br><br> 
        @elseif(Auth::user()->group_id == 11 && Auth::user()->department_id == 2)
          <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/accountlistingEngineer">Add New Project</a><br><br>
         <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/accountroads">Update Project</a><br><br>
         <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/accountrequirementsroads">Project Enquiry</a><br><br>
         <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/accountreports">My Report</a><br><br>
         <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/lcoorders">Orders</a><br><br>
        <a href="{{ URL::to('/') }}/kra" class="form-control btn btn-primary">KRA</a><br><br>
        <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/projectsUpdate" id="updates">Account Executive Projects</a><br><br>  
          @endif
         <table class="table table-responsive table-striped table-hover" style="border: 2px solid gray;">
          <tbody >
                <!-- <tr>
                  <td style="border: 1px solid gray;"> <label>Total Number of Projects Listed till nOw</label></td>
                  <td style="border: 1px solid gray;"><strong>{{ $numbercount }}</strong></td>
                </tr> -->
                <tr>
                  <td style="border: 1px solid gray;"> <label>Total Number of Projects Listed in previous month</label></td>
                  <td style="border: 1px solid gray;"><strong>{{ $lastmonth}}</strong></td>
                </tr>
                <tr>  
                  <td style="border: 1px solid gray;"><label>Total Number of Projects Listed Today</label></td>
                  <td style="border: 1px solid gray;"><strong>{{ $total }}</strong></td>
                </tr>
                <tr>
                  <td style="border: 1px solid gray;"><label>Enquiries Initiated </label></td>
                  <td style="border: 1px solid gray;"><strong>{{ $ordersInitiated }}</strong></td>
                </tr>
                <tr>
                  <td style="border: 1px solid gray;"><label>Enquiries Confirmed</label></td>
                  <td style="border: 1px solid gray;"><strong>{{ $ordersConfirmed }}<strong></td>
                </tr>
          </tbody>
        </table>
         @if(Auth::user()->group_id == 11 && Auth::user()->department_id == 2)
        <table class="table table-responsive table-striped table-hover" style="border: 2px solid gray;">
          <tbody >
                <!-- <tr>
                  <td style="border: 1px solid gray;"> <label>Total Number of Projects Listed till nOw</label></td>
                  <td style="border: 1px solid gray;"><strong>{{ $numbercount }}</strong></td>
                </tr> -->
                <tr>
                  <td style="border: 1px solid gray;"> <label>TOtal number of projects in {{$subwards->sub_ward_name}}</label></td>
                  <td style="border: 1px solid gray;"><strong>{{ $totalprojects}}</strong></td>
                </tr>
                <tr>  
                  <td style="border: 1px solid gray;"><label>Genuine Projects</label></td>
                  <td style="border: 1px solid gray;"><strong>{{ $genuineprojects }}</strong></td>
                </tr>
                <tr>
                  <td style="border: 1px solid gray;"><label>Unverified Projects</label></td>
                  <td style="border: 1px solid gray;"><strong>{{ $unverifiedprojects }}</strong></td>
                </tr>
                <tr>
                  <td style="border: 1px solid gray;"><label>Fake Projects</label></td>
                  <td style="border: 1px solid gray;"><strong>{{ $fakeprojects }}<strong></td>
                </tr>
          </tbody>
        </table>
        @endif
       </div>
        <div class="pull-right col-lg-8">
          <img class="img-thumbnail" src="{{ URL::to('/') }}/public/subWardImages/{{ $subwards->sub_ward_image }}">
        </div>
       @else
       No wards assigned to you yet
       @endif
    </div>
    <div class="row hidden">
      <div class="col-md-4 col-md-offset-4">
        <table class="table table-hover" border=1>
        <center><label for="Points">Your Points For Today</label></center>
          <thead>
            <th>Reason For Earning Point</th>
            <th>Point Earned</th>
          </thead>
          <tbody>
            @foreach($points_indetail as $points)
            <tr>
              <td>{!! $points->reason !!}</td>
              <td style="text-align: right">{{ $points->type == "Add" ? "+".$points->point : "-".$points->point }}</td>
            </tr>
            @endforeach
            <tr>
              <td style="text-align: right;"><b>Total</b></td>
              <td style="text-align: right">{{ $total }}</td>
            </tr>
          </tbody>
        </table>
        </div>
    </div>
</div>

<br><br>

<div class="col-md-8 col-md-offset-2" style="border-style: ridge;">
<div id="map" style="width:100%;height:400px"></div>
</div>

<script type="text/javascript" scr="https://maps.google.com/maps/api/js?sensor=false"></script>
@if(count($projects) == 0)
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

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: new google.maps.LatLng(12.9716, 77.5946),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();
   
    var marker, i;
    var subward = new google.maps.Polygon({
        paths:  newpat,
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
    @foreach($projects as $project)
      locations.push(["<a href=\"https://maps.google.com/?q={{ $project->address }}\">{{$project->project_id}} {{$project->project_name}},{{ $project->address }}</a>",{{ $project->latitude}}, {{ $project->longitude }}]);
      created.push("{{ $project->created_at}}");
      updated.push("{{ $project->updated_at}}");
      status.push("{{ $project->status }}");
    @endforeach

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: new google.maps.LatLng(locations[0][1], locations[0][2]),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) { 
    if(created[i] == updated[i]){
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
      });
    }else if(status[i] == "Order Confirmed"){
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
        icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png'
      });
    }else{
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
        icon: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png'
      });
    }

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
    if(newpath.length > 1){
    
      var subward = new google.maps.Polygon({
          paths: newpath,
          strokeColor: '#'+col,
          strokeOpacity: 0,
          strokeWeight: 2,
          fillColor: '#'+col,
          fillOpacity: 0.1
        });
    subward.setMap(map);
    }
  }
  </script>
@endif
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU&callback=myMap"></script>

<script>

</script>
@endif
@endsection
