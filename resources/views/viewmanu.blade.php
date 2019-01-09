<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 4? "layouts.amheader":"layouts.app");
?>
@extends($ext)
@section('content')
    <div class="col-md-12">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary" style="overflow-x:scroll">
                <div class="panel-heading text-center">
                    <b style="color:white;font-size:1.4em">Manufacturer Details</b>
                    <a href="{{ URL::to('/') }}/updateManufacturerDetails?id={{ $project->id }}" class="btn btn-warning btn-sm pull-right">Edit</a>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive table-striped table-hover">
                    <tbody>
                        <tr>
                            <td style="width:40%"><b>Listed On: </b></td>
                            
                            <td>{{ date('d-m-Y h:i:s A',strtotime($project->created_at)) }}</td>
                        </tr>
                       
                         @if(Auth::check())
                        @if(Auth::user()->department_id != 2)
                        <tr>
                            <td><b>Listed By : </b></td>
                            <td>
                                {{ $project->user != null ? $project->user->name : '' }}
                            </td>
                        </tr>
                       <!--  <tr>
                            <td style="width:40%"><b>Call Attended By : </b></td>
                            <td>{{ $project->user != null ? $project->user->name : '' }}</td>
                        </tr> -->
                        @endif
                        @endif
                        <tr>
                            <td><b>Updated By : </b></td>
                            <td>
                                {{ $project->user1 != null ? $project->user1->name : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:40%"><b>Last Updated On : </b></td>
                            <td>{{ date('d-m-Y h:i:s A',strtotime($project->updated_at)) }}</td>
                        </tr>
                        
                        <tr>
                            <td><b>Plant Name : </b></td>
                            <td>{{ $project->plant_name }}</td>
                        </tr>
                        <tr>
                            <td><b>Manufacturer Type: <b></td>
                            <td>{{ $project->manufacturer_type }}</td>
                        </tr>
                        <tr>
                            <td><b>Manufacturer Quality: <b></td>
                            <td>{{ $project->quality }}</td>
                        </tr>
                         <tr>
                            <td><b>Manufacturer Capacity: <b></td>
                            <td>{{ $project->capacity }}</td>
                        </tr>
                          <tr>
                            <td><b>Manufacturer Cement Requirement : <b></td>
                            <td>{{ $project->cement_requirement  }}</td>
                        </tr>
                          <tr>
                            <td><b>Manufacturer Prefered Cement Brands : <b></td>
                            <td>{{ $project->prefered_cement_brand   }}</td>
                        </tr>
                         <tr>
                            <td><b>Manufacturer Sample Request : <b></td>
                            <td>{{ $project->sample   }}</td>
                        </tr>
                            
                       <tr>
                            <td><b>Address : </b></td>
                            <td>
                                <a target="_blank" href="https://maps.google.com?q={{$project->address }}">{{$project->address}}</a>
                            </td>
                        </tr>
                      
                        <tr>
                            <td style="width:40%"><b>Sub-ward : </b></td>
                            <td><a href="{{ URL::to('/')}}/viewsubward?manu_id={{$project->id}} && subward={{ $project->subward != null ?$project->subward->sub_ward_name:'' }}" data-toggle="tooltip" data-placement="top" title="click here to view map" class="red-tooltip" target="_blank">{{ $project->subward != null?$project->subward->sub_ward_name:'' }}
                                    </a>
                                 
                                  <?php 
                                $sub = App\Manufacturer::where('id',$project->id)->pluck('latitude')->first();
                                $subs = App\Manufacturer::where('id',$project->id)->pluck('longitude')->first();
                                
                                ?> 
    <form  action="{{ URL::to('/') }}/findmanuward" method="post">
        {{ csrf_field() }}
<div>
  <input type="hidden" name="lat" id="lat" class="form-control" value="{{$sub}}" placeholder="lat">
  <input type="hidden" name="lat" id="log" class="form-control" value="{{$subs}}"  placeholder="long">
  <input type="hidden" name="manusubidfind" id="manusubid" value="">
  <input type="hidden" name="projectid" value="{{$project->id}}">
  <button onclick="initMap()" type="submit">Get Subward</button>
</div>
    </form>  



 

                                </td>
                        </tr>
                       
                       
                       <tr> 
                            <td><b>Total_Area  : </b></td>
                            <td>
                                {{ $project->total_area  }}  
                            </td>
                        </tr>
                       
                        <tr>
                            <td><b>Project Image : </b></td>
                            <td>
                               <?php
                                               $images = explode(",", $project->image);
                                               ?>
                                             <div class="row">
                                                 @for($i = 0; $i < count($images); $i++)
                                                     <div class="col-md-3">
                                                          <img height="350" width="350"  src="{{ URL::to('/') }}/public/Manufacturerimage/{{ $images[$i] }}" class="img img-thumbnail">
                                                     </div>
                                                 @endfor
                                              </div>
                            </td>
                            </td>
                        </tr>
                        
                        <tr>
                            <td><b>Remarks : </b></td>
                            <td>
                                {{ $project->remarks }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default" style="border-color:green">
            <div class="panel-heading" style="background-color:green">
               <b style="color:white">Owner Details</b> 
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <th>Owner Name</th>
                        <th>Owner Contact</th>
                        <th>Owner Email</th>
                    </thead>
                    <tbody>
                        <tr>
                             <td>{{ $project->owner != null ? $project->owner->name : '' }}</td>
                              <td>{{ $project->owner != null ? $project->owner->contact : '' }}</td>
                           <td>{{ $project->owner != null ? $project->owner->email : '' }}</td>
                           
                        </tr>
                    </tbody>
                </table>        
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default" style="border-color:orange">
            <div class="panel-heading" style="background-color:orange">
               <b style="color:white">Manager Details</b> 
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <th>Manager Name</th>
                         <th>Manager Contact</th>
                         <th>Manager Email</th>
                    </thead>    
                    <tbody>
                        <tr>
                            <td>{{ $project->Manager != null ? $project->Manager->name : '' }}</td>
                            <td>{{ $project->Manager != null ? $project->Manager->contact: '' }}</td>
                            <td>{{ $project->Manager != null ? $project->Manager->email : '' }}</td>
                        </tr>
                    </tbody>
                </table>        
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default" style="border-color:green">
            <div class="panel-heading" style="background-color:green">
               <b style="color:white">Sales Engineer Details</b> 
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <th>Sales Engineer Name</th>
                       <th>Sales Engineer Contact</th>
                       <th>Sales Engineer Email</th>
                    </thead>    
                    <tbody>
                        <tr>
                            <td>{{ $project->sales != null ? $project->sales->name : '' }}</td>
                              <td>{{ $project->sales != null ? $project->sales->contact : '' }}</td>
                            <td>{{ $project->sales != null ? $project->sales->email : '' }}</td>
                        </tr>
                    </tbody>
                </table>        
            </div>
        </div>
    </div>
</div> 
<div class="col-md-12">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default" style="border-color:green">
            <div class="panel-heading" style="background-color:green">
               <b style="color:white">Procurement Details</b> 
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <th>Procurement Name</th>
                        <th>Procurement Contact</th>
                        <th>Procurement Email</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $project->proc != null ? $project->proc->name : '' }}</td>
                            <td>{{ $project->proc != null ? $project->proc->contact : '' }}</td>
                            <td>{{ $project->proc != null ? $project->proc->email : '' }}</td>
                        </tr>
                    </tbody>
                </table>        
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
     background-color: #00acd6 

});
</script> 
<script type="text/javascript">
  
    function initMap() {

      var x = document.getElementById("lat");
          var lat = x.value;
        var y = document.getElementById("log");
        var long = y.value;
     
      var latitude = lat;
      var longitude = long;
      var faultyward = "{{json_encode($ward)}}";
      var ward = faultyward.split('&quot;,&quot;').join('","');
      ward = ward.split('&quot;').join('"');

      var ss = JSON.parse(ward);
      var shouldAlert;
      for(var i=0; i<Object(ss['original'].length); i++){
        
        var finalward = [];
        finalward = ss['original'][i]['lat'].map(s => eval('null,' +s ));

       var bermudaTriangle = new google.maps.Polygon({paths: finalward});  
        var locat = new google.maps.LatLng(latitude,longitude);
       shouldAlert = google.maps.geometry.poly.containsLocation(locat, bermudaTriangle);

              
               if(shouldAlert == true){

                      getBrands(ss['original'][i]['ward']);
                          break;

                }
           
      }
      if(shouldAlert == false){
        alert("not serviceable area");
      }
  }
function getBrands(arg){
    const Http = new XMLHttpRequest();
    var x = arg;
  
  const url='{{URL::to('/')}}/subfind?id='+x;
   Http.open("GET", url);
   Http.send();

Http.onreadystatechange=(e)=>{
              

           initsubward(Http.responseText);
            
            
            }
  

  }

  function initsubward(arg){
       var x = document.getElementById("lat");
          var lat = x.value;
        var y = document.getElementById("log");
        var long = y.value;


      var latitude = lat;
      var longitude = long;

     
        var subfaulty = arg;
      //console.log(subfaulty);
      /*
      var subward = subfaulty.split('&quot;,&quot;').join('","');
     
      subward = subward.split('&quot;').join('"');*/

      var subs = JSON.parse(subfaulty);

     // console.log(subs.length);


      for(var i=0; i<Object(subs.length); i++){
        
        var finalsubward = [];
        finalsubward = subs[i]['lat'].map(s => eval('null,' +s ));

       var bermudaTriangle = new google.maps.Polygon({paths: finalsubward});  
        var locat = new google.maps.LatLng(latitude,longitude);
       var shouldAlert = google.maps.geometry.poly.containsLocation(locat, bermudaTriangle);

              
               if(shouldAlert == true){
                        // alert(subs[i]['subward']);
                        var m = subs[i]['subward'];
                       document.getElementById('manusubid').value = m;


                }

           
      }
      


  }
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU&libraries=geometry&callback=initMap"></script>
  <script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
@endsection    
