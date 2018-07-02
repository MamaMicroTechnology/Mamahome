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
    $totalBlocks = 0;
    $totalBlocksPrice = 0;
    $totalElectricals = 0;
    $totalElectricalsPrice = 0;
    $totalPlumbing = 0;
    $totalPlumbingPrice = 0;
    $totalDoors = 0;
    $totalDoorsPrice = 0;
?>
<div class="col-md-3 col-md-offset-3">
    <label for="">Material Projection (Cement)</label>
    <form action="{{ URL::to('/') }}/projection" method="GET">
        <label for="wards">Wards</label>
        <select id="wards" required class="form-control" name="ward">
            <option value="">--Select--</option>
            <option value="All" {{ isset($_GET['ward']) ? $_GET['ward'] == "All" ? "selected" : "" : "" }}>All</option>
            @foreach($wards as $ward)
            <option value="{{ $ward->id}}" {{ $ward->id == $wardId? 'selected':'' }}>{{ $ward->ward_name }}</option>
            @endforeach
        </select><br>
        <label for="categories">Categories</label>
        <select id="categories" required class="form-control" name="category">
            <option value="">--Select--</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "cement" ? "selected" : "" : ""}} value="cement">Cement</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "steel" ? "selected" : "" : ""}} value="steel">Steel</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "sand" ? "selected" : "" : ""}} value="sand">Sand</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "aggregates" ? "selected" : "" : ""}} value="aggregates">Aggregates</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "blocks" ? "selected" : "" : ""}} value="blocks">Blocks & Bricks</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "electrical" ? "selected" : "" : ""}} value="electrical">Electrical</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "plumbing" ? "selected" : "" : ""}} value="plumbing">Plumbing</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "flooring" ? "selected" : "" : ""}} value="flooring">Flooring</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "bathroom" ? "selected" : "" : ""}} value="bathroom">Bathroom & Sanitary</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "wood" ? "selected" : "" : ""}} value="wood">Wood & Adhesive</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "paints" ? "selected" : "" : ""}} value="paints">Paints</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "wardrobe" ? "selected" : "" : ""}} value="wardrobe">Wardrobes & Kitchen</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "appliences" ? "selected" : "" : ""}} value="appliences">Home Appliences</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "furnitures" ? "selected" : "" : ""}} value="furnitures">Furnitures</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "rails" ? "selected" : "" : ""}} value="rails">Handrails</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "glasses" ? "selected" : "" : ""}} value="glasses">Glasses & Facades</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "rmc" ? "selected" : "" : ""}} value="rmc">RMC</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "ceilling" ? "selected" : "" : ""}} value="ceilling">False Ceilling</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "fire" ? "selected" : "" : ""}} value="fire">Fire & Safety</option>
            <option {{ isset($_GET['category']) ? $_GET['category'] == "automation" ? "selected" : "" : ""}} value="automation">Home Automation</option>
        </select><br>
        <label for="price">Price</label>
        <input required value="{{ isset($_GET['bCycle']) ? $_GET['price'] : '' }}" type="text" name="price" id="price" placeholder="Price" class="form-control"><br>
        <label for="bCycle">Business Cycle</label>
        <input required value="{{ isset($_GET['bCycle']) ? $_GET['bCycle'] : '' }}" type="text" name="bCycle" id="bCycle" placeholder="Business Cycle" class="form-control"><br>
        <button class="btn btn-success form-control">Calculate</button>
    </form>   
</div>
<div class="col-md-4">
@if($planningCount != NULL)
<?php
        $price = $_GET['price'];
        $bCycle = $_GET['bCycle'];
        $category = $_GET['category'];
        $planningSize = round($planningSize);
        $diggingSize = round($diggingSize);
        $foundationSize = round($foundationSize);
        $pillarsSize = round($pillarsSize);
        $wallsSize = round($wallsSize);
        $roofingSize = round($roofingSize);
        $enpSize = round($enpSize);
        $plasteringSize = round($plasteringSize);
        $flooringSize = round($flooringSize);
        $carpentrySize = round($carpentrySize);
        $paintingSize = round($paintingSize);
        $fixturesSize = round($fixturesSize);
        $completionSize = round($completionSize);
        switch($category){
            case "cement": ?>
            <table class="table table-hover" border=1>
                <thead>
                    <th>Stages</th>
                    <th>Total Bags Required</th>
                    <th>Amount</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Planning</td>
                        <td>{{ number_format($planningSize * 15 / 50) }}</td>
                        <?php $totalCementBags += ($planningSize * 15 / 50); ?>
                        <td>{{ number_format($planningSize * 15 / 50 * $price) }}</td>
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
            </table>
        <?php
                break;
            case "steel": ?>
            <table class="table table-hover" border=1>
            <thead>
                <th>Stages</th>
                <th>Total Tons Required</th>
                <th>Amount</th>
            </thead>
            <tbody>
                <tr>
                    <td>Planning</td>
                    <td>{{ number_format(($planningSize * 4)/1000) }}</td>
                    <?php $totalSteel += (($planningSize * 4)/1000); ?>
                    <td>{{ number_format((($planningSize * 4)/1000) * $price) }}</td>
                    <?php $totalSteelPrice += ((($planningSize * 4)/1000) * $price); ?>
                </tr>
                <tr>
                    <td>Digging</td>
                    <td>{{ number_format(($diggingSize * 4)/1000) }}</td>
                    <?php $totalSteel += (($diggingSize * 4)/1000); ?>
                    <td>{{ number_format((($diggingSize * 4)/1000) * $price) }}</td>
                    <?php $totalSteelPrice += ((($diggingSize * 4)/1000) * $price); ?>
                </tr>
                <tr>
                    <td>Foundation</td>
                    <td>{{ number_format((($foundationSize * 4)/1000)/100*70) }}</td>
                    <?php $totalSteel += ((($foundationSize * 4)/1000)/100*70); ?>
                    <td>{{ number_format(((($foundationSize * 4)/1000)/100*70) * $price) }}</td>
                    <?php $totalSteelPrice += (((($foundationSize * 4)/1000)/100*70) * $price); ?>
                </tr>
                <tr>
                    <td>Pillars</td>
                    <td>{{ number_format((($pillarsSize * 4)/1000)/100*35) }}</td>
                    <?php $totalSteel += ((($pillarsSize * 4)/1000)/100*35); ?>
                    <td>{{ number_format(((($pillarsSize * 4)/1000)/100*35) * $price) }}</td>
                    <?php $totalSteelPrice += (((($pillarsSize * 4)/1000)/100*35) * $price); ?>
                </tr>
                <tr>
                    <td>Walls</td>
                    <td>{{ number_format((($wallsSize * 4)/1000)/100*35) }}</td>
                    <?php $totalSteel += ((($wallsSize * 4)/1000)/100*35); ?>
                    <td>{{ number_format(((($wallsSize * 4)/1000)/100*35) * $price) }}</td>
                    <?php $totalSteelPrice += (((($wallsSize * 4)/1000)/100*35) * $price); ?>
                </tr>
                <tr>
                    <td>Roofing</td>
                    <td>{{ number_format((($roofingSize * 4)/1000)/100*35) }}</td>
                    <?php $totalSteel += ((($roofingSize * 4)/1000)/100*35); ?>
                    <td>{{ number_format(((($roofingSize * 4)/1000)/100*35) * $price) }}</td>
                    <?php $totalSteelPrice += (((($roofingSize * 4)/1000)/100*35) * $price); ?>
                </tr>
                <tr>
                    <td>Electrical & Plumbing</td>
                    <td>{{ number_format((($enpSize * 4)/1000)/100*0) }}</td>
                    <?php $totalSteel += ((($enpSize * 4)/1000)/100*0); ?>
                    <td>{{ number_format(((($enpSize * 4)/1000)/100*0) * $price) }}</td>
                    <?php $totalSteelPrice += (((($enpSize * 4)/1000)/100*0) * $price); ?>
                </tr>
                <tr>
                    <td>Plastering</td>
                    <td>{{ number_format((($plasteringSize * 4)/1000)/100*0) }}</td>
                    <?php $totalSteel += ((($plasteringSize * 4)/1000)/100*0); ?>
                    <td>{{ number_format(((($plasteringSize * 4)/1000)/100*0) * $price) }}</td>
                    <?php $totalSteelPrice += (((($plasteringSize * 4)/1000)/100*0) * $price); ?>
                </tr>
                <tr>
                    <td>Flooring</td>
                    <td>{{ number_format((($flooringSize * 4)/1000)/100*0) }}</td>
                    <?php $totalSteel += ((($flooringSize * 4)/1000)/100*0); ?>
                    <td>{{ number_format(((($flooringSize * 4)/1000)/100*0) * $price) }}</td>
                    <?php $totalSteelPrice += (((($flooringSize * 4)/1000)/100*0) * $price); ?>
                </tr>
                <tr>
                    <td>Carpentry</td>
                    <td>{{ number_format((($carpentrySize * 4)/1000)/100*0) }}</td>
                    <?php $totalSteel += ((($carpentrySize * 4)/1000)/100*0); ?>
                    <td>{{ number_format(((($carpentrySize * 4)/1000)/100*0) * $price) }}</td>
                    <?php $totalSteelPrice += (((($carpentrySize * 4)/1000)/100*0) * $price); ?>
                </tr>
                <tr>
                    <td>Paintings</td>
                    <td>{{ number_format((($paintingSize * 4)/1000)/100*0) }}</td>
                    <?php $totalSteel += ((($paintingSize * 4)/1000)/100*0); ?>
                    <td>{{ number_format(((($paintingSize * 4)/1000)/100*0) * $price) }}</td>
                    <?php $totalSteelPrice += (((($paintingSize * 4)/1000)/100*0) * $price); ?>
                </tr>
                <tr>
                    <td>Fixtures</td>
                    <td>{{ number_format((($fixturesSize * 4)/1000)/100*0) }}</td>
                    <?php $totalSteel += ((($fixturesSize * 4)/1000)/100*0); ?>
                    <td>{{ number_format(((($fixturesSize * 4)/1000)/100*0) * $price) }}</td>
                    <?php $totalSteelPrice += (((($fixturesSize * 4)/1000)/100*0) * $price); ?>
                </tr>
                <tr>
                    <td>Completion</td>
                    <td>{{ number_format((($completionSize * 4)/1000)/100*0) }}</td>
                    <?php $totalSteel += ((($completionSize * 4)/1000)/100*0); ?>
                    <td>{{ number_format(((($completionSize * 4)/1000)/100*0) * $price) }}</td>
                    <?php $totalSteelPrice += (((($completionSize * 4)/1000)/100*0) * $price); ?>
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
            </table>
        <?php
                break;
            case "sand": ?>
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
                            <td>{{ number_format((($planningSize * 1.2)/23.25) * $price) }}</td>
                            <?php $totalSandPrice += ((($planningSize * 1.2)/23.25) * $price); ?>
                        </tr>
                        <tr>
                            <td>Digging</td>
                            <td>{{ number_format(($diggingSize * 1.2)/23.25) }}</td>
                            <?php $totalSand += (($diggingSize * 1.2)/23.25); ?>
                            <td>{{ number_format((($diggingSize * 1.2)/23.25) * $price) }}</td>
                            <?php $totalSandPrice += ((($diggingSize * 1.2)/23.25) * $price); ?>
                        </tr>
                        <tr>
                            <td>Foundation</td>
                            <td>{{ number_format((($foundationSize * 1.2)/23.25)/100*90) }}</td>
                            <?php $totalSand += ((($foundationSize * 1.2)/23.25)/100*90); ?>
                            <td>{{ number_format(((($foundationSize * 1.2)/23.25)/100*90) * $price) }}</td>
                            <?php $totalSandPrice += (((($foundationSize * 1.2)/23.25)/100*90) * $price); ?>
                        </tr>
                        <tr>
                            <td>Pillars</td>
                            <td>{{ number_format((($pillarsSize * 1.2)/23.25)/100*70) }}</td>
                            <?php $totalSand += ((($pillarsSize * 1.2)/23.25)/100*70); ?>
                            <td>{{ number_format(((($pillarsSize * 1.2)/23.25)/100*70) * $price) }}</td>
                            <?php $totalSandPrice += (((($pillarsSize * 1.2)/23.25)/100*70) * $price); ?>
                        </tr>
                        <tr>
                            <td>Walls</td>
                            <td>{{ number_format((($wallsSize * 1.2)/23.25)/100*50) }}</td>
                            <?php $totalSand += ((($wallsSize * 1.2)/23.25)/100*50); ?>
                            <td>{{ number_format(((($wallsSize * 1.2)/23.25)/100*50) * $price) }}</td>
                            <?php $totalSandPrice += (((($wallsSize * 1.2)/23.25)/100*50) * $price); ?>
                        </tr>
                        <tr>
                            <td>Roofing</td>
                            <td>{{ number_format((($roofingSize * 1.2)/23.25)/100*35) }}</td>
                            <?php $totalSand += ((($roofingSize * 1.2)/23.25)/100*35); ?>
                            <td>{{ number_format(((($roofingSize * 1.2)/23.25)/100*35) * $price) }}</td>
                            <?php $totalSandPrice += (((($roofingSize * 1.2)/23.25)/100*35) * $price); ?>
                        </tr>
                        <tr>
                            <td>Electrical & Plumbing</td>
                            <td>{{ number_format((($enpSize * 1.2)/23.25)/100*35) }}</td>
                            <?php $totalSand += ((($enpSize * 1.2)/23.25)/100*35); ?>
                            <td>{{ number_format(((($enpSize * 1.2)/23.25)/100*35) * $price) }}</td>
                            <?php $totalSandPrice += (((($enpSize * 1.2)/23.25)/100*35) * $price); ?>
                        </tr>
                        <tr>
                            <td>Plastering</td>
                            <td>{{ number_format((($plasteringSize * 1.2)/23.25)/100*10) }}</td>
                            <?php $totalSand += ((($plasteringSize * 1.2)/23.25)/100*10); ?>
                            <td>{{ number_format(((($plasteringSize * 1.2)/23.25)/100*10) * $price) }}</td>
                            <?php $totalSandPrice += (((($plasteringSize * 1.2)/23.25)/100*10) * $price); ?>
                        </tr>
                        <tr>
                            <td>Flooring</td>
                            <td>{{ number_format((($flooringSize * 1.2)/23.25)/100*0) }}</td>
                            <?php $totalSand += ((($flooringSize * 1.2)/23.25)/100*0); ?>
                            <td>{{ number_format(((($flooringSize * 1.2)/23.25)/100*0) * $price) }}</td>
                            <?php $totalSandPrice += (((($flooringSize * 1.2)/23.25)/100*0) * $price); ?>
                        </tr>
                        <tr>
                            <td>Carpentry</td>
                            <td>{{ number_format((($carpentrySize * 1.2)/23.25)/100*0) }}</td>
                            <?php $totalSand += ((($carpentrySize * 1.2)/23.25)/100*0); ?>
                            <td>{{ number_format(((($carpentrySize * 1.2)/23.25)/100*0) * $price) }}</td>
                            <?php $totalSandPrice += (((($carpentrySize * 1.2)/23.25)/100*0) * $price); ?>
                        </tr>
                        <tr>
                            <td>Paintings</td>
                            <td>{{ number_format((($paintingSize * 1.2)/23.25)/100*0) }}</td>
                            <?php $totalSand += ((($paintingSize * 1.2)/23.25)/100*0); ?>
                            <td>{{ number_format(((($paintingSize * 1.2)/23.25)/100*0) * $price) }}</td>
                            <?php $totalSandPrice += (((($paintingSize * 1.2)/23.25)/100*0) * $price); ?>
                        </tr>
                        <tr>
                            <td>Fixtures</td>
                            <td>{{ number_format((($fixturesSize * 1.2)/23.25)/100*0) }}</td>
                            <?php $totalSand += ((($fixturesSize * 1.2)/23.25)/100*0); ?>
                            <td>{{ number_format(((($fixturesSize * 1.2)/23.25)/100*0) * $price) }}</td>
                            <?php $totalSandPrice += (((($fixturesSize * 1.2)/23.25)/100*0) * $price); ?>
                        </tr>
                        <tr>
                            <td>Completion</td>
                            <td>{{ number_format((($completionSize * 1.2)/23.25)/100*0) }}</td>
                            <?php $totalSand += ((($completionSize * 1.2)/23.25)/100*0); ?>
                            <td>{{ number_format(((($completionSize * 1.2)/23.25)/100*0) * $price) }}</td>
                            <?php $totalSandPrice += (((($completionSize * 1.2)/23.25)/100*0) * $price); ?>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th>{{ number_format($totalSand) }}</th>
                            <th>{{ number_format($totalSandPrice) }}</th>
                        </tr>
                        <tr>
                            <th>Monthly Requirement</th>
                            <th>{{ number_format($totalSand/$bCycle) }}</th>
                            <th>{{ number_format($totalSandPrice/$bCycle) }}</th>
                        </tr>
                    </tbody>
                </table>
        <?php
                break;
            case "aggregates": ?>
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
                        <td>{{ number_format((($planningSize * 1.35)/23.25) * $price) }}</td>
                        <?php $totalAggregatesPrice += ((($planningSize * 1.35)/23.25) * $price); ?>
                    </tr>
                    <tr>
                        <td>Digging</td>
                        <td>{{ number_format(($diggingSize * 1.35)/23.25) }}</td>
                        <?php $totalAggregates += (($diggingSize * 1.35)/23.25); ?>
                        <td>{{ number_format((($diggingSize * 1.35)/23.25) * $price) }}</td>
                        <?php $totalAggregatesPrice += ((($diggingSize * 1.35)/23.25) * $price); ?>
                    </tr>
                    <tr>
                        <td>Foundation</td>
                        <td>{{ number_format((($foundationSize * 1.35)/23.25)/100*80) }}</td>
                        <?php $totalAggregates += ((($foundationSize * 1.35)/23.25)/100*80); ?>
                        <td>{{ number_format(((($foundationSize * 1.35)/23.25)/100*80) * $price) }}</td>
                        <?php $totalAggregatesPrice += (((($foundationSize * 1.35)/23.25)/100*80) * $price); ?>
                    </tr>
                    <tr>
                        <td>Pillars</td>
                        <td>{{ number_format((($pillarsSize * 1.35)/23.25)/100*50) }}</td>
                        <?php $totalAggregates += ((($pillarsSize * 1.35)/23.25)/100*50); ?>
                        <td>{{ number_format(((($pillarsSize * 1.35)/23.25)/100*50) * $price) }}</td>
                        <?php $totalAggregatesPrice += (((($pillarsSize * 1.35)/23.25)/100*50) * $price); ?>
                    </tr>
                    <tr>
                        <td>Walls</td>
                        <td>{{ number_format((($wallsSize * 1.35)/23.25)/100*50) }}</td>
                        <?php $totalAggregates += ((($wallsSize * 1.35)/23.25)/100*50); ?>
                        <td>{{ number_format(((($wallsSize * 1.35)/23.25)/100*50) * $price) }}</td>
                        <?php $totalAggregatesPrice += (((($wallsSize * 1.35)/23.25)/100*50) * $price); ?>
                    </tr>
                    <tr>
                        <td>Roofing</td>
                        <td>{{ number_format((($roofingSize * 1.35)/23.25)/100*50) }}</td>
                        <?php $totalAggregates += ((($roofingSize * 1.35)/23.25)/100*50); ?>
                        <td>{{ number_format(((($roofingSize * 1.35)/23.25)/100*50) * $price) }}</td>
                        <?php $totalAggregatesPrice += (((($roofingSize * 1.35)/23.25)/100*50) * $price); ?>
                    </tr>
                    <tr>
                        <td>Electrical & Plumbing</td>
                        <td>{{ number_format((($enpSize * 1.35)/23.25)/100*0) }}</td>
                        <?php $totalAggregates += ((($enpSize * 1.35)/23.25)/100*0); ?>
                        <td>{{ number_format(((($enpSize * 1.35)/23.25)/100*0) * $price) }}</td>
                        <?php $totalAggregatesPrice += (((($enpSize * 1.35)/23.25)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Plastering</td>
                        <td>{{ number_format((($plasteringSize * 1.35)/23.25)/100*0) }}</td>
                        <?php $totalAggregates += ((($plasteringSize * 1.35)/23.25)/100*0); ?>
                        <td>{{ number_format(((($plasteringSize * 1.35)/23.25)/100*0) * $price) }}</td>
                        <?php $totalAggregatesPrice += (((($plasteringSize * 1.35)/23.25)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Flooring</td>
                        <td>{{ number_format((($flooringSize * 1.35)/23.25)/100*0) }}</td>
                        <?php $totalAggregates += ((($flooringSize * 1.35)/23.25)/100*0); ?>
                        <td>{{ number_format(((($flooringSize * 1.35)/23.25)/100*0) * $price) }}</td>
                        <?php $totalAggregatesPrice += (((($flooringSize * 1.35)/23.25)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td>{{ number_format((($carpentrySize * 1.35)/23.25)/100*0) }}</td>
                        <?php $totalAggregates += ((($carpentrySize * 1.35)/23.25)/100*0); ?>
                        <td>{{ number_format(((($carpentrySize * 1.35)/23.25)/100*0) * $price) }}</td>
                        <?php $totalAggregatesPrice += (((($carpentrySize * 1.35)/23.25)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Paintings</td>
                        <td>{{ number_format((($paintingSize * 1.35)/23.25)/100*0) }}</td>
                        <?php $totalAggregates += ((($paintingSize * 1.35)/23.25)/100*0); ?>
                        <td>{{ number_format(((($paintingSize * 1.35)/23.25)/100*0) * $price) }}</td>
                        <?php $totalAggregatesPrice += (((($paintingSize * 1.35)/23.25)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Fixtures</td>
                        <td>{{ number_format((($fixturesSize * 1.35)/23.25)/100*0) }}</td>
                        <?php $totalAggregates += ((($fixturesSize * 1.35)/23.25)/100*0); ?>
                        <td>{{ number_format(((($fixturesSize * 1.35)/23.25)/100*0) * $price) }}</td>
                        <?php $totalAggregatesPrice += (((($fixturesSize * 1.35)/23.25)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Completion</td>
                        <td>{{ number_format((($completionSize * 1.35)/23.25)/100*0) }}</td>
                        <?php $totalAggregates += ((($completionSize * 1.35)/23.25)/100*0); ?>
                        <td>{{ number_format(((($completionSize * 1.35)/23.25)/100*0) * $price) }}</td>
                        <?php $totalAggregatesPrice += (((($completionSize * 1.35)/23.25)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th>{{ number_format($totalAggregates) }}</th>
                        <th>{{ number_format($totalAggregatesPrice) }}</th>
                    </tr>
                    <tr>
                        <th>Monthly Requirement</th>
                        <th>{{ number_format($totalAggregates/$bCycle) }}</th>
                        <th>{{ number_format($totalAggregatesPrice/$bCycle) }}</th>
                    </tr>
                    </tbody>
                </table>
        <?php   
                break;
            case "blocks": ?>
                <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Nos. Required</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Planning</td>
                        <td>{{ number_format(($planningSize * 4.167)/4.16) }}</td>
                        <?php $totalBlocks += (($planningSize * 4.167)/4.16); ?>
                        <td>{{ number_format((($planningSize * 4.167)/4.16) * $price) }}</td>
                        <?php $totalBlocksPrice += ((($planningSize * 4.167)/4.16) * $price); ?>
                    </tr>
                    <tr>
                        <td>Digging</td>
                        <td>{{ number_format(($diggingSize * 4.167)/4.16) }}</td>
                        <?php $totalBlocks += (($diggingSize * 4.167)/4.16); ?>
                        <td>{{ number_format((($diggingSize * 4.167)/4.16) * $price) }}</td>
                        <?php $totalBlocksPrice += ((($diggingSize * 4.167)/4.16) * $price); ?>
                    </tr>
                    <tr>
                        <td>Foundation</td>
                        <td>{{ number_format((($foundationSize * 4.167)/4.16)) }}</td>
                        <?php $totalBlocks += ((($foundationSize * 4.167)/4.16)); ?>
                        <td>{{ number_format(((($foundationSize * 4.167)/4.16)) * $price) }}</td>
                        <?php $totalBlocksPrice += (((($foundationSize * 4.167)/4.16)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Pillars</td>
                        <td>{{ number_format((($pillarsSize * 4.167)/4.16)) }}</td>
                        <?php $totalBlocks += ((($pillarsSize * 4.167)/4.16)); ?>
                        <td>{{ number_format(((($pillarsSize * 4.167)/4.16)) * $price) }}</td>
                        <?php $totalBlocksPrice += (((($pillarsSize * 4.167)/4.16)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Walls</td>
                        <td>{{ number_format((($wallsSize * 4.167)/4.16)) }}</td>
                        <?php $totalBlocks += ((($wallsSize * 4.167)/4.16)); ?>
                        <td>{{ number_format(((($wallsSize * 4.167)/4.16)) * $price) }}</td>
                        <?php $totalBlocksPrice += (((($wallsSize * 4.167)/4.16)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Roofing</td>
                        <td>{{ number_format((($roofingSize * 4.167)/4.16)/100*0) }}</td>
                        <?php $totalBlocks += ((($roofingSize * 4.167)/4.16)/100*0); ?>
                        <td>{{ number_format(((($roofingSize * 4.167)/4.16)/100*0) * $price) }}</td>
                        <?php $totalBlocksPrice += (((($roofingSize * 4.167)/4.16)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Electrical & Plumbing</td>
                        <td>{{ number_format((($enpSize * 4.167)/4.16)/100*0) }}</td>
                        <?php $totalBlocks += ((($enpSize * 4.167)/4.16)/100*0); ?>
                        <td>{{ number_format(((($enpSize * 4.167)/4.16)/100*0) * $price) }}</td>
                        <?php $totalBlocksPrice += (((($enpSize * 4.167)/4.16)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Plastering</td>
                        <td>{{ number_format((($plasteringSize * 4.167)/4.16)/100*0) }}</td>
                        <?php $totalBlocks += ((($plasteringSize * 4.167)/4.16)/100*0); ?>
                        <td>{{ number_format(((($plasteringSize * 4.167)/4.16)/100*0) * $price) }}</td>
                        <?php $totalBlocksPrice += (((($plasteringSize * 4.167)/4.16)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Flooring</td>
                        <td>{{ number_format((($flooringSize * 4.167)/4.16)/100*0) }}</td>
                        <?php $totalBlocks += ((($flooringSize * 4.167)/4.16)/100*0); ?>
                        <td>{{ number_format(((($flooringSize * 4.167)/4.16)/100*0) * $price) }}</td>
                        <?php $totalBlocksPrice += (((($flooringSize * 4.167)/4.16)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td>{{ number_format((($carpentrySize * 4.167)/4.16)/100*0) }}</td>
                        <?php $totalBlocks += ((($carpentrySize * 4.167)/4.16)/100*0); ?>
                        <td>{{ number_format(((($carpentrySize * 4.167)/4.16)/100*0) * $price) }}</td>
                        <?php $totalBlocksPrice += (((($carpentrySize * 4.167)/4.16)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Paintings</td>
                        <td>{{ number_format((($paintingSize * 4.167)/4.16)/100*0) }}</td>
                        <?php $totalBlocks += ((($paintingSize * 4.167)/4.16)/100*0); ?>
                        <td>{{ number_format(((($paintingSize * 4.167)/4.16)/100*0) * $price) }}</td>
                        <?php $totalBlocksPrice += (((($paintingSize * 4.167)/4.16)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Fixtures</td>
                        <td>{{ number_format((($fixturesSize * 4.167)/4.16)/100*0) }}</td>
                        <?php $totalBlocks += ((($fixturesSize * 4.167)/4.16)/100*0); ?>
                        <td>{{ number_format(((($fixturesSize * 4.167)/4.16)/100*0) * $price) }}</td>
                        <?php $totalBlocksPrice += (((($fixturesSize * 4.167)/4.16)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Completion</td>
                        <td>{{ number_format((($completionSize * 4.167)/4.16)/100*0) }}</td>
                        <?php $totalBlocks += ((($completionSize * 4.167)/4.16)/100*0); ?>
                        <td>{{ number_format(((($completionSize * 4.167)/4.16)/100*0) * $price) }}</td>
                        <?php $totalBlocksPrice += (((($completionSize * 4.167)/4.16)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th>{{ number_format($totalBlocks) }}</th>
                        <th>{{ number_format($totalBlocksPrice) }}</th>
                    </tr>
                    <tr>
                        <th>Monthly Requirement</th>
                        <th>{{ number_format($totalBlocks/$bCycle) }}</th>
                        <th>{{ number_format($totalBlocksPrice/$bCycle) }}</th>
                    </tr>
                    </tbody>
                </table>
        <?php
                break;
            case "electrical": ?>
                <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Nos. Required</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Planning</td>
                        <td>{{ number_format(($planningSize * 84)/84) }}</td>
                        <?php $totalElectricals += (($planningSize * 84)/84); ?>
                        <td>{{ number_format((($planningSize * 84)/84) * $price) }}</td>
                        <?php $totalElectricalsPrice += ((($planningSize * 84)/84) * $price); ?>
                    </tr>
                    <tr>
                        <td>Digging</td>
                        <td>{{ number_format(($diggingSize * 84)/84) }}</td>
                        <?php $totalElectricals += (($diggingSize * 84)/84); ?>
                        <td>{{ number_format((($diggingSize * 84)/84) * $price) }}</td>
                        <?php $totalElectricalsPrice += ((($diggingSize * 84)/84) * $price); ?>
                    </tr>
                    <tr>
                        <td>Foundation</td>
                        <td>{{ number_format((($foundationSize * 84)/84)/100*80) }}</td>
                        <?php $totalElectricals += ((($foundationSize * 84)/84)/100*80); ?>
                        <td>{{ number_format(((($foundationSize * 84)/84)/100*80) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($foundationSize * 84)/84)/100*80) * $price); ?>
                    </tr>
                    <tr>
                        <td>Pillars</td>
                        <td>{{ number_format((($pillarsSize * 84)/84)/100*50) }}</td>
                        <?php $totalElectricals += ((($pillarsSize * 84)/84)/100*50); ?>
                        <td>{{ number_format(((($pillarsSize * 84)/84)/100*50) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($pillarsSize * 84)/84)/100*50) * $price); ?>
                    </tr>
                    <tr>
                        <td>Walls</td>
                        <td>{{ number_format((($wallsSize * 84)/84)/100*50) }}</td>
                        <?php $totalElectricals += ((($wallsSize * 84)/84)/100*50); ?>
                        <td>{{ number_format(((($wallsSize * 84)/84)/100*50) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($wallsSize * 84)/84)/100*50) * $price); ?>
                    </tr>
                    <tr>
                        <td>Roofing</td>
                        <td>{{ number_format((($roofingSize * 84)/84)/100*100) }}</td>
                        <?php $totalElectricals += ((($roofingSize * 84)/84)/100*100); ?>
                        <td>{{ number_format(((($roofingSize * 84)/84)/100*100) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($roofingSize * 84)/84)/100*100) * $price); ?>
                    </tr>
                    <tr>
                        <td>Electrical & Plumbing</td>
                        <td>{{ number_format((($enpSize * 84)/84)/100*100) }}</td>
                        <?php $totalElectricals += ((($enpSize * 84)/84)/100*100); ?>
                        <td>{{ number_format(((($enpSize * 84)/84)/100*100) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($enpSize * 84)/84)/100*100) * $price); ?>
                    </tr>
                    <tr>
                        <td>Plastering</td>
                        <td>{{ number_format((($plasteringSize * 84)/84)/100*0) }}</td>
                        <?php $totalElectricals += ((($plasteringSize * 84)/84)/100*0); ?>
                        <td>{{ number_format(((($plasteringSize * 84)/84)/100*0) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($plasteringSize * 84)/84)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Flooring</td>
                        <td>{{ number_format((($flooringSize * 84)/84)/100*0) }}</td>
                        <?php $totalElectricals += ((($flooringSize * 84)/84)/100*0); ?>
                        <td>{{ number_format(((($flooringSize * 84)/84)/100*0) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($flooringSize * 84)/84)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td>{{ number_format((($carpentrySize * 84)/84)/100*0) }}</td>
                        <?php $totalElectricals += ((($carpentrySize * 84)/84)/100*0); ?>
                        <td>{{ number_format(((($carpentrySize * 84)/84)/100*0) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($carpentrySize * 84)/84)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Paintings</td>
                        <td>{{ number_format((($paintingSize * 84)/84)/100*0) }}</td>
                        <?php $totalElectricals += ((($paintingSize * 84)/84)/100*0); ?>
                        <td>{{ number_format(((($paintingSize * 84)/84)/100*0) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($paintingSize * 84)/84)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Fixtures</td>
                        <td>{{ number_format((($fixturesSize * 84)/84)/100*0) }}</td>
                        <?php $totalElectricals += ((($fixturesSize * 84)/84)/100*0); ?>
                        <td>{{ number_format(((($fixturesSize * 84)/84)/100*0) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($fixturesSize * 84)/84)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Completion</td>
                        <td>{{ number_format((($completionSize * 84)/84)/100*0) }}</td>
                        <?php $totalElectricals += ((($completionSize * 84)/84)/100*0); ?>
                        <td>{{ number_format(((($completionSize * 84)/84)/100*0) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($completionSize * 84)/84)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th>{{ number_format($totalElectricals) }}</th>
                        <th>{{ number_format($totalElectricalsPrice) }}</th>
                    </tr>
                    <tr>
                        <th>Monthly Requirement</th>
                        <th>{{ number_format($totalElectricals/$bCycle) }}</th>
                        <th>{{ number_format($totalElectricalsPrice/$bCycle) }}</th>
                    </tr>
                    </tbody>
                </table>
        <?php
                break;
            case "plumbing": ?>
                <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Nos. Required</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Planning</td>
                        <td>{{ number_format(($planningSize * 50)/50) }}</td>
                        <?php $totalElectricals += (($planningSize * 50)/50); ?>
                        <td>{{ number_format((($planningSize * 50)/50) * $price) }}</td>
                        <?php $totalElectricalsPrice += ((($planningSize * 50)/50) * $price); ?>
                    </tr>
                    <tr>
                        <td>Digging</td>
                        <td>{{ number_format(($diggingSize * 50)/50) }}</td>
                        <?php $totalElectricals += (($diggingSize * 50)/50); ?>
                        <td>{{ number_format((($diggingSize * 50)/50) * $price) }}</td>
                        <?php $totalElectricalsPrice += ((($diggingSize * 50)/50) * $price); ?>
                    </tr>
                    <tr>
                        <td>Foundation</td>
                        <td>{{ number_format((($foundationSize * 50)/50)) }}</td>
                        <?php $totalElectricals += ((($foundationSize * 50)/50)); ?>
                        <td>{{ number_format(((($foundationSize * 50)/50)) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($foundationSize * 50)/50)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Pillars</td>
                        <td>{{ number_format((($pillarsSize * 50)/50)) }}</td>
                        <?php $totalElectricals += ((($pillarsSize * 50)/50)); ?>
                        <td>{{ number_format(((($pillarsSize * 50)/50)) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($pillarsSize * 50)/50)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Walls</td>
                        <td>{{ number_format((($wallsSize * 50)/50)) }}</td>
                        <?php $totalElectricals += ((($wallsSize * 50)/50)); ?>
                        <td>{{ number_format(((($wallsSize * 50)/50)) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($wallsSize * 50)/50)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Roofing</td>
                        <td>{{ number_format((($roofingSize * 50)/50)/100*100) }}</td>
                        <?php $totalElectricals += ((($roofingSize * 50)/50)/100*100); ?>
                        <td>{{ number_format(((($roofingSize * 50)/50)/100*100) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($roofingSize * 50)/50)/100*100) * $price); ?>
                    </tr>
                    <tr> 
                        <td>Electrical & Plumbing</td>
                        <td>{{ number_format((($enpSize * 50)/50)/100*100) }}</td>
                        <?php $totalElectricals += ((($enpSize * 50)/50)/100*100); ?>
                        <td>{{ number_format(((($enpSize * 50)/50)/100*100) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($enpSize * 50)/50)/100*100) * $price); ?>
                    </tr>
                    <tr>
                        <td>Plastering</td>
                        <td>{{ number_format((($plasteringSize * 50)/50)/100*0) }}</td>
                        <?php $totalElectricals += ((($plasteringSize * 50)/50)/100*0); ?>
                        <td>{{ number_format(((($plasteringSize * 50)/50)/100*0) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($plasteringSize * 50)/50)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Flooring</td>
                        <td>{{ number_format((($flooringSize * 50)/50)/100*0) }}</td>
                        <?php $totalElectricals += ((($flooringSize * 50)/50)/100*0); ?>
                        <td>{{ number_format(((($flooringSize * 50)/50)/100*0) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($flooringSize * 50)/50)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td>{{ number_format((($carpentrySize * 50)/50)/100*0) }}</td>
                        <?php $totalElectricals += ((($carpentrySize * 50)/50)/100*0); ?>
                        <td>{{ number_format(((($carpentrySize * 50)/50)/100*0) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($carpentrySize * 50)/50)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Paintings</td>
                        <td>{{ number_format((($paintingSize * 50)/50)/100*0) }}</td>
                        <?php $totalElectricals += ((($paintingSize * 50)/50)/100*0); ?>
                        <td>{{ number_format(((($paintingSize * 50)/50)/100*0) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($paintingSize * 50)/50)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Fixtures</td>
                        <td>{{ number_format((($fixturesSize * 50)/50)/100*0) }}</td>
                        <?php $totalElectricals += ((($fixturesSize * 50)/50)/100*0); ?>
                        <td>{{ number_format(((($fixturesSize * 50)/50)/100*0) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($fixturesSize * 50)/50)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Completion</td>
                        <td>{{ number_format((($completionSize * 50)/50)/100*0) }}</td>
                        <?php $totalElectricals += ((($completionSize * 50)/50)/100*0); ?>
                        <td>{{ number_format(((($completionSize * 50)/50)/100*0) * $price) }}</td>
                        <?php $totalElectricalsPrice += (((($completionSize * 50)/50)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th>{{ number_format($totalElectricals) }}</th>
                        <th>{{ number_format($totalElectricalsPrice) }}</th>
                    </tr>
                    <tr>
                        <th>Monthly Requirement</th>
                        <th>{{ number_format($totalElectricals/$bCycle) }}</th>
                        <th>{{ number_format($totalElectricalsPrice/$bCycle) }}</th>
                    </tr>
                    </tbody>
                </table>
        <?php
                break;
            case "doors": ?>
                <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Nos. Required</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Planning</td>
                        <td>{{ number_format(($planningSize * 350)/350) }}</td>
                        <?php $totalDoors += (($planningSize * 350)/350); ?>
                        <td>{{ number_format((($planningSize * 350)/350) * $price) }}</td>
                        <?php $totalDoorsPrice += ((($planningSize * 350)/350) * $price); ?>
                    </tr>
                    <tr>
                        <td>Digging</td>
                        <td>{{ number_format(($diggingSize * 350)/350) }}</td>
                        <?php $totalDoors += (($diggingSize * 350)/350); ?>
                        <td>{{ number_format((($diggingSize * 350)/350) * $price) }}</td>
                        <?php $totalDoorsPrice += ((($diggingSize * 350)/350) * $price); ?>
                    </tr>
                    <tr>
                        <td>Foundation</td>
                        <td>{{ number_format((($foundationSize * 350)/350)) }}</td>
                        <?php $totalDoors += ((($foundationSize * 350)/350)); ?>
                        <td>{{ number_format(((($foundationSize * 350)/350)) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($foundationSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Pillars</td>
                        <td>{{ number_format((($pillarsSize * 350)/350)) }}</td>
                        <?php $totalDoors += ((($pillarsSize * 350)/350)); ?>
                        <td>{{ number_format(((($pillarsSize * 350)/350)) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($pillarsSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Walls</td>
                        <td>{{ number_format((($wallsSize * 350)/350)) }}</td>
                        <?php $totalDoors += ((($wallsSize * 350)/350)); ?>
                        <td>{{ number_format(((($wallsSize * 350)/350)) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($wallsSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Roofing</td>
                        <td>{{ number_format((($roofingSize * 350)/350)) }}</td>
                        <?php $totalDoors += ((($roofingSize * 350)/350)); ?>
                        <td>{{ number_format(((($roofingSize * 350)/350)) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($roofingSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Electrical & Plumbing</td>
                        <td>{{ number_format((($enpSize * 350)/350)) }}</td>
                        <?php $totalDoors += ((($enpSize * 350)/350)); ?>
                        <td>{{ number_format(((($enpSize * 350)/350)) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($enpSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Plastering</td>
                        <td>{{ number_format((($plasteringSize * 350)/350)) }}</td>
                        <?php $totalDoors += ((($plasteringSize * 350)/350)); ?>
                        <td>{{ number_format(((($plasteringSize * 350)/350)) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($plasteringSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Flooring</td>
                        <td>{{ number_format((($flooringSize * 350)/350)) }}</td>
                        <?php $totalDoors += ((($flooringSize * 350)/350)); ?>
                        <td>{{ number_format(((($flooringSize * 350)/350)) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($flooringSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td>{{ number_format((($carpentrySize * 350)/350)) }}</td>
                        <?php $totalDoors += ((($carpentrySize * 350)/350)); ?>
                        <td>{{ number_format(((($carpentrySize * 350)/350)) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($carpentrySize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Paintings</td>
                        <td>{{ number_format((($paintingSize * 350)/350)/100*0) }}</td>
                        <?php $totalDoors += ((($paintingSize * 350)/350)/100*0); ?>
                        <td>{{ number_format(((($paintingSize * 350)/350)/100*0) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($paintingSize * 350)/350)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Fixtures</td>
                        <td>{{ number_format((($fixturesSize * 350)/350)/100*0) }}</td>
                        <?php $totalDoors += ((($fixturesSize * 350)/350)/100*0); ?>
                        <td>{{ number_format(((($fixturesSize * 350)/350)/100*0) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($fixturesSize * 350)/350)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Completion</td>
                        <td>{{ number_format((($completionSize * 350)/350)/100*0) }}</td>
                        <?php $totalDoors += ((($completionSize * 350)/350)/100*0); ?>
                        <td>{{ number_format(((($completionSize * 350)/350)/100*0) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($completionSize * 350)/350)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th>{{ number_format($totalDoors) }}</th>
                        <th>{{ number_format($totalDoorsPrice) }}</th>
                    </tr>
                    <tr>
                        <th>Monthly Requirement</th>
                        <th>{{ number_format($totalDoors/$bCycle) }}</th>
                        <th>{{ number_format($totalDoorsPrice/$bCycle) }}</th>
                    </tr>
                    </tbody>
                </table>
        <?php
                break;
            case "": ?>
                <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Nos. Required</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Planning</td>
                        <td>{{ number_format(($planningSize * 350)/350) }}</td>
                        <?php $totalDoors += (($planningSize * 350)/350); ?>
                        <td>{{ number_format((($planningSize * 350)/350) * $price) }}</td>
                        <?php $totalDoorsPrice += ((($planningSize * 350)/350) * $price); ?>
                    </tr>
                    <tr>
                        <td>Digging</td>
                        <td>{{ number_format(($diggingSize * 350)/350) }}</td>
                        <?php $totalDoors += (($diggingSize * 350)/350); ?>
                        <td>{{ number_format((($diggingSize * 350)/350) * $price) }}</td>
                        <?php $totalDoorsPrice += ((($diggingSize * 350)/350) * $price); ?>
                    </tr>
                    <tr>
                        <td>Foundation</td>
                        <td>{{ number_format((($foundationSize * 350)/350)) }}</td>
                        <?php $totalDoors += ((($foundationSize * 350)/350)); ?>
                        <td>{{ number_format(((($foundationSize * 350)/350)) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($foundationSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Pillars</td>
                        <td>{{ number_format((($pillarsSize * 350)/350)) }}</td>
                        <?php $totalDoors += ((($pillarsSize * 350)/350)); ?>
                        <td>{{ number_format(((($pillarsSize * 350)/350)) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($pillarsSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Walls</td>
                        <td>{{ number_format((($wallsSize * 350)/350)) }}</td>
                        <?php $totalDoors += ((($wallsSize * 350)/350)); ?>
                        <td>{{ number_format(((($wallsSize * 350)/350)) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($wallsSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Roofing</td>
                        <td>{{ number_format((($roofingSize * 350)/350)/100*100) }}</td>
                        <?php $totalDoors += ((($roofingSize * 350)/350)/100*100); ?>
                        <td>{{ number_format(((($roofingSize * 350)/350)/100*100) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($roofingSize * 350)/350)/100*100) * $price); ?>
                    </tr>
                    <tr>
                        <td>Electrical & Plumbing</td>
                        <td>{{ number_format((($enpSize * 350)/350)/100*100) }}</td>
                        <?php $totalDoors += ((($enpSize * 350)/350)/100*100); ?>
                        <td>{{ number_format(((($enpSize * 350)/350)/100*100) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($enpSize * 350)/350)/100*100) * $price); ?>
                    </tr>
                    <tr>
                        <td>Plastering</td>
                        <td>{{ number_format((($plasteringSize * 350)/350)) }}</td>
                        <?php $totalDoors += ((($plasteringSize * 350)/350)); ?>
                        <td>{{ number_format(((($plasteringSize * 350)/350)) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($plasteringSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Flooring</td>
                        <td>{{ number_format((($flooringSize * 350)/350)) }}</td>
                        <?php $totalDoors += ((($flooringSize * 350)/350)); ?>
                        <td>{{ number_format(((($flooringSize * 350)/350)) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($flooringSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td>{{ number_format((($carpentrySize * 350)/350)) }}</td>
                        <?php $totalDoors += ((($carpentrySize * 350)/350)); ?>
                        <td>{{ number_format(((($carpentrySize * 350)/350)) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($carpentrySize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Paintings</td>
                        <td>{{ number_format((($paintingSize * 350)/350)/100*0) }}</td>
                        <?php $totalDoors += ((($paintingSize * 350)/350)/100*0); ?>
                        <td>{{ number_format(((($paintingSize * 350)/350)/100*0) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($paintingSize * 350)/350)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Fixtures</td>
                        <td>{{ number_format((($fixturesSize * 350)/350)/100*0) }}</td>
                        <?php $totalDoors += ((($fixturesSize * 350)/350)/100*0); ?>
                        <td>{{ number_format(((($fixturesSize * 350)/350)/100*0) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($fixturesSize * 350)/350)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Completion</td>
                        <td>{{ number_format((($completionSize * 350)/350)/100*0) }}</td>
                        <?php $totalDoors += ((($completionSize * 350)/350)/100*0); ?>
                        <td>{{ number_format(((($completionSize * 350)/350)/100*0) * $price) }}</td>
                        <?php $totalDoorsPrice += (((($completionSize * 350)/350)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th>{{ number_format($totalDoors) }}</th>
                        <th>{{ number_format($totalDoorsPrice) }}</th>
                    </tr>
                    <tr>
                        <th>Monthly Requirement</th>
                        <th>{{ number_format($totalDoors/$bCycle) }}</th>
                        <th>{{ number_format($totalDoorsPrice/$bCycle) }}</th>
                    </tr>
                    </tbody>
                </table>
        <?php
                break;
            case "automation": ?>
            <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Nos. Required</th>
                        <th>Amount</th>
                    </thead>
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
                <td>{{ number_format((($foundationSize * 30)/30) * $price) }}</td>
                <?php $totalCementPrice += ((($foundationSize * 30)/30) * $price); ?>
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
                <?php $totalCementPrice += (((($roofingSize * 30)/30)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format((($enpSize * 30)/30)) }}</td>
                <?php $totalCementBags += (($enpSize * 30)/30); ?>
                <td>{{ number_format((($enpSize * 30)/30) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 30)/30) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 30)/30)}}</td>
                <?php $totalCementBags += (($plasteringSize * 30)/30); ?>
                <td>{{ number_format((($plasteringSize * 30)/30) * $price) }}</td>
                <?php $totalCementPrice += (((($plasteringSize * 30)/30)) * $price); ?>
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
                <td>{{ number_format((($carpentrySize * 30)/30) * $price) }}</td>
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
        </table>
        <?php
                break;
            case "flooring": ?>
                <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Nos. Required</th>
                        <th>Amount</th>
                    </thead>
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
                            <td>{{ number_format((($foundationSize * 0.8)/0.8) * $price) }}</td>
                            <?php $totalCementPrice += ((($foundationSize * 0.8)/0.8) * $price); ?>
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
                            <?php $totalCementPrice += (((($roofingSize * 0.8)/0.8)) * $price); ?>
                        </tr>
                        <tr>
                            <td>Electrical & Plumbing</td>
                            <td>{{ number_format(($enpSize * 0.8)/0.8) }}</td>
                            <?php $totalCementBags += (($enpSize * 0.8)/0.8); ?>
                            <td>{{ number_format((($enpSize * 0.8)/0.8) * $price) }}</td>
                            <?php $totalCementPrice += ((($enpSize * 0.8)/0.8) * $price); ?>
                        </tr>
                        <tr>
                            <td>Plastering</td>
                            <td>{{ number_format(($plasteringSize * 0.8)/0.8)}}</td>
                            <?php $totalCementBags += (($plasteringSize * 0.8)/0.8); ?>
                            <td>{{ number_format((($plasteringSize * 0.8)/0.8) * $price) }}</td>
                            <?php $totalCementPrice += (((($plasteringSize * 0.8)/0.8)) * $price); ?>
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
                            <td>{{ number_format(((($carpentrySize * 0.8)/0.8) * $price)) }}</td>
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
                            <td>{{ number_format(($fixturesSize * 0)) }}</td>
                            <?php $totalCementBags += ((($fixturesSize * 0))); ?>
                            <td>{{ number_format(((($fixturesSize * 0))) * $price) }}</td>
                            <?php $totalCementPrice += (((($fixturesSize * 0))) * $price); ?>
                        </tr>
                        <tr>
                            <td>Completion</td>
                            <td>{{ number_format((($completionSize * 0))) }}</td>
                            <?php $totalCementBags += ((($completionSize * 0))); ?>
                            <td>{{ number_format(((($completionSize * 0))) * $price) }}</td>
                            <?php $totalCementPrice += (((($completionSize * 0))) * $price); ?>
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
                </table>
        <?php
                break;
            case "bathroom": ?>
            <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Nos. Required</th>
                        <th>Amount</th>
                    </thead>
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
                    <td>{{ number_format((($foundationSize * 70)/70) * $price) }}</td>
                    <?php $totalCementPrice += ((($foundationSize * 70)/70) * $price); ?>
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
                    <?php $totalCementPrice += (((($roofingSize * 70)/70)) * $price); ?>
                </tr>
                <tr>
                    <td>Electrical & Plumbing</td>
                    <td>{{ number_format(($enpSize * 70)/70) }}</td>
                    <?php $totalCementBags += (($enpSize * 70)/70); ?>
                    <td>{{ number_format((($enpSize * 70)/70) * $price) }}</td>
                    <?php $totalCementPrice += ((($enpSize * 70)/70) * $price); ?>
                </tr>
                <tr>
                    <td>Plastering</td>
                    <td>{{ number_format(($plasteringSize * 70)/70)}}</td>
                    <?php $totalCementBags += (($plasteringSize * 70)/70); ?>
                    <td>{{ number_format((($plasteringSize * 70)/70) * $price) }}</td>
                    <?php $totalCementPrice += (((($plasteringSize * 70)/70)) * $price); ?>
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
                    <td>{{ number_format((($carpentrySize * 70)/70) * $price) }}</td>
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
                    <td>{{ number_format((($completionSize * 0))) }}</td>
                    <?php $totalCementBags += ((($completionSize * 0))); ?>
                    <td>{{ number_format(((($completionSize * 0))) * $price) }}</td>
                    <?php $totalCementPrice += (((($completionSize * 0))) * $price); ?>
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
        </table>
        <?php
                break;
            case "wood": ?>
            <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Nos. Required</th>
                        <th>Amount</th>
                    </thead>
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
                <td>{{ number_format((($foundationSize * 120)/120) * $price) }}</td>
                <?php $totalCementPrice += ((($foundationSize * 120)/120) * $price); ?>
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
                <?php $totalCementPrice += (((($roofingSize * 120)/120)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format(($enpSize * 120)/120) }}</td>
                <?php $totalCementBags += (($enpSize * 120)/120); ?>
                <td>{{ number_format((($enpSize * 120)/120) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 120)/120) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 120)/120)}}</td>
                <?php $totalCementBags += (($plasteringSize * 120)/120); ?>
                <td>{{ number_format((($plasteringSize * 120)/120) * $price) }}</td>
                <?php $totalCementPrice += (((($plasteringSize * 120)/120)) * $price); ?>
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
                <td>{{ number_format((($carpentrySize * 120)/120) * $price) }}</td>
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
                <td>{{ number_format((($completionSize * 0))) }}</td>
                <?php $totalCementBags += ((($completionSize * 0))); ?>
                <td>{{ number_format(((($completionSize * 0))) * $price) }}</td>
                <?php $totalCementPrice += (((($completionSize * 0))) * $price); ?>
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
        </table>
        <?php
                break;
            case "paints"; ?>
                <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Nos. Required</th>
                        <th>Amount</th>
                    </thead>
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
                <td>{{ number_format((($foundationSize * 55)/55) * $price) }}</td>
                <?php $totalCementPrice += ((($foundationSize * 55)/55) * $price); ?>
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
                <?php $totalCementPrice += (((($roofingSize * 55)/55)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format(($enpSize * 55)/55) }}</td>
                <?php $totalCementBags += (($enpSize * 55)/55); ?>
                <td>{{ number_format((($enpSize * 55)/55) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 55)/55) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 55)/55)}}</td>
                <?php $totalCementBags += (($plasteringSize * 55)/55); ?>
                <td>{{ number_format((($plasteringSize * 55)/55) * $price) }}</td>
                <?php $totalCementPrice += (((($plasteringSize * 55)/55)) * $price); ?>
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
                <td>{{ number_format((($carpentrySize * 55)/55) * $price) }}</td>
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
                <td>{{ number_format(($fixturesSize * 0)) }}</td>
                <?php $totalCementBags += ((($fixturesSize * 0))); ?>
                <td>{{ number_format(((($fixturesSize * 0))) * $price) }}</td>
                <?php $totalCementPrice += (((($fixturesSize * 0))) * $price); ?>
            </tr>
            <tr>
                <td>Completion</td>
                <td>{{ number_format((($completionSize * 0))) }}</td>
                <?php $totalCementBags += ((($completionSize * 0))); ?>
                <td>{{ number_format(((($completionSize * 0))) * $price) }}</td>
                <?php $totalCementPrice += (((($completionSize * 0))) * $price); ?>
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
                </table>
        <?php
                break;
            case "wardrobe": ?>
            <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Nos. Required</th>
                        <th>Amount</th>
                    </thead>
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
                    <td>{{ number_format((($foundationSize * 60)/60) * $price) }}</td>
                    <?php $totalCementPrice += ((($foundationSize * 60)/60) * $price); ?>
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
                    <?php $totalCementPrice += (((($roofingSize * 60)/60)) * $price); ?>
                </tr>
                <tr>
                    <td>Electrical & Plumbing</td>
                    <td>{{ number_format(($enpSize * 60)/60) }}</td>
                    <?php $totalCementBags += (($enpSize * 60)/60); ?>
                    <td>{{ number_format((($enpSize * 60)/60) * $price) }}</td>
                    <?php $totalCementPrice += ((($enpSize * 60)/60) * $price); ?>
                </tr>
                <tr>
                    <td>Plastering</td>
                    <td>{{ number_format(($plasteringSize * 60)/60)}}</td>
                    <?php $totalCementBags += (($plasteringSize * 60)/60); ?>
                    <td>{{ number_format((($plasteringSize * 60)/60) * $price) }}</td>
                    <?php $totalCementPrice += (((($plasteringSize * 60)/60)) * $price); ?>
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
                    <td>{{ number_format((($carpentrySize * 60)/60) * $price) }}</td>
                    <?php $totalCementPrice += ((($carpentrySize * 60)/60) * $price); ?>
                </tr>
                <tr>
                    <td>Paintings</td>
                    <td>{{ number_format(($paintingSize * 0)) }}</td>
                    <?php $totalCementBags += (($paintingSize * 0)); ?>
                    <td>{{ number_format((($paintingSize * 0)) * $price) }}</td>
                    <?php $totalCementPrice += ((($paintingSize * 0)) * $price); ?>
                </tr>
                <tr>
                    <td>Fixtures</td>
                    <td>{{ number_format(($fixturesSize * 0)) }}</td>
                    <?php $totalCementBags += ((($fixturesSize * 0))); ?>
                    <td>{{ number_format(((($fixturesSize * 0))) * $price) }}</td>
                    <?php $totalCementPrice += (((($fixturesSize * 0))) * $price); ?>
                </tr>
                <tr>
                    <td>Completion</td>
                    <td>{{ number_format((($completionSize * 0))) }}</td>
                    <?php $totalCementBags += ((($completionSize * 0))); ?>
                    <td>{{ number_format(((($completionSize * 0))) * $price) }}</td>
                    <?php $totalCementPrice += (((($completionSize * 0))) * $price); ?>
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
        </table>
        <?php
            break;
            case "appliences"; ?>
            <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Nos. Required</th>
                        <th>Amount</th>
                    </thead>
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
                    <td>{{ number_format((($foundationSize * 200)/200) * $price) }}</td>
                    <?php $totalCementPrice += ((($foundationSize * 200)/200) * $price); ?>
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
                    <?php $totalCementPrice += (((($roofingSize * 200)/200)) * $price); ?>
                </tr>
                <tr>
                    <td>Electrical & Plumbing</td>
                    <td>{{ number_format(($enpSize * 200)/200) }}</td>
                    <?php $totalCementBags += (($enpSize * 200)/200); ?>
                    <td>{{ number_format((($enpSize * 200)/200) * $price) }}</td>
                    <?php $totalCementPrice += ((($enpSize * 200)/200) * $price); ?>
                </tr>
                <tr>
                    <td>Plastering</td>
                    <td>{{ number_format(($plasteringSize * 200)/200)}}</td>
                    <?php $totalCementBags += (($plasteringSize * 200)/200); ?>
                    <td>{{ number_format((($plasteringSize * 200)/200) * $price) }}</td>
                    <?php $totalCementPrice += (((($plasteringSize * 200)/200)) * $price); ?>
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
                    <td>{{ number_format((($carpentrySize * 200)/200) * $price) }}</td>
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
        </table>
        <?php
                break;
            case "furnitures": ?>
                <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Nos. Required</th>
                        <th>Amount</th>
                    </thead>
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
                <td>{{ number_format((($foundationSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($foundationSize * 100)/100) * $price); ?>
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
                <?php $totalCementPrice += (((($roofingSize * 100)/100)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format(($enpSize * 100)/100) }}</td>
                <?php $totalCementBags += (($enpSize * 100)/100); ?>
                <td>{{ number_format((($enpSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 100)/100)}}</td>
                <?php $totalCementBags += (($plasteringSize * 100)/100); ?>
                <td>{{ number_format((($plasteringSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += (((($plasteringSize * 100)/100)) * $price); ?>
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
                <td>{{ number_format((($carpentrySize * 100)/100) * $price) }}</td>
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
                </table>
        <?php
                break;
            case "rails": ?>
            <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Nos. Required</th>
                        <th>Amount</th>
                    </thead>
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
                <td>{{ number_format((($foundationSize * 50)/50) * $price) }}</td>
                <?php $totalCementPrice += ((($foundationSize * 50)/50) * $price); ?>
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
                <?php $totalCementPrice += (((($roofingSize * 50)/50)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format(($enpSize * 50)/50) }}</td>
                <?php $totalCementBags += (($enpSize * 50)/50); ?>
                <td>{{ number_format((($enpSize * 50)/50) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 50)/50) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 50)/50)}}</td>
                <?php $totalCementBags += (($plasteringSize * 50)/50); ?>
                <td>{{ number_format((($plasteringSize * 50)/50) * $price) }}</td>
                <?php $totalCementPrice += (((($plasteringSize * 50)/50)) * $price); ?>
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
                <td>{{ number_format((($carpentrySize * 50)/50) * $price) }}</td>
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
        </table>
        <?php
                break;
            case "glasses": ?>
                <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Nos. Required</th>
                        <th>Amount</th>
                    </thead>
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
                            <td>{{ number_format((($foundationSize * 25)/25) * $price) }}</td>
                            <?php $totalCementPrice += ((($foundationSize * 25)/25) * $price); ?>
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
                            <?php $totalCementPrice += (((($roofingSize * 25)/25)) * $price); ?>
                        </tr>
                        <tr>
                            <td>Electrical & Plumbing</td>
                            <td>{{ number_format(($enpSize * 25)/25) }}</td>
                            <?php $totalCementBags += (($enpSize * 25)/25); ?>
                            <td>{{ number_format((($enpSize * 25)/25) * $price) }}</td>
                            <?php $totalCementPrice += ((($enpSize * 25)/25) * $price); ?>
                        </tr>
                        <tr>
                            <td>Plastering</td>
                            <td>{{ number_format(($plasteringSize * 25)/25)}}</td>
                            <?php $totalCementBags += (($plasteringSize * 25)/25); ?>
                            <td>{{ number_format((($plasteringSize * 25)/25) * $price) }}</td>
                            <?php $totalCementPrice += (((($plasteringSize * 25)/25)) * $price); ?>
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
                            <td>{{ number_format((($carpentrySize * 25)/25) * $price) }}</td>
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
                            <td>{{ number_format((($completionSize * 0))) }}</td>
                            <?php $totalCementBags += ((($completionSize * 0))); ?>
                            <td>{{ number_format(((($completionSize * 0))) * $price) }}</td>
                            <?php $totalCementPrice += (((($completionSize * 0))) * $price); ?>
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
                </table>
        <?php
                break;
            case "rmc": ?>
            <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Nos. Required</th>
                        <th>Amount</th>
                    </thead>
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
                <td>{{ number_format(((($foundationSize * 0.06)/0.06)/100*65) * $price) }}</td>
                <?php $totalCementPrice += (((($foundationSize * 0.06)/0.06)/100*65) * $price); ?>
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
                <td>{{ number_format(($roofingSize * 0)) }}</td>
                <?php $totalCementBags += (($roofingSize * 0)); ?>
                <td>{{ number_format((($roofingSize * 0)) * $price) }}</td>
                <?php $totalCementPrice += (((($roofingSize * 0))) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format(($enpSize * 0)) }}</td>
                <?php $totalCementBags += (($enpSize * 0)); ?>
                <td>{{ number_format((($enpSize * 0)) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 0)) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 0))}}</td>
                <?php $totalCementBags += (($plasteringSize * 0)); ?>
                <td>{{ number_format((($plasteringSize * 0)) * $price) }}</td>
                <?php $totalCementPrice += (((($plasteringSize * 0))) * $price); ?>
            </tr>
            <tr>
                <td>Flooring</td>
                <td>{{ number_format(($flooringSize * 0)) }}</td>
                <?php $totalCementBags += (($flooringSize * 0)); ?>
                <td>{{ number_format((($flooringSize * 0)) * $price) }}</td>
                <?php $totalCementPrice += ((($flooringSize * 0)) * $price); ?>
            </tr>
            <tr>
                <td>Carpentry</td>
                <td>{{ number_format(($carpentrySize * 0)) }}</td>
                <?php $totalCementBags += (($carpentrySize * 0)); ?>
                <td>{{ number_format((($carpentrySize * 0)) * $price) }}</td>
                <?php $totalCementPrice += ((($carpentrySize * 0)) * $price); ?>
            </tr>
            <tr>
                <td>Paintings</td>
                <td>{{ number_format(($paintingSize * 0)) }}</td>
                <?php $totalCementBags += (($paintingSize * 0)); ?>
                <td>{{ number_format((($paintingSize * 0)) * $price) }}</td>
                <?php $totalCementPrice += ((($paintingSize * 0)) * $price); ?>
            </tr>
            <tr>
                <td>Fixtures</td>
                <td>{{ number_format(($fixturesSize * 0)) }}</td>
                <?php $totalCementBags += ((($fixturesSize * 0))); ?>
                <td>{{ number_format(((($fixturesSize * 0))) * $price) }}</td>
                <?php $totalCementPrice += (((($fixturesSize * 0))) * $price); ?>
            </tr>
            <tr>
                <td>Completion</td>
                <td>{{ number_format((($completionSize * 0))) }}</td>
                <?php $totalCementBags += ((($completionSize * 0))); ?>
                <td>{{ number_format(((($completionSize * 0))) * $price) }}</td>
                <?php $totalCementPrice += (((($completionSize * 0))) * $price); ?>
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
        <?php
                break;
            case "ceilling": ?>
                <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Nos. Required</th>
                        <th>Amount</th>
                    </thead>
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
                            <td>{{ number_format((($foundationSize * 35)/35) * $price) }}</td>
                            <?php $totalCementPrice += ((($foundationSize * 35)/35) * $price); ?>
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
                            <?php $totalCementPrice += (((($roofingSize * 35)/35)) * $price); ?>
                        </tr>
                        <tr>
                            <td>Electrical & Plumbing</td>
                            <td>{{ number_format(($enpSize * 35)/35) }}</td>
                            <?php $totalCementBags += (($enpSize * 35)/35); ?>
                            <td>{{ number_format((($enpSize * 35)/35) * $price) }}</td>
                            <?php $totalCementPrice += ((($enpSize * 35)/35) * $price); ?>
                        </tr>
                        <tr>
                            <td>Plastering</td>
                            <td>{{ number_format(($plasteringSize * 35)/35)}}</td>
                            <?php $totalCementBags += (($plasteringSize * 35)/35); ?>
                            <td>{{ number_format((($plasteringSize * 35)/35) * $price) }}</td>
                            <?php $totalCementPrice += (((($plasteringSize * 35)/35)) * $price); ?>
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
                            <td>{{ number_format((($carpentrySize * 35)/35) * $price) }}</td>
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
                            <td>{{ number_format((($completionSize * 0))) }}</td>
                            <?php $totalCementBags += ((($completionSize * 0))); ?>
                            <td>{{ number_format(((($completionSize * 0))) * $price) }}</td>
                            <?php $totalCementPrice += (((($completionSize * 0))) * $price); ?>
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
                </table>
        <?php
                break;
            case "fire": ?>
            <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Nos. Required</th>
                        <th>Amount</th>
                    </thead>
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
                <td>{{ number_format((($foundationSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($foundationSize * 100)/100) * $price); ?>
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
                <?php $totalCementPrice += (((($roofingSize * 100)/100)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format(($enpSize * 100)/100) }}</td>
                <?php $totalCementBags += (($enpSize * 100)/100); ?>
                <td>{{ number_format((($enpSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 100)/100) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 100)/100)}}</td>
                <?php $totalCementBags += (($plasteringSize * 100)/100); ?>
                <td>{{ number_format((($plasteringSize * 100)/100) * $price) }}</td>
                <?php $totalCementPrice += (((($plasteringSize * 100)/100)) * $price); ?>
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
                <td>{{ number_format((($carpentrySize * 100)/100) * $price) }}</td>
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
        </table>
        <?php
                break;
            case "automation": ?>
                <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Nos. Required</th>
                        <th>Amount</th>
                    </thead>
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
                <td>{{ number_format((($foundationSize * 30)/30) * $price) }}</td>
                <?php $totalCementPrice += ((($foundationSize * 30)/30) * $price); ?>
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
                <?php $totalCementPrice += (((($roofingSize * 30)/30)) * $price); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format(($enpSize * 30)/30) }}</td>
                <?php $totalCementBags += (($enpSize * 30)/30); ?>
                <td>{{ number_format((($enpSize * 30)/30) * $price) }}</td>
                <?php $totalCementPrice += ((($enpSize * 30)/30) * $price); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format(($plasteringSize * 30)/30)}}</td>
                <?php $totalCementBags += (($plasteringSize * 30)/30); ?>
                <td>{{ number_format((($plasteringSize * 30)/30) * $price) }}</td>
                <?php $totalCementPrice += (((($plasteringSize * 30)/30)) * $price); ?>
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
                <td>{{ number_format((($carpentrySize * 30)/30) * $price) }}</td>
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
                </table>
        <?php
            default:
                echo("No category");
        }
        ?>
</div>
@endif
@endsection
