@extends('layouts.app')
@section('content')
<?php
    $totalCementBags = 0;
    $totalCementPrice = 0;
    $totalSteel = 0;
    $totalSteelPrice = 0;
    $totalSand = 0;
    $totalSandPrice = 0;
    $totalAggregates = 0;
    $totalAggregatesPrice = 0;
?>
<div class="col-md-3">
    <label for="">Material Projection (Cement)</label>
    <form action="{{ URL::to('/') }}/projection" method="GET">
        <select required class="form-control" name="ward">
            <option value="">--Select--</option>
            <option value="All">All</option>
            @foreach($wards as $ward)
            <option value="{{ $ward->id}}" {{ $ward->id == $wardId? 'selected':'' }}>{{ $ward->ward_name }}</option>
            @endforeach
        </select><br>
        <input type="hidden" name="category" value="cement">
        <input required type="text" name="price" id="" placeholder="Price" class="form-control"><br>
        <input required value="{{ isset($_GET['bCycle']) ? $_GET['bCycle'] : '' }}" type="text" name="bCycle" id="" placeholder="Business Cycle" class="form-control"><br>
        <button class="btn btn-success form-control">Calculate</button>
    </form>   
<br>
    <table class="table table-hover" border=1>
        <thead>
            <th>Stages</th>
            <th>Total Bags Required</th>
            <th>Amount</th>
        </thead>
        @if(isset($_GET['price']) && isset($_GET['bCycle']))
        <?php
            $price = $_GET['price'];
            $bCycle = $_GET['bCycle'];
        ?>
        @endif
     @if($planningCount != NULL && (isset($_GET['category']) ? $_GET['category'] == "Home automation" : ""))
        <tbody>
            <tr>
                <td>Planning</td>
                <td>{{ number_format(($planningSize * 30)/30) }}</td>
                <?php $totalCementBags += (($planningSize * 30)/30); ?>
                <td>{{ number_format((($planningSize * 30)/30) * $price) }}</td>
                <?php $totalCementPrice += ((($planningSize * 30)/30) * $price); ?>
            </tr>
            <tr>
                <td>Digging</td>
                <td>{{ number_format(($diggingSize * 30)/30) }}</td>
                <?php $totalCementBags += (($diggingSize * 30)/30); ?>
                <td>{{ number_format((($diggingSize * 30)/30) * $price) }}</td>
                <?php $totalCementPrice += ((($diggingSize * 30)/30) * $price); ?>
            </tr>
            <tr>
                <td>Foundation</td>
                <td>{{ number_format(($foundationSize * 30)/30)}}</td>
                <?php $totalCementBags += (($foundationSize * 30)/30); ?>
                <td>{{ number_format(($foundationSize * 30)/30) * $price) }}</td>
                <?php $totalCementPrice += (($foundationSize * 30)/30) * $price); ?>
            </tr>
            <tr>
                <td>Pillars</td>
                <td>{{ number_format(($pillarsSize * 30)/30) }}</td>
                <?php $totalCementBags += (($pillarsSize * 30)/30); ?>
                <td>{{ number_format((($pillarsSize * 30)/30) * $price) }}</td>
                <?php $totalCementPrice += ((($pillarsSize * 30)/30) * $price); ?>
            </tr>
            <tr>
                <td>Walls</td>
                <td>{{ number_format(($wallsSize * 30)/30) }}</td>
                <?php $totalCementBags += (($wallsSize * 30)/30); ?>
                <td>{{ number_format((($wallsSize * 30)/30) * $price) }}</td>
                <?php $totalCementPrice += ((($wallsSize * 30)/30) * $price); ?>
            </tr>
            <tr>
                <td>Roofing</td>
                <td>{{ number_format(($roofingSize * 30)/30) }}</td>
                <?php $totalCementBags += (($roofingSize * 30)/30); ?>
                <td>{{ number_format((($roofingSize * 30)/30) * $price) }}</td>
                <?php $totalCementPrice += ((($roofingSize * 30)/30)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format((($enpSize * 30)/30) }}</td>
                <?php $totalCementBags += (($enpSize * 30)/30); ?>
                <td>{{ number_format((($enpSize * 30)/30) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 30)/30) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 30)/30)}}</td>
                <?php $totalCementBags += (($plasteringSize * 30)/30); ?>
                <td>{{ number_format((($plasteringSize * 30)/30) * $price) }}</td>
                <?php $totalCementPrice += ((($plasteringSize * 30)/30)) * $price); ?>
            </tr>
            <tr>
                <td>Flooring</td>
                <td>{{ number_format(($flooringSize * 30)/30) }}</td>
                <?php $totalCementBags += (($flooringSize * 30)/30); ?>
                <td>{{ number_format((($flooringSize * 30)/30) * $price) }}</td>
                <?php $totalCementPrice += ((($flooringSize * 30)/30) * $price); ?>
            </tr>
            <tr>
                <td>Carpentry</td>
                <td>{{ number_format(($carpentrySize * 30)/30) }}</td>
                <?php $totalCementBags += (($carpentrySize * 30)/30); ?>
                <td>{{ number_format(((($carpentrySize * 30)/30) * $price) }}</td>
                <?php $totalCementPrice += ((($carpentrySize * 30)/30) * $price); ?>
            </tr>
            <tr>
                <td>Paintings</td>
                <td>{{ number_format(($paintingSize * 30)/30) }}</td>
                <?php $totalCementBags += (($paintingSize * 30)/30); ?>
                <td>{{ number_format((($paintingSize * 30)/30) * $price) }}</td>
                <?php $totalCementPrice += ((($paintingSize * 30)/30) * $price); ?>
            </tr>
            <tr>
                <td>Fixtures</td>
                <td>{{ number_format(($fixturesSize * 30)/30) }}</td>
                <?php $totalCementBags += ((($fixturesSize * 30)/30)); ?>
                <td>{{ number_format(((($fixturesSize * 30)/30)) * $price) }}</td>
                <?php $totalCementPrice += (((($fixturesSize * 30)/30)) * $price); ?>
            </tr>
            <tr>
                <td>Completion</td>
                <td>{{ number_format((($completionSize * 30)/30)) }}</td>
                <?php $totalCementBags += ((($completionSize * 30)/30)); ?>
                <td>{{ number_format(((($completionSize * 30)/30)) * $price) }}</td>
                <?php $totalCementPrice += (((($completionSize * 30)/30)) * $price); ?>
            </tr>
            <tr>
                <th>Total</th>
                <th>{{ number_format($totalCementBags) }}</th>
                <th>{{ number_format($totalCementPrice) }}</th>
            </tr>
            <tr>
                <th>Monthly Requirement</th>
                <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
            </tr>
        </tbody>
        @endif
         @if($planningCount != NULL && (isset($_GET['category']) ? $_GET['category'] == "Fire safety" : ""))
        <tbody>
            <tr>
                <td>Planning</td>
                <td>{{ number_format(($planningSize * 100)/100) }}</td>
                <?php $totalCementBags += (($planningSize * 100)/100); ?>
                <td>{{ number_format((($planningSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($planningSize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Digging</td>
                <td>{{ number_format(($diggingSize * 100)/100) }}</td>
                <?php $totalCementBags += (($diggingSize * 100)/100); ?>
                <td>{{ number_format((($diggingSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($diggingSize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Foundation</td>
                <td>{{ number_format(($foundationSize * 100)/100)}}</td>
                <?php $totalCementBags += (($foundationSize * 100)/100); ?>
                <td>{{ number_format(($foundationSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += (($foundationSize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Pillars</td>
                <td>{{ number_format(($pillarsSize * 100)/100) }}</td>
                <?php $totalCementBags += (($pillarsSize * 100)/100); ?>
                <td>{{ number_format((($pillarsSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($pillarsSize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Walls</td>
                <td>{{ number_format(($wallsSize * 100)/100) }}</td>
                <?php $totalCementBags += (($wallsSize * 100)/100); ?>
                <td>{{ number_format((($wallsSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($wallsSize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Roofing</td>
                <td>{{ number_format(($roofingSize * 100)/100) }}</td>
                <?php $totalCementBags += (($roofingSize * 100)/100); ?>
                <td>{{ number_format((($roofingSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($roofingSize * 100)/100)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format((($enpSize * 100)/100) }}</td>
                <?php $totalCementBags += (($enpSize * 100)/100); ?>
                <td>{{ number_format((($enpSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 100)/100)}}</td>
                <?php $totalCementBags += (($plasteringSize * 100)/100); ?>
                <td>{{ number_format((($plasteringSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($plasteringSize * 100)/100)) * $price); ?>
            </tr>
            <tr>
                <td>Flooring</td>
                <td>{{ number_format(($flooringSize * 100)/100) }}</td>
                <?php $totalCementBags += (($flooringSize * 100)/100); ?>
                <td>{{ number_format((($flooringSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($flooringSize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Carpentry</td>
                <td>{{ number_format(($carpentrySize * 100)/100) }}</td>
                <?php $totalCementBags += (($carpentrySize * 100)/100); ?>
                <td>{{ number_format(((($carpentrySize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($carpentrySize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Paintings</td>
                <td>{{ number_format(($paintingSize * 100)/100) }}</td>
                <?php $totalCementBags += (($paintingSize * 100)/100); ?>
                <td>{{ number_format((($paintingSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($paintingSize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Fixtures</td>
                <td>{{ number_format(($fixturesSize * 100)/100) }}</td>
                <?php $totalCementBags += ((($fixturesSize * 100)/100)); ?>
                <td>{{ number_format(((($fixturesSize * 100)/100)) * $price) }}</td>
                <?php $totalCementPrice += (((($fixturesSize * 100)/100)) * $price); ?>
            </tr>
            <tr>
                <td>Completion</td>
                <td>{{ number_format((($completionSize * 100)/100)) }}</td>
                <?php $totalCementBags += ((($completionSize * 100)/100)); ?>
                <td>{{ number_format(((($completionSize * 100)/100)) * $price) }}</td>
                <?php $totalCementPrice += (((($completionSize * 100)/100)) * $price); ?>
            </tr>
            <tr>
                <th>Total</th>
                <th>{{ number_format($totalCementBags) }}</th>
                <th>{{ number_format($totalCementPrice) }}</th>
            </tr>
            <tr>
                <th>Monthly Requirement</th>
                <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
            </tr>
        </tbody>
        @endif

         @if($planningCount != NULL && (isset($_GET['category']) ? $_GET['category'] == "False Ceiling" : ""))
        <tbody>
            <tr>
                <td>Planning</td>
                <td>{{ number_format(($planningSize * 35)/35) }}</td>
                <?php $totalCementBags += (($planningSize * 35)/35); ?>
                <td>{{ number_format((($planningSize * 35)/35) * $price) }}</td>
                <?php $totalCementPrice += ((($planningSize * 35)/35) * $price); ?>
            </tr>
            <tr>
                <td>Digging</td>
                <td>{{ number_format(($diggingSize * 35)/35) }}</td>
                <?php $totalCementBags += (($diggingSize * 35)/35); ?>
                <td>{{ number_format((($diggingSize * 35)/35) * $price) }}</td>
                <?php $totalCementPrice += ((($diggingSize * 35)/35) * $price); ?>
            </tr>
            <tr>
                <td>Foundation</td>
                <td>{{ number_format(($foundationSize * 35)/35)}}</td>
                <?php $totalCementBags += (($foundationSize * 35)/35); ?>
                <td>{{ number_format(($foundationSize * 35)/35) * $price) }}</td>
                <?php $totalCementPrice += (($foundationSize * 35)/35) * $price); ?>
            </tr>
            <tr>
                <td>Pillars</td>
                <td>{{ number_format(($pillarsSize * 35)/35) }}</td>
                <?php $totalCementBags += (($pillarsSize * 35)/35); ?>
                <td>{{ number_format((($pillarsSize * 35)/35) * $price) }}</td>
                <?php $totalCementPrice += ((($pillarsSize * 35)/35) * $price); ?>
            </tr>
            <tr>
                <td>Walls</td>
                <td>{{ number_format(($wallsSize * 35)/35) }}</td>
                <?php $totalCementBags += (($wallsSize * 35)/35); ?>
                <td>{{ number_format((($wallsSize * 35)/35) * $price) }}</td>
                <?php $totalCementPrice += ((($wallsSize * 35)/35) * $price); ?>
            </tr>
            <tr>
                <td>Roofing</td>
                <td>{{ number_format(($roofingSize * 35)/35) }}</td>
                <?php $totalCementBags += (($roofingSize * 35)/35); ?>
                <td>{{ number_format((($roofingSize * 35)/35) * $price) }}</td>
                <?php $totalCementPrice += ((($roofingSize * 35)/35)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format((($enpSize * 35)/35) }}</td>
                <?php $totalCementBags += (($enpSize * 35)/35); ?>
                <td>{{ number_format((($enpSize * 35)/35) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 35)/35) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 35)/35)}}</td>
                <?php $totalCementBags += (($plasteringSize * 35)/35); ?>
                <td>{{ number_format((($plasteringSize * 35)/35) * $price) }}</td>
                <?php $totalCementPrice += ((($plasteringSize * 35)/35)) * $price); ?>
            </tr>
            <tr>
                <td>Flooring</td>
                <td>{{ number_format(($flooringSize * 35)/35) }}</td>
                <?php $totalCementBags += (($flooringSize * 35)/35); ?>
                <td>{{ number_format((($flooringSize * 35)/35) * $price) }}</td>
                <?php $totalCementPrice += ((($flooringSize * 35)/35) * $price); ?>
            </tr>
            <tr>
                <td>Carpentry</td>
                <td>{{ number_format(($carpentrySize * 35)/35) }}</td>
                <?php $totalCementBags += (($carpentrySize * 35)/35); ?>
                <td>{{ number_format(((($carpentrySize * 35)/35) * $price) }}</td>
                <?php $totalCementPrice += ((($carpentrySize * 35)/35) * $price); ?>
            </tr>
            <tr>
                <td>Paintings</td>
                <td>{{ number_format(($paintingSize * 35)/35) }}</td>
                <?php $totalCementBags += (($paintingSize * 35)/35); ?>
                <td>{{ number_format((($paintingSize * 35)/35) * $price) }}</td>
                <?php $totalCementPrice += ((($paintingSize * 35)/35) * $price); ?>
            </tr>
            <tr>
                <td>Fixtures</td>
                <td>{{ number_format(($fixturesSize * 35)/35) }}</td>
                <?php $totalCementBags += ((($fixturesSize * 35)/35)); ?>
                <td>{{ number_format(((($fixturesSize * 35)/35)) * $price) }}</td>
                <?php $totalCementPrice += (((($fixturesSize * 35)/35)) * $price); ?>
            </tr>
            <tr>
                <td>Completion</td>
                <td>{{ number_format((($completionSize * 0)/0)) }}</td>
                <?php $totalCementBags += ((($completionSize * 0)/0)); ?>
                <td>{{ number_format(((($completionSize * 0)/0)) * $price) }}</td>
                <?php $totalCementPrice += (((($completionSize * 0)/0)) * $price); ?>
            </tr>
            <tr>
                <th>Total</th>
                <th>{{ number_format($totalCementBags) }}</th>
                <th>{{ number_format($totalCementPrice) }}</th>
            </tr>
            <tr>
                <th>Monthly Requirement</th>
                <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
            </tr>
        </tbody>
        @endif



        @if($planningCount != NULL && (isset($_GET['category']) ? $_GET['category'] == "RMC" : ""))
        <tbody>
            <tr>
                <td>Planning</td>
                <td>{{ number_format(($planningSize * 0.06)/0.06) }}</td>
                <?php $totalCementBags += (($planningSize * 0.06)/0.06); ?>
                <td>{{ number_format((($planningSize * 0.06)/0.06) * $price) }}</td>
                <?php $totalCementPrice += ((($planningSize * 0.06)/0.06) * $price); ?>
            </tr>
            <tr>
                <td>Digging</td>
                <td>{{ number_format(($diggingSize * 0.06)/0.06) }}</td>
                <?php $totalCementBags += (($diggingSize * 0.06)/0.06); ?>
                <td>{{ number_format((($diggingSize * 0.06)/0.06) * $price) }}</td>
                <?php $totalCementPrice += ((($diggingSize * 0.06)/0.06) * $price); ?>
            </tr>
            <tr>
                <td>Foundation</td>
                <td>{{ number_format((($foundationSize * 0.06)/0.06)/100*65)}}</td>
                <?php $totalCementBags += ((($foundationSize * 0.06)/0.06)/100*65); ?>
                <td>{{ number_format((($foundationSize * 0.06)/0.06)/100*65) * $price) }}</td>
                <?php $totalCementPrice += ((($foundationSize * 0.06)/0.06)/100*65) * $price); ?>
            </tr>
            <tr>
                <td>Pillars</td>
                <td>{{ number_format((($pillarsSize * 0.06)/0.06)/100*35) }}</td>
                <?php $totalCementBags += ((($pillarsSize * 0.06)/0.06)/100*35); ?>
                <td>{{ number_format(((($pillarsSize * 0.06)/0.06)/100*35) * $price) }}</td>
                <?php $totalCementPrice += (((($pillarsSize * 0.06)/0.06)/100*35) * $price); ?>
            </tr>
            <tr>
                <td>Walls</td>
                <td>{{ number_format((($wallsSize * 0.06)/0.06)/100*35) }}</td>
                <?php $totalCementBags += ((($wallsSize * 0.06)/0.06)/100*35); ?>
                <td>{{ number_format(((($wallsSize * 0.06)/0.06)/100*35)* $price) }}</td>
                <?php $totalCementPrice += (((($wallsSize * 0.06)/0.06)/100*35) * $price); ?>
            </tr>
            <tr>
                <td>Roofing</td>
                <td>{{ number_format(($roofingSize * 0)/0) }}</td>
                <?php $totalCementBags += (($roofingSize * 0)/0); ?>
                <td>{{ number_format((($roofingSize * 0)/0) * $price) }}</td>
                <?php $totalCementPrice += ((($roofingSize * 0)/0)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format((($enpSize * 0)/0) }}</td>
                <?php $totalCementBags += (($enpSize * 0)/0); ?>
                <td>{{ number_format((($enpSize * 0)/0) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 0)/0) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 0)/0)}}</td>
                <?php $totalCementBags += (($plasteringSize * 0)/0); ?>
                <td>{{ number_format((($plasteringSize * 0)/0) * $price) }}</td>
                <?php $totalCementPrice += ((($plasteringSize * 0)/0)) * $price); ?>
            </tr>
            <tr>
                <td>Flooring</td>
                <td>{{ number_format(($flooringSize * 0)/0) }}</td>
                <?php $totalCementBags += (($flooringSize * 0)/0); ?>
                <td>{{ number_format((($flooringSize * 0)/0) * $price) }}</td>
                <?php $totalCementPrice += ((($flooringSize * 0)/0) * $price); ?>
            </tr>
            <tr>
                <td>Carpentry</td>
                <td>{{ number_format(($carpentrySize * 0)/0) }}</td>
                <?php $totalCementBags += (($carpentrySize * 0)/0); ?>
                <td>{{ number_format(((($carpentrySize * 0)/0) * $price) }}</td>
                <?php $totalCementPrice += ((($carpentrySize * 0)/0) * $price); ?>
            </tr>
            <tr>
                <td>Paintings</td>
                <td>{{ number_format(($paintingSize * 0)/0) }}</td>
                <?php $totalCementBags += (($paintingSize * 0)/0); ?>
                <td>{{ number_format((($paintingSize * 0)/0) * $price) }}</td>
                <?php $totalCementPrice += ((($paintingSize * 0)/0) * $price); ?>
            </tr>
            <tr>
                <td>Fixtures</td>
                <td>{{ number_format(($fixturesSize * 0)/0) }}</td>
                <?php $totalCementBags += ((($fixturesSize * 0)/0)); ?>
                <td>{{ number_format(((($fixturesSize * 0)/0)) * $price) }}</td>
                <?php $totalCementPrice += (((($fixturesSize * 0)/0)) * $price); ?>
            </tr>
            <tr>
                <td>Completion</td>
                <td>{{ number_format((($completionSize * 0)/0)) }}</td>
                <?php $totalCementBags += ((($completionSize * 0)/0)); ?>
                <td>{{ number_format(((($completionSize * 0)/0)) * $price) }}</td>
                <?php $totalCementPrice += (((($completionSize * 0)/0)) * $price); ?>
            </tr>
            <tr>
                <th>Total</th>
                <th>{{ number_format($totalCementBags) }}</th>
                <th>{{ number_format($totalCementPrice) }}</th>
            </tr>
            <tr>
                <th>Monthly Requirement</th>
                <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
            </tr>
        </tbody>
        @endif


        @if($planningCount != NULL && (isset($_GET['category']) ? $_GET['category'] == "Glasses and facades" : ""))
        <tbody>
            <tr>
                <td>Planning</td>
                <td>{{ number_format(($planningSize * 25)/25) }}</td>
                <?php $totalCementBags += (($planningSize * 25)/25); ?>
                <td>{{ number_format((($planningSize * 25)/25) * $price) }}</td>
                <?php $totalCementPrice += ((($planningSize * 25)/25) * $price); ?>
            </tr>
            <tr>
                <td>Digging</td>
                <td>{{ number_format(($diggingSize * 25)/25) }}</td>
                <?php $totalCementBags += (($diggingSize * 25)/25); ?>
                <td>{{ number_format((($diggingSize * 25)/25) * $price) }}</td>
                <?php $totalCementPrice += ((($diggingSize * 25)/25) * $price); ?>
            </tr>
            <tr>
                <td>Foundation</td>
                <td>{{ number_format(($foundationSize * 25)/25)}}</td>
                <?php $totalCementBags += (($foundationSize * 25)/25); ?>
                <td>{{ number_format(($foundationSize * 25)/25) * $price) }}</td>
                <?php $totalCementPrice += (($foundationSize * 25)/25) * $price); ?>
            </tr>
            <tr>
                <td>Pillars</td>
                <td>{{ number_format(($pillarsSize * 25)/25) }}</td>
                <?php $totalCementBags += (($pillarsSize * 25)/25); ?>
                <td>{{ number_format((($pillarsSize * 25)/25) * $price) }}</td>
                <?php $totalCementPrice += ((($pillarsSize * 25)/25) * $price); ?>
            </tr>
            <tr>
                <td>Walls</td>
                <td>{{ number_format(($wallsSize * 25)/25) }}</td>
                <?php $totalCementBags += (($wallsSize * 25)/25); ?>
                <td>{{ number_format((($wallsSize * 25)/25) * $price) }}</td>
                <?php $totalCementPrice += ((($wallsSize * 25)/25) * $price); ?>
            </tr>
            <tr>
                <td>Roofing</td>
                <td>{{ number_format(($roofingSize * 25)/25) }}</td>
                <?php $totalCementBags += (($roofingSize * 25)/25); ?>
                <td>{{ number_format((($roofingSize * 25)/25) * $price) }}</td>
                <?php $totalCementPrice += ((($roofingSize * 25)/25)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format((($enpSize * 25)/25) }}</td>
                <?php $totalCementBags += (($enpSize * 25)/25); ?>
                <td>{{ number_format((($enpSize * 25)/25) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 25)/25) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 25)/25)}}</td>
                <?php $totalCementBags += (($plasteringSize * 25)/25); ?>
                <td>{{ number_format((($plasteringSize * 25)/25) * $price) }}</td>
                <?php $totalCementPrice += ((($plasteringSize * 25)/25)) * $price); ?>
            </tr>
            <tr>
                <td>Flooring</td>
                <td>{{ number_format(($flooringSize * 25)/25) }}</td>
                <?php $totalCementBags += (($flooringSize * 25)/25); ?>
                <td>{{ number_format((($flooringSize * 25)/25) * $price) }}</td>
                <?php $totalCementPrice += ((($flooringSize * 25)/25) * $price); ?>
            </tr>
            <tr>
                <td>Carpentry</td>
                <td>{{ number_format(($carpentrySize * 25)/25) }}</td>
                <?php $totalCementBags += (($carpentrySize * 25)/25); ?>
                <td>{{ number_format(((($carpentrySize * 25)/25) * $price) }}</td>
                <?php $totalCementPrice += ((($carpentrySize * 25)/25) * $price); ?>
            </tr>
            <tr>
                <td>Paintings</td>
                <td>{{ number_format(($paintingSize * 25)/25) }}</td>
                <?php $totalCementBags += (($paintingSize * 25)/25); ?>
                <td>{{ number_format((($paintingSize * 25)/25) * $price) }}</td>
                <?php $totalCementPrice += ((($paintingSize * 25)/25) * $price); ?>
            </tr>
            <tr>
                <td>Fixtures</td>
                <td>{{ number_format(($fixturesSize * 25)/25) }}</td>
                <?php $totalCementBags += ((($fixturesSize * 25)/25)); ?>
                <td>{{ number_format(((($fixturesSize * 25)/25)) * $price) }}</td>
                <?php $totalCementPrice += (((($fixturesSize * 25)/25)) * $price); ?>
            </tr>
            <tr>
                <td>Completion</td>
                <td>{{ number_format((($completionSize * 0)/0)) }}</td>
                <?php $totalCementBags += ((($completionSize * 0)/0)); ?>
                <td>{{ number_format(((($completionSize * 0)/0)) * $price) }}</td>
                <?php $totalCementPrice += (((($completionSize * 0)/0)) * $price); ?>
            </tr>
            <tr>
                <th>Total</th>
                <th>{{ number_format($totalCementBags) }}</th>
                <th>{{ number_format($totalCementPrice) }}</th>
            </tr>
            <tr>
                <th>Monthly Requirement</th>
                <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
            </tr>
        </tbody>
        @endif  


         @if($planningCount != NULL && (isset($_GET['category']) ? $_GET['category'] == "HandRails" : ""))
        <tbody>
            <tr>
                <td>Planning</td>
                <td>{{ number_format(($planningSize * 50)/50) }}</td>
                <?php $totalCementBags += (($planningSize * 50)/50); ?>
                <td>{{ number_format((($planningSize * 50)/50) * $price) }}</td>
                <?php $totalCementPrice += ((($planningSize * 50)/50) * $price); ?>
            </tr>
            <tr>
                <td>Digging</td>
                <td>{{ number_format(($diggingSize * 50)/50) }}</td>
                <?php $totalCementBags += (($diggingSize * 50)/50); ?>
                <td>{{ number_format((($diggingSize * 50)/50) * $price) }}</td>
                <?php $totalCementPrice += ((($diggingSize * 50)/50) * $price); ?>
            </tr>
            <tr>
                <td>Foundation</td>
                <td>{{ number_format(($foundationSize * 50)/50)}}</td>
                <?php $totalCementBags += (($foundationSize * 50)/50); ?>
                <td>{{ number_format(($foundationSize * 50)/50) * $price) }}</td>
                <?php $totalCementPrice += (($foundationSize * 50)/50) * $price); ?>
            </tr>
            <tr>
                <td>Pillars</td>
                <td>{{ number_format(($pillarsSize * 50)/50) }}</td>
                <?php $totalCementBags += (($pillarsSize * 50)/50); ?>
                <td>{{ number_format((($pillarsSize * 50)/50) * $price) }}</td>
                <?php $totalCementPrice += ((($pillarsSize * 50)/50) * $price); ?>
            </tr>
            <tr>
                <td>Walls</td>
                <td>{{ number_format(($wallsSize * 50)/50) }}</td>
                <?php $totalCementBags += (($wallsSize * 50)/50); ?>
                <td>{{ number_format((($wallsSize * 50)/50) * $price) }}</td>
                <?php $totalCementPrice += ((($wallsSize * 50)/50) * $price); ?>
            </tr>
            <tr>
                <td>Roofing</td>
                <td>{{ number_format(($roofingSize * 50)/50) }}</td>
                <?php $totalCementBags += (($roofingSize * 50)/50); ?>
                <td>{{ number_format((($roofingSize * 50)/50) * $price) }}</td>
                <?php $totalCementPrice += ((($roofingSize * 50)/50)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format((($enpSize * 50)/50) }}</td>
                <?php $totalCementBags += (($enpSize * 50)/50); ?>
                <td>{{ number_format((($enpSize * 50)/50) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 50)/50) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 50)/50)}}</td>
                <?php $totalCementBags += (($plasteringSize * 50)/50); ?>
                <td>{{ number_format((($plasteringSize * 50)/50) * $price) }}</td>
                <?php $totalCementPrice += ((($plasteringSize * 50)/50)) * $price); ?>
            </tr>
            <tr>
                <td>Flooring</td>
                <td>{{ number_format(($flooringSize * 50)/50) }}</td>
                <?php $totalCementBags += (($flooringSize * 50)/50); ?>
                <td>{{ number_format((($flooringSize * 50)/50) * $price) }}</td>
                <?php $totalCementPrice += ((($flooringSize * 50)/50) * $price); ?>
            </tr>
            <tr>
                <td>Carpentry</td>
                <td>{{ number_format(($carpentrySize * 50)/50) }}</td>
                <?php $totalCementBags += (($carpentrySize * 50)/50); ?>
                <td>{{ number_format(((($carpentrySize * 50)/50) * $price) }}</td>
                <?php $totalCementPrice += ((($carpentrySize * 50)/50) * $price); ?>
            </tr>
            <tr>
                <td>Paintings</td>
                <td>{{ number_format(($paintingSize * 50)/50) }}</td>
                <?php $totalCementBags += (($paintingSize * 50)/50); ?>
                <td>{{ number_format((($paintingSize * 50)/50) * $price) }}</td>
                <?php $totalCementPrice += ((($paintingSize * 50)/50) * $price); ?>
            </tr>
            <tr>
                <td>Fixtures</td>
                <td>{{ number_format(($fixturesSize * 50)/50) }}</td>
                <?php $totalCementBags += ((($fixturesSize * 50)/50)); ?>
                <td>{{ number_format(((($fixturesSize * 50)/50)) * $price) }}</td>
                <?php $totalCementPrice += (((($fixturesSize * 50)/50)) * $price); ?>
            </tr>
            <tr>
                <td>Completion</td>
                <td>{{ number_format((($completionSize * 50)/50)) }}</td>
                <?php $totalCementBags += ((($completionSize * 50)/50)); ?>
                <td>{{ number_format(((($completionSize * 50)/50)) * $price) }}</td>
                <?php $totalCementPrice += (((($completionSize * 50)/50)) * $price); ?>
            </tr>
            <tr>
                <th>Total</th>
                <th>{{ number_format($totalCementBags) }}</th>
                <th>{{ number_format($totalCementPrice) }}</th>
            </tr>
            <tr>
                <th>Monthly Requirement</th>
                <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
            </tr>
        </tbody>
        @endif 


         @if($planningCount != NULL && (isset($_GET['category']) ? $_GET['category'] == "Furnitures" : ""))
        <tbody>
            <tr>
                <td>Planning</td>
                <td>{{ number_format(($planningSize * 100)/100) }}</td>
                <?php $totalCementBags += (($planningSize * 100)/100); ?>
                <td>{{ number_format((($planningSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($planningSize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Digging</td>
                <td>{{ number_format(($diggingSize * 100)/100) }}</td>
                <?php $totalCementBags += (($diggingSize * 100)/100); ?>
                <td>{{ number_format((($diggingSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($diggingSize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Foundation</td>
                <td>{{ number_format(($foundationSize * 100)/100)}}</td>
                <?php $totalCementBags += (($foundationSize * 100)/100); ?>
                <td>{{ number_format(($foundationSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += (($foundationSize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Pillars</td>
                <td>{{ number_format(($pillarsSize * 100)/100) }}</td>
                <?php $totalCementBags += (($pillarsSize * 100)/100); ?>
                <td>{{ number_format((($pillarsSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($pillarsSize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Walls</td>
                <td>{{ number_format(($wallsSize * 100)/100) }}</td>
                <?php $totalCementBags += (($wallsSize * 100)/100); ?>
                <td>{{ number_format((($wallsSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($wallsSize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Roofing</td>
                <td>{{ number_format(($roofingSize * 100)/100) }}</td>
                <?php $totalCementBags += (($roofingSize * 100)/100); ?>
                <td>{{ number_format((($roofingSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($roofingSize * 100)/100)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format((($enpSize * 100)/100) }}</td>
                <?php $totalCementBags += (($enpSize * 100)/100); ?>
                <td>{{ number_format((($enpSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 100)/100)}}</td>
                <?php $totalCementBags += (($plasteringSize * 100)/100); ?>
                <td>{{ number_format((($plasteringSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($plasteringSize * 100)/100)) * $price); ?>
            </tr>
            <tr>
                <td>Flooring</td>
                <td>{{ number_format(($flooringSize * 100)/100) }}</td>
                <?php $totalCementBags += (($flooringSize * 100)/100); ?>
                <td>{{ number_format((($flooringSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($flooringSize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Carpentry</td>
                <td>{{ number_format(($carpentrySize * 100)/100) }}</td>
                <?php $totalCementBags += (($carpentrySize * 100)/100); ?>
                <td>{{ number_format(((($carpentrySize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($carpentrySize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Paintings</td>
                <td>{{ number_format(($paintingSize * 100)/100) }}</td>
                <?php $totalCementBags += (($paintingSize * 100)/100); ?>
                <td>{{ number_format((($paintingSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($paintingSize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Fixtures</td>
                <td>{{ number_format(($fixturesSize * 100)/100) }}</td>
                <?php $totalCementBags += ((($fixturesSize * 100)/100)); ?>
                <td>{{ number_format(((($fixturesSize * 100)/100)) * $price) }}</td>
                <?php $totalCementPrice += (((($fixturesSize * 100)/100)) * $price); ?>
            </tr>
            <tr>
                <td>Completion</td>
                <td>{{ number_format((($completionSize * 100)/100)) }}</td>
                <?php $totalCementBags += ((($completionSize * 100)/100)); ?>
                <td>{{ number_format(((($completionSize * 100)/100)) * $price) }}</td>
                <?php $totalCementPrice += (((($completionSize * 100)/100)) * $price); ?>
            </tr>
            <tr>
                <th>Total</th>
                <th>{{ number_format($totalCementBags) }}</th>
                <th>{{ number_format($totalCementPrice) }}</th>
            </tr>
            <tr>
                <th>Monthly Requirement</th>
                <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
            </tr>
        </tbody>
        @endif 


         @if($planningCount != NULL && (isset($_GET['category']) ? $_GET['category'] == "Home Appliences" : ""))
        <tbody>
            <tr>
                <td>Planning</td>
                <td>{{ number_format(($planningSize * 200)/200) }}</td>
                <?php $totalCementBags += (($planningSize * 200)/200); ?>
                <td>{{ number_format((($planningSize * 200)/200) * $price) }}</td>
                <?php $totalCementPrice += ((($planningSize * 200)/200) * $price); ?>
            </tr>
            <tr>
                <td>Digging</td>
                <td>{{ number_format(($diggingSize * 200)/200) }}</td>
                <?php $totalCementBags += (($diggingSize * 200)/200); ?>
                <td>{{ number_format((($diggingSize * 200)/200) * $price) }}</td>
                <?php $totalCementPrice += ((($diggingSize * 200)/200) * $price); ?>
            </tr>
            <tr>
                <td>Foundation</td>
                <td>{{ number_format(($foundationSize * 200)/200)}}</td>
                <?php $totalCementBags += (($foundationSize * 200)/200); ?>
                <td>{{ number_format(($foundationSize * 200)/200) * $price) }}</td>
                <?php $totalCementPrice += (($foundationSize * 200)/200) * $price); ?>
            </tr>
            <tr>
                <td>Pillars</td>
                <td>{{ number_format(($pillarsSize * 200)/200) }}</td>
                <?php $totalCementBags += (($pillarsSize * 200)/200); ?>
                <td>{{ number_format((($pillarsSize * 200)/200) * $price) }}</td>
                <?php $totalCementPrice += ((($pillarsSize * 200)/200) * $price); ?>
            </tr>
            <tr>
                <td>Walls</td>
                <td>{{ number_format(($wallsSize * 200)/200) }}</td>
                <?php $totalCementBags += (($wallsSize * 200)/200); ?>
                <td>{{ number_format((($wallsSize * 200)/200) * $price) }}</td>
                <?php $totalCementPrice += ((($wallsSize * 200)/200) * $price); ?>
            </tr>
            <tr>
                <td>Roofing</td>
                <td>{{ number_format(($roofingSize * 200)/200) }}</td>
                <?php $totalCementBags += (($roofingSize * 200)/200); ?>
                <td>{{ number_format((($roofingSize * 200)/200) * $price) }}</td>
                <?php $totalCementPrice += ((($roofingSize * 200)/200)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format((($enpSize * 200)/200) }}</td>
                <?php $totalCementBags += (($enpSize * 200)/200); ?>
                <td>{{ number_format((($enpSize * 200)/200) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 200)/200) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 200)/200)}}</td>
                <?php $totalCementBags += (($plasteringSize * 200)/200); ?>
                <td>{{ number_format((($plasteringSize * 200)/200) * $price) }}</td>
                <?php $totalCementPrice += ((($plasteringSize * 200)/200)) * $price); ?>
            </tr>
            <tr>
                <td>Flooring</td>
                <td>{{ number_format(($flooringSize * 200)/200) }}</td>
                <?php $totalCementBags += (($flooringSize * 200)/200); ?>
                <td>{{ number_format((($flooringSize * 200)/200) * $price) }}</td>
                <?php $totalCementPrice += ((($flooringSize * 200)/200) * $price); ?>
            </tr>
            <tr>
                <td>Carpentry</td>
                <td>{{ number_format(($carpentrySize * 200)/200) }}</td>
                <?php $totalCementBags += (($carpentrySize * 200)/200); ?>
                <td>{{ number_format(((($carpentrySize * 200)/200) * $price) }}</td>
                <?php $totalCementPrice += ((($carpentrySize * 200)/200) * $price); ?>
            </tr>
            <tr>
                <td>Paintings</td>
                <td>{{ number_format(($paintingSize * 200)/200) }}</td>
                <?php $totalCementBags += (($paintingSize * 200)/200); ?>
                <td>{{ number_format((($paintingSize * 200)/200) * $price) }}</td>
                <?php $totalCementPrice += ((($paintingSize * 200)/200) * $price); ?>
            </tr>
            <tr>
                <td>Fixtures</td>
                <td>{{ number_format(($fixturesSize * 200)/200) }}</td>
                <?php $totalCementBags += ((($fixturesSize * 200)/200)); ?>
                <td>{{ number_format(((($fixturesSize * 200)/200)) * $price) }}</td>
                <?php $totalCementPrice += (((($fixturesSize * 200)/200)) * $price); ?>
            </tr>
            <tr>
                <td>Completion</td>
                <td>{{ number_format((($completionSize * 200)/200)) }}</td>
                <?php $totalCementBags += ((($completionSize * 200)/200)); ?>
                <td>{{ number_format(((($completionSize * 200)/200)) * $price) }}</td>
                <?php $totalCementPrice += (((($completionSize * 200)/200)) * $price); ?>
            </tr>
            <tr>
                <th>Total</th>
                <th>{{ number_format($totalCementBags) }}</th>
                <th>{{ number_format($totalCementPrice) }}</th>
            </tr>
            <tr>
                <th>Monthly Requirement</th>
                <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
            </tr>
        </tbody>
        @endif 


         @if($planningCount != NULL && (isset($_GET['category']) ? $_GET['category'] == "Home Appliences" : ""))
        <tbody>
            <tr>
                <td>Planning</td>
                <td>{{ number_format(($planningSize * 60)/60) }}</td>
                <?php $totalCementBags += (($planningSize * 60)/60); ?>
                <td>{{ number_format((($planningSize * 60)/60) * $price) }}</td>
                <?php $totalCementPrice += ((($planningSize * 60)/60) * $price); ?>
            </tr>
            <tr>
                <td>Digging</td>
                <td>{{ number_format(($diggingSize * 60)/60) }}</td>
                <?php $totalCementBags += (($diggingSize * 60)/60); ?>
                <td>{{ number_format((($diggingSize * 60)/60) * $price) }}</td>
                <?php $totalCementPrice += ((($diggingSize * 60)/60) * $price); ?>
            </tr>
            <tr>
                <td>Foundation</td>
                <td>{{ number_format(($foundationSize * 60)/60)}}</td>
                <?php $totalCementBags += (($foundationSize * 60)/60); ?>
                <td>{{ number_format(($foundationSize * 60)/60) * $price) }}</td>
                <?php $totalCementPrice += (($foundationSize * 60)/60) * $price); ?>
            </tr>
            <tr>
                <td>Pillars</td>
                <td>{{ number_format(($pillarsSize * 60)/60) }}</td>
                <?php $totalCementBags += (($pillarsSize * 60)/60); ?>
                <td>{{ number_format((($pillarsSize * 60)/60) * $price) }}</td>
                <?php $totalCementPrice += ((($pillarsSize * 60)/60) * $price); ?>
            </tr>
            <tr>
                <td>Walls</td>
                <td>{{ number_format(($wallsSize * 60)/60) }}</td>
                <?php $totalCementBags += (($wallsSize * 60)/60); ?>
                <td>{{ number_format((($wallsSize * 60)/60) * $price) }}</td>
                <?php $totalCementPrice += ((($wallsSize * 60)/60) * $price); ?>
            </tr>
            <tr>
                <td>Roofing</td>
                <td>{{ number_format(($roofingSize * 60)/60) }}</td>
                <?php $totalCementBags += (($roofingSize * 60)/60); ?>
                <td>{{ number_format((($roofingSize * 60)/60) * $price) }}</td>
                <?php $totalCementPrice += ((($roofingSize * 60)/60)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format((($enpSize * 60)/60) }}</td>
                <?php $totalCementBags += (($enpSize * 60)/60); ?>
                <td>{{ number_format((($enpSize * 60)/60) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 60)/60) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 60)/60)}}</td>
                <?php $totalCementBags += (($plasteringSize * 60)/60); ?>
                <td>{{ number_format((($plasteringSize * 60)/60) * $price) }}</td>
                <?php $totalCementPrice += ((($plasteringSize * 60)/60)) * $price); ?>
            </tr>
            <tr>
                <td>Flooring</td>
                <td>{{ number_format(($flooringSize * 60)/60) }}</td>
                <?php $totalCementBags += (($flooringSize * 60)/60); ?>
                <td>{{ number_format((($flooringSize * 60)/60) * $price) }}</td>
                <?php $totalCementPrice += ((($flooringSize * 60)/60) * $price); ?>
            </tr>
            <tr>
                <td>Carpentry</td>
                <td>{{ number_format(($carpentrySize * 60)/60) }}</td>
                <?php $totalCementBags += (($carpentrySize * 60)/60); ?>
                <td>{{ number_format(((($carpentrySize * 60)/60) * $price) }}</td>
                <?php $totalCementPrice += ((($carpentrySize * 60)/60) * $price); ?>
            </tr>
            <tr>
                <td>Paintings</td>
                <td>{{ number_format(($paintingSize * 0)/0) }}</td>
                <?php $totalCementBags += (($paintingSize * 0)/0); ?>
                <td>{{ number_format((($paintingSize * 0)/0) * $price) }}</td>
                <?php $totalCementPrice += ((($paintingSize * 0)/0) * $price); ?>
            </tr>
            <tr>
                <td>Fixtures</td>
                <td>{{ number_format(($fixturesSize * 0)/0) }}</td>
                <?php $totalCementBags += ((($fixturesSize * 0)/0)); ?>
                <td>{{ number_format(((($fixturesSize * 0)/0)) * $price) }}</td>
                <?php $totalCementPrice += (((($fixturesSize * 0)/0)) * $price); ?>
            </tr>
            <tr>
                <td>Completion</td>
                <td>{{ number_format((($completionSize * 0)/0)) }}</td>
                <?php $totalCementBags += ((($completionSize * 0)/0)); ?>
                <td>{{ number_format(((($completionSize * 0)/0)) * $price) }}</td>
                <?php $totalCementPrice += (((($completionSize * 0)/0)) * $price); ?>
            </tr>
            <tr>
                <th>Total</th>
                <th>{{ number_format($totalCementBags) }}</th>
                <th>{{ number_format($totalCementPrice) }}</th>
            </tr>
            <tr>
                <th>Monthly Requirement</th>
                <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
            </tr>
        </tbody>
        @endif 


        @if($planningCount != NULL && (isset($_GET['category']) ? $_GET['category'] == "Paints" : ""))
        <tbody>
            <tr>
                <td>Planning</td>
                <td>{{ number_format(($planningSize * 55)/55) }}</td>
                <?php $totalCementBags += (($planningSize * 55)/55); ?>
                <td>{{ number_format((($planningSize * 55)/55) * $price) }}</td>
                <?php $totalCementPrice += ((($planningSize * 55)/55) * $price); ?>
            </tr>
            <tr>
                <td>Digging</td>
                <td>{{ number_format(($diggingSize * 55)/55) }}</td>
                <?php $totalCementBags += (($diggingSize * 55)/55); ?>
                <td>{{ number_format((($diggingSize * 55)/55) * $price) }}</td>
                <?php $totalCementPrice += ((($diggingSize * 55)/55) * $price); ?>
            </tr>
            <tr>
                <td>Foundation</td>
                <td>{{ number_format(($foundationSize * 55)/55)}}</td>
                <?php $totalCementBags += (($foundationSize * 55)/55); ?>
                <td>{{ number_format(($foundationSize * 55)/55) * $price) }}</td>
                <?php $totalCementPrice += (($foundationSize * 55)/55) * $price); ?>
            </tr>
            <tr>
                <td>Pillars</td>
                <td>{{ number_format(($pillarsSize * 55)/55) }}</td>
                <?php $totalCementBags += (($pillarsSize * 55)/55); ?>
                <td>{{ number_format((($pillarsSize * 55)/55) * $price) }}</td>
                <?php $totalCementPrice += ((($pillarsSize * 55)/55) * $price); ?>
            </tr>
            <tr>
                <td>Walls</td>
                <td>{{ number_format(($wallsSize * 55)/55) }}</td>
                <?php $totalCementBags += (($wallsSize * 55)/55); ?>
                <td>{{ number_format((($wallsSize * 55)/55) * $price) }}</td>
                <?php $totalCementPrice += ((($wallsSize * 55)/55) * $price); ?>
            </tr>
            <tr>
                <td>Roofing</td>
                <td>{{ number_format(($roofingSize * 55)/55) }}</td>
                <?php $totalCementBags += (($roofingSize * 55)/55); ?>
                <td>{{ number_format((($roofingSize * 55)/55) * $price) }}</td>
                <?php $totalCementPrice += ((($roofingSize * 55)/55)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format((($enpSize * 55)/55) }}</td>
                <?php $totalCementBags += (($enpSize * 55)/55); ?>
                <td>{{ number_format((($enpSize * 55)/55) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 55)/55) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 55)/55)}}</td>
                <?php $totalCementBags += (($plasteringSize * 55)/55); ?>
                <td>{{ number_format((($plasteringSize * 55)/55) * $price) }}</td>
                <?php $totalCementPrice += ((($plasteringSize * 55)/55)) * $price); ?>
            </tr>
            <tr>
                <td>Flooring</td>
                <td>{{ number_format(($flooringSize * 55)/55) }}</td>
                <?php $totalCementBags += (($flooringSize * 55)/55); ?>
                <td>{{ number_format((($flooringSize * 55)/55) * $price) }}</td>
                <?php $totalCementPrice += ((($flooringSize * 55)/55) * $price); ?>
            </tr>
            <tr>
                <td>Carpentry</td>
                <td>{{ number_format(($carpentrySize * 55)/55) }}</td>
                <?php $totalCementBags += (($carpentrySize * 55)/55); ?>
                <td>{{ number_format(((($carpentrySize * 55)/55) * $price) }}</td>
                <?php $totalCementPrice += ((($carpentrySize * 55)/55) * $price); ?>
            </tr>
            <tr>
                <td>Paintings</td>
                <td>{{ number_format(($paintingSize * 55)/55) }}</td>
                <?php $totalCementBags += (($paintingSize * 55)/55); ?>
                <td>{{ number_format((($paintingSize * 55)/55) * $price) }}</td>
                <?php $totalCementPrice += ((($paintingSize * 55)/55) * $price); ?>
            </tr>
            <tr>
                <td>Fixtures</td>
                <td>{{ number_format(($fixturesSize * 0)/0) }}</td>
                <?php $totalCementBags += ((($fixturesSize * 0)/0)); ?>
                <td>{{ number_format(((($fixturesSize * 0)/0)) * $price) }}</td>
                <?php $totalCementPrice += (((($fixturesSize * 0)/0)) * $price); ?>
            </tr>
            <tr>
                <td>Completion</td>
                <td>{{ number_format((($completionSize * 0)/0)) }}</td>
                <?php $totalCementBags += ((($completionSize * 0)/0)); ?>
                <td>{{ number_format(((($completionSize * 0)/0)) * $price) }}</td>
                <?php $totalCementPrice += (((($completionSize * 0)/0)) * $price); ?>
            </tr>
            <tr>
                <th>Total</th>
                <th>{{ number_format($totalCementBags) }}</th>
                <th>{{ number_format($totalCementPrice) }}</th>
            </tr>
            <tr>
                <th>Monthly Requirement</th>
                <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
            </tr>
        </tbody>
        @endif 

@if($planningCount != NULL && (isset($_GET['category']) ? $_GET['category'] == "Wood and Adhesive" : ""))
        <tbody>
            <tr>
                <td>Planning</td>
                <td>{{ number_format(($planningSize * 120)/120) }}</td>
                <?php $totalCementBags += (($planningSize * 120)/120); ?>
                <td>{{ number_format((($planningSize * 120)/120) * $price) }}</td>
                <?php $totalCementPrice += ((($planningSize * 120)/120) * $price); ?>
            </tr>
            <tr>
                <td>Digging</td>
                <td>{{ number_format(($diggingSize * 120)/120) }}</td>
                <?php $totalCementBags += (($diggingSize * 120)/120); ?>
                <td>{{ number_format((($diggingSize * 120)/120) * $price) }}</td>
                <?php $totalCementPrice += ((($diggingSize * 120)/120) * $price); ?>
            </tr>
            <tr>
                <td>Foundation</td>
                <td>{{ number_format(($foundationSize * 120)/120)}}</td>
                <?php $totalCementBags += (($foundationSize * 120)/120); ?>
                <td>{{ number_format(($foundationSize * 120)/120) * $price) }}</td>
                <?php $totalCementPrice += (($foundationSize * 120)/120) * $price); ?>
            </tr>
            <tr>
                <td>Pillars</td>
                <td>{{ number_format(($pillarsSize * 120)/120) }}</td>
                <?php $totalCementBags += (($pillarsSize * 120)/120); ?>
                <td>{{ number_format((($pillarsSize * 120)/120) * $price) }}</td>
                <?php $totalCementPrice += ((($pillarsSize * 120)/120) * $price); ?>
            </tr>
            <tr>
                <td>Walls</td>
                <td>{{ number_format(($wallsSize * 120)/120) }}</td>
                <?php $totalCementBags += (($wallsSize * 120)/120); ?>
                <td>{{ number_format((($wallsSize * 120)/120) * $price) }}</td>
                <?php $totalCementPrice += ((($wallsSize * 120)/120) * $price); ?>
            </tr>
            <tr>
                <td>Roofing</td>
                <td>{{ number_format(($roofingSize * 120)/120) }}</td>
                <?php $totalCementBags += (($roofingSize * 120)/120); ?>
                <td>{{ number_format((($roofingSize * 120)/120) * $price) }}</td>
                <?php $totalCementPrice += ((($roofingSize * 120)/120)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format((($enpSize * 120)/120) }}</td>
                <?php $totalCementBags += (($enpSize * 120)/120); ?>
                <td>{{ number_format((($enpSize * 120)/120) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 120)/120) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 120)/120)}}</td>
                <?php $totalCementBags += (($plasteringSize * 120)/120); ?>
                <td>{{ number_format((($plasteringSize * 120)/120) * $price) }}</td>
                <?php $totalCementPrice += ((($plasteringSize * 120)/120)) * $price); ?>
            </tr>
            <tr>
                <td>Flooring</td>
                <td>{{ number_format(($flooringSize * 120)/120) }}</td>
                <?php $totalCementBags += (($flooringSize * 120)/120); ?>
                <td>{{ number_format((($flooringSize * 120)/120) * $price) }}</td>
                <?php $totalCementPrice += ((($flooringSize * 120)/120) * $price); ?>
            </tr>
            <tr>
                <td>Carpentry</td>
                <td>{{ number_format(($carpentrySize * 120)/120) }}</td>
                <?php $totalCementBags += (($carpentrySize * 120)/120); ?>
                <td>{{ number_format(((($carpentrySize * 120)/120) * $price) }}</td>
                <?php $totalCementPrice += ((($carpentrySize * 120)/120) * $price); ?>
            </tr>
            <tr>
                <td>Paintings</td>
                <td>{{ number_format(($paintingSize * 120)/120) }}</td>
                <?php $totalCementBags += (($paintingSize * 120)/120); ?>
                <td>{{ number_format((($paintingSize * 120)/120) * $price) }}</td>
                <?php $totalCementPrice += ((($paintingSize * 120)/120) * $price); ?>
            </tr>
            <tr>
                <td>Fixtures</td>
                <td>{{ number_format(($fixturesSize * 120)/120) }}</td>
                <?php $totalCementBags += ((($fixturesSize * 120)/120)); ?>
                <td>{{ number_format(((($fixturesSize * 120)/120)) * $price) }}</td>
                <?php $totalCementPrice += (((($fixturesSize * 120)/120)) * $price); ?>
            </tr>
            <tr>
                <td>Completion</td>
                <td>{{ number_format((($completionSize * 0)/0)) }}</td>
                <?php $totalCementBags += ((($completionSize * 0)/0)); ?>
                <td>{{ number_format(((($completionSize * 0)/0)) * $price) }}</td>
                <?php $totalCementPrice += (((($completionSize * 0)/0)) * $price); ?>
            </tr>
            <tr>
                <th>Total</th>
                <th>{{ number_format($totalCementBags) }}</th>
                <th>{{ number_format($totalCementPrice) }}</th>
            </tr>
            <tr>
                <th>Monthly Requirement</th>
                <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
            </tr>
        </tbody>
        @endif 


   @if($planningCount != NULL && (isset($_GET['category']) ? $_GET['category'] == "Bathroom and sanitary" : ""))
        <tbody>
            <tr>
                <td>Planning</td>
                <td>{{ number_format(($planningSize * 70)/70) }}</td>
                <?php $totalCementBags += (($planningSize * 70)/70); ?>
                <td>{{ number_format((($planningSize * 70)/70) * $price) }}</td>
                <?php $totalCementPrice += ((($planningSize * 70)/70) * $price); ?>
            </tr>
            <tr>
                <td>Digging</td>
                <td>{{ number_format(($diggingSize * 70)/70) }}</td>
                <?php $totalCementBags += (($diggingSize * 70)/70); ?>
                <td>{{ number_format((($diggingSize * 70)/70) * $price) }}</td>
                <?php $totalCementPrice += ((($diggingSize * 70)/70) * $price); ?>
            </tr>
            <tr>
                <td>Foundation</td>
                <td>{{ number_format(($foundationSize * 70)/70)}}</td>
                <?php $totalCementBags += (($foundationSize * 70)/70); ?>
                <td>{{ number_format(($foundationSize * 70)/70) * $price) }}</td>
                <?php $totalCementPrice += (($foundationSize * 70)/70) * $price); ?>
            </tr>
            <tr>
                <td>Pillars</td>
                <td>{{ number_format(($pillarsSize * 70)/70) }}</td>
                <?php $totalCementBags += (($pillarsSize * 70)/70); ?>
                <td>{{ number_format((($pillarsSize * 70)/70) * $price) }}</td>
                <?php $totalCementPrice += ((($pillarsSize * 70)/70) * $price); ?>
            </tr>
            <tr>
                <td>Walls</td>
                <td>{{ number_format(($wallsSize * 70)/70) }}</td>
                <?php $totalCementBags += (($wallsSize * 70)/70); ?>
                <td>{{ number_format((($wallsSize * 70)/70) * $price) }}</td>
                <?php $totalCementPrice += ((($wallsSize * 70)/70) * $price); ?>
            </tr>
            <tr>
                <td>Roofing</td>
                <td>{{ number_format(($roofingSize * 70)/70) }}</td>
                <?php $totalCementBags += (($roofingSize * 70)/70); ?>
                <td>{{ number_format((($roofingSize * 70)/70) * $price) }}</td>
                <?php $totalCementPrice += ((($roofingSize * 70)/70)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format((($enpSize * 70)/70) }}</td>
                <?php $totalCementBags += (($enpSize * 70)/70); ?>
                <td>{{ number_format((($enpSize * 70)/70) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 70)/70) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 70)/70)}}</td>
                <?php $totalCementBags += (($plasteringSize * 70)/70); ?>
                <td>{{ number_format((($plasteringSize * 70)/70) * $price) }}</td>
                <?php $totalCementPrice += ((($plasteringSize * 70)/70)) * $price); ?>
            </tr>
            <tr>
                <td>Flooring</td>
                <td>{{ number_format(($flooringSize * 70)/70) }}</td>
                <?php $totalCementBags += (($flooringSize * 70)/70); ?>
                <td>{{ number_format((($flooringSize * 70)/70) * $price) }}</td>
                <?php $totalCementPrice += ((($flooringSize * 70)/70) * $price); ?>
            </tr>
            <tr>
                <td>Carpentry</td>
                <td>{{ number_format(($carpentrySize * 70)/70) }}</td>
                <?php $totalCementBags += (($carpentrySize * 70)/70); ?>
                <td>{{ number_format(((($carpentrySize * 70)/70) * $price) }}</td>
                <?php $totalCementPrice += ((($carpentrySize * 70)/70) * $price); ?>
            </tr>
            <tr>
                <td>Paintings</td>
                <td>{{ number_format(($paintingSize * 70)/70) }}</td>
                <?php $totalCementBags += (($paintingSize * 70)/70); ?>
                <td>{{ number_format((($paintingSize * 70)/70) * $price) }}</td>
                <?php $totalCementPrice += ((($paintingSize * 70)/70) * $price); ?>
            </tr>
            <tr>
                <td>Fixtures</td>
                <td>{{ number_format(($fixturesSize * 70)/70) }}</td>
                <?php $totalCementBags += ((($fixturesSize * 70)/70)); ?>
                <td>{{ number_format(((($fixturesSize * 70)/70)) * $price) }}</td>
                <?php $totalCementPrice += (((($fixturesSize * 70)/70)) * $price); ?>
            </tr>
            <tr>
                <td>Completion</td>
                <td>{{ number_format((($completionSize * 0)/0)) }}</td>
                <?php $totalCementBags += ((($completionSize * 0)/0)); ?>
                <td>{{ number_format(((($completionSize * 0)/0)) * $price) }}</td>
                <?php $totalCementPrice += (((($completionSize * 0)/0)) * $price); ?>
            </tr>
            <tr>
                <th>Total</th>
                <th>{{ number_format($totalCementBags) }}</th>
                <th>{{ number_format($totalCementPrice) }}</th>
            </tr>
            <tr>
                <th>Monthly Requirement</th>
                <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
            </tr>
        </tbody>
        @endif 


        @if($planningCount != NULL && (isset($_GET['category']) ? $_GET['category'] == "Flooring" : ""))
        <tbody>
            <tr>
                <td>Planning</td>
                <td>{{ number_format(($planningSize * 0.8)/0.8) }}</td>
                <?php $totalCementBags += (($planningSize * 0.8)/0.8); ?>
                <td>{{ number_format((($planningSize * 0.8)/0.8) * $price) }}</td>
                <?php $totalCementPrice += ((($planningSize * 0.8)/0.8) * $price); ?>
            </tr>
            <tr>
                <td>Digging</td>
                <td>{{ number_format(($diggingSize * 0.8)/0.8) }}</td>
                <?php $totalCementBags += (($diggingSize * 0.8)/0.8); ?>
                <td>{{ number_format((($diggingSize * 0.8)/0.8) * $price) }}</td>
                <?php $totalCementPrice += ((($diggingSize * 0.8)/0.8) * $price); ?>
            </tr>
            <tr>
                <td>Foundation</td>
                <td>{{ number_format(($foundationSize * 0.8)/0.8)}}</td>
                <?php $totalCementBags += (($foundationSize * 0.8)/0.8); ?>
                <td>{{ number_format(($foundationSize * 0.8)/0.8) * $price) }}</td>
                <?php $totalCementPrice += (($foundationSize * 0.8)/0.8) * $price); ?>
            </tr>
            <tr>
                <td>Pillars</td>
                <td>{{ number_format(($pillarsSize * 0.8)/0.8) }}</td>
                <?php $totalCementBags += (($pillarsSize * 0.8)/0.8); ?>
                <td>{{ number_format((($pillarsSize * 0.8)/0.8) * $price) }}</td>
                <?php $totalCementPrice += ((($pillarsSize * 0.8)/0.8) * $price); ?>
            </tr>
            <tr>
                <td>Walls</td>
                <td>{{ number_format(($wallsSize * 0.8)/0.8) }}</td>
                <?php $totalCementBags += (($wallsSize * 0.8)/0.8); ?>
                <td>{{ number_format((($wallsSize * 0.8)/0.8) * $price) }}</td>
                <?php $totalCementPrice += ((($wallsSize * 0.8)/0.8) * $price); ?>
            </tr>
            <tr>
                <td>Roofing</td>
                <td>{{ number_format(($roofingSize * 0.8)/0.8) }}</td>
                <?php $totalCementBags += (($roofingSize * 0.8)/0.8); ?>
                <td>{{ number_format((($roofingSize * 0.8)/0.8) * $price) }}</td>
                <?php $totalCementPrice += ((($roofingSize * 0.8)/0.8)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format((($enpSize * 0.8)/0.8) }}</td>
                <?php $totalCementBags += (($enpSize * 0.8)/0.8); ?>
                <td>{{ number_format((($enpSize * 0.8)/0.8) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 0.8)/0.8) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 0.8)/0.8)}}</td>
                <?php $totalCementBags += (($plasteringSize * 0.8)/0.8); ?>
                <td>{{ number_format((($plasteringSize * 0.8)/0.8) * $price) }}</td>
                <?php $totalCementPrice += ((($plasteringSize * 0.8)/0.8)) * $price); ?>
            </tr>
            <tr>
                <td>Flooring</td>
                <td>{{ number_format(($flooringSize * 0.8)/0.8) }}</td>
                <?php $totalCementBags += (($flooringSize * 0.8)/0.8); ?>
                <td>{{ number_format((($flooringSize * 0.8)/0.8) * $price) }}</td>
                <?php $totalCementPrice += ((($flooringSize * 0.8)/0.8) * $price); ?>
            </tr>
            <tr>
                <td>Carpentry</td>
                <td>{{ number_format(($carpentrySize * 0.8)/0.8) }}</td>
                <?php $totalCementBags += (($carpentrySize * 0.8)/0.8); ?>
                <td>{{ number_format(((($carpentrySize * 0.8)/0.8) * $price) }}</td>
                <?php $totalCementPrice += ((($carpentrySize * 0.8)/0.8) * $price); ?>
            </tr>
            <tr>
                <td>Paintings</td>
                <td>{{ number_format(($paintingSize * 0.8)/0.8) }}</td>
                <?php $totalCementBags += (($paintingSize * 0.8)/0.8); ?>
                <td>{{ number_format((($paintingSize * 0.8)/0.8) * $price) }}</td>
                <?php $totalCementPrice += ((($paintingSize * 0.8)/0.8) * $price); ?>
            </tr>
            <tr>
                <td>Fixtures</td>
                <td>{{ number_format(($fixturesSize * 0)/0) }}</td>
                <?php $totalCementBags += ((($fixturesSize * 0)/0)); ?>
                <td>{{ number_format(((($fixturesSize * 0)/0)) * $price) }}</td>
                <?php $totalCementPrice += (((($fixturesSize * 0)/0)) * $price); ?>
            </tr>
            <tr>
                <td>Completion</td>
                <td>{{ number_format((($completionSize * 0)/0)) }}</td>
                <?php $totalCementBags += ((($completionSize * 0)/0)); ?>
                <td>{{ number_format(((($completionSize * 0)/0)) * $price) }}</td>
                <?php $totalCementPrice += (((($completionSize * 0)/0)) * $price); ?>
            </tr>
            <tr>
                <th>Total</th>
                <th>{{ number_format($totalCementBags) }}</th>
                <th>{{ number_format($totalCementPrice) }}</th>
            </tr>
            <tr>
                <th>Monthly Requirement</th>
                <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
            </tr>
        </tbody>
        @endif 
    </table>

</div>
<div class="col-md-3">
    <label for="">Material Projection (Steel)</label>
    <form action="{{ URL::to('/') }}/projection" method="GET">
        <select required class="form-control" name="ward">
            <option value="">--Select--</option>
            <option value="All">All</option>
            @foreach($wards as $ward)
            <option value="{{ $ward->id}}" {{ $ward->id == $wardId? 'selected':'' }}>{{ $ward->ward_name }}</option>
            @endforeach
        </select><br>
        <input required type="text" name="steelPrice" id="" placeholder="Steel Price" class="form-control"><br>
        <input type="hidden" name="category" value="steel">
        <input required value="{{ isset($_GET['bCycle']) ? $_GET['bCycle'] : '' }}" type="text" name="bCycle" id="" placeholder="Business Cycle" class="form-control"><br>
        <button class="btn btn-success form-control">Calculate</button>
    </form>   
    <br>
    @if($planningCount != NULL && (isset($_GET['category']) ? $_GET['category'] == "steel" : ""))
    <table class="table table-hover" border=1>
    <thead>
        <th>Stages</th>
        <th>Total Tons Required</th>
        <th>Amount</th>
    </thead>
    @if(isset($_GET['steelPrice']) && isset($_GET['bCycle']))
    <?php
            $steelPrice = $_GET['steelPrice'];
            $bCycle = $_GET['bCycle'];
        ?>
    <tbody>
        <tr>
            <td>Planning</td>
            <td>{{ number_format(($planningSize * 4)/1000) }}</td>
            <?php $totalSteel += (($planningSize * 4)/1000); ?>
            <td>{{ number_format((($planningSize * 4)/1000) * $steelPrice) }}</td>
            <?php $totalSteelPrice += ((($planningSize * 4)/1000) * $steelPrice); ?>
        </tr>
        <tr>
            <td>Digging</td>
            <td>{{ number_format(($diggingSize * 4)/1000) }}</td>
            <?php $totalSteel += (($diggingSize * 4)/1000); ?>
            <td>{{ number_format((($diggingSize * 4)/1000) * $steelPrice) }}</td>
            <?php $totalSteelPrice += ((($diggingSize * 4)/1000) * $steelPrice); ?>
        </tr>
        <tr>
            <td>Foundation</td>
            <td>{{ number_format((($foundationSize * 4)/1000)/100*70) }}</td>
            <?php $totalSteel += ((($foundationSize * 4)/1000)/100*70); ?>
            <td>{{ number_format(((($foundationSize * 4)/1000)/100*70) * $steelPrice) }}</td>
            <?php $totalSteelPrice += (((($foundationSize * 4)/1000)/100*70) * $steelPrice); ?>
        </tr>
        <tr>
            <td>Pillars</td>
            <td>{{ number_format((($pillarsSize * 4)/1000)/100*35) }}</td>
            <?php $totalSteel += ((($pillarsSize * 4)/1000)/100*35); ?>
            <td>{{ number_format(((($pillarsSize * 4)/1000)/100*35) * $steelPrice) }}</td>
            <?php $totalSteelPrice += (((($pillarsSize * 4)/1000)/100*35) * $steelPrice); ?>
        </tr>
        <tr>
            <td>Walls</td>
            <td>{{ number_format((($wallsSize * 4)/1000)/100*35) }}</td>
            <?php $totalSteel += ((($wallsSize * 4)/1000)/100*35); ?>
            <td>{{ number_format(((($wallsSize * 4)/1000)/100*35) * $steelPrice) }}</td>
            <?php $totalSteelPrice += (((($wallsSize * 4)/1000)/100*35) * $steelPrice); ?>
        </tr>
        <tr>
            <td>Roofing</td>
            <td>{{ number_format((($roofingSize * 4)/1000)/100*35) }}</td>
            <?php $totalSteel += ((($roofingSize * 4)/1000)/100*35); ?>
            <td>{{ number_format(((($roofingSize * 4)/1000)/100*35) * $steelPrice) }}</td>
            <?php $totalSteelPrice += (((($roofingSize * 4)/1000)/100*35) * $steelPrice); ?>
        </tr>
        <tr>
            <td>Electrical & Plumbing</td>
            <td>{{ number_format((($enpSize * 4)/1000)/100*0) }}</td>
            <?php $totalSteel += ((($enpSize * 4)/1000)/100*0); ?>
            <td>{{ number_format(((($enpSize * 4)/1000)/100*0) * $steelPrice) }}</td>
            <?php $totalSteelPrice += (((($enpSize * 4)/1000)/100*0) * $steelPrice); ?>
        </tr>
        <tr>
            <td>Plastering</td>
            <td>{{ number_format((($plasteringSize * 4)/1000)/100*0) }}</td>
            <?php $totalSteel += ((($plasteringSize * 4)/1000)/100*0); ?>
            <td>{{ number_format(((($plasteringSize * 4)/1000)/100*0) * $steelPrice) }}</td>
            <?php $totalSteelPrice += (((($plasteringSize * 4)/1000)/100*0) * $steelPrice); ?>
        </tr>
        <tr>
            <td>Flooring</td>
            <td>{{ number_format((($flooringSize * 4)/1000)/100*0) }}</td>
            <?php $totalSteel += ((($flooringSize * 4)/1000)/100*0); ?>
            <td>{{ number_format(((($flooringSize * 4)/1000)/100*0) * $steelPrice) }}</td>
            <?php $totalSteelPrice += (((($flooringSize * 4)/1000)/100*0) * $steelPrice); ?>
        </tr>
        <tr>
            <td>Carpentry</td>
            <td>{{ number_format((($carpentrySize * 4)/1000)/100*0) }}</td>
            <?php $totalSteel += ((($carpentrySize * 4)/1000)/100*0); ?>
            <td>{{ number_format(((($carpentrySize * 4)/1000)/100*0) * $steelPrice) }}</td>
            <?php $totalSteelPrice += (((($carpentrySize * 4)/1000)/100*0) * $steelPrice); ?>
        </tr>
        <tr>
            <td>Paintings</td>
            <td>{{ number_format((($paintingSize * 4)/1000)/100*0) }}</td>
            <?php $totalSteel += ((($paintingSize * 4)/1000)/100*0); ?>
            <td>{{ number_format(((($paintingSize * 4)/1000)/100*0) * $steelPrice) }}</td>
            <?php $totalSteelPrice += (((($paintingSize * 4)/1000)/100*0) * $steelPrice); ?>
        </tr>
        <tr>
            <td>Fixtures</td>
            <td>{{ number_format((($fixturesSize * 4)/1000)/100*0) }}</td>
            <?php $totalSteel += ((($fixturesSize * 4)/1000)/100*0); ?>
            <td>{{ number_format(((($fixturesSize * 4)/1000)/100*0) * $steelPrice) }}</td>
            <?php $totalSteelPrice += (((($fixturesSize * 4)/1000)/100*0) * $steelPrice); ?>
        </tr>
        <tr>
            <td>Completion</td>
            <td>{{ number_format((($completionSize * 4)/1000)/100*0) }}</td>
            <?php $totalSteel += ((($completionSize * 4)/1000)/100*0); ?>
            <td>{{ number_format(((($completionSize * 4)/1000)/100*0) * $steelPrice) }}</td>
            <?php $totalSteelPrice += (((($completionSize * 4)/1000)/100*0) * $steelPrice); ?>
        </tr>
        <tr>
            <th>Total</th>
            <th>{{ number_format($totalSteel) }}</th>
            <th>{{ number_format($totalSteelPrice) }}</th>
        </tr>
        <tr>
            <th>Monthly Requirement</th>
            <th>{{ number_format($totalSteel/$bCycle) }}</th>
            <th>{{ number_format($totalSteelPrice/$bCycle) }}</th>
        </tr>
    </tbody>
    @endif
    </table>
    @endif
</div>
<div class="col-md-3">
    <label for="">Material Projection (Sand)</label>
    <form action="{{ URL::to('/') }}/projection" method="GET">
        <select required class="form-control" name="ward">
            <option value="">--Select--</option>
            <option value="All">All</option>
            @foreach($wards as $ward)
            <option value="{{ $ward->id}}" {{ $ward->id == $wardId? 'selected':'' }}>{{ $ward->ward_name }}</option>
            @endforeach
        </select><br>
        <input required type="text" name="sandPrice" id="" placeholder="Sand Price" class="form-control"><br>
        <input type="hidden" name="category" value="sand">
        <input required value="{{ isset($_GET['bCycle']) ? $_GET['bCycle'] : '' }}" type="text" name="bCycle" id="" placeholder="Business Cycle" class="form-control"><br>
        <button class="btn btn-success form-control">Calculate</button>
    </form>
    <br>
    @if($planningCount != NULL && (isset($_GET['category']) ? $_GET['category'] == "sand" : ""))
    <table class="table table-hover" border=1>
        <thead>
            <th>Stages</th>
            <th>Total Tons Required</th>
            <th>Amount</th>
        </thead>
        <tbody>
            <tr>
                <td>Planning</td>
                <td>{{ number_format(($planningSize * 1.2)/23.25) }}</td>
                <?php $totalSand += (($planningSize * 1.2)/23.25); ?>
                <td>{{ number_format((($planningSize * 1.2)/23.25) * 950) }}</td>
                <?php $totalSandPrice += ((($planningSize * 1.2)/23.25) * 950); ?>
            </tr>
            <tr>
                <td>Digging</td>
                <td>{{ number_format(($diggingSize * 1.2)/23.25) }}</td>
                <?php $totalSand += (($diggingSize * 1.2)/23.25); ?>
                <td>{{ number_format((($diggingSize * 1.2)/23.25) * 950) }}</td>
                <?php $totalSandPrice += ((($diggingSize * 1.2)/23.25) * 950); ?>
            </tr>
            <tr>
                <td>Foundation</td>
                <td>{{ number_format((($foundationSize * 1.2)/23.25)/100*90) }}</td>
                <?php $totalSand += ((($foundationSize * 1.2)/23.25)/100*90); ?>
                <td>{{ number_format(((($foundationSize * 1.2)/23.25)/100*90) * 950) }}</td>
                <?php $totalSandPrice += (((($foundationSize * 1.2)/23.25)/100*90) * 950); ?>
            </tr>
            <tr>
                <td>Pillars</td>
                <td>{{ number_format((($pillarsSize * 1.2)/23.25)/100*70) }}</td>
                <?php $totalSand += ((($pillarsSize * 1.2)/23.25)/100*70); ?>
                <td>{{ number_format(((($pillarsSize * 1.2)/23.25)/100*70) * 950) }}</td>
                <?php $totalSandPrice += (((($pillarsSize * 1.2)/23.25)/100*70) * 950); ?>
            </tr>
            <tr>
                <td>Walls</td>
                <td>{{ number_format((($wallsSize * 1.2)/23.25)/100*50) }}</td>
                <?php $totalSand += ((($wallsSize * 1.2)/23.25)/100*50); ?>
                <td>{{ number_format(((($wallsSize * 1.2)/23.25)/100*50) * 950) }}</td>
                <?php $totalSandPrice += (((($wallsSize * 1.2)/23.25)/100*50) * 950); ?>
            </tr>
            <tr>
                <td>Roofing</td>
                <td>{{ number_format((($roofingSize * 1.2)/23.25)/100*35) }}</td>
                <?php $totalSand += ((($roofingSize * 1.2)/23.25)/100*35); ?>
                <td>{{ number_format(((($roofingSize * 1.2)/23.25)/100*35) * 950) }}</td>
                <?php $totalSandPrice += (((($roofingSize * 1.2)/23.25)/100*35) * 950); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format((($enpSize * 1.2)/23.25)/100*35) }}</td>
                <?php $totalSand += ((($enpSize * 1.2)/23.25)/100*35); ?>
                <td>{{ number_format(((($enpSize * 1.2)/23.25)/100*35) * 950) }}</td>
                <?php $totalSandPrice += (((($enpSize * 1.2)/23.25)/100*35) * 950); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format((($plasteringSize * 1.2)/23.25)/100*10) }}</td>
                <?php $totalSand += ((($plasteringSize * 1.2)/23.25)/100*10); ?>
                <td>{{ number_format(((($plasteringSize * 1.2)/23.25)/100*10) * 950) }}</td>
                <?php $totalSandPrice += (((($plasteringSize * 1.2)/23.25)/100*10) * 950); ?>
            </tr>
            <tr>
                <td>Flooring</td>
                <td>{{ number_format((($flooringSize * 1.2)/23.25)/100*0) }}</td>
                <?php $totalSand += ((($flooringSize * 1.2)/23.25)/100*0); ?>
                <td>{{ number_format(((($flooringSize * 1.2)/23.25)/100*0) * 950) }}</td>
                <?php $totalSandPrice += (((($flooringSize * 1.2)/23.25)/100*0) * 950); ?>
            </tr>
            <tr>
                <td>Carpentry</td>
                <td>{{ number_format((($carpentrySize * 1.2)/23.25)/100*0) }}</td>
                <?php $totalSand += ((($carpentrySize * 1.2)/23.25)/100*0); ?>
                <td>{{ number_format(((($carpentrySize * 1.2)/23.25)/100*0) * 950) }}</td>
                <?php $totalSandPrice += (((($carpentrySize * 1.2)/23.25)/100*0) * 950); ?>
            </tr>
            <tr>
                <td>Paintings</td>
                <td>{{ number_format((($paintingSize * 1.2)/23.25)/100*0) }}</td>
                <?php $totalSand += ((($paintingSize * 1.2)/23.25)/100*0); ?>
                <td>{{ number_format(((($paintingSize * 1.2)/23.25)/100*0) * 950) }}</td>
                <?php $totalSandPrice += (((($paintingSize * 1.2)/23.25)/100*0) * 950); ?>
            </tr>
            <tr>
                <td>Fixtures</td>
                <td>{{ number_format((($fixturesSize * 1.2)/23.25)/100*0) }}</td>
                <?php $totalSand += ((($fixturesSize * 1.2)/23.25)/100*0); ?>
                <td>{{ number_format(((($fixturesSize * 1.2)/23.25)/100*0) * 950) }}</td>
                <?php $totalSandPrice += (((($fixturesSize * 1.2)/23.25)/100*0) * 950); ?>
            </tr>
            <tr>
                <td>Completion</td>
                <td>{{ number_format((($completionSize * 1.2)/23.25)/100*0) }}</td>
                <?php $totalSand += ((($completionSize * 1.2)/23.25)/100*0); ?>
                <td>{{ number_format(((($completionSize * 1.2)/23.25)/100*0) * 950) }}</td>
                <?php $totalSandPrice += (((($completionSize * 1.2)/23.25)/100*0) * 950); ?>
            </tr>
            <tr>
                <th>Total</th>
                <th>{{ number_format($totalSand) }}</th>
                <th>{{ number_format($totalSandPrice) }}</th>
            </tr>
            <tr>
                <th>Monthly Requirement</th>
                <th>{{ number_format($totalSand/10) }}</th>
                <th>{{ number_format($totalSandPrice/10) }}</th>
            </tr>
        </tbody>
    </table>
    @endif
</div>
<div class="col-md-3">
    <label for="">Material Projection (Aggregates)</label>
    <form action="{{ URL::to('/') }}/projection" method="GET">
        <select required class="form-control" name="ward">
            <option value="">--Select--</option>
            <option value="All">All</option>
            @foreach($wards as $ward)
            <option value="{{ $ward->id}}" {{ $ward->id == $wardId? 'selected':'' }}>{{ $ward->ward_name }}</option>
            @endforeach
        </select><br>
        <input required type="text" name="aggregatesPrice" id="" placeholder="Aggregates Price" class="form-control"><br>
        <input type="hidden" name="category" value="aggregates">
        <input required value="{{ isset($_GET['bCycle']) ? $_GET['bCycle'] : '' }}" type="text" name="bCycle" id="" placeholder="Business Cycle" class="form-control"><br>
        <button class="btn btn-success form-control">Calculate</button>
    </form>
    <br>
    @if($planningCount != NULL && (isset($_GET['category']) ? $_GET['category'] == "aggregates" : ""))
    <table class="table table-hover" border=1>
        <thead>
            <th>Stages</th>
            <th>Total Tons Required</th>
            <th>Amount</th>
        </thead>
        <tbody>
        <tr>
            <td>Planning</td>
            <td>{{ number_format(($planningSize * 1.35)/23.25) }}</td>
            <?php $totalAggregates += (($planningSize * 1.35)/23.25); ?>
            <td>{{ number_format((($planningSize * 1.35)/23.25) * 750) }}</td>
            <?php $totalAggregatesPrice += ((($planningSize * 1.35)/23.25) * 750); ?>
        </tr>
        <tr>
            <td>Digging</td>
            <td>{{ number_format(($diggingSize * 1.35)/23.25) }}</td>
            <?php $totalAggregates += (($diggingSize * 1.35)/23.25); ?>
            <td>{{ number_format((($diggingSize * 1.35)/23.25) * 750) }}</td>
            <?php $totalAggregatesPrice += ((($diggingSize * 1.35)/23.25) * 750); ?>
        </tr>
        <tr>
            <td>Foundation</td>
            <td>{{ number_format((($foundationSize * 1.35)/23.25)/100*80) }}</td>
            <?php $totalAggregates += ((($foundationSize * 1.35)/23.25)/100*80); ?>
            <td>{{ number_format(((($foundationSize * 1.35)/23.25)/100*80) * 750) }}</td>
            <?php $totalAggregatesPrice += (((($foundationSize * 1.35)/23.25)/100*80) * 750); ?>
        </tr>
        <tr>
            <td>Pillars</td>
            <td>{{ number_format((($pillarsSize * 1.35)/23.25)/100*50) }}</td>
            <?php $totalAggregates += ((($pillarsSize * 1.35)/23.25)/100*50); ?>
            <td>{{ number_format(((($pillarsSize * 1.35)/23.25)/100*50) * 750) }}</td>
            <?php $totalAggregatesPrice += (((($pillarsSize * 1.35)/23.25)/100*50) * 750); ?>
        </tr>
        <tr>
            <td>Walls</td>
            <td>{{ number_format((($wallsSize * 1.35)/23.25)/100*50) }}</td>
            <?php $totalAggregates += ((($wallsSize * 1.35)/23.25)/100*50); ?>
            <td>{{ number_format(((($wallsSize * 1.35)/23.25)/100*50) * 750) }}</td>
            <?php $totalAggregatesPrice += (((($wallsSize * 1.35)/23.25)/100*50) * 750); ?>
        </tr>
        <tr>
            <td>Roofing</td>
            <td>{{ number_format((($roofingSize * 1.35)/23.25)/100*50) }}</td>
            <?php $totalAggregates += ((($roofingSize * 1.35)/23.25)/100*50); ?>
            <td>{{ number_format(((($roofingSize * 1.35)/23.25)/100*50) * 750) }}</td>
            <?php $totalAggregatesPrice += (((($roofingSize * 1.35)/23.25)/100*50) * 750); ?>
        </tr>
        <tr>
            <td>Electrical & Plumbing</td>
            <td>{{ number_format((($enpSize * 1.35)/23.25)/100*0) }}</td>
            <?php $totalAggregates += ((($enpSize * 1.35)/23.25)/100*0); ?>
            <td>{{ number_format(((($enpSize * 1.35)/23.25)/100*0) * 750) }}</td>
            <?php $totalAggregatesPrice += (((($enpSize * 1.35)/23.25)/100*0) * 750); ?>
        </tr>
        <tr>
            <td>Plastering</td>
            <td>{{ number_format((($plasteringSize * 1.35)/23.25)/100*0) }}</td>
            <?php $totalAggregates += ((($plasteringSize * 1.35)/23.25)/100*0); ?>
            <td>{{ number_format(((($plasteringSize * 1.35)/23.25)/100*0) * 750) }}</td>
            <?php $totalAggregatesPrice += (((($plasteringSize * 1.35)/23.25)/100*0) * 750); ?>
        </tr>
        <tr>
            <td>Flooring</td>
            <td>{{ number_format((($flooringSize * 1.35)/23.25)/100*0) }}</td>
            <?php $totalAggregates += ((($flooringSize * 1.35)/23.25)/100*0); ?>
            <td>{{ number_format(((($flooringSize * 1.35)/23.25)/100*0) * 750) }}</td>
            <?php $totalAggregatesPrice += (((($flooringSize * 1.35)/23.25)/100*0) * 750); ?>
        </tr>
        <tr>
            <td>Carpentry</td>
            <td>{{ number_format((($carpentrySize * 1.35)/23.25)/100*0) }}</td>
            <?php $totalAggregates += ((($carpentrySize * 1.35)/23.25)/100*0); ?>
            <td>{{ number_format(((($carpentrySize * 1.35)/23.25)/100*0) * 750) }}</td>
            <?php $totalAggregatesPrice += (((($carpentrySize * 1.35)/23.25)/100*0) * 750); ?>
        </tr>
        <tr>
            <td>Paintings</td>
            <td>{{ number_format((($paintingSize * 1.35)/23.25)/100*0) }}</td>
            <?php $totalAggregates += ((($paintingSize * 1.35)/23.25)/100*0); ?>
            <td>{{ number_format(((($paintingSize * 1.35)/23.25)/100*0) * 750) }}</td>
            <?php $totalAggregatesPrice += (((($paintingSize * 1.35)/23.25)/100*0) * 750); ?>
        </tr>
        <tr>
            <td>Fixtures</td>
            <td>{{ number_format((($fixturesSize * 1.35)/23.25)/100*0) }}</td>
            <?php $totalAggregates += ((($fixturesSize * 1.35)/23.25)/100*0); ?>
            <td>{{ number_format(((($fixturesSize * 1.35)/23.25)/100*0) * 750) }}</td>
            <?php $totalAggregatesPrice += (((($fixturesSize * 1.35)/23.25)/100*0) * 750); ?>
        </tr>
        <tr>
            <td>Completion</td>
            <td>{{ number_format((($completionSize * 1.35)/23.25)/100*0) }}</td>
            <?php $totalAggregates += ((($completionSize * 1.35)/23.25)/100*0); ?>
            <td>{{ number_format(((($completionSize * 1.35)/23.25)/100*0) * 750) }}</td>
            <?php $totalAggregatesPrice += (((($completionSize * 1.35)/23.25)/100*0) * 750); ?>
        </tr>
        <tr>
            <th>Total</th>
            <th>{{ number_format($totalAggregates) }}</th>
            <th>{{ number_format($totalAggregatesPrice) }}</th>
        </tr>
        <tr>
            <th>Monthly Requirement</th>
            <th>{{ number_format($totalSteel/10) }}</th>
            <th>{{ number_format($totalSteelPrice/10) }}</th>
        </tr>
        </tbody>
    </table>
</div>
@endif
@endsection