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
<div class="col-md-6 col-md-offset-3">
    <table class="table table-hover" id="heading">
        <tr>
            <th style="text-align:center; background-color: #d0dcef;" colspan=3>Capital Expenditure</th>
        </tr>
        <tr>
            <td>Rental Deposit</td>
            <td>:</td>
            <td style="text-align:right">{{ number_format($capitalExpenditure->rental) }}</td>
        </tr>
        <tr>
            <td>Assets (Desktop PC,
            <br>Laptop, Phones & Accessories)</td>
            <td>:</td>
            <td style="text-align:right">{{ number_format($capitalExpenditure->assets) }}</td>
        </tr>
        <tr>
            <th style="text-align:center; background-color: #d0dcef;" colspan=3>Operational Expenditure</th>
        </tr>
        <tr>
            <td>Salary</td>
            <td>:</td>
            <td style="text-align:right">{{ number_format($operationalExpenditure->salary) }}</td>
        </tr>
        <tr>
            <td>Office Rent</td>
            <td>:</td>
            <td style="text-align:right">{{ number_format($operationalExpenditure->office_rent) }}</td>
        </tr>
        <tr>
            <td>Mama Micro Technology User Fee</td>
            <td>:</td>
            <td style="text-align:right">{{ number_format($operationalExpenditure->mmt_user_fee) }}</td>
        </tr>
        <tr>
            <td>Travelling</td>
            <td>:</td>
            <td style="text-align:right">{{ number_format($operationalExpenditure->travelling) }}</td>
        </tr>
        <tr>
            <td>Petrol</td>
            <td>:</td>
            <td style="text-align:right">{{ number_format($operationalExpenditure->petrol) }}</td>
        </tr>
        <tr>
            <td>Telephone Charges</td>
            <td>:</td>
            <td style="text-align:right">{{ number_format($operationalExpenditure->telephone_charges) }}</td>
        </tr>
        <!-- <tr>
            <td>Bonuses</td>
            <td>:</td>
            <td><input required type="text" name="bonuses" id="bonuses" placeholder="Bonus" class="form-control"></td>
        </tr> -->
        <tr>
            <td>Miscellineous <br>
            (Server Charges, Software Charges,<br> Food & Accomodation,Priting & Stationary,<br>
            Legal & Audit Charges, Courier Charges, etc)</td>
            <td>:</td>
            <td style="text-align:right">{{ number_format($operationalExpenditure->miscellineous) }}</td>
        </tr>
        <tr>
            <th>Total</th>
            <th>:</th>
            <th style="text-align:right">{{ number_format($total = $operationalExpenditure->salary + $operationalExpenditure->office_rent + $operationalExpenditure->petrol + $operationalExpenditure->travelling + $operationalExpenditure->telephone_charges + $operationalExpenditure->miscellineous + $operationalExpenditure->mmt_user_fee) }}</th>
        </tr>
        <tr>
            <td colspan=3>
                <a href="{{ URL::to('/') }}/expenditure?edit=true" class="btn btn-success form-control">Edit</a>
            </td>
        </tr>
    </table>
    <table class="table table-hover">
        <tr>
            <th>Yearly Transactional Profit</th>
            <th>:</th>
            <th>{{ number_format($planning->totalTP) }}</th>
        </tr>
        <tr>
            <th>Yearly Operational Expenditure</th>
            <th>:</th>
            <th>{{ number_format($exp = $total * 12) }}</th>
        </tr>
        <tr>
            <th>Yearly Net Profit</th>
            <th>:</th>
            <th>{{ number_format($planning->totalTP - $exp) }}</th>
        </tr>
        
    </table>
    <br>
    <br>
    <br>
</div>
@endsection