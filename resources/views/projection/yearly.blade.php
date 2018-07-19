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
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-success">
        <div class="panel-heading">Yearly Planning For MH_91_Z1</div>
        <div class="panel-body">
            <?php $time = strtotime($projection); ?>
            <?php
                $transactionalProfit = $percent = isset($_GET['percent']) ? $_GET['percent'] : '';
                $total = 0;
                $totalTransaction = 0;
            ?>
            <form action="">
            <div class="form-group">
            <!-- <label style="text-align:left;" for="from" class="control-label col-sm-2">Category :</label> -->
                <!-- <div class="col-md-2">
                    <select name="category" id="category" class="form-control input-sm">
                        <option value="">--Select Categories--</option>
                        <option value="all">All</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->category }}">{{ ucwords($category->category) }}</option>
                        @endforeach
                    </select>
                </div> -->
                <label style="text-align:left;" for="from" class="control-label col-sm-5">Input Monthly Incremental Target Percentage :</label>
                <div class="col-md-4">
                    <input required value="{{ isset($_GET['percent']) ? $_GET['percent'] : '' }}" required type="text" name="percent" id="percent" placeholder="Monthly Incremental Target Percentage" class="form-control">
                </div>
            </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" type="submit">Check</button>
                </div>
            </form>
            <br><br><br>
            <table class="table table-hover" border=1>
                <tr style='background-color:#236281; color:white;'>
                    <th style="text-align:center">Month</th>
                    <th style="text-align:center">Monthly Target</th>
                    <th style="text-align:center">Monthly Transactional Profit</th>
                </tr>
                <tr>
                    <td  style="text-align:center;">{{ date('d-M-Y',strtotime($projection)) }}</td>
                    <td  style='text-align:center'>{{ number_format($totalTarget) }}</td>
                    <td  style='text-align:center'>{{ number_format($totalTP) }}</td>
                </tr>
                @if(isset($_GET['percent']))
                @for($i = 1; $i < 12; $i++)
                <tr>
                    <td style="text-align:center">{{ date('d-M-Y',strtotime('+'.$i.' months',$time)) }}</td>
                    <td style='text-align:center'>{{ number_format($totalTarget = $totalTarget + $totalTarget * ($percent/100)) }}</td>
                    <td style='text-align:center'>{{ number_format($totalTP = $totalTP + $totalTP * ($transactionalProfit/100)) }}</td>
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
        <form class="{{ isset($_GET['percent']) ? '' : 'hidden' }}" action="{{ URL::to('/') }}/lockYearly" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="type" value="yearly">
            <input type="hidden" name="incremental_percentage" value="{{ isset($_GET['percent']) ? $_GET['percent'] : '' }}">
            <input type="hidden" name="totalTarget" value="{{ $total }}">
            <input type="hidden" name="totalTP" value="{{ $totalTransaction }}">
            <input type="submit" value="Lock Target" class="btn btn-success">
        </form>
        <br>
    </div>
</div>
@endsection