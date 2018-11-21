@extends('layouts.leheader')
@section('content')


@if($deliveryDetails == null)
<div class="col-md-6 col-md-offset-3">
  <div class="panel panel-primary">
    <div class="panel-heading">Delivery Details</div>
    <div class="panel-body">
      <form action="{{ URL::to('/') }}/saveSignature" id="saveSign" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
        <input type="text" class="hidden" id="sign2" name="sign">
        <label for="orderId">Order Id</label>
        <p>{{ $_GET['orderId'] }}</p>
        <input type="hidden" name="orderId" value="{{ $_GET['orderId'] }}">
        <label for="vehicleNo">Vehicle No</label>
        <input required type="file" name="vno" id="vehicleNo" class="form-control">
        <label for="locationPicture">Location Picture</label>
        <input required type="file" name="lp" id="locationPicture" class="form-control">
        <label for="quality">Quality</label>
        <input required type="file" name="qm" id="quality" class="form-control">
        <label for="signature-pad">Signature</label>
        <div id="signature-pad" class="signature-pad">
          <div class="signature-pad--body">
            <canvas></canvas>
          </div>
          <div class="signature-pad--footer">
        
            <div class="signature-pad--actions">
              <div>
                <button type="button" class="button clear" data-action="clear">Clear</button>
                <button type="button" class="button hidden" data-action="change-color">Change color</button>
                <button type="button" class="button hidden" data-action="undo">Undo</button>
        
              </div>
              <div>
                <button type="button" class="button save hidden" data-action="save-png">Save as PNG</button>
                <button type="button" class="button save btn btn-success form-control" data-action="save-jpg">Save Details</button>
                <button type="button" class="button save hidden" data-action="save-svg">Save as SVG</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

</div>
@else
<div class="col-md-6 col-md-offset-3">
  
  <div class="panel panel-primary">
    <div class="panel-heading">Delivery Details</div>
    <div class="panel-body">

      <div class="col-md-4">
        <div class="thumbnail">
          <a href="{{ URL::to('/') }}/delivery_details/{{ $deliveryDetails->vehicle_no }}">
            <img src="{{ URL::to('/') }}/delivery_details/{{ $deliveryDetails->vehicle_no }}" alt="Fjords" style="width:100%">
            <div class="caption">
              <p>Vehicle No</p>
            </div>
          </a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="thumbnail">
          <a href="{{ URL::to('/') }}/delivery_details/{{ $deliveryDetails->location_picture }}">
            <img src="{{ URL::to('/') }}/delivery_details/{{ $deliveryDetails->location_picture }}" alt="Fjords" style="width:100%">
            <div class="caption">
              <p>Location</p>
            </div>
          </a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="thumbnail">
          <a href="{{ URL::to('/') }}/delivery_details/{{ $deliveryDetails->quality_of_material }}">
            <img src="{{ URL::to('/') }}/delivery_details/{{ $deliveryDetails->quality_of_material }}" alt="Fjords" style="width:100%">
            <div class="caption">
              <p>Quality Of Material</p>
            </div>
          </a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="thumbnail">
          <a href="{{ $deliveryDetails->signature }}">
            <img src="{{ $deliveryDetails->signature }}" alt="Fjords" width="400" height="400">
            <div class="caption">
              <p>Signature</p>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@endsection