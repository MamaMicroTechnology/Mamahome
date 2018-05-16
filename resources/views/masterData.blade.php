@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Countries</div>
                <div class="panel-body">
                    <form method="POST" action="{{ URL::to('/') }}/addCountry">
                        {{ csrf_field() }}
                        <table class="table">
                            <tr>
                                <td><input required type="text" class="form-control input-sm" name="code" placeholder="Code"></td>
                                <td><input required type="text" class="form-control input-sm" name="name" placeholder="Country Name"></td>
                                <td><input type="submit" class="btn btn-primary btn-sm" value="Add"></td>
                            </tr>
                        </table>
                    </form>
                    <table class="table">
                        <thead>
                            <th>Country Code</th>
                            <th>Country Name</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($countries as $country)
                                <tr>
                                    <td>{{ $country->country_code }}</td>
                                    <td>{{ $country->country_name }}</td>
                                    <td><button class="btn btn-sm btn-danger">Delete</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Zones
                    @if(session('ErrorZone'))
                        <div class="alert-danger pull-right">{{ session('ErrorZone' )}}</div>
                    @endif 
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ URL::to('/') }}/addZone" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <table class="table">
                                <tr>
                                    <td>
                                        <select class="form-control input-sm" name="sId" required="">
                                            <option value="">--Country--</option>
                                            @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" name="zone_name" required class="form-control input-sm" placeholder="Zone Name"></td>
                                    <td><input type="text" name="zone_no" required class="form-control input-sm" placeholder="Zone No."></td>
                                    <td><input type="file" name="image" required class="form-control input-sm" accept="image/*"></td>
                                    <td><button type="submit" class="btn btn-success input-sm">Add</button></td>
                                </tr>
                            </table>
                        </form>
                        <table class="table">
                            <thead>
                                <th>Country</th>
                                <th>Zone Name</th>
                                <th>Zone No</th>
                                <th>Zone Image</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach($zones as $zone)
                                    <tr>
                                        <td>{{ $zone->country->country_name }} </td>
                                        <td>{{ $zone->zone_name }}</td>
                                        <td>{{ $zone->zone_number }}</td>
                                        <td style="width:10%"><center><a href="{{ URL::to('/')}}/public/zoneimages/{{ $zone->zone_image}}" class="btn btn-sm btn-primary" target="_blank">View image</a></center></td>
                                        <td>
                                            <a href="{{ URL::to('/') }}/wardmaping?zoneId={{ $zone->id }}" class="btn btn-success btn-sm">Edit</a>
                                            </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Wards</div>
                <div class="panel-body">
                    <form method="POST" action="{{ URL::to('/') }}/addWard" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <table class="table">
                            <tr>
                                <td>
                                    <select name="country" required class="input-sm form-control">
                                        <option value="">--Country--</option>
                                        @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select required name="zone" class="input-sm form-control">
                                        <option value="">--Zone--&nbsp;&nbsp;&nbsp;</option>
                                        @foreach($zones as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->zone_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="text" name="name" required placeholder="Ward Name" class="form-control input-sm"></td>
                                <td><input type="file" name="image" required class="form-control input-sm" accept="image/*"></td>
                            </tr>
                        </table>
                        <button type="submit" class="form-control btn btn-success input-sm">Add</button>
                    </form>
                    <br>
                        <table class="table table-responsive">
                            <thead>
                                <th>Ward Name</th>
                                <th><center>Ward Image</center></th>
                                <th><center>Action</center></th>
                            </thead>
                            <tbody>
                                    @foreach($wards as $ward)
                                    <tr>
                                        <td style="width:20%">{{ $ward->ward_name }}</td>
                                        <td style="width:33%"><center><a href="{{ URL::to('/') }}/public/wardImages/{{ $ward->ward_image }}" class="btn btn-sm btn-primary" target="_blank">View Image</a></center></td>
                                        <td><a href="{{ URL::to('/') }}/wardmaping?wardId={{ $ward->id }}" class="btn btn-success btn-sm form-control">Edit</a></td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Sub Wards</div>
                <div class="panel-body" style=" height: 700px; max-height: 700px; overflow-y:scroll; overflow-x: hidden;">
                    <form method="POST" action="{{ URL::to('/') }}/addSubWard" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <table class="table table-responsive table-hover">
                            <tr>
                                <td>
                                    <select name="ward" required class="form-control input-sm">
                                        <option value="">Ward&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                        @foreach($wards as $ward)
                                            <option value="{{ $ward->id }}">{{ $ward->ward_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" name="name" required placeholder="Subward Name" class="form-control input-sm"></td>
                                <td><input type="file" name="image" required class="form-control input-sm" accept="image/*"></td>
                                <td><button type="submit" class="btn btn-success input-sm">Add</button></td>
                            </tr>
                        </table>
                    </form>
                        <table class="table table-responsive table-hover">
                            <thead>
                                <th>Subward Name</th>
                                <th><center>Ward Image</center></th>
                                <th><center>Action</center></th>
                            </thead>
                            <tbody>
                                    @foreach($subwards as $ward)
                                        <tr>
                                            <td style="width:20%">{{ $ward->sub_ward_name }}</td>
                                            <td style="width:33%"><center><a href="{{ URL::to('/')}}/public/subWardImages/{{ $ward->sub_ward_image}}" class="btn btn-sm btn-primary" target="_blank">View image</a></center></td>
                                            <td><a href="{{ URL::to('/') }}/wardmaping?subWardId={{ $ward->id }}" class="btn btn-success btn-sm form-control">Edit</a></td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function editwardimage(arg)
    {
        var photo = document.getElementById("wardimage"+arg);
        alert(photo);
        return false;
    }
</script>
@endsection
