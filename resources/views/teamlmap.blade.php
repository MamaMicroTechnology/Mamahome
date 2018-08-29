<div class="panel panel-default" style="border-color:#0e877f">
<div class="panel-heading" style="background-color:#0e877f;font-weight:bold;font-size:1.3em;color:white"></div>
<div class="panel-body" style="height:500px;max-height:500px">
  <b>Name : </b>{{ $name }}<br><br>
  @if($login != "None")
  @foreach($login as $login)
  <b>Field Login Time : </b>{{ $login->logintime }}<br><br>
  <b>Remark(Late Login) : </b>{{ $login->remark }}<br><br>
  <b>Logout :</b>{{ $login->logout }}<br><br>
  @endforeach
  @endif
    <br><br>
<div id="map" style="width:980PX;height:450px;overflow-y: hidden;overflow-x: hidden;"></div>
</div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<!-- <script type="text/javascript" scr="https://maps.google.com/maps/api/js?sensor=false"></script> -->

 @if($login != "None")
  <script type="text/javascript">
    function initMap() {
      @if($login != "None")
      var latitude = "{{ $login->latitude }}";
      var longitude = "{{ $login->longitude}}";
      @else 
            var latitude = "";
            var longitude = "";
      @endif
      
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 12.973317199999999, lng: 77.60892439999999},
          zoom: 17,
        });

        var triangleCoords = [
          {lat: 12.974057062456545, lng: 77.6079534283009},
          {lat: 12.974014570488526, lng: 77.60904159498637},
          {lat: 12.972807020809695, lng: 77.60931518030588},
          {lat: 12.972550873154397, lng: 77.60837640715067},
          {lat: 12.973847291229198, lng: 77.60796334696238}
        ];

        var bermudaTriangle = new google.maps.Polygon({paths: triangleCoords});

        // Construct the polygon.
        var Triangle = new google.maps.Polygon({
          paths: triangleCoords,
          strokeColor: '#FF0000',
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: '#FF0000',
          fillOpacity: 0.35
        });
        Triangle.setMap(map);
        
        window.onload = function(){
          var time = "{{ $login->logintime}}";
          var id = "Auth::user()->group_id";
          var locat = new google.maps.LatLng(latitude,longitude);
          var resultColor =
              google.maps.geometry.poly.containsLocation(locat, bermudaTriangle) ?
              'green' :
              'red';
          var resultPath =
              google.maps.geometry.poly.containsLocation(locat, bermudaTriangle) ?
              // A triangle.
              "m 0 -1 l 1 2 -2 0 z" :
              google.maps.SymbolPath.CIRCLE;
          var shouldAlert =
              google.maps.geometry.poly.containsLocation(locat, bermudaTriangle) ? 0 : 1;

          new google.maps.Marker({
            position: new google.maps.LatLng(latitude, longitude),
            map: map,
            icon: {
              path: resultPath,
              fillColor: resultColor,
              fillOpacity: .9,
              strokeColor: 'white',
              strokeWeight: .8,
              scale: 10
            }
          });
         var arg = "{{$login->id }}";
         var time = "{{$login->status}}";
          var id = "{{Auth::user()->group_id}}";
          if(id == 22){
              shouldAlert = 0;
          }
          if(time != "Pending"){
            shouldAlert = 0;
          }
          
          if(shouldAlert == 1 ){
                  swal({   title: "Attendance",   
                  text: "{{$name}} Logged Outside The Office.Is It a Permitted Login?",   
                  type: "warning",   
                  showCancelButton: true,   
                  confirmButtonColor: "#259e33", 
                  cancelButtonColor: "#DD6B55",   
                  confirmButtonText: "Approve",   
                  cancelButtonText: "Reject",   
                  closeOnConfirm: false,   
                  closeOnCancel: false }, 
                  function(isConfirm){   
                    if (isConfirm) 
                    {   
                      $.ajax({
                            type: 'GET',
                            url: "{{URL::to('/')}}/atapprove",
                            data: {id: arg},
                            async: false,
                            success: function(response){
                              swal("Thank You", "Attendance Approved", "success");  
                            }
                        });  
                    }else{
                            $.ajax({
                            type: 'GET',
                            url: "{{URL::to('/')}}/atreject",
                            data: {id: arg},
                            async: false,
                            success: function(response){
                              swal("Thank You", "Attendance Rejected", "error");  
                            }
                        });
                    }
                });
          }
        }
    }
  </script>
  @else
    <script type="text/javascript">
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 12.973317199999999, lng: 77.60892439999999},
          zoom: 17,
        });

        var triangleCoords = [
          {lat: 12.974057062456545, lng: 77.6079534283009},
          {lat: 12.974014570488526, lng: 77.60904159498637},
          {lat: 12.972807020809695, lng: 77.60931518030588},
          {lat: 12.972550873154397, lng: 77.60837640715067},
          {lat: 12.973847291229198, lng: 77.60796334696238}
        ];

        var bermudaTriangle = new google.maps.Polygon({paths: triangleCoords});

        // Construct the polygon.
        var Triangle = new google.maps.Polygon({
          paths: triangleCoords,
          strokeColor: '#FF0000',
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: '#FF0000',
          fillOpacity: 0.35
        });
        Triangle.setMap(map);
      }
  </script>
@endif
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU&libraries=geometry&callback=initMap"></script>