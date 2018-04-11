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
  <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal{{ $zone->id }}">Edit</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal{{ $zone->id }}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Zone</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ URL::to('/') }}/saveEdit" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $zone->id }}" name="zoneId" >
                            <table class="table">
                                <tr>
                                    <!--  -->
                                    <td><input type="text" name="zone_name" required class="form-control input-sm" value="{{ $zone->zone_name}}" ></td>
                                    <td><input type="text" name="zone_no" required class="form-control input-sm" value="{{ $zone->zone_number}}" ></td>

                                    <td>

                                         <input type="file" name="image" required class="form-control input-sm" accept="image/*" value="{{ $zone->zone_image }}" >
                                       @if($zone->zone_image!=NULL) 
                        <img  height="500" class="img img-responsive" width="500" src= "{{ URL::to('/') }}/public/zoneimages/{{ $zone->zone_image }}">

                                         @endif
                                     </td>


                                    <td><button type="submit" class="btn btn-success input-sm">Save</button></td>
                                </tr>
                            </table>
                        </form>



        </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Save</button>
        </div> -->
      </div>
      
    </div>
  </div>
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
                                <!--<td>-->
                                <!--    <select required name="state" class="input-sm form-control">-->
                                <!--        <option value="">--State--&nbsp;&nbsp;&nbsp;</option>-->
                                <!--        @foreach($states as $state)-->
                                <!--        <option value="{{ $state->id }}">{{ $state->state_name }}</option>-->
                                <!--        @endforeach-->
                                <!--    </select>-->
                                <!--</td>-->
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
                                        <!--<td><input type="file" name="wardimage{{$ward->id}}" onchange="editwardimage('{{$ward->id}}')" id="wardimage{{$ward->id}}" class="form-control" value="Edit Image" /></td>-->
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
                                            <td>
                                                <form method="POST" action="{{ URL::to('/') }}/editsubwardimage" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" value="{{ $ward->id }}" name="subwardId">
                                                    <input type="file" name="subwardimage" onchange="this.form.submit()" id="subwardimage{{$ward->id}}" class="form-control" accept="image/*" />
                                                </form>
                                            </td>
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
