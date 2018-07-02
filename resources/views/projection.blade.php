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
@if($planningCount != NULL && (isset($_GET['category']) ? $_GET['category'] == "cement" : ""))
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
        <tbody>
            <tr>
                <td>Planning</td>
                <td>{{ number_format(($planningSize * 15)/50) }}</td>
                <?php $totalCementBags += (($planningSize * 15)/50); ?>
                <td>{{ number_format((($planningSize * 15)/50) * $price) }}</td>
                <?php $totalCementPrice += ((($planningSize * 15)/50) * $price); ?>
            </tr>
            <tr>
                <td>Digging</td>
                <td>{{ number_format(($diggingSize * 15)/50) }}</td>
                <?php $totalCementBags += (($diggingSize * 15)/50); ?>
                <td>{{ number_format((($diggingSize * 15)/50) * $price) }}</td>
                <?php $totalCementPrice += ((($diggingSize * 15)/50) * $price); ?>
            </tr>
            <tr>
                <td>Foundation</td>
                <td>{{ number_format((($foundationSize * 15)/50)/100*85) }}</td>
                <?php $totalCementBags += ((($foundationSize * 15)/50)/100*85); ?>
                <td>{{ number_format(((($foundationSize * 15)/50)/100*85) * $price) }}</td>
                <?php $totalCementPrice += (((($foundationSize * 15)/50)/100*85) * $price); ?>
            </tr>
            <tr>
                <td>Pillars</td>
                <td>{{ number_format((($pillarsSize * 15)/50)/100*70) }}</td>
                <?php $totalCementBags += ((($pillarsSize * 15)/50)/100*70); ?>
                <td>{{ number_format(((($pillarsSize * 15)/50)/100*70) * $price) }}</td>
                <?php $totalCementPrice += (((($pillarsSize * 15)/50)/100*70) * $price); ?>
            </tr>
            <tr>
                <td>Walls</td>
                <td>{{ number_format((($wallsSize * 15)/50)/100*55) }}</td>
                <?php $totalCementBags += ((($wallsSize * 15)/50)/100*50); ?>
                <td>{{ number_format(((($wallsSize * 15)/50)/100*55) * $price) }}</td>
                <?php $totalCementPrice += (((($wallsSize * 15)/50)/100*55) * $price); ?>
            </tr>
            <tr>
                <td>Roofing</td>
                <td>{{ number_format((($roofingSize * 15)/50)/100*25) }}</td>
                <?php $totalCementBags += ((($roofingSize * 15)/50)/100*25); ?>
                <td>{{ number_format(((($roofingSize * 15)/50)/100*25) * $price) }}</td>
                <?php $totalCementPrice += (((($roofingSize * 15)/50)/100*25) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format((($enpSize * 15)/50)/100*25) }}</td>
                <?php $totalCementBags += ((($enpSize * 15)/50)/100*25); ?>
                <td>{{ number_format(((($enpSize * 15)/50)/100*25) * $price) }}</td>
                <?php $totalCementPrice += (((($enpSize * 15)/50)/100*25) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format((($plasteringSize * 15)/50)/100*10) }}</td>
                <?php $totalCementBags += ((($plasteringSize * 15)/50)/100*10); ?>
                <td>{{ number_format(((($plasteringSize * 15)/50)/100*10) * $price) }}</td>
                <?php $totalCementPrice += (((($plasteringSize * 15)/50)/100*10) * $price); ?>
            </tr>
            <tr>
                <td>Flooring</td>
                <td>{{ number_format((($flooringSize * 15)/50)/100*5) }}</td>
                <?php $totalCementBags += ((($flooringSize * 15)/50)/100*5); ?>
                <td>{{ number_format(((($flooringSize * 15)/50)/100*5) * $price) }}</td>
                <?php $totalCementPrice += (((($flooringSize * 15)/50)/100*5) * $price); ?>
            </tr>
            <tr>
                <td>Carpentry</td>
                <td>{{ number_format((($carpentrySize * 15)/50)/100*0) }}</td>
                <?php $totalCementBags += ((($carpentrySize * 15)/50)/100*0); ?>
                <td>{{ number_format(((($carpentrySize * 15)/50)/100*0) * $price) }}</td>
                <?php $totalCementPrice += (((($carpentrySize * 15)/50)/100*0) * $price); ?>
            </tr>
            <tr>
                <td>Paintings</td>
                <td>{{ number_format((($paintingSize * 15)/50)/100*0) }}</td>
                <?php $totalCementBags += ((($paintingSize * 15)/50)/100*0); ?>
                <td>{{ number_format(((($paintingSize * 15)/50)/100*0) * $price) }}</td>
                <?php $totalCementPrice += (((($paintingSize * 15)/50)/100*0) * $price); ?>
            </tr>
            <tr>
                <td>Fixtures</td>
                <td>{{ number_format((($fixturesSize * 15)/50)/100*0) }}</td>
                <?php $totalCementBags += ((($fixturesSize * 15)/50)/100*0); ?>
                <td>{{ number_format(((($fixturesSize * 15)/50)/100*0) * $price) }}</td>
                <?php $totalCementPrice += (((($fixturesSize * 15)/50)/100*0) * $price); ?>
            </tr>
            <tr>
                <td>Completion</td>
                <td>{{ number_format((($completionSize * 15)/50)/100*0) }}</td>
                <?php $totalCementBags += ((($completionSize * 15)/50)/100*0); ?>
                <td>{{ number_format(((($completionSize * 15)/50)/100*0) * $price) }}</td>
                <?php $totalCementPrice += (((($completionSize * 15)/50)/100*0) * $price); ?>
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
@endif
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