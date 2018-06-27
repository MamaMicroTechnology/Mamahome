@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default" style="border-color:green">
                <div class="panel-heading" style="color:white;background-color:green">Zones
                    @if(session('ErrorZone'))
                        <div class="alert-danger pull-right">{{ session('ErrorZone' )}}</div>
                    @endif 
                </div>
                <div class="panel-body" style=" height: 500px; max-height: 500px; overflow-y:scroll; overflow-x: hidden;">
        
                        <table class="table">
                            <thead>       
                                    <th style="padding-left: 50px;">Zone Name</th>
                                    <th style="padding-right: 50px;">Zone No</th>
                                    <th  >Zone Map</th>   
                            </thead>
                            <tbody>
                                    @foreach($zones as $zone)
                                        <tr>
                                           <td style="text-align: left;padding-left:70px">{{ $zone->zone_name }}</td>
                                            <td >{{ $zone->zone_number }}</td>
                                            <td ><a href="{{ URL::to('/')}}/viewMap?zoneId={{ $zone->id}}"  target="_blank">View image</a></td>
                                        </tr>
                                    @endforeach
                            </tbody>
                              
                        </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            
            <div class="panel panel-default" style="border-color: green">
                <div class="panel-heading" style="color:white;background-color: green">Main Wards</div>
                <div class="panel-body" style=" height: 500px; max-height: 500px; overflow-y:scroll; overflow-x: hidden;">
                    <table class="table">
                        <thead>
                            <th style="text-align: center;">Ward Name</th>
                            <th style="text-align: center;">Ward Image and Map</th>
                        </thead>
                        <tbody>
                            @foreach($wards as $ward)
                            <tr>
                                <td style="text-align: center;">{{ $ward->ward_name }}</td>
                                <td style="text-align: center;"><a href="{{ URL::to('/')}}/public/wardImages/{{ $ward->ward_image }}"> click here to Image</a></td>
                            </tr>
                             <td>
                                
                                <td style="text-align: center;"><a href="{{ URL::to('/') }}/viewMap?wardId={{ $ward->id }}" class="btn btn-sm btn-primary" target="_blank"> click here to View Map</a></td>
                            </td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
