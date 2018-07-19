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
<?php $total = $operationalExpenditure->salary + $operationalExpenditure->office_rent + $operationalExpenditure->petrol + $operationalExpenditure->travelling + $operationalExpenditure->telephone_charges + $operationalExpenditure->miscellineous + $operationalExpenditure->mmt_user_fee; ?>
    
    <table class="table table-hover" border=1>
        <tr>
            <th>Yearly Transactional Profit</th>
            <th>{{ number_format($planning->totalTP) }}</th>
        </tr>
        <tr>
            <th>Yearly Operational Expenditure</th>
            <th>{{ number_format($exp = $total * 12) }}</th>
        </tr>
        <tr>
            <th>Yearly Net Profit</th>
            <th>{{ number_format($planning->totalTP - $exp) }}</th>
        </tr>
    </table>
    <br>
    <form action="" method="get">
        <table class="table">
            <tr>
                <td>Yearly Increment</td>
                <td>:</td>
                <td><input value="{{ isset($_GET['increment']) ? $_GET['increment'] : '' }}" type="text" name="increment" id="increment" title="Yearly Increment" placeholder="Yearly Increment" class="form-control"></td>
                <td><button type="submit" class="btn btn-success">View</button></td>
            </tr>
        </table>
    </form>
    <br>
    @if(isset($_GET['increment']))
        <table class="table table-hover" border=1>
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Expenditure</th>
                    <th>Transactional Profit</th>
                    <th>Net Profit</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ date('Y',strtotime($planning->created_at)) }}</td>
                    <td>{{ number_format($exp = $total * 12) }}</td>
                    <td>{{ number_format($planning->totalTP) }}</td>
                    <td>{{ number_format($planning->totalTP - $exp) }}</td>
                </tr>
                <?php $exp = $total * 12; $tp = $planning->totalTP;?>
                @for($i = 1; $i <= 5; $i++)
                <tr>
                    <td>{{ date('Y',strtotime($i . ' years',strtotime($planning->created_at))) }}</td>
                    <td>{{ number_format($exp += $total * 12/100*$_GET['increment']) }}</td>
                    <td>{{ number_format($tp += $planning->totalTP / 100*$planning->incremental_percentage) }}</td>
                    <td>{{ number_format($tp - $exp) }}</td>
                </tr>
                @endfor
            </tbody>
        </table>
    @endif
    <br>
</div>
@endsection