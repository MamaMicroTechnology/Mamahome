<?php
    $group = Auth::user()->group->group_name;
    if($group == "Auditor"){
        $content = "auditor.layout.auditor";
    }else{
        $content = "layouts.app";
    }
?>
@extends($content)
@section('content')

    <div class="col-md-4 col-md-offset-2">
        <div class="panel panel-success">
            <div class="panel-heading">Bulk Cement</div>
            <div class="panel-body">
                <form action="{{ URL::to('/') }}/bulkBusiness" method="get">
                    <table class="table">
                        <tr>
                            <td>Dates</td>
                            <td>:</td>
                            <td><input value="{{ isset($_GET['dates']) ? $_GET['dates'] : '' }}" placeholder="Select Dates" type="text" name="dates" id="dates" class="form-control date"></td>
                        </tr>
                        <tr>
                            <td>Ward</td>
                            <td>:</td>
                            <td>
                                <select name="wards" id="wards" class="form-control">
                                    <option value="">--Select--</option>
                                    <option {{ isset($_GET['wards']) ? $_GET['wards'] == "All" ? 'selected' : '' : ''}} value="All">All</option>
                                    @foreach($wards as $ward)
                                    <option {{ isset($_GET['wards']) ? $_GET['wards'] == $ward->id ? 'selected' : '' : ''}} value="{{ $ward->id }}">{{ $ward->ward_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Type</td>
                            <td>:</td>
                            <td>
                                <select name="type" id="type" class="form-control">
                                    <option value="">--Select--</option>
                                    <option {{ isset($_GET['type']) ? $_GET['type'] == "RMC" ? 'selected' : '' : '' }} value="RMC">RMC</option>
                                    <option {{ isset($_GET['type']) ? $_GET['type'] == "Blocks" ? 'selected' : '' : '' }} value="Blocks">Blocks</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td>:</td>
                            <td><input value="{{ isset($_GET['price']) ? $_GET['price'] : '' }}" placeholder="Input Price" type="text" name="price" id="price" class="form-control"></td>
                        </tr>
                        <tr>
                            <td colspan=3><button type="submit" class="btn btn-success form-control">Proceed</button></td>
                        </tr>
                    </table>
                </form>
                @if(isset($_GET['price']))
                <table class="table table-hover">
                    <tr>
                        <td>Monthly Target</td>
                        <td>:</td>
                        <td><input type="text" placeholder="Monthly Target" name="monthly_target" id="monthly_target" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan=3><button type="button" onclick="monthly_target(document.getElementById('monthly_target').value)" class="form-control btn btn-success">Proceed</button></td>
                    </tr>
                    <tr id="bags_tr" class="hidden">
                        <td>Bulks</td>
                        <td>:</td>
                        <td id="bags"></td>
                    </tr>
                    <tr id="amount_tr" class="hidden">
                        <td>Amount</td>
                        <td>:</td>
                        <td id="amount"></td>
                    </tr>
                    <tr id="transactional_profit_tr" class="hidden">
                        <td>Transactional Profit</td>
                        <td>:</td>
                        <td><input type="text" placeholder="Transactional Profit" name="transactional_profit" id="transactional_profit" class="form-control"></td>
                    </tr>
                    <tr id="tp_button" class="hidden">
                        <td colspan=3><button onclick="transactional_profit(document.getElementById('transactional_profit').value)" class="form-control btn btn-success">Proceed</button></td>
                    </tr>
                    <tr id="transactional_tr" class="hidden">
                        <td>Transactional Profit</td>
                        <td>:</td>
                        <td id="tp"></td>
                    </tr>
                    <tr id="lock" class="hidden">
                        <td colspan=3><button onclick="lock_target()" class="form-control btn btn-primary">Lock Target</button></td>
                    </tr>
                </table>
                @endif
            </div>
        </div>
    </div>
    @if(isset($_GET['price']))
    <div class="col-md-6">
        <div class="panel panel-danger">
            <div class="panel-heading">Projection</div>
            <div class="panel-body">
                <table class="table table-hover">
                    <tr>
                        <th class="text-center">Manufacturer Type</th>
                        <th class="text-center">Number of Manufacturers</th>
                        <th class="text-center">Total Cement Requirement<br>(Per Day)</th>
                        <th class="text-center">Amount</th>
                    </tr>
                    <tr class="text-center">
                        <td>Bulk Cement For {{ $type }}</td>
                        <td>{{ $rmcManufacturerCount }}</td>
                        <td>
                            @if($type == "RMC")
                                {{ number_format($rmc = 340 * $rmcManufacturerCount) }}
                            @else
                                {{ number_format($rmc = 100 * $rmcManufacturerCount) }}
                            @endif
                        </td>
                        <td>{{ number_format($rmcPrice = $rmc * $_GET['price']) }}</td>
                    </tr>
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center">Monthly Requirement</th>
                        <th class="text-center" id="monthly_requirement">{{ number_format($monthly = ($rmc) * 22) }}</th>
                        <th class="text-center" id="monthly_requirement_amount">{{ number_format($monthly_amount = $monthly * 22) }}</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @endif
@if($errors->has('type'))
<script>
    swal("Error","Please select the type of manufacturer","error");
</script>
@endif

@if(session('success'))
<script>
    swal("Success","{{ session('success') }}",'success');
</script>
@endif
@if(isset($_GET['price']))
<form action="{{ URL::to('/') }}/saveBulk" id="saveProjection" method="post">
{{ csrf_field() }}
<input type="hidden" id="mType" name="type">
<input type="hidden" id="monthlyTarget" name="monthly_target">
<input type="hidden" id="transactionalProfit" name="transactional_profit">
<input type="hidden" id="monthlyRequirement" name="monthly_requirement">
<input type="hidden" id="monthlyAmount" name="monthly_amount">
<input type="hidden" name="sub_ward_id" value="{{ $_GET['wards'] }}">
<input type="hidden" name="number_of_manufacturer" value="{{ $rmcManufacturerCount }}">
<input type="hidden" id="price2" value="{{ $_GET['price'] }}" name="price">
<input type="hidden" name="dates" value="{{ $_GET['dates'] }}">
</form>
<script>
    var bags, amount;
    function monthly_target(arg){
        if(arg != ""){
            document.getElementById('bags_tr').className = "";
            document.getElementById('amount_tr').className = "";
            document.getElementById('transactional_profit_tr').className = "";
            document.getElementById('tp_button').className = "";
            bags = Math.round({{ $monthly }} / 100 * arg);
            amount = Math.round({{ $monthly_amount }} / 100 * arg);
            document.getElementById('bags').innerHTML = bags.toLocaleString();
            document.getElementById('amount').innerHTML = amount.toLocaleString();
        }else{
            swal("Error","Enter Monthly Target","error");
        }
    }
    function transactional_profit(arg){
        if(arg != ""){
            document.getElementById('transactional_tr').className = "";
            document.getElementById('lock').className = "";
            var transactional_profit = Math.round(amount / 100 * arg);
            document.getElementById("tp").innerHTML = transactional_profit.toLocaleString();
        }else{
            swal("Error","Enter Transactional Profit","error");
        }
    }
    function lock_target(){
        document.getElementById('mType').value = "{{ $type }}";
        document.getElementById('monthlyTarget').value = document.getElementById('monthly_target').value;
        document.getElementById('transactionalProfit').value = document.getElementById('transactional_profit').value;
        document.getElementById('monthlyRequirement').value = "{{ $monthly}}";
        document.getElementById('monthlyAmount').value = "{{ $monthly_amount }}";

        document.getElementById('saveProjection').submit();
    }
</script>
@endif
@endsection