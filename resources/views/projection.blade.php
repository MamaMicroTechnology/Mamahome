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
<div id="projection" class="col-md-6 col-md-offset-3">
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="pull-center col-md-3 col-md-offset-5"><b>Projection</b></div>
        <div class="pull-right">{{ date('d-m-Y') }}</div>    
        <br>
    </div>
    <div class="panel-body">
<div class="col-md-6">
    <form class="form-horizontal" action="{{ URL::to('/') }}/projection" method="GET">
        <div class="form-group">
        <label style="text-align:left;" for="wards" class="control-label col-sm-6">Wards</label>
        <div class="col-md-6">
            <select id="wards" required class="form-control" name="ward">
                <option value="">--Select--</option>
                <option value="All" {{ isset($_GET['ward']) ? $_GET['ward'] == "All" ? "selected" : "" : "" }}>All</option>
                @foreach($wards as $ward)
                <option value="{{ $ward->id}}" {{ $ward->id == $wardId? 'selected':'' }}>{{ $ward->ward_name }}</option>
                @endforeach
            </select>
        </div>
        </div>
        <div class="form-group">
        <label style="text-align:left;" class="control-label col-sm-6" for="categories">Categories</label>
        <div class="col-md-6">
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
            </select>
        </div>
        </div>
        <div class="form-group">
        <label style="text-align:left;" class="control-label col-sm-6" for="price">Price</label>
        <div class="col-md-6">
        <input id="price" required value="{{ isset($_GET['bCycle']) ? $_GET['price'] : '' }}" type="text" name="price" id="price" placeholder="Price" class="form-control">
        </div>
        </div>
        <div class="form-group">
        <label style="text-align:left;" class="control-label col-sm-6" for="bCycle">Business Cycle</label>
        <div class="col-md-6">
        <input required value="{{ isset($_GET['bCycle']) ? $_GET['bCycle'] : '' }}" type="text" name="bCycle" id="bCycle" placeholder="Business Cycle" class="form-control"><br>
        </div>
        </div>
        <button class="btn btn-success form-control">Proceed</button>
    </form>
    <br>
    <div>
        <label for="target">Monthly Target</label>
        <input id="percentage" type="text" class="form-control" placeholder="Input Your Percentage From Monthly Projection"><br>
        <button onclick="calculateTarget()" class="btn btn-success form-control">Proceed</button>
        <br>
        <br>
        <p id="monthlyTarget"></p>
    </div>
    <div id="lock" class="hidden">
        <input class="form-control" type="text" placeholder="Perentage For Transactional Profit" id="per">
        <br>
        <p id="tp"></p>
        <button onclick="transactionalProfit()" class="btn btn-primary form-control">Proceed</button>
        <br><br>
        <button class="btn btn-primary form-control" onclick="save()">Lock Target</button>
    </div>
</div>
<div class="col-md-6">
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
                        <th>Requirement</th>
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
                    <?php $totalCementBags += (($planningSize * 4)/1000); ?>
                    <td>{{ number_format((($planningSize * 4)/1000) * $price) }}</td>
                    <?php $totalCementPrice += ((($planningSize * 4)/1000) * $price); ?>
                </tr>
                <tr>
                    <td>Digging</td>
                    <td>{{ number_format(($diggingSize * 4)/1000) }}</td>
                    <?php $totalCementBags += (($diggingSize * 4)/1000); ?>
                    <td>{{ number_format((($diggingSize * 4)/1000) * $price) }}</td>
                    <?php $totalCementPrice += ((($diggingSize * 4)/1000) * $price); ?>
                </tr>
                <tr>
                    <td>Foundation</td>
                    <td>{{ number_format((($foundationSize * 4)/1000)/100*70) }}</td>
                    <?php $totalCementBags += ((($foundationSize * 4)/1000)/100*70); ?>
                    <td>{{ number_format(((($foundationSize * 4)/1000)/100*70) * $price) }}</td>
                    <?php $totalCementPrice += (((($foundationSize * 4)/1000)/100*70) * $price); ?>
                </tr>
                <tr>
                    <td>Pillars</td>
                    <td>{{ number_format((($pillarsSize * 4)/1000)/100*35) }}</td>
                    <?php $totalCementBags += ((($pillarsSize * 4)/1000)/100*35); ?>
                    <td>{{ number_format(((($pillarsSize * 4)/1000)/100*35) * $price) }}</td>
                    <?php $totalCementPrice += (((($pillarsSize * 4)/1000)/100*35) * $price); ?>
                </tr>
                <tr>
                    <td>Walls</td>
                    <td>{{ number_format((($wallsSize * 4)/1000)/100*35) }}</td>
                    <?php $totalCementBags += ((($wallsSize * 4)/1000)/100*35); ?>
                    <td>{{ number_format(((($wallsSize * 4)/1000)/100*35) * $price) }}</td>
                    <?php $totalCementPrice += (((($wallsSize * 4)/1000)/100*35) * $price); ?>
                </tr>
                <tr>
                    <td>Roofing</td>
                    <td>{{ number_format((($roofingSize * 4)/1000)/100*35) }}</td>
                    <?php $totalCementBags += ((($roofingSize * 4)/1000)/100*35); ?>
                    <td>{{ number_format(((($roofingSize * 4)/1000)/100*35) * $price) }}</td>
                    <?php $totalCementPrice += (((($roofingSize * 4)/1000)/100*35) * $price); ?>
                </tr>
                <tr>
                    <td>Electrical & Plumbing</td>
                    <td>{{ number_format((($enpSize * 4)/1000)/100*0) }}</td>
                    <?php $totalCementBags += ((($enpSize * 4)/1000)/100*0); ?>
                    <td>{{ number_format(((($enpSize * 4)/1000)/100*0) * $price) }}</td>
                    <?php $totalCementPrice += (((($enpSize * 4)/1000)/100*0) * $price); ?>
                </tr>
                <tr>
                    <td>Plastering</td>
                    <td>{{ number_format((($plasteringSize * 4)/1000)/100*0) }}</td>
                    <?php $totalCementBags += ((($plasteringSize * 4)/1000)/100*0); ?>
                    <td>{{ number_format(((($plasteringSize * 4)/1000)/100*0) * $price) }}</td>
                    <?php $totalCementPrice += (((($plasteringSize * 4)/1000)/100*0) * $price); ?>
                </tr>
                <tr>
                    <td>Flooring</td>
                    <td>{{ number_format((($flooringSize * 4)/1000)/100*0) }}</td>
                    <?php $totalCementBags += ((($flooringSize * 4)/1000)/100*0); ?>
                    <td>{{ number_format(((($flooringSize * 4)/1000)/100*0) * $price) }}</td>
                    <?php $totalCementPrice += (((($flooringSize * 4)/1000)/100*0) * $price); ?>
                </tr>
                <tr>
                    <td>Carpentry</td>
                    <td>{{ number_format((($carpentrySize * 4)/1000)/100*0) }}</td>
                    <?php $totalCementBags += ((($carpentrySize * 4)/1000)/100*0); ?>
                    <td>{{ number_format(((($carpentrySize * 4)/1000)/100*0) * $price) }}</td>
                    <?php $totalCementPrice += (((($carpentrySize * 4)/1000)/100*0) * $price); ?>
                </tr>
                <tr>
                    <td>Paintings</td>
                    <td>{{ number_format((($paintingSize * 4)/1000)/100*0) }}</td>
                    <?php $totalCementBags += ((($paintingSize * 4)/1000)/100*0); ?>
                    <td>{{ number_format(((($paintingSize * 4)/1000)/100*0) * $price) }}</td>
                    <?php $totalCementPrice += (((($paintingSize * 4)/1000)/100*0) * $price); ?>
                </tr>
                <tr>
                    <td>Fixtures</td>
                    <td>{{ number_format((($fixturesSize * 4)/1000)/100*0) }}</td>
                    <?php $totalCementBags += ((($fixturesSize * 4)/1000)/100*0); ?>
                    <td>{{ number_format(((($fixturesSize * 4)/1000)/100*0) * $price) }}</td>
                    <?php $totalCementPrice += (((($fixturesSize * 4)/1000)/100*0) * $price); ?>
                </tr>
                <tr>
                    <td>Completion</td>
                    <td>{{ number_format((($completionSize * 4)/1000)/100*0) }}</td>
                    <?php $totalCementBags += ((($completionSize * 4)/1000)/100*0); ?>
                    <td>{{ number_format(((($completionSize * 4)/1000)/100*0) * $price) }}</td>
                    <?php $totalCementPrice += (((($completionSize * 4)/1000)/100*0) * $price); ?>
                </tr>
                <tr>
                    <th>Total</th>
                    <th>{{ number_format($totalCementBags) }}</th>
                    <th>{{ number_format($totalCementPrice) }}</th>
                </tr>
                <tr>
                    <th>Requirement</th>
                    <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                    <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
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
                            <?php $totalCementBags += (($planningSize * 1.2)/23.25); ?>
                            <td>{{ number_format((($planningSize * 1.2)/23.25) * $price) }}</td>
                            <?php $totalCementPrice += ((($planningSize * 1.2)/23.25) * $price); ?>
                        </tr>
                        <tr>
                            <td>Digging</td>
                            <td>{{ number_format(($diggingSize * 1.2)/23.25) }}</td>
                            <?php $totalCementBags += (($diggingSize * 1.2)/23.25); ?>
                            <td>{{ number_format((($diggingSize * 1.2)/23.25) * $price) }}</td>
                            <?php $totalCementPrice += ((($diggingSize * 1.2)/23.25) * $price); ?>
                        </tr>
                        <tr>
                            <td>Foundation</td>
                            <td>{{ number_format((($foundationSize * 1.2)/23.25)/100*90) }}</td>
                            <?php $totalCementBags += ((($foundationSize * 1.2)/23.25)/100*90); ?>
                            <td>{{ number_format(((($foundationSize * 1.2)/23.25)/100*90) * $price) }}</td>
                            <?php $totalCementPrice += (((($foundationSize * 1.2)/23.25)/100*90) * $price); ?>
                        </tr>
                        <tr>
                            <td>Pillars</td>
                            <td>{{ number_format((($pillarsSize * 1.2)/23.25)/100*70) }}</td>
                            <?php $totalCementBags += ((($pillarsSize * 1.2)/23.25)/100*70); ?>
                            <td>{{ number_format(((($pillarsSize * 1.2)/23.25)/100*70) * $price) }}</td>
                            <?php $totalCementPrice += (((($pillarsSize * 1.2)/23.25)/100*70) * $price); ?>
                        </tr>
                        <tr>
                            <td>Walls</td>
                            <td>{{ number_format((($wallsSize * 1.2)/23.25)/100*50) }}</td>
                            <?php $totalCementBags += ((($wallsSize * 1.2)/23.25)/100*50); ?>
                            <td>{{ number_format(((($wallsSize * 1.2)/23.25)/100*50) * $price) }}</td>
                            <?php $totalCementPrice += (((($wallsSize * 1.2)/23.25)/100*50) * $price); ?>
                        </tr>
                        <tr>
                            <td>Roofing</td>
                            <td>{{ number_format((($roofingSize * 1.2)/23.25)/100*35) }}</td>
                            <?php $totalCementBags += ((($roofingSize * 1.2)/23.25)/100*35); ?>
                            <td>{{ number_format(((($roofingSize * 1.2)/23.25)/100*35) * $price) }}</td>
                            <?php $totalCementPrice += (((($roofingSize * 1.2)/23.25)/100*35) * $price); ?>
                        </tr>
                        <tr>
                            <td>Electrical & Plumbing</td>
                            <td>{{ number_format((($enpSize * 1.2)/23.25)/100*35) }}</td>
                            <?php $totalCementBags += ((($enpSize * 1.2)/23.25)/100*35); ?>
                            <td>{{ number_format(((($enpSize * 1.2)/23.25)/100*35) * $price) }}</td>
                            <?php $totalCementPrice += (((($enpSize * 1.2)/23.25)/100*35) * $price); ?>
                        </tr>
                        <tr>
                            <td>Plastering</td>
                            <td>{{ number_format((($plasteringSize * 1.2)/23.25)/100*10) }}</td>
                            <?php $totalCementBags += ((($plasteringSize * 1.2)/23.25)/100*10); ?>
                            <td>{{ number_format(((($plasteringSize * 1.2)/23.25)/100*10) * $price) }}</td>
                            <?php $totalCementPrice += (((($plasteringSize * 1.2)/23.25)/100*10) * $price); ?>
                        </tr>
                        <tr>
                            <td>Flooring</td>
                            <td>{{ number_format((($flooringSize * 1.2)/23.25)/100*0) }}</td>
                            <?php $totalCementBags += ((($flooringSize * 1.2)/23.25)/100*0); ?>
                            <td>{{ number_format(((($flooringSize * 1.2)/23.25)/100*0) * $price) }}</td>
                            <?php $totalCementPrice += (((($flooringSize * 1.2)/23.25)/100*0) * $price); ?>
                        </tr>
                        <tr>
                            <td>Carpentry</td>
                            <td>{{ number_format((($carpentrySize * 1.2)/23.25)/100*0) }}</td>
                            <?php $totalCementBags += ((($carpentrySize * 1.2)/23.25)/100*0); ?>
                            <td>{{ number_format(((($carpentrySize * 1.2)/23.25)/100*0) * $price) }}</td>
                            <?php $totalCementPrice += (((($carpentrySize * 1.2)/23.25)/100*0) * $price); ?>
                        </tr>
                        <tr>
                            <td>Paintings</td>
                            <td>{{ number_format((($paintingSize * 1.2)/23.25)/100*0) }}</td>
                            <?php $totalCementBags += ((($paintingSize * 1.2)/23.25)/100*0); ?>
                            <td>{{ number_format(((($paintingSize * 1.2)/23.25)/100*0) * $price) }}</td>
                            <?php $totalCementPrice += (((($paintingSize * 1.2)/23.25)/100*0) * $price); ?>
                        </tr>
                        <tr>
                            <td>Fixtures</td>
                            <td>{{ number_format((($fixturesSize * 1.2)/23.25)/100*0) }}</td>
                            <?php $totalCementBags += ((($fixturesSize * 1.2)/23.25)/100*0); ?>
                            <td>{{ number_format(((($fixturesSize * 1.2)/23.25)/100*0) * $price) }}</td>
                            <?php $totalCementPrice += (((($fixturesSize * 1.2)/23.25)/100*0) * $price); ?>
                        </tr>
                        <tr>
                            <td>Completion</td>
                            <td>{{ number_format((($completionSize * 1.2)/23.25)/100*0) }}</td>
                            <?php $totalCementBags += ((($completionSize * 1.2)/23.25)/100*0); ?>
                            <td>{{ number_format(((($completionSize * 1.2)/23.25)/100*0) * $price) }}</td>
                            <?php $totalCementPrice += (((($completionSize * 1.2)/23.25)/100*0) * $price); ?>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th>{{ number_format($totalCementBags) }}</th>
                            <th>{{ number_format($totalCementPrice) }}</th>
                        </tr>
                        <tr>
                            <th>Requirement</th>
                            <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                            <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
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
                        <?php $totalCementBags += (($planningSize * 1.35)/23.25); ?>
                        <td>{{ number_format((($planningSize * 1.35)/23.25) * $price) }}</td>
                        <?php $totalCementPrice += ((($planningSize * 1.35)/23.25) * $price); ?>
                    </tr>
                    <tr>
                        <td>Digging</td>
                        <td>{{ number_format(($diggingSize * 1.35)/23.25) }}</td>
                        <?php $totalCementBags += (($diggingSize * 1.35)/23.25); ?>
                        <td>{{ number_format((($diggingSize * 1.35)/23.25) * $price) }}</td>
                        <?php $totalCementPrice += ((($diggingSize * 1.35)/23.25) * $price); ?>
                    </tr>
                    <tr>
                        <td>Foundation</td>
                        <td>{{ number_format((($foundationSize * 1.35)/23.25)/100*80) }}</td>
                        <?php $totalCementBags += ((($foundationSize * 1.35)/23.25)/100*80); ?>
                        <td>{{ number_format(((($foundationSize * 1.35)/23.25)/100*80) * $price) }}</td>
                        <?php $totalCementPrice += (((($foundationSize * 1.35)/23.25)/100*80) * $price); ?>
                    </tr>
                    <tr>
                        <td>Pillars</td>
                        <td>{{ number_format((($pillarsSize * 1.35)/23.25)/100*50) }}</td>
                        <?php $totalCementBags += ((($pillarsSize * 1.35)/23.25)/100*50); ?>
                        <td>{{ number_format(((($pillarsSize * 1.35)/23.25)/100*50) * $price) }}</td>
                        <?php $totalCementPrice += (((($pillarsSize * 1.35)/23.25)/100*50) * $price); ?>
                    </tr>
                    <tr>
                        <td>Walls</td>
                        <td>{{ number_format((($wallsSize * 1.35)/23.25)/100*50) }}</td>
                        <?php $totalCementBags += ((($wallsSize * 1.35)/23.25)/100*50); ?>
                        <td>{{ number_format(((($wallsSize * 1.35)/23.25)/100*50) * $price) }}</td>
                        <?php $totalCementPrice += (((($wallsSize * 1.35)/23.25)/100*50) * $price); ?>
                    </tr>
                    <tr>
                        <td>Roofing</td>
                        <td>{{ number_format((($roofingSize * 1.35)/23.25)/100*50) }}</td>
                        <?php $totalCementBags += ((($roofingSize * 1.35)/23.25)/100*50); ?>
                        <td>{{ number_format(((($roofingSize * 1.35)/23.25)/100*50) * $price) }}</td>
                        <?php $totalCementPrice += (((($roofingSize * 1.35)/23.25)/100*50) * $price); ?>
                    </tr>
                    <tr>
                        <td>Electrical & Plumbing</td>
                        <td>{{ number_format((($enpSize * 1.35)/23.25)/100*0) }}</td>
                        <?php $totalCementBags += ((($enpSize * 1.35)/23.25)/100*0); ?>
                        <td>{{ number_format(((($enpSize * 1.35)/23.25)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($enpSize * 1.35)/23.25)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Plastering</td>
                        <td>{{ number_format((($plasteringSize * 1.35)/23.25)/100*0) }}</td>
                        <?php $totalCementBags += ((($plasteringSize * 1.35)/23.25)/100*0); ?>
                        <td>{{ number_format(((($plasteringSize * 1.35)/23.25)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($plasteringSize * 1.35)/23.25)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Flooring</td>
                        <td>{{ number_format((($flooringSize * 1.35)/23.25)/100*0) }}</td>
                        <?php $totalCementBags += ((($flooringSize * 1.35)/23.25)/100*0); ?>
                        <td>{{ number_format(((($flooringSize * 1.35)/23.25)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($flooringSize * 1.35)/23.25)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td>{{ number_format((($carpentrySize * 1.35)/23.25)/100*0) }}</td>
                        <?php $totalCementBags += ((($carpentrySize * 1.35)/23.25)/100*0); ?>
                        <td>{{ number_format(((($carpentrySize * 1.35)/23.25)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($carpentrySize * 1.35)/23.25)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Paintings</td>
                        <td>{{ number_format((($paintingSize * 1.35)/23.25)/100*0) }}</td>
                        <?php $totalCementBags += ((($paintingSize * 1.35)/23.25)/100*0); ?>
                        <td>{{ number_format(((($paintingSize * 1.35)/23.25)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($paintingSize * 1.35)/23.25)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Fixtures</td>
                        <td>{{ number_format((($fixturesSize * 1.35)/23.25)/100*0) }}</td>
                        <?php $totalCementBags += ((($fixturesSize * 1.35)/23.25)/100*0); ?>
                        <td>{{ number_format(((($fixturesSize * 1.35)/23.25)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($fixturesSize * 1.35)/23.25)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Completion</td>
                        <td>{{ number_format((($completionSize * 1.35)/23.25)/100*0) }}</td>
                        <?php $totalCementBags += ((($completionSize * 1.35)/23.25)/100*0); ?>
                        <td>{{ number_format(((($completionSize * 1.35)/23.25)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($completionSize * 1.35)/23.25)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th>{{ number_format($totalCementBags) }}</th>
                        <th>{{ number_format($totalCementPrice) }}</th>
                    </tr>
                    <tr>
                        <th>Requirement</th>
                        <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                        <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
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
                        <?php $totalCementBags += (($planningSize * 4.167)/4.16); ?>
                        <td>{{ number_format((($planningSize * 4.167)/4.16) * $price) }}</td>
                        <?php $totalCementPrice += ((($planningSize * 4.167)/4.16) * $price); ?>
                    </tr>
                    <tr>
                        <td>Digging</td>
                        <td>{{ number_format(($diggingSize * 4.167)/4.16) }}</td>
                        <?php $totalCementBags += (($diggingSize * 4.167)/4.16); ?>
                        <td>{{ number_format((($diggingSize * 4.167)/4.16) * $price) }}</td>
                        <?php $totalCementPrice += ((($diggingSize * 4.167)/4.16) * $price); ?>
                    </tr>
                    <tr>
                        <td>Foundation</td>
                        <td>{{ number_format((($foundationSize * 4.167)/4.16)) }}</td>
                        <?php $totalCementBags += ((($foundationSize * 4.167)/4.16)); ?>
                        <td>{{ number_format(((($foundationSize * 4.167)/4.16)) * $price) }}</td>
                        <?php $totalCementPrice += (((($foundationSize * 4.167)/4.16)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Pillars</td>
                        <td>{{ number_format((($pillarsSize * 4.167)/4.16)) }}</td>
                        <?php $totalCementBags += ((($pillarsSize * 4.167)/4.16)); ?>
                        <td>{{ number_format(((($pillarsSize * 4.167)/4.16)) * $price) }}</td>
                        <?php $totalCementPrice += (((($pillarsSize * 4.167)/4.16)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Walls</td>
                        <td>{{ number_format((($wallsSize * 4.167)/4.16)) }}</td>
                        <?php $totalCementBags += ((($wallsSize * 4.167)/4.16)); ?>
                        <td>{{ number_format(((($wallsSize * 4.167)/4.16)) * $price) }}</td>
                        <?php $totalCementPrice += (((($wallsSize * 4.167)/4.16)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Roofing</td>
                        <td>{{ number_format((($roofingSize * 4.167)/4.16)/100*0) }}</td>
                        <?php $totalCementBags += ((($roofingSize * 4.167)/4.16)/100*0); ?>
                        <td>{{ number_format(((($roofingSize * 4.167)/4.16)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($roofingSize * 4.167)/4.16)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Electrical & Plumbing</td>
                        <td>{{ number_format((($enpSize * 4.167)/4.16)/100*0) }}</td>
                        <?php $totalCementBags += ((($enpSize * 4.167)/4.16)/100*0); ?>
                        <td>{{ number_format(((($enpSize * 4.167)/4.16)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($enpSize * 4.167)/4.16)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Plastering</td>
                        <td>{{ number_format((($plasteringSize * 4.167)/4.16)/100*0) }}</td>
                        <?php $totalCementBags += ((($plasteringSize * 4.167)/4.16)/100*0); ?>
                        <td>{{ number_format(((($plasteringSize * 4.167)/4.16)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($plasteringSize * 4.167)/4.16)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Flooring</td>
                        <td>{{ number_format((($flooringSize * 4.167)/4.16)/100*0) }}</td>
                        <?php $totalCementBags += ((($flooringSize * 4.167)/4.16)/100*0); ?>
                        <td>{{ number_format(((($flooringSize * 4.167)/4.16)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($flooringSize * 4.167)/4.16)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td>{{ number_format((($carpentrySize * 4.167)/4.16)/100*0) }}</td>
                        <?php $totalCementBags += ((($carpentrySize * 4.167)/4.16)/100*0); ?>
                        <td>{{ number_format(((($carpentrySize * 4.167)/4.16)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($carpentrySize * 4.167)/4.16)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Paintings</td>
                        <td>{{ number_format((($paintingSize * 4.167)/4.16)/100*0) }}</td>
                        <?php $totalCementBags += ((($paintingSize * 4.167)/4.16)/100*0); ?>
                        <td>{{ number_format(((($paintingSize * 4.167)/4.16)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($paintingSize * 4.167)/4.16)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Fixtures</td>
                        <td>{{ number_format((($fixturesSize * 4.167)/4.16)/100*0) }}</td>
                        <?php $totalCementBags += ((($fixturesSize * 4.167)/4.16)/100*0); ?>
                        <td>{{ number_format(((($fixturesSize * 4.167)/4.16)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($fixturesSize * 4.167)/4.16)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Completion</td>
                        <td>{{ number_format((($completionSize * 4.167)/4.16)/100*0) }}</td>
                        <?php $totalCementBags += ((($completionSize * 4.167)/4.16)/100*0); ?>
                        <td>{{ number_format(((($completionSize * 4.167)/4.16)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($completionSize * 4.167)/4.16)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th>{{ number_format($totalCementBags) }}</th>
                        <th>{{ number_format($totalCementPrice) }}</th>
                    </tr>
                    <tr>
                        <th>Requirement</th>
                        <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                        <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
                    </tr>
                    </tbody>
                </table>
        <?php
                break;
            case "electrical": ?>
                <table class="table table-hover" border=1>
                    <thead>

                        <th>Stages</th>
                        <th>Total Sqft. Required</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Planning</td>
                        <td>{{ number_format(($planningSize * 84)/84) }}</td>
                        <?php $totalCementBags += (($planningSize * 84)/84); ?>
                        <td>{{ number_format((($planningSize * 84)/84) * $price) }}</td>
                        <?php $totalCementPrice += ((($planningSize * 84)/84) * $price); ?>
                    </tr>
                    <tr>
                        <td>Digging</td>
                        <td>{{ number_format(($diggingSize * 84)/84) }}</td>
                        <?php $totalCementBags += (($diggingSize * 84)/84); ?>
                        <td>{{ number_format((($diggingSize * 84)/84) * $price) }}</td>
                        <?php $totalCementPrice += ((($diggingSize * 84)/84) * $price); ?>
                    </tr>
                    <tr>
                        <td>Foundation</td>
                        <td>{{ number_format((($foundationSize * 84)/84)/100*80) }}</td>
                        <?php $totalCementBags += ((($foundationSize * 84)/84)/100*80); ?>
                        <td>{{ number_format(((($foundationSize * 84)/84)/100*80) * $price) }}</td>
                        <?php $totalCementPrice += (((($foundationSize * 84)/84)/100*80) * $price); ?>
                    </tr>
                    <tr>
                        <td>Pillars</td>
                        <td>{{ number_format((($pillarsSize * 84)/84)/100*50) }}</td>
                        <?php $totalCementBags += ((($pillarsSize * 84)/84)/100*50); ?>
                        <td>{{ number_format(((($pillarsSize * 84)/84)/100*50) * $price) }}</td>
                        <?php $totalCementPrice += (((($pillarsSize * 84)/84)/100*50) * $price); ?>
                    </tr>
                    <tr>
                        <td>Walls</td>
                        <td>{{ number_format((($wallsSize * 84)/84)/100*50) }}</td>
                        <?php $totalCementBags += ((($wallsSize * 84)/84)/100*50); ?>
                        <td>{{ number_format(((($wallsSize * 84)/84)/100*50) * $price) }}</td>
                        <?php $totalCementPrice += (((($wallsSize * 84)/84)/100*50) * $price); ?>
                    </tr>
                    <tr>
                        <td>Roofing</td>
                        <td>{{ number_format((($roofingSize * 84)/84)/100*100) }}</td>
                        <?php $totalCementBags += ((($roofingSize * 84)/84)/100*100); ?>
                        <td>{{ number_format(((($roofingSize * 84)/84)/100*100) * $price) }}</td>
                        <?php $totalCementPrice += (((($roofingSize * 84)/84)/100*100) * $price); ?>
                    </tr>
                    <tr>
                        <td>Electrical & Plumbing</td>
                        <td>{{ number_format((($enpSize * 84)/84)/100*100) }}</td>
                        <?php $totalCementBags += ((($enpSize * 84)/84)/100*100); ?>
                        <td>{{ number_format(((($enpSize * 84)/84)/100*100) * $price) }}</td>
                        <?php $totalCementPrice += (((($enpSize * 84)/84)/100*100) * $price); ?>
                    </tr>
                    <tr>
                        <td>Plastering</td>
                        <td>{{ number_format((($plasteringSize * 84)/84)/100*0) }}</td>
                        <?php $totalCementBags += ((($plasteringSize * 84)/84)/100*0); ?>
                        <td>{{ number_format(((($plasteringSize * 84)/84)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($plasteringSize * 84)/84)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Flooring</td>
                        <td>{{ number_format((($flooringSize * 84)/84)/100*0) }}</td>
                        <?php $totalCementBags += ((($flooringSize * 84)/84)/100*0); ?>
                        <td>{{ number_format(((($flooringSize * 84)/84)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($flooringSize * 84)/84)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td>{{ number_format((($carpentrySize * 84)/84)/100*0) }}</td>
                        <?php $totalCementBags += ((($carpentrySize * 84)/84)/100*0); ?>
                        <td>{{ number_format(((($carpentrySize * 84)/84)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($carpentrySize * 84)/84)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Paintings</td>
                        <td>{{ number_format((($paintingSize * 84)/84)/100*0) }}</td>
                        <?php $totalCementBags += ((($paintingSize * 84)/84)/100*0); ?>
                        <td>{{ number_format(((($paintingSize * 84)/84)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($paintingSize * 84)/84)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Fixtures</td>
                        <td>{{ number_format((($fixturesSize * 84)/84)/100*0) }}</td>
                        <?php $totalCementBags += ((($fixturesSize * 84)/84)/100*0); ?>
                        <td>{{ number_format(((($fixturesSize * 84)/84)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($fixturesSize * 84)/84)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Completion</td>
                        <td>{{ number_format((($completionSize * 84)/84)/100*0) }}</td>
                        <?php $totalCementBags += ((($completionSize * 84)/84)/100*0); ?>
                        <td>{{ number_format(((($completionSize * 84)/84)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($completionSize * 84)/84)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th>{{ number_format($totalCementBags) }}</th>
                        <th>{{ number_format($totalCementPrice) }}</th>
                    </tr>
                    <tr>
                        <th>Requirement</th>
                        <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                        <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
                    </tr>
                    </tbody>
                </table>
        <?php
                break;
            case "plumbing": ?>
                <table class="table table-hover" border=1>
                    <thead>
                        <th>Stages</th>
                        <th>Total Sqft. Required</th>
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
                        <td>{{ number_format((($foundationSize * 50)/50)) }}</td>
                        <?php $totalCementBags += ((($foundationSize * 50)/50)); ?>
                        <td>{{ number_format(((($foundationSize * 50)/50)) * $price) }}</td>
                        <?php $totalCementPrice += (((($foundationSize * 50)/50)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Pillars</td>
                        <td>{{ number_format((($pillarsSize * 50)/50)) }}</td>
                        <?php $totalCementBags += ((($pillarsSize * 50)/50)); ?>
                        <td>{{ number_format(((($pillarsSize * 50)/50)) * $price) }}</td>
                        <?php $totalCementPrice += (((($pillarsSize * 50)/50)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Walls</td>
                        <td>{{ number_format((($wallsSize * 50)/50)) }}</td>
                        <?php $totalCementBags += ((($wallsSize * 50)/50)); ?>
                        <td>{{ number_format(((($wallsSize * 50)/50)) * $price) }}</td>
                        <?php $totalCementPrice += (((($wallsSize * 50)/50)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Roofing</td>
                        <td>{{ number_format((($roofingSize * 50)/50)/100*100) }}</td>
                        <?php $totalCementBags += ((($roofingSize * 50)/50)/100*100); ?>
                        <td>{{ number_format(((($roofingSize * 50)/50)/100*100) * $price) }}</td>
                        <?php $totalCementPrice += (((($roofingSize * 50)/50)/100*100) * $price); ?>
                    </tr>
                    <tr> 
                        <td>Electrical & Plumbing</td>
                        <td>{{ number_format((($enpSize * 50)/50)/100*100) }}</td>
                        <?php $totalCementBags += ((($enpSize * 50)/50)/100*100); ?>
                        <td>{{ number_format(((($enpSize * 50)/50)/100*100) * $price) }}</td>
                        <?php $totalCementPrice += (((($enpSize * 50)/50)/100*100) * $price); ?>
                    </tr>
                    <tr>
                        <td>Plastering</td>
                        <td>{{ number_format((($plasteringSize * 50)/50)/100*0) }}</td>
                        <?php $totalCementBags += ((($plasteringSize * 50)/50)/100*0); ?>
                        <td>{{ number_format(((($plasteringSize * 50)/50)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($plasteringSize * 50)/50)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Flooring</td>
                        <td>{{ number_format((($flooringSize * 50)/50)/100*0) }}</td>
                        <?php $totalCementBags += ((($flooringSize * 50)/50)/100*0); ?>
                        <td>{{ number_format(((($flooringSize * 50)/50)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($flooringSize * 50)/50)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td>{{ number_format((($carpentrySize * 50)/50)/100*0) }}</td>
                        <?php $totalCementBags += ((($carpentrySize * 50)/50)/100*0); ?>
                        <td>{{ number_format(((($carpentrySize * 50)/50)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($carpentrySize * 50)/50)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Paintings</td>
                        <td>{{ number_format((($paintingSize * 50)/50)/100*0) }}</td>
                        <?php $totalCementBags += ((($paintingSize * 50)/50)/100*0); ?>
                        <td>{{ number_format(((($paintingSize * 50)/50)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($paintingSize * 50)/50)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Fixtures</td>
                        <td>{{ number_format((($fixturesSize * 50)/50)/100*0) }}</td>
                        <?php $totalCementBags += ((($fixturesSize * 50)/50)/100*0); ?>
                        <td>{{ number_format(((($fixturesSize * 50)/50)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($fixturesSize * 50)/50)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Completion</td>
                        <td>{{ number_format((($completionSize * 50)/50)/100*0) }}</td>
                        <?php $totalCementBags += ((($completionSize * 50)/50)/100*0); ?>
                        <td>{{ number_format(((($completionSize * 50)/50)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($completionSize * 50)/50)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th>{{ number_format($totalCementBags) }}</th>
                        <th>{{ number_format($totalCementPrice) }}</th>
                    </tr>
                    <tr>
                        <th>Requirement</th>
                        <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                        <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
                    </tr>
                    </tbody>
                </table>
        <?php
                break;
            case "doors": ?>
                <table class="table table-hover" border=1>
                    <thead>

                        <th>Stages</th>
                        <th>Total Sqft. Required</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Planning</td>
                        <td>{{ number_format(($planningSize * 350)/350) }}</td>
                        <?php $totalCementBags += (($planningSize * 350)/350); ?>
                        <td>{{ number_format((($planningSize * 350)/350) * $price) }}</td>
                        <?php $totalCementPrice += ((($planningSize * 350)/350) * $price); ?>
                    </tr>
                    <tr>
                        <td>Digging</td>
                        <td>{{ number_format(($diggingSize * 350)/350) }}</td>
                        <?php $totalCementBags += (($diggingSize * 350)/350); ?>
                        <td>{{ number_format((($diggingSize * 350)/350) * $price) }}</td>
                        <?php $totalCementPrice += ((($diggingSize * 350)/350) * $price); ?>
                    </tr>
                    <tr>
                        <td>Foundation</td>
                        <td>{{ number_format((($foundationSize * 350)/350)) }}</td>
                        <?php $totalCementBags += ((($foundationSize * 350)/350)); ?>
                        <td>{{ number_format(((($foundationSize * 350)/350)) * $price) }}</td>
                        <?php $totalCementPrice += (((($foundationSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Pillars</td>
                        <td>{{ number_format((($pillarsSize * 350)/350)) }}</td>
                        <?php $totalCementBags += ((($pillarsSize * 350)/350)); ?>
                        <td>{{ number_format(((($pillarsSize * 350)/350)) * $price) }}</td>
                        <?php $totalCementPrice += (((($pillarsSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Walls</td>
                        <td>{{ number_format((($wallsSize * 350)/350)) }}</td>
                        <?php $totalCementBags += ((($wallsSize * 350)/350)); ?>
                        <td>{{ number_format(((($wallsSize * 350)/350)) * $price) }}</td>
                        <?php $totalCementPrice += (((($wallsSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Roofing</td>
                        <td>{{ number_format((($roofingSize * 350)/350)) }}</td>
                        <?php $totalCementBags += ((($roofingSize * 350)/350)); ?>
                        <td>{{ number_format(((($roofingSize * 350)/350)) * $price) }}</td>
                        <?php $totalCementPrice += (((($roofingSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Electrical & Plumbing</td>
                        <td>{{ number_format((($enpSize * 350)/350)) }}</td>
                        <?php $totalCementBags += ((($enpSize * 350)/350)); ?>
                        <td>{{ number_format(((($enpSize * 350)/350)) * $price) }}</td>
                        <?php $totalCementPrice += (((($enpSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Plastering</td>
                        <td>{{ number_format((($plasteringSize * 350)/350)) }}</td>
                        <?php $totalCementBags += ((($plasteringSize * 350)/350)); ?>
                        <td>{{ number_format(((($plasteringSize * 350)/350)) * $price) }}</td>
                        <?php $totalCementPrice += (((($plasteringSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Flooring</td>
                        <td>{{ number_format((($flooringSize * 350)/350)) }}</td>
                        <?php $totalCementBags += ((($flooringSize * 350)/350)); ?>
                        <td>{{ number_format(((($flooringSize * 350)/350)) * $price) }}</td>
                        <?php $totalCementPrice += (((($flooringSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td>{{ number_format((($carpentrySize * 350)/350)) }}</td>
                        <?php $totalCementBags += ((($carpentrySize * 350)/350)); ?>
                        <td>{{ number_format(((($carpentrySize * 350)/350)) * $price) }}</td>
                        <?php $totalCementPrice += (((($carpentrySize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Paintings</td>
                        <td>{{ number_format((($paintingSize * 350)/350)/100*0) }}</td>
                        <?php $totalCementBags += ((($paintingSize * 350)/350)/100*0); ?>
                        <td>{{ number_format(((($paintingSize * 350)/350)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($paintingSize * 350)/350)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Fixtures</td>
                        <td>{{ number_format((($fixturesSize * 350)/350)/100*0) }}</td>
                        <?php $totalCementBags += ((($fixturesSize * 350)/350)/100*0); ?>
                        <td>{{ number_format(((($fixturesSize * 350)/350)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($fixturesSize * 350)/350)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Completion</td>
                        <td>{{ number_format((($completionSize * 350)/350)/100*0) }}</td>
                        <?php $totalCementBags += ((($completionSize * 350)/350)/100*0); ?>
                        <td>{{ number_format(((($completionSize * 350)/350)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($completionSize * 350)/350)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th>{{ number_format($totalCementBags) }}</th>
                        <th>{{ number_format($totalCementPrice) }}</th>
                    </tr>
                    <tr>
                        <th>Requirement</th>
                        <th>{{ number_format($totalCementBags/$bCycle) }}</th>
                        <th>{{ number_format($totalCementPrice/$bCycle) }}</th>
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
                        <?php $totalCementBags += (($planningSize * 350)/350); ?>
                        <td>{{ number_format((($planningSize * 350)/350) * $price) }}</td>
                        <?php $totalCementPrice += ((($planningSize * 350)/350) * $price); ?>
                    </tr>
                    <tr>
                        <td>Digging</td>
                        <td>{{ number_format(($diggingSize * 350)/350) }}</td>
                        <?php $totalCementBags += (($diggingSize * 350)/350); ?>
                        <td>{{ number_format((($diggingSize * 350)/350) * $price) }}</td>
                        <?php $totalCementPrice += ((($diggingSize * 350)/350) * $price); ?>
                    </tr>
                    <tr>
                        <td>Foundation</td>
                        <td>{{ number_format((($foundationSize * 350)/350)) }}</td>
                        <?php $totalCementBags += ((($foundationSize * 350)/350)); ?>
                        <td>{{ number_format(((($foundationSize * 350)/350)) * $price) }}</td>
                        <?php $totalCementPrice += (((($foundationSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Pillars</td>
                        <td>{{ number_format((($pillarsSize * 350)/350)) }}</td>
                        <?php $totalCementBags += ((($pillarsSize * 350)/350)); ?>
                        <td>{{ number_format(((($pillarsSize * 350)/350)) * $price) }}</td>
                        <?php $totalCementPrice += (((($pillarsSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Walls</td>
                        <td>{{ number_format((($wallsSize * 350)/350)) }}</td>
                        <?php $totalCementBags += ((($wallsSize * 350)/350)); ?>
                        <td>{{ number_format(((($wallsSize * 350)/350)) * $price) }}</td>
                        <?php $totalCementPrice += (((($wallsSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Roofing</td>
                        <td>{{ number_format((($roofingSize * 350)/350)/100*100) }}</td>
                        <?php $totalCementBags += ((($roofingSize * 350)/350)/100*100); ?>
                        <td>{{ number_format(((($roofingSize * 350)/350)/100*100) * $price) }}</td>
                        <?php $totalCementPrice += (((($roofingSize * 350)/350)/100*100) * $price); ?>
                    </tr>
                    <tr>
                        <td>Electrical & Plumbing</td>
                        <td>{{ number_format((($enpSize * 350)/350)/100*100) }}</td>
                        <?php $totalCementBags += ((($enpSize * 350)/350)/100*100); ?>
                        <td>{{ number_format(((($enpSize * 350)/350)/100*100) * $price) }}</td>
                        <?php $totalCementPrice += (((($enpSize * 350)/350)/100*100) * $price); ?>
                    </tr>
                    <tr>
                        <td>Plastering</td>
                        <td>{{ number_format((($plasteringSize * 350)/350)) }}</td>
                        <?php $totalCementBags += ((($plasteringSize * 350)/350)); ?>
                        <td>{{ number_format(((($plasteringSize * 350)/350)) * $price) }}</td>
                        <?php $totalCementPrice += (((($plasteringSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Flooring</td>
                        <td>{{ number_format((($flooringSize * 350)/350)) }}</td>
                        <?php $totalCementBags += ((($flooringSize * 350)/350)); ?>
                        <td>{{ number_format(((($flooringSize * 350)/350)) * $price) }}</td>
                        <?php $totalCementPrice += (((($flooringSize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td>{{ number_format((($carpentrySize * 350)/350)) }}</td>
                        <?php $totalCementBags += ((($carpentrySize * 350)/350)); ?>
                        <td>{{ number_format(((($carpentrySize * 350)/350)) * $price) }}</td>
                        <?php $totalCementPrice += (((($carpentrySize * 350)/350)) * $price); ?>
                    </tr>
                    <tr>
                        <td>Paintings</td>
                        <td>{{ number_format((($paintingSize * 350)/350)/100*0) }}</td>
                        <?php $totalCementBags += ((($paintingSize * 350)/350)/100*0); ?>
                        <td>{{ number_format(((($paintingSize * 350)/350)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($paintingSize * 350)/350)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Fixtures</td>
                        <td>{{ number_format((($fixturesSize * 350)/350)/100*0) }}</td>
                        <?php $totalCementBags += ((($fixturesSize * 350)/350)/100*0); ?>
                        <td>{{ number_format(((($fixturesSize * 350)/350)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($fixturesSize * 350)/350)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <td>Completion</td>
                        <td>{{ number_format((($completionSize * 350)/350)/100*0) }}</td>
                        <?php $totalCementBags += ((($completionSize * 350)/350)/100*0); ?>
                        <td>{{ number_format(((($completionSize * 350)/350)/100*0) * $price) }}</td>
                        <?php $totalCementPrice += (((($completionSize * 350)/350)/100*0) * $price); ?>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th>{{ number_format($totalCementBags) }}</th>
                        <th>{{ number_format($totalCementPrice) }}</th>
                    </tr>
                    <tr>
                        <th>Requirement</th>
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
                <th>Requirement</th>
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
                        <th>Total Sqft. Required</th>
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
                            <th>Requirement</th>
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
                        <th>Total Sqft. Required</th>
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
                    <th>Requirement</th>
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
                        <th>Total Sqft. Required</th>
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
                <th>Requirement</th>
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
                        <th>Total Sqft. Required</th>
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
                <th>Requirement</th>
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
                        <th>Total Sqft. Required</th>
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
                    <th>Requirement</th>
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
                    <th>Requirement</th>
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
                <th>Requirement</th>
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
                <th>Requirement</th>
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
                            <th>Requirement</th>
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
                <th>Requirement</th>
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
                            <th>Requirement</th>
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
                <th>Requirement</th>
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
                <th>Requirement</th>
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
@if(!isset($bCycle))
<?php $bCycle = 1; ?>
@endif
</div>
</div>
</div>
<form action="/lockProjection" id="lockProj" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="monthlyTarget" id="mTarget">
    <input type="hidden" name="transactionalProfit" id="transactionalProfit">
    <input type="hidden" name="price" id="priceSave">
    <input type="hidden" name="businessCycle" id="businessCycle">
    <input type="hidden" name="category" id="category">
</form>
<script>
    var calBag;
    var calPrice;
    function calculateTarget(){
        var percent = document.getElementById('percentage').value;
        var number = {{ $totalCementBags/$bCycle }};
        var price = {{ $totalCementPrice/$bCycle }};
        calBag = number/100*percent;
        calPrice = price/100*percent;
        calBag = Math.round(calBag);
        calPrice = Math.round(calPrice);
        var text = "<b>Bags : " + calBag.toLocaleString() + "&nbsp;&nbsp;&nbsp;&nbsp; Amount : " + calPrice.toLocaleString() + "</b>";
        document.getElementById('monthlyTarget').innerHTML = text;
        document.getElementById('lock').className = "";
    }
    function transactionalProfit(){
        var percent = document.getElementById('per').value;
        var calBag2 = calBag/100*percent;
        var calPrice2 = calPrice/100*percent;
        calBag2 = Math.round(calBag2);
        calPrice2 = Math.round(calPrice2);
        var text = "<b>Transactional Profit Amount : " + calPrice2.toLocaleString() + "</b>";
        document.getElementById('tp').innerHTML = text;
    }
    function save(){
        var form = document.getElementById('lockProj');
        document.getElementById('mTarget').value = document.getElementById('percentage').value;
        document.getElementById('transactionalProfit').value = document.getElementById('per').value;
        document.getElementById('priceSave').value = document.getElementById('price').value;
        document.getElementById('businessCycle').value = document.getElementById('bCycle').value;
        document.getElementById('category').value = document.getElementById('categories').value;
        form.submit();
    }
</script>
@endsection
