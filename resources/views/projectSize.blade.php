
@extends('layouts.app')
@section('content')
<br>
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-success">
    <div class="panel-heading">
       {{-- Total No Of Projects In Zone 1 : {{$totalProjects}}--}}
    </div>
    <div class="panel-body">
        <div class="col-md-6">
            <center>Ward</center>
            <form method="GET" action="{{ URL::to('/') }}/getprojectsize">
                <select required class="form-control" name="ward">
                    <option value="">--Select--</option>
                    <option value="All">All</option>
                @foreach($wards as $ward)
                    <option value="{{ $ward->id}}" {{ $ward->id == $wardId? 'selected':'' }}>{{ $ward->ward_name }}</option>
                @endforeach
                </select><br>
                <button class="btn btn-primary form-control" type="submit">Fetch</button>
            </form>
            <br>
            @if(session('Error'))
                <p class="alert alert-error">{{ session('Error') }}</p>
            @endif
            @if($planningCount != NULL)
            Total Project Sizes {{ $_GET['ward'] != "All" ? 'Under '.$wardname->ward_name : ''}} (based on stages)<br>
            Total No. Of Projects : {{ $planningCount + $diggingCount + $foundationCount + $pillarsCount + $completionCount + $fixturesCount + $paintingCount + $carpentryCount + $flooringCount + $plasteringCount + $enpCount + $roofingCount + $wallsCount + $closedCount }}
            Total Sizes : <b>{{ $planningSize + $diggingSize + $foundationSize + $pillarsSize + $completionSize + $fixturesSize + $paintingSize + $carpentrySize + $flooringSize + $plasteringSize + $enpSize + $roofingSize + $wallsSize + $closedSize }}</b>
            <table class="table table-hover" border="1">
                <thead>
                    <th class="text-center">Stages</th>
                    <th class="text-center">No. of Projects</th>
                    <th class="text-center">Size<br>(in Sq. Ft.)</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Planning</td>
                        <td class="text-center"> {{ $planningCount }} </td>
                        <td> {{ $planningSize }}</td>
                    </tr>
                    <tr>
                        <td>Digging</td>
                        <td class="text-center">{{ $diggingCount }}</td>
                        <td>{{ $diggingSize }}</td>
                    </tr>
                    <tr>
                        <td>Foundation</td>
                        <td class="text-center">{{ $foundationCount }}</td>
                        <td>{{ $foundationSize }}</td>
                    </tr>
                    <tr>
                        <td>Pillars</td>
                        <td class="text-center">{{ $pillarsCount }}</td>
                        <td>{{ $pillarsSize }}</td>
                    </tr>
                    <tr>
                        <td>Walls</td>
                        <td class="text-center">{{ $wallsCount }}</td>
                        <td>{{ $wallsSize }}</td>
                    </tr>
                    <tr>
                        <td>Roofing</td>
                        <td class="text-center">{{ $roofingCount }}</td>
                        <td>{{ $roofingSize }}</td>
                    </tr>
                    
                    <tr>
                        <td>Electrical &amp; Plumbing</td>
                        <td class="text-center">{{ $enpCount }}</td>
                        <td>{{ $enpSize }}</td>
                    </tr>
                    <tr>
                        <td>Plastering</td>
                        <td class="text-center">{{ $plasteringCount }}</td>
                        <td>{{ $plasteringSize }}</td>
                    </tr>
                    <tr>
                        <td>Flooring</td>
                        <td class="text-center">{{ $flooringCount }}</td>
                        <td>{{ $flooringSize }}</td>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td class="text-center">{{ $carpentryCount }}</td>
                        <td>{{ $carpentrySize }}</td>
                    </tr>
                    <tr>
                        <td>Paintings</td>
                        <td class="text-center">{{ $paintingCount }}</td>
                        <td>{{ $paintingSize }}</td>
                    </tr>
                    <tr>
                        <td>Fixtures</td>
                        <td class="text-center">{{ $fixturesCount }}</td>
                        <td>{{ $fixturesSize }}</td>
                    </tr>
                    <tr>
                        <td>Completion</td>
                        <td class="text-center">{{ $completionCount }}</td>
                        <td>{{ $completionSize }}</td>
                    </tr>
                </tbody>
            </table> 
            @endif
        </div>

        @if($subwards != NULL && $_GET['ward'] != "All")
        <div class="col-md-6">
            <center>Sub Ward</center>
            <form method="GET" action="{{ URL::to('/') }}/getprojectsize">
                <input type="hidden" name="ward" value={{ $wardId }}>
                <select required class="form-control" name="subward">
                    <option value="">--Select--</option>
                    @foreach($subwards as $ward)
                        <option value="{{ $ward->id}}" {{ $subwardId == $ward->id? 'selected':'' }}>{{ $ward->sub_ward_name }}</option>
                    @endforeach
                </select><br>
                <button class="btn btn-primary form-control" type="submit">Fetch</button>
            </form>
            <br>
            @if(session('Error'))
                <p class="alert alert-error">{{ session('Error') }}</p>
            @endif
            @if(isset($_GET['subward']))
            Total Project Sizes Under {{ $subwardName}} (based on stages)<br>
            Total No. of Projects : @if($total) {{ $total }} @endif
            Total Sizes : <b>@if($totalsubward) {{ $totalsubward }} @endif</b>
            <table class="table table-hover" border="1">
                <thead>
                    <th class="text-center">Stages</th>
                    <th class="text-center">No. of Projects</th>
                    <th class="text-center">Size<br>(in Sq. Ft.)</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Planning</td>
                        <td class="text-center">{{ $Cplanning }}</td>
                        <td>
                             
                              {{ $planning }} 
                        </td>
                    </tr>
                    <tr>
                        <td>Digging</td>
                        <td class="text-center">{{ $Cdigging }}</td>
                        <td>
                            
                            {{ $digging }}
                        </td>
                    </tr>
                    <tr>
                        <td>Foundation</td>
                        <td class="text-center">{{ $Cfoundation }}</td>
                        <td>
                            {{ $foundation }}
                        </td>
                    </tr>
                    <tr>
                        <td>Pillars</td>
                        <td class="text-center">{{ $Cpillars }}</td>
                        <td>
                            
                            {{ $pillars }}
                        </td>
                    </tr>
                    <tr>
                        <td>Walls</td>
                        <td class="text-center">{{ $Cwalls }}</td>
                        <td>
                            
                            {{ $walls }}
                        </td>
                    </tr>
                    <tr>
                        <td>Roofing</td>
                        <td class="text-center">{{ $Croofing }}</td>
                        <td>
                            {{ $roofing }}
                        </td>
                    </tr>
                    <tr>
                        <td>Electrical &amp; Plumbing</td>
                        <td class="text-center">{{ $Cenp }}</td>
                        <td>
                            
                            {{ $enp }}
                        </td>
                    </tr>
                    <tr>
                        <td>Plastering</td>
                        <td class="text-center">{{ $Cplastering }}</td>
                        <td>
                            
                            {{ $plastering }}
                        </td>
                    </tr>
                    <tr>
                        <td>Flooring</td>
                        <td class="text-center">{{ $Cflooring }}</td>
                        <td>
                            
                            {{ $flooring }}
                        </td>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td class="text-center">{{ $Ccarpentry }}</td>
                        <td>
                            
                            {{ $carpentry }}
                        </td>
                    </tr>
                    <tr>
                        <td>Paintings</td>
                        <td class="text-center">{{ $Cpainting }}</td>
                        <td>
                            
                            {{ $painting }}
                        </td>
                    </tr>
                    <tr>
                        <td>Fixtures</td>
                        <td class="text-center">{{ $Cfixtures }}</td>
                        <td>
                            
                            {{ $fixtures }}
                        </td>
                    </tr>
                    <tr>
                        <td>Completion</td>
                        <td class="text-center">{{ $Ccompletion }}</td>
                        <td>
                            
                            {{ $completion }}
                        </td>
                    </tr>
                </tbody>
            </table> 
        @endif
        </div>
    @endif
    </div>
</div>
</div>
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
@if($planningCount != NULL)
<div class="col-md-3">
    <table class="table table-hover" border=1>
        <label for="">Material Projection (Cement)</label>
        <thead>
            <th>Stages</th>
            <th>Total Bags Required</th>
            <th>Amount</th>
        </thead>
        <tbody>
            <tr>
                <td>Planning</td>
                <td>{{ number_format(($planningSize * 15)/50) }}</td>
                <?php $totalCementBags += (($planningSize * 15)/50); ?>
                <td>{{ number_format((($planningSize * 15)/50) * 270) }}</td>
                <?php $totalCementPrice += ((($planningSize * 15)/50) * 270); ?>
            </tr>
            <tr>
                <td>Digging</td>
                <td>{{ number_format(($diggingSize * 15)/50) }}</td>
                <?php $totalCementBags += (($diggingSize * 15)/50); ?>
                <td>{{ number_format((($diggingSize * 15)/50) * 270) }}</td>
                <?php $totalCementPrice += ((($diggingSize * 15)/50) * 270); ?>
            </tr>
            <tr>
                <td>Foundation</td>
                <td>{{ number_format((($foundationSize * 15)/50)/100*85) }}</td>
                <?php $totalCementBags += ((($foundationSize * 15)/50)/100*85); ?>
                <td>{{ number_format(((($foundationSize * 15)/50)/100*85) * 270) }}</td>
                <?php $totalCementPrice += (((($foundationSize * 15)/50)/100*85) * 270); ?>
            </tr>
            <tr>
                <td>Pillars</td>
                <td>{{ number_format((($pillarsSize * 15)/50)/100*70) }}</td>
                <?php $totalCementBags += ((($pillarsSize * 15)/50)/100*70); ?>
                <td>{{ number_format(((($pillarsSize * 15)/50)/100*70) * 270) }}</td>
                <?php $totalCementPrice += (((($pillarsSize * 15)/50)/100*70) * 270); ?>
            </tr>
            <tr>
                <td>Walls</td>
                <td>{{ number_format((($wallsSize * 15)/50)/100*55) }}</td>
                <?php $totalCementBags += ((($wallsSize * 15)/50)/100*50); ?>
                <td>{{ number_format(((($wallsSize * 15)/50)/100*55) * 270) }}</td>
                <?php $totalCementPrice += (((($wallsSize * 15)/50)/100*55) * 270); ?>
            </tr>
            <tr>
                <td>Roofing</td>
                <td>{{ number_format((($roofingSize * 15)/50)/100*25) }}</td>
                <?php $totalCementBags += ((($roofingSize * 15)/50)/100*25); ?>
                <td>{{ number_format(((($roofingSize * 15)/50)/100*25) * 270) }}</td>
                <?php $totalCementPrice += (((($roofingSize * 15)/50)/100*25) * 270); ?>
            </tr>
            <tr>
                <td>Electrical & Plumbing</td>
                <td>{{ number_format((($enpSize * 15)/50)/100*25) }}</td>
                <?php $totalCementBags += ((($enpSize * 15)/50)/100*25); ?>
                <td>{{ number_format(((($enpSize * 15)/50)/100*25) * 270) }}</td>
                <?php $totalCementPrice += (((($enpSize * 15)/50)/100*25) * 270); ?>
            </tr>
            <tr>
                <td>Plastering</td>
                <td>{{ number_format((($plasteringSize * 15)/50)/100*10) }}</td>
                <?php $totalCementBags += ((($plasteringSize * 15)/50)/100*10); ?>
                <td>{{ number_format(((($plasteringSize * 15)/50)/100*10) * 270) }}</td>
                <?php $totalCementPrice += (((($plasteringSize * 15)/50)/100*10) * 270); ?>
            </tr>
            <tr>
                <td>Flooring</td>
                <td>{{ number_format((($flooringSize * 15)/50)/100*5) }}</td>
                <?php $totalCementBags += ((($flooringSize * 15)/50)/100*5); ?>
                <td>{{ number_format(((($flooringSize * 15)/50)/100*5) * 270) }}</td>
                <?php $totalCementPrice += (((($flooringSize * 15)/50)/100*5) * 270); ?>
            </tr>
            <tr>
                <td>Carpentry</td>
                <td>{{ number_format((($carpentrySize * 15)/50)/100*0) }}</td>
                <?php $totalCementBags += ((($carpentrySize * 15)/50)/100*0); ?>
                <td>{{ number_format(((($carpentrySize * 15)/50)/100*0) * 270) }}</td>
                <?php $totalCementPrice += (((($carpentrySize * 15)/50)/100*0) * 270); ?>
            </tr>
            <tr>
                <td>Paintings</td>
                <td>{{ number_format((($paintingSize * 15)/50)/100*0) }}</td>
                <?php $totalCementBags += ((($paintingSize * 15)/50)/100*0); ?>
                <td>{{ number_format(((($paintingSize * 15)/50)/100*0) * 270) }}</td>
                <?php $totalCementPrice += (((($paintingSize * 15)/50)/100*0) * 270); ?>
            </tr>
            <tr>
                <td>Fixtures</td>
                <td>{{ number_format((($fixturesSize * 15)/50)/100*0) }}</td>
                <?php $totalCementBags += ((($fixturesSize * 15)/50)/100*0); ?>
                <td>{{ number_format(((($fixturesSize * 15)/50)/100*0) * 270) }}</td>
                <?php $totalCementPrice += (((($fixturesSize * 15)/50)/100*0) * 270); ?>
            </tr>
            <tr>
                <td>Completion</td>
                <td>{{ number_format((($completionSize * 15)/50)/100*0) }}</td>
                <?php $totalCementBags += ((($completionSize * 15)/50)/100*0); ?>
                <td>{{ number_format(((($completionSize * 15)/50)/100*0) * 270) }}</td>
                <?php $totalCementPrice += (((($completionSize * 15)/50)/100*0) * 270); ?>
            </tr>
            <tr>
                <th>Total</th>
                <th>{{ number_format($totalCementBags) }}</th>
                <th>{{ number_format($totalCementPrice) }}</th>
            </tr>
            <tr>
                <th>Monthly Requirement</th>
                <th>{{ number_format($totalCementBags/10) }}</th>
                <th>{{ number_format($totalCementPrice/10) }}</th>
            </tr>
        </tbody>
    </table>
</div>
<div class="col-md-3">
    <table class="table table-hover" border=1>
    <label for="">Material Projection (Steel)</label>
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
            <td>{{ number_format((($planningSize * 4)/1000) * 50000) }}</td>
            <?php $totalSteelPrice += ((($planningSize * 4)/1000) * 50000); ?>
        </tr>
        <tr>
            <td>Digging</td>
            <td>{{ number_format(($diggingSize * 4)/1000) }}</td>
            <?php $totalSteel += (($diggingSize * 4)/1000); ?>
            <td>{{ number_format((($diggingSize * 4)/1000) * 50000) }}</td>
            <?php $totalSteelPrice += ((($diggingSize * 4)/1000) * 50000); ?>
        </tr>
        <tr>
            <td>Foundation</td>
            <td>{{ number_format((($foundationSize * 4)/1000)/100*70) }}</td>
            <?php $totalSteel += ((($foundationSize * 4)/1000)/100*70); ?>
            <td>{{ number_format(((($foundationSize * 4)/1000)/100*70) * 50000) }}</td>
            <?php $totalSteelPrice += (((($foundationSize * 4)/1000)/100*70) * 50000); ?>
        </tr>
        <tr>
            <td>Pillars</td>
            <td>{{ number_format((($pillarsSize * 4)/1000)/100*35) }}</td>
            <?php $totalSteel += ((($pillarsSize * 4)/1000)/100*35); ?>
            <td>{{ number_format(((($pillarsSize * 4)/1000)/100*35) * 50000) }}</td>
            <?php $totalSteelPrice += (((($pillarsSize * 4)/1000)/100*35) * 50000); ?>
        </tr>
        <tr>
            <td>Walls</td>
            <td>{{ number_format((($wallsSize * 4)/1000)/100*35) }}</td>
            <?php $totalSteel += ((($wallsSize * 4)/1000)/100*35); ?>
            <td>{{ number_format(((($wallsSize * 4)/1000)/100*35) * 50000) }}</td>
            <?php $totalSteelPrice += (((($wallsSize * 4)/1000)/100*35) * 50000); ?>
        </tr>
        <tr>
            <td>Roofing</td>
            <td>{{ number_format((($roofingSize * 4)/1000)/100*35) }}</td>
            <?php $totalSteel += ((($roofingSize * 4)/1000)/100*35); ?>
            <td>{{ number_format(((($roofingSize * 4)/1000)/100*35) * 50000) }}</td>
            <?php $totalSteelPrice += (((($roofingSize * 4)/1000)/100*35) * 50000); ?>
        </tr>
        <tr>
            <td>Electrical & Plumbing</td>
            <td>{{ number_format((($enpSize * 4)/1000)/100*0) }}</td>
            <?php $totalSteel += ((($enpSize * 4)/1000)/100*0); ?>
            <td>{{ number_format(((($enpSize * 4)/1000)/100*0) * 50000) }}</td>
            <?php $totalSteelPrice += (((($enpSize * 4)/1000)/100*0) * 50000); ?>
        </tr>
        <tr>
            <td>Plastering</td>
            <td>{{ number_format((($plasteringSize * 4)/1000)/100*0) }}</td>
            <?php $totalSteel += ((($plasteringSize * 4)/1000)/100*0); ?>
            <td>{{ number_format(((($plasteringSize * 4)/1000)/100*0) * 50000) }}</td>
            <?php $totalSteelPrice += (((($plasteringSize * 4)/1000)/100*0) * 50000); ?>
        </tr>
        <tr>
            <td>Flooring</td>
            <td>{{ number_format((($flooringSize * 4)/1000)/100*0) }}</td>
            <?php $totalSteel += ((($flooringSize * 4)/1000)/100*0); ?>
            <td>{{ number_format(((($flooringSize * 4)/1000)/100*0) * 50000) }}</td>
            <?php $totalSteelPrice += (((($flooringSize * 4)/1000)/100*0) * 50000); ?>
        </tr>
        <tr>
            <td>Carpentry</td>
            <td>{{ number_format((($carpentrySize * 4)/1000)/100*0) }}</td>
            <?php $totalSteel += ((($carpentrySize * 4)/1000)/100*0); ?>
            <td>{{ number_format(((($carpentrySize * 4)/1000)/100*0) * 50000) }}</td>
            <?php $totalSteelPrice += (((($carpentrySize * 4)/1000)/100*0) * 50000); ?>
        </tr>
        <tr>
            <td>Paintings</td>
            <td>{{ number_format((($paintingSize * 4)/1000)/100*0) }}</td>
            <?php $totalSteel += ((($paintingSize * 4)/1000)/100*0); ?>
            <td>{{ number_format(((($paintingSize * 4)/1000)/100*0) * 50000) }}</td>
            <?php $totalSteelPrice += (((($paintingSize * 4)/1000)/100*0) * 50000); ?>
        </tr>
        <tr>
            <td>Fixtures</td>
            <td>{{ number_format((($fixturesSize * 4)/1000)/100*0) }}</td>
            <?php $totalSteel += ((($fixturesSize * 4)/1000)/100*0); ?>
            <td>{{ number_format(((($fixturesSize * 4)/1000)/100*0) * 50000) }}</td>
            <?php $totalSteelPrice += (((($fixturesSize * 4)/1000)/100*0) * 50000); ?>
        </tr>
        <tr>
            <td>Completion</td>
            <td>{{ number_format((($completionSize * 4)/1000)/100*0) }}</td>
            <?php $totalSteel += ((($completionSize * 4)/1000)/100*0); ?>
            <td>{{ number_format(((($completionSize * 4)/1000)/100*0) * 50000) }}</td>
            <?php $totalSteelPrice += (((($completionSize * 4)/1000)/100*0) * 50000); ?>
        </tr>
        <tr>
            <th>Total</th>
            <th>{{ number_format($totalSteel) }}</th>
            <th>{{ number_format($totalSteelPrice) }}</th>
        </tr>
        <tr>
            <th>Monthly Requirement</th>
            <th>{{ number_format($totalSteel/10) }}</th>
            <th>{{ number_format($totalSteelPrice/10) }}</th>
        </tr>
    </tbody>
    </table>
</div>
<div class="col-md-3">
    <table class="table table-hover" border=1>
        <label for="">Material Projection (Sand)</label>
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
</div>
<div class="col-md-3">
    <table class="table table-hover" border=1>
        <label for="">Material Projection (Aggregates)</label>
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
