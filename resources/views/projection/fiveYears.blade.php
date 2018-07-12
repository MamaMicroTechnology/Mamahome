@extends('layouts.app')
@section('content')
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-success">
        <div class="panel-heading">Five Years Planning For MH_91_Z1</div>
        <div class="panel-body">
            <?php $time = strtotime($projection); ?>
            <?php
                $transactionalProfit = $percent = isset($_GET['percent']) ? $_GET['percent'] : '';
                $total = 0;
                $totalTransaction = 0;
            ?>
            <form action="">
            <div class="form-group">
                <label style="text-align:left;" for="from" class="control-label col-sm-5">Input Yearly Incremental Target Percentage :</label>
                <div class="col-md-4">
                    <input value="{{ isset($_GET['percent']) ? $_GET['percent'] : '' }}" required type="text" name="percent" id="percent" placeholder="Yearly Incremental Target Percentage" class="form-control">
                </div>
            </div>
                <div class="col-md-3">
                    <button class="btn btn-primary" type="submit">Check</button>
                </div>
            </form>
            <br><br>
            <table class="table table-hover">
                <tr style='background-color:#236281; color:white;'>
                    <th style="text-align:center">Year</th>
                    <th style="text-align:center">Yearly Target</th>
                    <th style="text-align:center">Yearly Transactional Profit</th>
                </tr>
                <tr>
                    <th style="text-align:center;">{{ date('d-M-Y',strtotime($projection)) }}</th>
                    <th style='text-align:center'>{{ number_format($totalTarget) }}</th>
                    <th style='text-align:center'>{{ number_format($totalTP) }}</th>
                </tr>
                @if(isset($_GET['percent']))
                @for($i = 1; $i < 5; $i++)
                <tr>
                    <th style="text-align:center">{{ date('d-M-Y',strtotime('+'.$i.' years',$time)) }}</th>
                    <th style='text-align:center'>{{ number_format($totalTarget = $totalTarget + $totalTarget * ($percent/100)) }}</th>
                    <th style='text-align:center'>{{ number_format($totalTP = $totalTP + $totalTP * ($transactionalProfit/100)) }}</th>
                </tr>
                <?php
                    $total += $totalTarget;
                    $totalTransaction += $totalTP;
                ?>
                @endfor
                <tr>
                    <th style="text-align:center">Total</th>
                    <th style='text-align:center'>{{ number_format($total) }}</th>
                    <th style='text-align:center'>{{ number_format($totalTransaction) }}</th>
                </tr>
                @endif
            </table>
        </div>
        <form action="{{ URL::to('/') }}/lockYearly" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="type" value="five_years">
            <input type="hidden" name="incremental_percentage" value="{{ isset($_GET['percent']) ? $_GET['percent'] : '' }}">
            <input type="hidden" name="totalTarget" value="{{ $total }}">
            <input type="hidden" name="totalTP" value="{{ $totalTransaction }}">
            <input type="submit" value="Lock Target" class="btn btn-success">
        </form>
    </div>
</div>
<script>

</script>
@endsection