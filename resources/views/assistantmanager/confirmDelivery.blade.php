@extends('layouts.logisticslayout')
@section('content')
<form method="POST" action="{{ URL::to('/') }}/confirmDelivery">
    {{ csrf_field() }}
    <input type="hidden" value="{{ $project->project_id }}" name="projectId">
    <input type="hidden" value="{{ $requirement->id }}" name="requiremntId">
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-danger">
            <div class="panel-heading">Order Details <b class="pull-right"><a class="btn btn-sm btn-danger" href="{{url()->previous()}}">Back</a></b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">Customer Name</div>
                    <div class="col-md-8"><input type="text" name="customerName" class="form-control input-sm" value="{{ $project->ownerdetails->owner_name != NULL?$project->ownerdetails->owner_name:$project->procurementdetails->procurement_name }}"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Delivery Location</div>
                    <div class="col-md-8"><input type="text" name="location" class="form-control input-sm" value="{{ $project->siteaddress->address }}"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Sub Ward</div>
                    <div class="col-md-8"><input name="subward" type="text" class="form-control input-sm" readonly value="{{ $subward }}"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Amount Received</div>
                    <div class="col-md-8"><input name="amount" type="text" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Receive Date</div>
                    <div class="col-md-8"><input name="rDate" type="date" class="form-control input-sm"></div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">Payment Method</div>
                    <div class="col-md-8">
                        <select name="paymentMethod" class="form-control">
                            <option value="">--Select--</option>
                            <option>Cash On Delivery</option>
                            <option>Cheque</option>
                        </select>    
                    </div>
                </div><br>
                <!--<div class="row">-->
                <!--    <div class="col-md-4">Transaction No.</div>-->
                <!--    <div class="col-md-8"><input name="transactionNo" type="text" class="form-control input-sm"></div>-->
                <!--</div>-->
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-6"><input type="submit" class="btn btn-success form-control" value="Save"></div>
                    <div class="col-md-6"><input type="reset" class="btn btn-danger form-control pull-right" value="Clear"></div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
</form>
@endsection