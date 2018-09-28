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

<div class="col-md-4 col-md-offset-1">
    <div class="panel panel-primary">
        <div class="panel-heading">Projections</div>
        <div class="panel-body">
        <form action="" method="get">
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
                    <td>One Time Invesment</td>
                    <td>:</td>
                    <td><input value="{{ isset($_GET['oti']) ? $_GET['oti'] : '' }}" required type="number" min=0 name="oti" id="oti" class="form-control"></td>
                </tr>
                <tr>
                    <td>Expenses Per Month</td>
                    <td>:</td>
                    <td><input value="{{ isset($_GET['expenses_per_month']) ? $_GET['expenses_per_month'] : '' }}" required type="number" min=0 name="expenses_per_month" id="expenses_per_month" class="form-control"></td>
                </tr>
                <tr>
                    <td>Expected Revenue</td>
                    <td>:</td>
                    <td><input value="{{ isset($_GET['expected_revenue']) ? $_GET['expected_revenue'] : '' }}" required type="number" min=0 name="expected_revenue" id="expected_revenue" class="form-control"></td>
                </tr>
                <tr>
                    <td colspan=3><button type="submit" class="btn btn-success form-control">Start Projection</button></td>
                </tr>
            </table>
        </form>
        </div>
    </div>
</div>
@if(isset($_GET['zone_number']))
<div class="col-md-6">
    <table class="table table-hover" border=1>
        <thead>
            <tr>
                <th colspan=2 style="background-color:#dddddd; text-align:center;">Projection</th>
            </tr>
        </thead>
        <tr>
            <td>Zones</td>
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
                        <td>{{ $_GET['assets'] }}</td>
                    </tr>
                    @php $assets = $_GET['assets'] + $_GET['deposit'] + $_GET['oti'] @endphp
                    <tr>
                        <td>Deposit</td>
                        <td>{{ $_GET['deposit'] }}</td>
                    </tr>
                    <tr>
                        <td>One Time Investment</td>
                        <td>{{ $_GET['oti'] }}</td>
                    </tr>
                    <tr>
                        <td>Expenses Per Month</td>
                        <td>{{ $_GET['expenses_per_month'] }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    @php $time = strtotime($_GET['starting_date']); @endphp
    <table class="table table-hover" border=1>
    <tr style="background-color:#5cb85c; color:white;">
        <th class="text-center">Date</th>
        <th class="text-center">Expense</th>
        <th class="text-center">Revenue</th>
        <th class="text-center">Transactional Profit</th>
    </tr>
    <tbody id="things">
    <tr>
        <td class="text-center">{{ date('M Y',strtotime($_GET['starting_date'])) }}</td>
        <td class="text-right">{{ number_format($current_expense = $_GET['expenses_per_month'] + $assets) }}</td>
        <td class="text-right">{{ number_format($currentRevenue = $_GET['expected_revenue']) }}</td>
        <td class="text-right">{{ number_format($currentTP = $_GET['expected_revenue'] / 100 * 5) }}</td>
    </tr>
    <!-- codes deleted here -->
    </tbody>
    <tbody id="things2">
    </tbody>
    <tr>
        <td colspan=4>
            @for($i = 1; $i < 12; $i++)
            <button data-toggle="modal" data-target="#calculation{{ $i }}" class="{{ $i == 1 ? 'btn btn-warning form-control' : 'hidden' }}" id="btn{{ $i }}">Project For {{ date('M Y',strtotime('+'.$i.' months',$time)) }}</button>
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
                                            <td>One Time Invesment</td>
                                            <td>:</td>
                                            <td><input required type="number" min=0 name="oti_increment[]" id="oti_increment{{ $i }}" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td>Expenses Per Month</td>
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
    <table class="table table-responsive" border=1>
    <tbody id="disp">
    
    </tbody>
    </table>
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
                            <td>One Time Invesment</td>
                            <td>:</td>
                            <td><input required type="number" min=0 name="five_oti_increment[]" id="oti_increment" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Expenses Per Month</td>
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
var monthly_expense = parseInt("{{ $_GET['expenses_per_month'] }}");
var revenue = parseInt("{{ $_GET['expected_revenue'] }}");
var totalExpense = 0;
var totalTP = 0;
var totalRevenue = 0;
function calculateForMonth(arg){
    var month = document.getElementById('month'+arg).innerHTML;
    var next = arg + 1;
    var assets_increment = parseInt(document.getElementById('assets_increment'+arg).value);
    var deposit_increment = parseInt(document.getElementById('deposit_increment'+arg).value);
    var oti_increment = parseInt(document.getElementById('oti_increment'+arg).value);
    var monthly_expense_increment = parseInt(document.getElementById('expenses_per_month_increment'+arg).value);
    var revenue_increment = parseInt(document.getElementById('revenue_increment'+arg).value);
    if(isNaN(assets_increment) || isNaN(deposit_increment) || isNaN(oti_increment) || isNaN(monthly_expense_increment) || isNaN(revenue_increment)){
        swal("Error","Please Enter Incremental Percentage","error");
    }else{
        if(arg % 3 == 0){
            text += "<tr style='background-color:#e0e0e0;'><td colspan='4'></td></tr>";
        }
        assets_in = assets / 100 * assets_increment;
        deposit_in = deposit / 100 * deposit_increment;
        oti_in = oti / 100 * oti_increment;
        monthly_expense_in = monthly_expense / 100 * monthly_expense_increment;
        revenue_in = revenue / 100 * revenue_increment;
        monthly_expense = monthly_expense_in + monthly_expense + assets_in + deposit_in + oti_in;
        revenue = revenue + revenue_in;
        var tp = revenue / 100 * 5;
        totalRevenue += revenue;
        totalExpense += monthly_expense;
        totalTP += tp;
        assets = assets + assets_in;
        deposit = deposit + deposit_in;
        oti = oti + oti_in;
        document.getElementById('btn'+arg).className = "hidden";
        var monthly_expense2 = parseInt(monthly_expense);
        var revenue2 = parseInt(revenue);
        var tp2 = parseInt(tp);
        text += "<tr><td class='text-center'>"+month+
                    "</td><td class='text-right'>"+monthly_expense2.toLocaleString()+
                    "</td><td class='text-right'>"+revenue2.toLocaleString()+
                    "</td><td class='text-right'>"+tp2.toLocaleString()+
                    "</td></tr>";
        if(arg != 11){
            document.getElementById('btn'+next).className = "btn btn-warning form-control";
        }else{
            // alert("Total Expense : " + totalExpense + "Total TP : " + totalTP + "Assets : " + assets/100*40 + "Deposit : " + deposit);
            text += "<tr><th class='text-center'>Total</th><th class='text-right'>"+
                        totalExpense+"</th><th class='text-right'>"+(totalRevenue + assets/100*40)+"</th><th class='text-right'>"+
                        totalTP+"</th></tr>"
            document.getElementById('btnFiveYears').className = "btn btn-warning form-control";
        }
        document.getElementById('things2').innerHTML = text;
        $("#calculation"+arg).modal('hide');
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
        assets = assets/100*40;
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
        var result = "Total Deposit : " + deposit.toLocaleString() + "<br>"
                        + "Total Assets : " + assets.toLocaleString() + "<br>"
                        + "Total Expenses : " + totalExpense.toLocaleString() + "<br>"
                        + "Total Revenue : " + totalRevenue.toLocaleString() + "<br>"
                        + t + " : " + totalExpense.toLocaleString() + " - (" + deposit.toLocaleString()
                        + " + " + assets.toLocaleString() + " + " + totalRevenue.toLocaleString() + ") = "
                        + cal.toLocaleString();
        document.getElementById("calculatedResults").innerHTML = result;
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
                        document.getElementById('display_projection').innerHTML = text;
                        break;
                
                    case "yes":
                        count++;
                        document.getElementById('additional_zone').reset();
                        $("#calculation").modal('show');
                        break;
                
                    default:
                        swal("Got away safely!");
                }
            });
    var count = 1;
    function project(){
        zones += "<br>" + document.getElementById('zone_number2').value + ". " + document.getElementById('zone_name2').value;
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
                    document.getElementById('display_projection').innerHTML = zones;
                    break;
            
                case "yes":
                    count++;
                    document.getElementById('additional_zone').reset();
                    $("#calculation").modal('show');
                    break;
            
                default:
                    swal("Got away safely!");
            }
        });
    }
</script>
@endif
@endsection