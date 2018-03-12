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
         <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/listingEngineer">Add New Project</a><br><br>
         <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/roads">Update Project</a><br><br>
         <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/requirementsroads">Project Enquiry</a><br><br>
         <a class="btn btn-primary form-control" href="{{ URL::to('/')}}/reports">My Report</a><br><br>
         <a href="{{ URL::to('/') }}/kra" class="form-control btn btn-primary">KRA</a><br><br>
         <label>
           You have listed <strong>{{ $numbercount }}</strong> projects so far.<br>
           You have listed {{ $total }} projects today.<br>
           {{ $ordersInitiated }} orders has been initiated by you<br>
           out of which {{ $ordersConfirmed }} has been confirmed
         </label><br><br>
            <center></center>
            <div class="panel-panel-primary">
                <div class="panel-heading text-center">
                    <!--<b><u>CURRENT PRICE LIST</u></b>-->
                </div>
                <div class="panel-body">

                            
                </div>
            </div>
            
       </div>
        <div class="pull-right col-lg-8">
          <img class="img-thumbnail" src="{{ URL::to('/') }}/public/subWardImages/{{ $subwards->sub_ward_image }}">
        </div>
       @else
       No wards assigned to you yet
       @endif
    </div>
</div>

<br><br>

<div class="col-md-8 col-md-offset-2" style="border-style: ridge;">
<div id="map" style="width:100%;height:400px"></div>
</div>

<script type="text/javascript" scr="https://maps.google.com/maps/api/js?sensor=false"></script>

  <script type="text/javascript">
    window.onload = function() {
    var locations = new Array();
    var created = new Array();
    var updated = new Array();
    var status = new Array();
    @foreach($projects as $project)
      locations.push(["<a href=\"https://maps.google.com/?q={{ $project->address }}\">{{$project->project_id}} {{$project->project_name}},{{ $project->address }}</a>",{{ $project->latitude}}, {{ $project->longitude }}]);
      created.push("{{ $project->created_at}}");
      updated.push("{{ $project->updated_at}}");
      status.push("{{ $project->status }}");
    @endforeach

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
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
        icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
      });
    }else{
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
        icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
      });
    }

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
  }
  </script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU&callback=myMap"></script>

<script>

</script>
@endif
@endsection