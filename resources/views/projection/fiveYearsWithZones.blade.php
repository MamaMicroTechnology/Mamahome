@extends('layouts.app')
@section('content')
    <br>
    <div class="col-md-4">
        <div class="panel panel-success">
            <div class="panel-heading">Inputs For Projection</div>
            <div class="panel-body">
                <form action="">
                    <table class="table table-responsive">
                        <tr>
                            <td>Revenue</td>
                            <td>:</td>
                            <td><input id="revenue_input" type="number" min=0 class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Expense</td>
                            <td>:</td>
                            <td><input id="expense_input" type="number" min=0 class="form-control"></td>
                        </tr>
                        <tr>
                            <td colspan="3"><button type="button" onclick="calculateProjection()" class="btn btn-success form-control">View Projection</button></td>
                        </tr>
                    </table>
                </form>
                <table class="table table-responsive">
                    <tr>
                        <td>Revenue</td>
                        <td>:</td>
                        <td class="text-right" id="revenue_calculation"></td>
                    </tr>
                    <tr>
                        <td>Expense</td>
                        <td>:</td>
                        <td class="text-right" id="expense_calculation"></td>
                    </tr>
                    <tr>
                        <td>Profit Before Tax</td>
                        <td>:</td>
                        <td class="text-right" id="profit_before_tax"></td>
                    </tr>
                    <tr>
                        <td>Tax</td>
                        <td>:</td>
                        <td class="text-right" id="tax"></td>
                    </tr>
                    <tr>
                        <td>Profit After Tax</td>
                        <td>:</td>
                        <td class="text-right" id="profit_after_tax"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <table class="table table-responsive" border=1>
            <thead style="background-color: #eed35b;">
                <th>Month</th>
                <th>Particulars</th>
                <th>2019-2020</th>
                <th>2020-2021</th>
                <th>2021-2022</th>
                <th>2022-2023</th>
                <th>2023-2024</th>
                <th>2024-2025</th>
            </thead>
            <tbody>
                <tr style="background-color: #e69730;">
                    <td></td>
                    <td></td>
                    <td>1st Year</td>
                    <td>2nd Year</td>
                    <td>3rd Year</td>
                    <td>4th Year</td>
                    <td>5th Year</td>
                    <td>6th Year</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td rowspan=6>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        Jan - Mar
                    </td>
                    <td class="text-center" style="background-color:#f2bce7;"></td>
                    <td class="text-center" style="background-color:#f2bce7;"></td>
                    <td class="text-center" style="background-color:#f2bce7;">Z1 - Z12</td>
                    <td class="text-center" style="background-color:#f2bce7;">Z1 TO Z28</td>
                    <td class="text-center" style="background-color:#f2bce7;">Z1 TO Z47</td>
                    <td class="text-center" style="background-color:#f2bce7;">Z1 TO Z72</td>
                    <td class="text-center" style="background-color:#f2bce7;">Z1 TO Z100</td>
                </tr>
                <tr style="background-color: #f2bce7;">
                    <td>Revenue</td>
                    <td></td>
                    <td class="text-right" id="revenue_4"></td>
                    <td class="text-right" id="revenue_8"></td>
                    <td class="text-right" id="revenue_12"></td>
                    <td class="text-right" id="revenue_16"></td>
                    <td class="text-right" id="revenue_20"></td>
                </tr>
                <tr style="background-color: #f2bce7;">
                    <td>Expense</td>
                    <td></td>
                    <td class="text-right" id="expense_4"></td>
                    <td class="text-right" id="expense_8"></td>
                    <td class="text-right" id="expense_12"></td>
                    <td class="text-right" id="expense_16"></td>
                    <td class="text-right" id="expense_20"></td>
                </tr>
                <tr style="background-color: #f2bce7;">
                    <td>Profit Before Tax</td>
                    <td></td>
                    <td class="text-right" id="pbt_4"></td>
                    <td class="text-right" id="pbt_8"></td>
                    <td class="text-right" id="pbt_12"></td>
                    <td class="text-right" id="pbt_16"></td>
                    <td class="text-right" id="pbt_20"></td>
                </tr>
                <tr style="background-color: #f2bce7;">
                    <td>Tax</td>
                    <td></td>
                    <td class="text-right" id="tax_4"></td>
                    <td class="text-right" id="tax_8"></td>
                    <td class="text-right" id="tax_12"></td>
                    <td class="text-right" id="tax_16"></td>
                    <td class="text-right" id="tax_20"></td>
                </tr>
                <tr style="background-color: #f2bce7;">
                    <td>Profit After Tax</td>
                    <td></td>
                    <td class="text-right" id="pat_4"></td>
                    <td class="text-right" id="pat_8"></td>
                    <td class="text-right" id="pat_12"></td>
                    <td class="text-right" id="pat_16"></td>
                    <td class="text-right" id="pat_20"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td rowspan=6>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        Apr - Jun
                    </td>
                    <td style="background-color:#adc5ed;"></td>
                    <td class="text-center" style="background-color:#adc5ed;">Z1 TO Z3</td>
                    <td class="text-center" style="background-color:#adc5ed;">Z1 TO Z16</td>
                    <td class="text-center" style="background-color:#adc5ed;">Z1 TO Z32</td>
                    <td class="text-center" style="background-color:#adc5ed;">Z1 TO Z53</td>
                    <td class="text-center" style="background-color:#adc5ed;">Z1 TO Z79</td>
                    <td style="background-color:#adc5ed;"></td>
                </tr>
                <tr style="background-color:#adc5ed;">
                    <td>Revenue</td>
                    <td class="text-right" id="revenue_1"></td>
                    <td class="text-right" id="revenue_5"></td>
                    <td class="text-right" id="revenue_9"></td>
                    <td class="text-right" id="revenue_13"></td>
                    <td class="text-right" id="revenue_17"></td>
                    <td></td>
                </tr>
                <tr style="background-color:#adc5ed;">
                    <td>Expense</td>
                    <td class="text-right" id="expense_1"></td>
                    <td class="text-right" id="expense_5"></td>
                    <td class="text-right" id="expense_9"></td>
                    <td class="text-right" id="expense_13"></td>
                    <td class="text-right" id="expense_17"></td>
                    <td></td>
                </tr>
                <tr style="background-color:#adc5ed;">
                    <td>Profit Before Tax</td>
                    <td class="text-right" id="pbt_1"></td>
                    <td class="text-right" id="pbt_5"></td>
                    <td class="text-right" id="pbt_9"></td>
                    <td class="text-right" id="pbt_13"></td>
                    <td class="text-right" id="pbt_17"></td>
                    <td></td>
                </tr>
                <tr style="background-color:#adc5ed;">
                    <td>Tax</td>
                    <td class="text-right" id="tax_1"></td>
                    <td class="text-right" id="tax_5"></td>
                    <td class="text-right" id="tax_9"></td>
                    <td class="text-right" id="tax_13"></td>
                    <td class="text-right" id="tax_17"></td>
                    <td></td>
                </tr>
                <tr style="background-color:#adc5ed;">
                    <td>Profit After Tax</td>
                    <td class="text-right" id="pat_1"></td>
                    <td class="text-right" id="pat_5"></td>
                    <td class="text-right" id="pat_9"></td>
                    <td class="text-right" id="pat_13"></td>
                    <td class="text-right" id="pat_17"></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td rowspan=6>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        Jul - Sept
                    </td>
                    <td style="background-color:#c6f2c7;"></td>
                    <td class="text-center" style="background-color:#c6f2c7;">Z1 TO Z5</td>
                    <td class="text-center" style="background-color:#c6f2c7;">Z1 TO Z20</td>
                    <td class="text-center" style="background-color:#c6f2c7;">Z1 TO Z37</td>
                    <td class="text-center" style="background-color:#c6f2c7;">Z1 TO Z59</td>
                    <td class="text-center" style="background-color:#c6f2c7;">Z1 TO Z86</td>
                    <td style="background-color:#c6f2c7;"></td>
                </tr>
                <tr style="background-color:#c6f2c7;">
                    <td>Revenue</td>
                    <td class="text-right" id="revenue_2"></td>
                    <td class="text-right" id="revenue_6"></td>
                    <td class="text-right" id="revenue_10"></td>
                    <td class="text-right" id="revenue_14"></td>
                    <td class="text-right" id="revenue_18"></td>
                    <td></td>
                </tr>
                <tr style="background-color:#c6f2c7;">
                    <td>Expense</td>
                    <td class="text-right" id="expense_2"></td>
                    <td class="text-right" id="expense_6"></td>
                    <td class="text-right" id="expense_10"></td>
                    <td class="text-right" id="expense_14"></td>
                    <td class="text-right" id="expense_18"></td>
                    <td></td>
                </tr>
                <tr style="background-color:#c6f2c7;">
                    <td>Profit Before Tax</td>
                    <td class="text-right" id="pbt_2"></td>
                    <td class="text-right" id="pbt_6"></td>
                    <td class="text-right" id="pbt_10"></td>
                    <td class="text-right" id="pbt_14"></td>
                    <td class="text-right" id="pbt_18"></td>
                    <td></td>
                </tr>
                <tr style="background-color:#c6f2c7;">
                    <td>Tax</td>
                    <td class="text-right" id="tax_2"></td>
                    <td class="text-right" id="tax_6"></td>
                    <td class="text-right" id="tax_10"></td>
                    <td class="text-right" id="tax_14"></td>
                    <td class="text-right" id="tax_18"></td>
                    <td></td>
                </tr>
                <tr style="background-color:#c6f2c7;">
                    <td>Profit After Tax</td>
                    <td class="text-right" id="pat_2"></td>
                    <td class="text-right" id="pat_6"></td>
                    <td class="text-right" id="pat_10"></td>
                    <td class="text-right" id="pat_14"></td>
                    <td class="text-right" id="pat_18"></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td rowspan=6>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        Oct - Dec
                    </td>
                    <td style="background-color:#f1e0c5;"></td>
                    <td class="text-center" style="background-color:#f1e0c5;">Z1 TO Z8</td>
                    <td class="text-center" style="background-color:#f1e0c5;">Z1 TO Z24</td>
                    <td class="text-center" style="background-color:#f1e0c5;">Z1 TO Z42</td>
                    <td class="text-center" style="background-color:#f1e0c5;">Z1 TO Z65</td>
                    <td class="text-center" style="background-color:#f1e0c5;">Z1 TO Z93</td>
                    <td style="background-color:#f1e0c5;"></td>
                </tr>
                <tr style="background-color:#f1e0c5;">
                    <td>Revenue</td>
                    <td class="text-right" id="revenue_3"></td>
                    <td class="text-right" id="revenue_7"></td>
                    <td class="text-right" id="revenue_11"></td>
                    <td class="text-right" id="revenue_15"></td>
                    <td class="text-right" id="revenue_19"></td>
                    <td></td>
                </tr>
                <tr style="background-color:#f1e0c5;">
                    <td>Expense</td>
                    <td class="text-right" id="expense_3"></td>
                    <td class="text-right" id="expense_7"></td>
                    <td class="text-right" id="expense_11"></td>
                    <td class="text-right" id="expense_15"></td>
                    <td class="text-right" id="expense_19"></td>
                    <td></td>
                </tr>
                <tr style="background-color:#f1e0c5;">
                    <td>Profit Before Tax</td>
                    <td class="text-right" id="pbt_3"></td>
                    <td class="text-right" id="pbt_7"></td>
                    <td class="text-right" id="pbt_11"></td>
                    <td class="text-right" id="pbt_15"></td>
                    <td class="text-right" id="pbt_19"></td>
                    <td></td>
                </tr>
                <tr style="background-color:#f1e0c5;">
                    <td>Tax</td>
                    <td class="text-right" id="tax_3"></td>
                    <td class="text-right" id="tax_7"></td>
                    <td class="text-right" id="tax_11"></td>
                    <td class="text-right" id="tax_15"></td>
                    <td class="text-right" id="tax_19"></td>
                    <td></td>
                </tr>
                <tr style="background-color:#f1e0c5;">
                    <td>Profit After Tax</td>
                    <td class="text-right" id="pat_3"></td>
                    <td class="text-right" id="pat_7"></td>
                    <td class="text-right" id="pat_11"></td>
                    <td class="text-right" id="pat_15"></td>
                    <td class="text-right" id="pat_19"></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <div>
            <table class="table table-responsive" border=1>
                <thead>
                    <th>Particulars</th>
                    <th class="text-center">2019-2020</th>
                    <th class="text-center">2020-2021</th>
                    <th class="text-center">2021-2022</th>
                    <th class="text-center">2022-2023</th>
                    <th class="text-center">2023-2024</th>
                    <th class="text-center">Total</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Revenue</td>
                        <td class="text-right" id="one_year_revenue_1"></td>
                        <td class="text-right" id="one_year_revenue_2"></td>
                        <td class="text-right" id="one_year_revenue_3"></td>
                        <td class="text-right" id="one_year_revenue_4"></td>
                        <td class="text-right" id="one_year_revenue_5"></td>
                        <td class="text-right" id="total_revenue"></td>
                    </tr>
                    <tr>
                        <td>Expense</td>
                        <td class="text-right" id="one_year_expense_1"></td>
                        <td class="text-right" id="one_year_expense_2"></td>
                        <td class="text-right" id="one_year_expense_3"></td>
                        <td class="text-right" id="one_year_expense_4"></td>
                        <td class="text-right" id="one_year_expense_5"></td>
                        <td class="text-right" id="total_expense"></td>
                    </tr>
                    <tr>
                        <td>Profit Before Tax</td>
                        <td class="text-right" id="one_year_pbt_1"></td>
                        <td class="text-right" id="one_year_pbt_2"></td>
                        <td class="text-right" id="one_year_pbt_3"></td>
                        <td class="text-right" id="one_year_pbt_4"></td>
                        <td class="text-right" id="one_year_pbt_5"></td>
                        <td class="text-right" id="total_pbt"></td>
                    </tr>
                    <tr>
                        <td>Tax</td>
                        <td class="text-right" id="one_year_tax_1"></td>
                        <td class="text-right" id="one_year_tax_2"></td>
                        <td class="text-right" id="one_year_tax_3"></td>
                        <td class="text-right" id="one_year_tax_4"></td>
                        <td class="text-right" id="one_year_tax_5"></td>
                        <td class="text-right" id="total_tax"></td>
                    </tr>
                    <tr>
                        <td>Profit After Tax</td>
                        <td class="text-right" id="one_year_pat_1"></td>
                        <td class="text-right" id="one_year_pat_2"></td>
                        <td class="text-right" id="one_year_pat_3"></td>
                        <td class="text-right" id="one_year_pat_4"></td>
                        <td class="text-right" id="one_year_pat_5"></td>
                        <td class="text-right" id="total_pat"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>    
    <script>
        function calculateProjection(){
            var revenue = parseInt(document.getElementById("revenue_input").value);
            var expense = parseInt(document.getElementById("expense_input").value);
            var profit_before_tax = revenue - expense;
            var tax = profit_before_tax / 100 * 35;
            var profit_after_tax = profit_before_tax - tax;
            document.getElementById('revenue_calculation').innerHTML = parseInt(revenue).toLocaleString();
            document.getElementById('expense_calculation').innerHTML = parseInt(expense).toLocaleString();
            document.getElementById('profit_before_tax').innerHTML = parseInt(profit_before_tax).toLocaleString();
            document.getElementById('tax').innerHTML = parseInt(tax).toLocaleString();
            document.getElementById('profit_after_tax').innerHTML = parseInt(profit_after_tax).toLocaleString();
            
            // filling up the table
            var revenue_cal = new Array();
            var expense_cal = new Array();
            var pbt_cal = new Array();
            var tax_cal = new Array();
            var pat_cal = new Array();
            
            var one_year_revenue = new Array();
            var one_year_expense = new Array();
            var one_year_pbt = new Array();
            var one_year_tax = new Array();
            var one_year_pat = new Array();
            
            var total_expense = 0;
            var total_revenue = 0;
            var total_pbt = 0;
            var total_tax = 0;
            var total_pat = 0;

            // revenues
            revenue_cal[0] = revenue * 9;
            revenue_cal[1] = revenue * 15;
            revenue_cal[2] = revenue * 24;
            revenue_cal[3] = revenue * 36;
            revenue_cal[4] = revenue * 48;
            revenue_cal[5] = revenue * 60;
            revenue_cal[6] = revenue * 72;
            revenue_cal[7] = revenue * 84;
            revenue_cal[8] = revenue * 96;
            revenue_cal[9] = revenue * 111;
            revenue_cal[10] = revenue * 126;
            revenue_cal[11] = revenue * 141;
            revenue_cal[12] = revenue * 159;
            revenue_cal[13] = revenue * 177;
            revenue_cal[14] = revenue * 195;
            revenue_cal[15] = revenue * 216;
            revenue_cal[16] = revenue * 237;
            revenue_cal[17] = revenue * 258;
            revenue_cal[18] = revenue * 279;
            revenue_cal[19] = revenue * 300;

            // expense
            expense_cal[0] = expense * 9;
            expense_cal[1] = expense * 15;
            expense_cal[2] = expense * 24;
            expense_cal[3] = expense * 36;
            expense_cal[4] = expense * 48;
            expense_cal[5] = expense * 60;
            expense_cal[6] = expense * 72;
            expense_cal[7] = expense * 84;
            expense_cal[8] = expense * 96;
            expense_cal[9] = expense * 111;
            expense_cal[10] = expense * 126;
            expense_cal[11] = expense * 141;
            expense_cal[12] = expense * 159;
            expense_cal[13] = expense * 177;
            expense_cal[14] = expense * 195;
            expense_cal[15] = expense * 216;
            expense_cal[16] = expense * 237;
            expense_cal[17] = expense * 258;
            expense_cal[18] = expense * 279;
            expense_cal[19] = expense * 300;

            // profit_before_tax
            pbt_cal[0] = profit_before_tax * 9;
            pbt_cal[1] = profit_before_tax * 15;
            pbt_cal[2] = profit_before_tax * 24;
            pbt_cal[3] = profit_before_tax * 36;
            pbt_cal[4] = profit_before_tax * 48;
            pbt_cal[5] = profit_before_tax * 60;
            pbt_cal[6] = profit_before_tax * 72;
            pbt_cal[7] = profit_before_tax * 84;
            pbt_cal[8] = profit_before_tax * 96;
            pbt_cal[9] = profit_before_tax * 111;
            pbt_cal[10] = profit_before_tax * 126;
            pbt_cal[11] = profit_before_tax * 141;
            pbt_cal[12] = profit_before_tax * 159;
            pbt_cal[13] = profit_before_tax * 177;
            pbt_cal[14] = profit_before_tax * 195;
            pbt_cal[15] = profit_before_tax * 216;
            pbt_cal[16] = profit_before_tax * 237;
            pbt_cal[17] = profit_before_tax * 258;
            pbt_cal[18] = profit_before_tax * 279;
            pbt_cal[19] = profit_before_tax * 300;

            // tax
            tax_cal[0] = tax * 9;
            tax_cal[1] = tax * 15;
            tax_cal[2] = tax * 24;
            tax_cal[3] = tax * 36;
            tax_cal[4] = tax * 48;
            tax_cal[5] = tax * 60;
            tax_cal[6] = tax * 72;
            tax_cal[7] = tax * 84;
            tax_cal[8] = tax * 96;
            tax_cal[9] = tax * 111;
            tax_cal[10] = tax * 126;
            tax_cal[11] = tax * 141;
            tax_cal[12] = tax * 159;
            tax_cal[13] = tax * 177;
            tax_cal[14] = tax * 195;
            tax_cal[15] = tax * 216;
            tax_cal[16] = tax * 237;
            tax_cal[17] = tax * 258;
            tax_cal[18] = tax * 279;
            tax_cal[19] = tax * 300;

            // profit after tax
            pat_cal[0] = profit_after_tax * 9;
            pat_cal[1] = profit_after_tax * 15;
            pat_cal[2] = profit_after_tax * 24;
            pat_cal[3] = profit_after_tax * 36;
            pat_cal[4] = profit_after_tax * 48;
            pat_cal[5] = profit_after_tax * 60;
            pat_cal[6] = profit_after_tax * 72;
            pat_cal[7] = profit_after_tax * 84;
            pat_cal[8] = profit_after_tax * 96;
            pat_cal[9] = profit_after_tax * 111;
            pat_cal[10] = profit_after_tax * 126;
            pat_cal[11] = profit_after_tax * 141;
            pat_cal[12] = profit_after_tax * 159;
            pat_cal[13] = profit_after_tax * 177;
            pat_cal[14] = profit_after_tax * 195;
            pat_cal[15] = profit_after_tax * 216;
            pat_cal[16] = profit_after_tax * 237;
            pat_cal[17] = profit_after_tax * 258;
            pat_cal[18] = profit_after_tax * 279;
            pat_cal[19] = profit_after_tax * 300;
            
            for(var i = 0; i < 20; i++){
                var disp = i + 1;
                document.getElementById('revenue_'+disp).innerHTML = parseInt(revenue_cal[i]).toLocaleString();
                document.getElementById('expense_'+disp).innerHTML = parseInt(expense_cal[i]).toLocaleString();
                document.getElementById('pbt_'+disp).innerHTML = parseInt(pbt_cal[i]).toLocaleString();
                document.getElementById('tax_'+disp).innerHTML = parseInt(tax_cal[i]).toLocaleString();
                document.getElementById('pat_'+disp).innerHTML = parseInt(pat_cal[i]).toLocaleString();
            }
            // for(var i = 0; i < 5; i++){
                for(var j = 0; j < 20; j += 4){
                    var s = 0;
                    s = s + j / 4;
                    one_year_revenue[s] = revenue_cal[j] + revenue_cal[j+1] + revenue_cal[j+2] + revenue_cal[j + 3];
                    one_year_expense[s] = expense_cal[j] + expense_cal[j+1] + expense_cal[j+2] + expense_cal[j + 3];
                    one_year_pbt[s] = pbt_cal[j] + pbt_cal[j+1] + pbt_cal[j+2] + pbt_cal[j + 3];
                    one_year_tax[s] = tax_cal[j] + tax_cal[j+1] + tax_cal[j+2] + tax_cal[j + 3];
                    one_year_pat[s] = pat_cal[j] + pat_cal[j+1] + pat_cal[j+2] + pat_cal[j + 3];
                }
            // }
            for(var k = 0; k < 5; k++){
                var next = k+1;
                document.getElementById('one_year_revenue_'+next).innerHTML = parseInt(one_year_revenue[k]).toLocaleString();
                document.getElementById('one_year_expense_'+next).innerHTML = parseInt(one_year_expense[k]).toLocaleString();
                document.getElementById('one_year_pbt_'+next).innerHTML = parseInt(one_year_pbt[k]).toLocaleString();
                document.getElementById('one_year_tax_'+next).innerHTML = parseInt(one_year_tax[k]).toLocaleString();
                document.getElementById('one_year_pat_'+next).innerHTML = parseInt(one_year_pat[k]).toLocaleString();
            }
            for(i = 0; i < 5; i++){
                total_revenue += one_year_revenue[i];
                total_expense += one_year_expense[i];
                total_pbt += one_year_pbt[i];
                total_tax += one_year_tax[i];
                total_pat += one_year_pat[i];
            }
            document.getElementById('total_revenue').innerHTML = parseInt(total_revenue).toLocaleString();
            document.getElementById('total_expense').innerHTML = parseInt(total_expense).toLocaleString();
            document.getElementById('total_pbt').innerHTML = parseInt(total_pbt).toLocaleString();
            document.getElementById('total_tax').innerHTML = parseInt(total_tax).toLocaleString();
            document.getElementById('total_pat').innerHTML = parseInt(total_pat).toLocaleString();
        }
    </script>
@endsection