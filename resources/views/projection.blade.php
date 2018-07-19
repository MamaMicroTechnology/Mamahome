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
<div class="col-md-3 pull-right">
    <table class="table table-hover" border=1>
    <tr>
        <th style="text-align:center" colspan=2>Business Cycle</th>
    </tr>
	<tr>
        <td>Planning</td>
        <td style="text-align:center" rowspan=3><br><br>1</td>
    </tr>
    <tr>
        <td>Digging</td>
    </tr>
    <tr>
        <td>Foundation</td>
    </tr>
    <tr>
        <td>Pillar</td>
        <td style="text-align:center" rowspan=2><br>3</td>
    </tr>
    <tr>
        <td>Roofing</td>
    </tr>
    <tr>
        <td>Walling</td>
        <td style="text-align:center">1</td>
    </tr>
    <tr>
        <td>Electrical</td>
        <td rowspan=2 style="text-align:center"><br>1</td>
    </tr>
    <tr>
        <td>Plumbing</td>
    </tr>
    <tr>
        <td>Plastering</td>
        <td style="text-align:center">1</td>
    </tr>
    <tr>
        <td>Fooring</td>
        <td style="text-align:center">1</td>
    </tr>
    <tr>
        <td>Carpentry</td>
        <td style="text-align:center">1</td>
    </tr>
    <tr>
        <td>Painting</td>
        <td rowspan=3 style="text-align:center"><br><br>1</td>
    </tr>
    <tr>
        <td>Fixtures</td>
    </tr>
    <tr>
        <td>Completion</td>
    </tr>
    <tr>
        <th>Total</th>
        <th style="text-align:center">10</th>
    </tr>
    </table>
    <small style="background-color:#c9dba4; padding:10px; text-align:center; width:100%;">
            <marquee><i>** Note: Material Calculation Is Based On Status Of The Project And Business Cycle **</i></marquee>
        </small>
</div>
<div id="projection" class="col-md-6 col-md-offset-2">
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
        <label style="text-align:left;" for="from" class="control-label col-sm-6">From</label>
        <div class="col-md-6">
            <input type="date" name="from" value="{{ isset($_GET['from']) ? $_GET['from'] : ''}}" id="from" class="form-control input-sm">
        </div>
    </div>
    <div class="form-group">
        <label style="text-align:left;" for="to" class="control-label col-sm-6">To</label>
        <div class="col-md-6">
            <input type="date" name="to" value="{{ isset($_GET['to']) ? $_GET['to'] : ''}}" id="to" class="form-control input-sm">
        </div>
    </div>
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
                <option {{ isset($_GET['category']) ? $_GET['category'] == "blocks and bricks" ? "selected" : "" : ""}} value="blocks and bricks">Blocks & Bricks</option>
                <option {{ isset($_GET['category']) ? $_GET['category'] == "electrical" ? "selected" : "" : ""}} value="electrical">Electrical</option>
                <option {{ isset($_GET['category']) ? $_GET['category'] == "plumbing" ? "selected" : "" : ""}} value="plumbing">Plumbing</option>
                <option {{ isset($_GET['category']) ? $_GET['category'] == "flooring" ? "selected" : "" : ""}} value="flooring">Flooring</option>
                <option {{ isset($_GET['category']) ? $_GET['category'] == "bathroom and sanitary" ? "selected" : "" : ""}} value="bathroom and sanitary">Bathroom & Sanitary</option>
                <option {{ isset($_GET['category']) ? $_GET['category'] == "wood and adhesive" ? "selected" : "" : ""}} value="wood and adhesive">Wood & Adhesive</option>
                <option {{ isset($_GET['category']) ? $_GET['category'] == "paints" ? "selected" : "" : ""}} value="paints">Paints</option>
                <option {{ isset($_GET['category']) ? $_GET['category'] == "wardrobes and kitchen" ? "selected" : "" : ""}} value="wardrobes and kitchen">Wardrobes & Kitchen</option>
                <option {{ isset($_GET['category']) ? $_GET['category'] == "home appliences" ? "selected" : "" : ""}} value="home appliences">Home Appliences</option>
                <option {{ isset($_GET['category']) ? $_GET['category'] == "furnitures" ? "selected" : "" : ""}} value="furnitures">Furnitures</option>
                <option {{ isset($_GET['category']) ? $_GET['category'] == "handrails" ? "selected" : "" : ""}} value="handrails">Handrails</option>
                <option {{ isset($_GET['category']) ? $_GET['category'] == "glasses and facades" ? "selected" : "" : ""}} value="glasses and facades">Glasses & Facades</option>
                <option {{ isset($_GET['category']) ? $_GET['category'] == "rmc" ? "selected" : "" : ""}} value="rmc">RMC</option>
                <option {{ isset($_GET['category']) ? $_GET['category'] == "ceilling" ? "selected" : "" : ""}} value="ceilling">False Ceilling</option>
                <option {{ isset($_GET['category']) ? $_GET['category'] == "fire safety" ? "selected" : "" : ""}} value="fire safety">Fire & Safety</option>
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
    <div class="{{ !isset($_GET['ward']) ? 'hidden': '' }}">
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
        <button class="btn btn-primary form-control" data-toggle="modal" data-target="#myModal">Lock Target</button>
        
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirmation</h4>
                    </div>
                    <div class="modal-body">
                        <p style="text-align:center">Do you want to lock this with the existing data or projected data?</p>
                        <label class="radio-inline">
                            <input type="radio" onclick="document.getElementById('percentage1').className='hidden';" name="existing" id="existing"> Existing Data<br>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" onclick="document.getElementById('percentage1').className='';" name="existing" id="projected"> Projected Data
                        </label>
                        <p class="hidden" id="percentage1">
                            <input type="text" name="percentage1" id="perc" class="form-control" placeholder="Incremental Percentage">
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button onclick="save()" class="btn btn-success pull-left">Submit</button>
                    </div>
                </div>
            </div>
        </div>
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
        
?>
            <table class="table table-hover" border=1>
                <thead>
                    <th>Stages</th>
                    <th>Total {{ $conversion != null ? $conversion->unit : '' }} Required</th>
                    <th>Amount</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Planning</td>
                        <td>{{ number_format(($planningSize * $conversion->minimum_requirement) / $conversion->conversion) }}</td>
                        <?php $totalCementBags += (($planningSize * $conversion->minimum_requirement) / $conversion->conversion); ?>
                        <td>{{ number_format(($planningSize * $conversion->minimum_requirement) / $conversion->conversion * $price) }}</td>
                        <?php $totalCementPrice += ((($planningSize * $conversion->minimum_requirement)/$conversion->conversion) * $price); ?>
                    </tr>
                    <tr>
                        <td>Digging</td>
                        <td>{{ number_format(($diggingSize * $conversion->minimum_requirement)/$conversion->conversion) }}</td>
                        <?php $totalCementBags += (($diggingSize * $conversion->minimum_requirement)/$conversion->conversion); ?>
                        <td>{{ number_format((($diggingSize * $conversion->minimum_requirement)/$conversion->conversion) * $price) }}</td>
                        <?php $totalCementPrice += ((($diggingSize * $conversion->minimum_requirement)/$conversion->conversion) * $price); ?>
                    </tr>
                    <tr>
                        <td>Foundation</td>
                        <td>{{ number_format((($foundationSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->foundation) }}</td>
                        <?php $totalCementBags += ((($foundationSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->foundation); ?>
                        <td>{{ number_format(((($foundationSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->foundation) * $price) }}</td>
                        <?php $totalCementPrice += (((($foundationSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->foundation) * $price); ?>
                    </tr>
                    <tr>
                        <td>Pillars</td>
                        <td>{{ number_format((($pillarsSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->pillars) }}</td>
                        <?php $totalCementBags += ((($pillarsSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->pillars); ?>
                        <td>{{ number_format(((($pillarsSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->pillars) * $price) }}</td>
                        <?php $totalCementPrice += (((($pillarsSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->pillars) * $price); ?>
                    </tr>
                    <tr>
                        <td>Walls</td>
                        <td>{{ number_format((($wallsSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->walls) }}</td>
                        <?php $totalCementBags += ((($wallsSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->walls); ?>
                        <td>{{ number_format(((($wallsSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->walls) * $price) }}</td>
                        <?php $totalCementPrice += (((($wallsSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->walls) * $price); ?>
                    </tr>
                    <tr>
                        <td>Roofing</td>
                        <td>{{ number_format((($roofingSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->roofing) }}</td>
                        <?php $totalCementBags += ((($roofingSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->roofing); ?>
                        <td>{{ number_format(((($roofingSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->roofing) * $price) }}</td>
                        <?php $totalCementPrice += (((($roofingSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->roofing) * $price); ?>
                    </tr>
                    <tr>
                        <td>Electrical & Plumbing</td>
                        <td>{{ number_format((($enpSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->electrical) }}</td>
                        <?php $totalCementBags += ((($enpSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->electrical); ?>
                        <td>{{ number_format(((($enpSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->electrical) * $price) }}</td>
                        <?php $totalCementPrice += (((($enpSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->electrical) * $price); ?>
                    </tr>
                    <tr>
                        <td>Plastering</td>
                        <td>{{ number_format((($plasteringSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->plastering) }}</td>
                        <?php $totalCementBags += ((($plasteringSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->plastering); ?>
                        <td>{{ number_format(((($plasteringSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->plastering) * $price) }}</td>
                        <?php $totalCementPrice += (((($plasteringSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->plastering) * $price); ?>
                    </tr>
                    <tr>
                        <td>Flooring</td>
                        <td>{{ number_format((($flooringSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->flooring) }}</td>
                        <?php $totalCementBags += ((($flooringSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->flooring); ?>
                        <td>{{ number_format(((($flooringSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->flooring) * $price) }}</td>
                        <?php $totalCementPrice += (((($flooringSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->flooring) * $price); ?>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td>{{ number_format((($carpentrySize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->carpentry) }}</td>
                        <?php $totalCementBags += ((($carpentrySize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->carpentry); ?>
                        <td>{{ number_format(((($carpentrySize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->carpentry) * $price) }}</td>
                        <?php $totalCementPrice += (((($carpentrySize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->carpentry) * $price); ?>
                    </tr>
                    <tr>
                        <td>Paintings</td>
                        <td>{{ number_format((($paintingSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->painting) }}</td>
                        <?php $totalCementBags += ((($paintingSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->painting); ?>
                        <td>{{ number_format(((($paintingSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->painting) * $price) }}</td>
                        <?php $totalCementPrice += (((($paintingSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->painting) * $price); ?>
                    </tr>
                    <tr>
                        <td>Fixtures</td>
                        <td>{{ number_format((($fixturesSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->fixture) }}</td>
                        <?php $totalCementBags += ((($fixturesSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->fixture); ?>
                        <td>{{ number_format(((($fixturesSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->fixture) * $price) }}</td>
                        <?php $totalCementPrice += (((($fixturesSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->fixture) * $price); ?>
                    </tr>
                    <tr>
                        <td>Completion</td>
                        <td>{{ number_format((($completionSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->completion) }}</td>
                        <?php $totalCementBags += ((($completionSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->completion); ?>
                        <td>{{ number_format(((($completionSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->completion) * $price) }}</td>
                        <?php $totalCementPrice += (((($completionSize * $conversion->minimum_requirement)/$conversion->conversion)/100*$utilization->completion) * $price); ?>
                    </tr>
                    <tr>
                        <th>Total Requirement</th>
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
     
</div>
@endif
@if(!isset($bCycle))
<?php $bCycle = 1; ?>
@endif
</div>
</div>
</div>
<div class="col-md-12">
    <div class="col-md-10 col-md-offset-3">
        <center>
            <h2>
                Thumb Rules<br>  
            </h2>
        </center>
            @foreach($conversions as $con)
            {{ ucwords($con->category) }} : Minimum 
            @if($con->per == "Nos")
                number
            @elseif($con->per == "Rs")
                amount
            @else
                requirement
            @endif

            of {{ ucwords($con->category) }} is {{ $con->category == "Flooring" ? $con->price_per_unit : $con->minimum_requirement }}
            @if($con->category != "Flooring")
            {{ $con->per }}/Sqft {{ $con->full_form != null ? "(".$con->per." = ". $con->full_form.")" : "" }}<br><br>
            @else
            {{ $con->per }}/Sqft {{ $con->full_form != null ? "(". $con->full_form.")" : "" }}<br><br>
            @endif
            @endforeach
        <small style="background-color:#c9dba4; padding:10px; text-align:center; width:100%;">
            <i>** Note: The Above Calculations Varies From Design To Design **</i>
        </small>
        <br><br>
    </div>
</div>
<form action="{{URL::to('/') }}/lockProjection" id="lockProj" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="monthlyTarget" id="mTarget">
    <input type="hidden" name="transactionalProfit" id="transactionalProfit">
    <input type="hidden" name="price" id="priceSave">
    <input type="hidden" name="businessCycle" id="businessCycle">
    <input type="hidden" name="category" id="category">
    <input type="hidden" name="from" id="from_date">
    <input type="hidden" name="to" id="to_date">
    <input type="hidden" name="incrementalPercentage" id="incrementalPercentage">
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
        var text = "<b>{{ $conversion != null ? $conversion->unit : '' }} : " + calBag.toLocaleString() + "&nbsp;&nbsp;&nbsp;&nbsp; Amount : " + calPrice.toLocaleString() + "</b>";
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
        document.getElementById('from_date').value= document.getElementById('from').value;
        document.getElementById('to_date').value = document.getElementById('to').value;
        if(document.getElementById('perc').value != "" && document.getElementById('projected').checked == true){
            document.getElementById('incrementalPercentage').value = document.getElementById('perc').value;
            form.submit();
        }else if(document.getElementById('perc').value == "" && document.getElementById('projected').checked == true){
            alert("Enter Incremental Percentage");
        }else{
            form.submit();
        }
    }
</script>
@endsection
