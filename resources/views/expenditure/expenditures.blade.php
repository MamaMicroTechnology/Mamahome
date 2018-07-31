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
    <form action="{{ URL::to('/') }}/saveExpenditure" method="post">
        {{ csrf_field() }}
        <table class="table table-hover" id="heading">
            <tr>
                <th style="text-align:center; background-color: #d0dcef;" colspan=3>Capital Expenditure</th>
            </tr>
            <tr>
                <td>Rental Deposit</td>
                <td>:</td>
                <td><input title="Please Enter Rental Deposit" value="{{ $capitalExpenditure != null ? $capitalExpenditure->rental : '' }}" required type="text" name="deposit" id="deposit" placeholder="Rental Deposit" class="form-control"></td>
            </tr>
            <tr>
                <td>Assets (Desktop PC,
                <br>Laptop, Phones & Accessories)</td>
                <td>:</td>
                <td><input title="Please Enter Your Assets Value" value="{{ $capitalExpenditure != null ? $capitalExpenditure->assets : '' }}" required type="text" name="assets" id="assets" placeholder="Assets" class="form-control"></td>
            </tr>
            <tr>
                <th style="text-align:center; background-color: #d0dcef;" colspan=3>Operational Expenditure</th>
            </tr>
            <tr>
                <td>Salary</td>
                <td>:</td>
                <td><input title="Enter Total Salary" value="{{ $operationalExpenditure != null ? $operationalExpenditure->salary : '' }}" required type="text" name="salary" id="salary" placeholder="Salary" class="form-control"></td>
            </tr>
            <tr>
                <td>Office Rent</td>
                <td>:</td>
                <td><input title="Enter Your Office Rent" value="{{ $operationalExpenditure != null ? $operationalExpenditure->office_rent : '' }}" required type="text" name="rent" id="rent" placeholder="Office Rent" class="form-control"></td>
            </tr>
            <tr>
                <td>Mama Micro Technology User Fee</td>
                <td>:</td>
                <td><input title="Enter Mama Micro Technology User Fee" value="{{ $operationalExpenditure != null ? $operationalExpenditure->mmt_user_fee : '' }}" required type="text" name="mmt_fees" id="services" placeholder="IT Services" class="form-control"></td>
            </tr>
            <tr>
                <td>Travelling</td>
                <td>:</td>
                <td><input title="Enter The Travelling Expenses" value="{{ $operationalExpenditure != null ? $operationalExpenditure->travelling : '' }}" required type="text" name="travel" id="travel" placeholder="Traveling Expenses" class="form-control"></td>
            </tr>
            <tr>
                <td>Petrol</td>
                <td>:</td>
                <td><input title="Enter The Petrol Costs" value="{{ $operationalExpenditure != null ? $operationalExpenditure->petrol : '' }}" required type="text" name="petrol" id="petrol" placeholder="Petrol" class="form-control"></td>
            </tr>
            <tr>
                <td>Telephone Charges</td>
                <td>:</td>
                <td><input value="{{ $operationalExpenditure != null ? $operationalExpenditure->telephone_charges : '' }}" required type="text" name="phone_charges" id="phone_charges" placeholder="Telephone Charges" title="Enter Telephone Charges" class="form-control"></td>
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
                <td><input value="{{ $operationalExpenditure != null ? $operationalExpenditure->miscellineous : '' }}" required type="text" title="Enter Miscellineous Expenditure" name="miscellineous" id="miscellineous" placeholder="Miscellineous" class="form-control"></td>
            </tr>
            <tr>
                <td colspan=3><input type="submit" value="Save" class="btn btn-success form-control"></td>
            </tr>
        </table>
    </form>
</div>
@endsection