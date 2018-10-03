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

@php $totalExpense = 0; $totalTP = 0; $totalRevenue  = 0; @endphp

<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-primary">
        <div class="panel-heading">Projections</div>
        <div class="panel-body">
            <form action="" method="get">
                <div class="col-md-6">
                    <table class="table table-hover">
                        <tr>
                            <td>Zone Number</td>
                            <td>:</td>
                            <td><input value="{{ isset($_GET['zone_number']) ? $_GET['zone_number'] : '' }}" required type="number" min=0 name="zone_number" id="zone_number" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Zone name</td>
                            <td>:</td>
                            <td><input value="{{ isset($_GET['zone_name']) ? $_GET['zone_name'] : '' }}" required type="text" name="zone_name" id="zone_name" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Starting Date</td>
                            <td>:</td>
                            <td><input value="{{ isset($_GET['starting_date']) ? $_GET['starting_date'] : '' }}" required type="date" name="starting_date" id="starting_date" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Setup Fees</td>
                            <td>:</td>
                            <td><input value="{{ isset($_GET['oti']) ? $_GET['oti'] : '' }}" required type="number" min=0 name="oti" id="oti" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Operational Expenses Per Month</td>
                            <td>:</td>
                            <td><input value="{{ isset($_GET['expenses_per_month']) ? $_GET['expenses_per_month'] : '' }}" required type="number" min=0 name="expenses_per_month" id="expenses_per_month" class="form-control"></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-responsive">
                        <tr>
                            <td>Assets</td>
                            <td>:</td>
                            <td><input value="{{ isset($_GET['assets']) ? $_GET['assets'] : '' }}" required type="number" min=0 name="assets" id="assets" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Deposit</td>
                            <td>:</td>
                            <td><input value="{{ isset($_GET['deposit']) ? $_GET['deposit'] : '' }}" required type="number" min=0 name="deposit" id="deposit" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Expected Revenue</td>
                            <td>:</td>
                            <td><input oninput="calculateCogs()" value="{{ isset($_GET['expected_revenue']) ? $_GET['expected_revenue'] : '' }}" required type="number" min=0 name="expected_revenue" id="expected_revenue_input" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>COGS</td>
                            <td>:</td>
                            <td id="cogs">
                            {{ isset($_GET['expected_revenue']) ? ($_GET['expected_revenue'] - ($_GET['expected_revenue'] / 100 * 5)) : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan=3><button type="submit" class="btn btn-success form-control">Start Projection</button></td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
@if(isset($_GET['zone_number']))
<div class="col-md-6" id="initial_zone">
    <table class="table table-hover" border=1>
        <thead>
            <tr>
                <th colspan=2 style="background-color:#dddddd; text-align:center;">Projection</th>
            </tr>
        </thead>
        <tr>
            <td>Zone</td>
            <td id="display_projection">{{ $_GET['zone_number'] }}. {{ $_GET['zone_name'] }}</td>
        </tr>
        <tr>
            <td>Starting Date</td>
            <td>{{ date('M-Y',strtotime($_GET['starting_date'])) }}</td>
        </tr>
        <tr>
            <td>Expenses</td>
            <td>
                <table class="table table-striped">
                    <tr>
                        <td>Assets</td>
                        <td>{{ number_format($_GET['assets']) }}</td>
                    </tr>
                    @php $assets = $_GET['assets'] + $_GET['deposit'] + $_GET['oti'] @endphp
                    <tr>
                        <td>Deposit</td>
                        <td>{{ number_format($_GET['deposit']) }}</td>
                    </tr>
                    <tr>
                        <td>Setup Fees</td>
                        <td>{{ number_format($_GET['oti']) }}</td>
                    </tr>
                    <tr>
                        <td>Operational Expenses Per Month</td>
                        <td>{{ number_format($_GET['expenses_per_month']) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    @php
        $asset_depreciation = ($_GET['assets'] / 100 * 40) / 12;
        $setup_fees_depreciation = ($_GET['oti'] / 100 * 40) / 12;
        $asset_depreciation = $asset_depreciation + $setup_fees_depreciation;
    @endphp
    @php $time = strtotime($_GET['starting_date']); @endphp
    <div id="test_tabel">
    <table class="table table-hover" border=1>
    <tr style="background-color:#5cb85c; color:white;">
        <th class="text-center">Description</th>
        <th class="text-center">Date</th>
        <th class="text-center">Dr</th>
        <th class="text-center">Cr</th>
        <th class="text-center">Closing Balance</th>
    </tr>
    <tbody id="things">
    <tr>
        <td class="text-center">Revenue</td>
        <td class="text-center">{{ date('M Y',strtotime($_GET['starting_date'])) }}</td>
        <td class="text-right"></td>
        <td class="text-right">{{ number_format($currentRevenue = $_GET['expected_revenue']) }}</td>
        @php $closing_balance = $currentRevenue @endphp
        <td class="text-right">{{ number_format($currentRevenue) }}</td>
    </tr>
    <tr>
        <td class="text-center">Operational Expenses</td>
        <td class="text-center">{{ date('M Y',strtotime($_GET['starting_date'])) }}</td>
        @php $current_expense = $_GET['expenses_per_month']; @endphp
        <td class="text-right">{{ number_format($_GET['expenses_per_month']) }}</td>
        @php $closing_balance = $closing_balance - $current_expense @endphp
        <td></td>
        <td class="text-right">{{ number_format($closing_balance) }}</td>
    </tr>
    <tr>
        <td class="text-center">Asset Depreciation</td>
        <td class="text-center">{{ date('M Y',strtotime($_GET['starting_date'])) }}</td>
        @php $currentTP = $_GET['expected_revenue'] / 100 * 5 @endphp
        <td class="text-right">{{ number_format($asset_depreciation) }}</td>
        <td class="text-right"></td>
        @php $closing_balance = $closing_balance - $asset_depreciation @endphp
        <td class="text-right">{{ number_format($closing_balance) }}</td>
    </tr>
    @if($closing_balance > 0)
    <tr>
        <td class="text-center">Tax</td>
        <td class="text-center">{{ date('M Y',strtotime($_GET['starting_date'])) }}</td>
        @php $tax = $closing_balance/100*35;  $closing_balance = $closing_balance - $tax @endphp
        <td class="text-right">{{ number_format($tax) }}</td>
        <td class="text-right"></td>
        <td class="text-right">{{ number_format($closing_balance) }}</td>
    </tr>
    @endif
    <tr>
        <td colspan=5>
            @if($closing_balance < 0)
                Loss : {{ number_format($closing_balance) }}
            @else
                Profit Before Tax : {{ number_format($closing_balance + $tax) }}
                <br>
                Profit After Tax : {{ number_format($closing_balance) }}
                <br>
            @endif
        </td>
    </tr>
    <!-- codes deleted here -->
    </tbody>
    <tbody id="things2">
    </tbody>
    <tr>
        <td colspan=5>
            @for($i = 1; $i < 12; $i++)
            <button data-toggle="modal" data-target="#calculation{{ $i }}" class="{{ $i == 1 ? 'btn btn-warning form-control' : 'hidden' }}" id="btn{{ $i }}">Projection For {{ date('M Y',strtotime('+'.$i.' months',$time)) }}</button>
            <!-- Modal -->
            <div id="calculation{{ $i }}" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form action="">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Projection</h4>
                    </div>
                    <div class="modal-body">
                        
                        <table class="table table-responsive" border=1>
                        <label for="address">
                            <address id="address"><b>**Instructions**</b> : <i>Please fill in all the fields with your expected increment in a month. If you don't have any increment expectation enter 0.</i></address>
                        </label>
                            <tr>
                                <td>Date</td>
                                <td>Expense</td>
                                <td>Revenue</td>
                            </tr>
                            <tr>
                                <td id="month{{ $i }}">{{ date('M Y',strtotime('+'.$i.' months',$time)) }}</td>
                                <td>
                                    <table class="table table-responsive">
                                        <tr>
                                            <td>Assets</td>
                                            <td>:</td>
                                            <td><input required type="number" min=0 name="assets_increment[]" id="assets_increment{{ $i }}" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td>Deposit</td>
                                            <td>:</td>
                                            <td><input required type="number" min=0 name="deposit_increment[]" id="deposit_increment{{ $i }}" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td>Setup Fees</td>
                                            <td>:</td>
                                            <td><input required type="number" min=0 name="oti_increment[]" id="oti_increment{{ $i }}" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td>Operational Expenses Per Month</td>
                                            <td>:</td>
                                            <td><input type="number" min=0 name="expenses_per_month_increment[]" id="expenses_per_month_increment{{ $i }}" class="form-control"></td>
                                        </tr>
                                    </table>
                                </td>
                                <td><input required type="number" min=0 placeholder="Revenue" name="revenue_increment[]" id="revenue_increment{{ $i }}" class="form-control"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="calculateForMonth({{ $i }})" class="btn btn-success pull-left">Proceed</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                    </form>
                </div>
            </div>
            @endfor
            <button data-toggle="modal" data-target="#five_calculation" class="hidden" id="btnFiveYears">Project For 5 Years</button>
        </td>
    </tr>
    </table>
    </div>
    <div id="year_end"></div>
    <table class="table table-responsive" border=1>
    <tbody id="disp">
    
    </tbody>
    </table>
    </div>
    <div class="col-md-6" id="next_zone"></div>
    <div id="calculatedResults">
    
    </div>
</div>
<!-- Modal -->
<div id="five_calculation" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form action="">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Projection</h4>
      </div>
      <div class="modal-body">
        <table class="table table-responsive" border=1>
        <label for="address">
            <address id="address"><b>**Instructions**</b> : <i>Please fill in all the fields with your expected increment in a month. If you don't have any increment expectation enter 0.</i></address>
        </label>
            <tr>
                <td>Date</td>
                <td>Expense</td>
                <td>Revenue</td>
            </tr>
            @for($i = 1; $i < 5; $i++)
            <input type="hidden" name="years[]" value="{{ date('M Y',strtotime('+'.$i.' years',$time)) }} - {{ date('M Y',strtotime('+'.($i + 1).' years',$time)) }}">
            <tr>
                <td>{{ date('M Y',strtotime('+'.$i.' years',$time)) }} - {{ date('M Y',strtotime('+'.($i + 1).' years',$time)) }}</td>
                <td>
                    <table class="table table-responsive">
                        <!-- <tr>
                            <td>Number Of Cities</td>
                            <td>:</td>
                            <td><input required type="number" min=0 name="five_cities[]" id="five_cities" class="form-control"></td>
                        </tr> -->
                        <tr>
                            <td>Assets</td>
                            <td>:</td>
                            <td><input required type="number" min=0 name="five_assets_increment[]" id="assets_increment" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Deposit</td>
                            <td>:</td>
                            <td><input required type="number" min=0 name="five_deposit_increment[]" id="deposit_increment" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Setup Fees</td>
                            <td>:</td>
                            <td><input required type="number" min=0 name="five_oti_increment[]" id="oti_increment" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Operational Expenses Per Month</td>
                            <td>:</td>
                            <td><input type="number" min=0 name="five_expenses_per_month_increment[]" id="expenses_per_month_increment" class="form-control"></td>
                        </tr>
                    </table>
                </td>
                <td><input required type="number" min=0 placeholder="Revenue" name="five_revenue_increment[]" id="revenue_increment" class="form-control"></td>
            </tr>
            @endfor
        </table>

      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-success pull-left" onclick="displayCalculation()">Proceed</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>
  </div>
</div>
<div id="calculation" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <form action="" id="additional_zone">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Please Enter The Zone Number And Name</h4>
        </div>
        <div class="modal-body">
            <table class="table table-responsive">
                <tr>
                    <td>Zone Number</td>
                    <td>:</td>
                    <td><input type="text" name="zone_number2" id="zone_number2" class="form-control"></td>
                </tr>
                <tr>
                    <td>Zone Name</td>
                    <td>:</td>
                    <td><input type="text" name="zone_name2" id="zone_name2" class="form-control"></td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="project()" data-dismiss="modal" class="btn btn-success pull-left">Proceed</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</form>
</div>
</div>
<script>
var text = "";
var assets = parseInt("{{ $_GET['assets'] }}");
var deposit = parseInt("{{ $_GET['deposit'] }}");
var oti = parseInt("{{ $_GET['oti'] }}");
var oti_depreciation = oti / 100 * 40;
var monthly_expense = parseInt("{{ $_GET['expenses_per_month'] }}");
var revenue = parseInt("{{ $_GET['expected_revenue'] }}");
var closing_balance = parseInt("{{ $closing_balance }}");
var totalExpense = 0;
var totalTP = 0;
var totalRevenue = 0;
var count = 1;
var tax;
var zone_name = [];
var zone_number = [];
var assets_depreciation = assets / 100 *40;
function calculateForMonth(arg){
    var month = document.getElementById('month'+arg).innerHTML;
    var next = arg + 1;
    var assets_increment = parseInt(document.getElementById('assets_increment'+arg).value);
    var deposit_increment = parseInt(document.getElementById('deposit_increment'+arg).value);
    var oti_increment = parseInt(document.getElementById('oti_increment'+arg).value);
    var monthly_expense_increment = parseInt(document.getElementById('expenses_per_month_increment'+arg).value);
    var revenue_increment = parseInt(document.getElementById('revenue_increment'+arg).value);
    var assets_dep_month = assets_depreciation / 12;
    var oti_dep_month = oti_depreciation / 12;
    var asset_increment = assets / 100 * assets_increment;
    var asset_increment_month = asset_increment / 12;

    if(isNaN(assets_increment) || isNaN(deposit_increment) || isNaN(oti_increment) || isNaN(monthly_expense_increment) || isNaN(revenue_increment)){
        swal("Error","Please Enter Incremental Percentage","error");
    }else{
        $("#calculation"+arg).modal('hide');
        if(arg % 3 == 0){
            text += "<tr style='background-color:#e0e0e0;'><td colspan='5'></td></tr>";
        }
        monthly_expense = monthly_expense + (monthly_expense / 100 * monthly_expense_increment);
        revenue = revenue + (revenue / 100 * revenue_increment);
        assets = assets + (assets/100*assets_increment);
        closing_balance = closing_balance + revenue;

        text += "<tr><td class='text-center'>Revenue</td><td class='text-center'>" + month + "</td>"
                + "<td></td><td class='text-right'>" + (parseInt(revenue)).toLocaleString() + "</td><td class='text-right'>" + (parseInt(closing_balance)).toLocaleString() + "</td></tr>";
        closing_balance = closing_balance - monthly_expense;
        text += "<tr><td class='text-center'>Operational Expenses</td><td class='text-center'>" + month + "</td>"
                + "<td class='text-right'>" + (parseInt(monthly_expense)).toLocaleString() + "</td><td></td><td class='text-right'>" + (parseInt(closing_balance)).toLocaleString() + "</td></tr>";
        closing_balance = closing_balance - assets_dep_month - oti_dep_month - asset_increment_month;
        text += "<tr><td class='text-center'>Asset Depreciation</td><td class='text-center'>" + month + "</td>"
                + "<td class='text-right'>" + (parseInt(assets_dep_month + oti_dep_month + asset_increment_month)).toLocaleString() + "</td><td></td><td class='text-right'>" + (parseInt(closing_balance)).toLocaleString() + "</td></tr>";
        if(closing_balance > 0){
            tax = closing_balance / 100 * 35;
            closing_balance = closing_balance - tax;
            text += "<tr>"+
                        "<td class='text-center'>Tax</td>"+
                        "<td class='text-center'>" + month + "</td>" +
                        "<td class='text-right'>" + (parseInt(tax)).toLocaleString() + "</td>"+
                        "<td class='text-right'></td>"+
                        "<td class='text-right'>" + (parseInt(closing_balance)).toLocaleString() + "</td></tr>";
            
            text += "<tr>"+
                        "<td colspan=5>Profit Before Tax "  + (parseInt(closing_balance + tax)).toLocaleString() + "<br>" +
                        "Profit After Tax : " + (parseInt(closing_balance)).toLocaleString() + "</td></tr>";
        }else{
            text += "<tr>"+
                        "<td colspan=5>Loss "  + (parseInt(closing_balance)).toLocaleString() + "</td></tr>";
        }
        if(arg != 11){
            document.getElementById('btn'+arg).className = "hidden";
            document.getElementById('btn'+next).className = "btn btn-warning form-control";
        }else{
            document.getElementById('btn'+arg).className = "hidden";
            document.getElementById('btnFiveYears').className = "btn btn-warning form-control";
        }
    }
    document.getElementById('things2').innerHTML = text;
    if(arg == 11){
        for(var i = 1; i < count; i++){
            var new_text = "<table class='table table-hover' border=1>"+"<thead><tr><th colspan=2 style='background-color:#dddddd; text-align:center;'>Projection</th>" +
            "</tr></thead><tr>"+
            "<td>Zone</td>"+
            "<td id='display_projection'>" + zone_number + ". " + zone_name +"</td>"+
        "</tr><tr>"+
            "<td>Starting Date</td>"+
            "<td>{{ date('M-Y',strtotime($_GET['starting_date'])) }}</td>"+
        "</tr><tr>"+
            "<td>Expenses</td><td>"+
                "<table class='table table-striped'>"+
                    "<tr><td>Assets</td><td>{{ number_format($_GET['assets']) }}</td>"+
                    "</tr>@php $assets = $_GET['assets'] + $_GET['deposit'] + $_GET['oti'] @endphp"+
                    "<tr><td>Deposit</td><td>{{ number_format($_GET['deposit']) }}</td>"+
                    "</tr><tr><td>Setup Fees</td>"+
                        "<td>{{ number_format($_GET['oti']) }}</td>"+
                    "</tr><tr><td>Operational Expenses Per Month</td>"+
                        "<td>{{ number_format($_GET['expenses_per_month']) }}</td>"+
                    "</tr></table></td></tr></table>";
            document.getElementById('next_zone').innerHTML = new_text + document.getElementById('test_tabel').innerHTML;
        }
    }
}
    var zones = document.getElementById('display_projection').innerHTML;
    function displayCalculation(){
        var fiveAssets = document.getElementsByName('five_assets_increment[]');
        var fiveDeposit = document.getElementsByName('five_deposit_increment[]');
        var fiveOneTime = document.getElementsByName('five_oti_increment[]');
        var fiveExpensePerMonth = document.getElementsByName('five_expenses_per_month_increment[]');
        var fiveRevenue = document.getElementsByName('five_revenue_increment[]');
        var fiveCities = document.getElementsByName('five_revenue_increment[]');
        
        var years = document.getElementsByName('years[]');
    
        var expense = totalExpense;
        var revenue = totalRevenue;
        var assets_depreciation = assets/100*40;
        assets = assets - assets/100*40;
        // var deposit = deposit;
        var oneTimeInvestment = oti;
        
        var text = "<tr style='background-color:#5cb85c; color:white; text-align:center'><td>Year</td><td>Expense</td><td>Revenue</td><td>Transactional Profit</td></tr>";
        var check = 0;
        text += "<tr><td class='text-center'>{{ date('M Y',$time) }} - {{ date('M Y',strtotime('+ 1 years',$time)) }}</td>"+
            "<td class='text-right'>" + totalExpense.toLocaleString() + "</td><td class='text-right'>" + totalRevenue.toLocaleString() +
            "</td><td class='text-right'>"+totalTP.toLocaleString()
            +"</td></tr>";
        for(var i = 0; i < fiveAssets.length; i++){
            if(fiveCities[i] == "" || fiveAssets[i].value == "" || fiveDeposit[i].value == "" || fiveOneTime[i].value == "" || fiveExpensePerMonth[i].value == "" || fiveRevenue[i].value == ""){
                swal('Error','Please Enter Increment Amount','error');
                check = 1;
            }else{
                var expense_in = totalExpense / 100 * parseInt(fiveAssets[i].value);
                var revenue_in = revenue / 100 * parseInt(fiveRevenue[i].value);
                var assets_in = assets / 100 * parseInt(fiveAssets[i].value);
                var deposit_in = deposit / 100 * parseInt(fiveRevenue[i].value);
                var oneTimeInvestment_in = oneTimeInvestment / 100 * parseInt(fiveOneTime[i].value);

                revenue = revenue + revenue_in;
                totalExpense = totalExpense + expense_in + assets_in + deposit_in + oneTimeInvestment_in;
                var tp = revenue / 100 * 5;
                text += "<tr>"+
                        "<td class='text-center'>"+ years[i].value+"</td>"+
                        "<td class='text-right'>"+ expense.toLocaleString()+"</td>"+
                        "<td class='text-right'>"+ revenue.toLocaleString()+"</td>"+
                        "<td class='text-right'>"+ tp.toLocaleString()+"</td>"+
                    "</tr>";
                totalExpense += expense;
                totalTP += tp;
                totalRevenue += revenue;
                text += "<tr>"+
                        "<td></td>"+
                        "<td colspan=3>Total Expenses :" + totalExpense + "<br>" +
                        "Total Revenue : " + totalRevenue + "<br>" +
                        "Total TP : " + totalTP + "<br>" +
                        "Assets Depreciated : " + assets_depreciation + "<br>";
                if(totalRevenue > totalExpense){
                    text += "Profit Before Tax : " + (totalRevenue - totalExpense) + "<br>" +
                            "Less Tax : " + ((totalRevenue - totalExpense) / 100 * 35) + "<br>" +
                            "Profit After Tax : " + ((totalRevenue - totalExpense) - ((totalRevenue - totalExpense) / 100 * 35)) + "</td></tr>";
                }else{
                    text += "Loss : " + (totalRevenue - totalExpense) + "</td></tr>";
                }
            }
        }
        text += "<tr>"+
                    "<th class='text-center'>Total</th>"+
                    "<th class='text-right'>"+totalExpense.toLocaleString()+"</th>"+
                    "<th class='text-right'>"+totalRevenue.toLocaleString()+"</th>"+
                    "<th class='text-right'>"+totalTP.toLocaleString()+"</th>"+
                "</tr>";
        if(check == 0){
            $("#five_calculation").modal('hide');
        }
        var running_assets = deposit + assets + totalRevenue;
        if(totalExpense > running_assets){
            var t = "Loss";
            var cal = totalExpense - running_assets;
        }else{
            var t = "Profit";
            var cal = running_assets - totalExpense;
        }
        document.getElementById("disp").innerHTML = text;
    }
    swal("Are you starting any new zone with the same calculation expenses at the same time period?", {
                buttons: {
                    no: "No",
                    yes: true,
                },
                })
                .then((value) => {
                switch (value) {
                
                    case "no":
                        
                        break;
                
                    case "yes":
                        count++;
                        document.getElementById('additional_zone').reset();
                        $("#calculation").modal('show');
                        break;
                
                    default:
                }
            });
    function project(){
        // zones += "<br>" + document.getElementById('zone_number2').value + ". " + document.getElementById('zone_name2').value;
        var dates = new Date(document.getElementById('starting_date').value);
        
        swal("Are you starting any new zone with the same calculation expenses at the same time period?", {
            buttons: {
                no: "No",
                yes: true,
            },
            })
            .then((value) => {
            switch (value) {
            
                case "no":
                    break;
            
                case "yes":
                    count++;
                    zone_name.push(document.getElementById('zone_name2').value);
                    zone_number.push(document.getElementById('zone_number2').value);
                    // alert(zone_name);
                    document.getElementById('additional_zone').reset();
                    $("#calculation").modal('show');
                    break;
            
                default:
                    
            }
        });
    }
</script>
@endif
<script>
    function calculateCogs(){
        var expected_revenue_first = parseInt(document.getElementById('expected_revenue_input').value);
        var revenue_five_percent = expected_revenue_first / 100 * 5;
        var cogs = expected_revenue_first - revenue_five_percent;
        document.getElementById('cogs').innerHTML = cogs;
    }
</script>
@endsection