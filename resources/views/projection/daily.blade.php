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
        <div class="panel-heading">Daily Target For MH_91_Z1
            <p class="pull-right">{{ date('d-m-Y',strtotime($projection)) }} to {{ date('d-m-Y',strtotime($toDate)) }}</p>
        </div>
        <div class="panel-body">
            <?php $time = strtotime($projection);
                $from = date_create($projection);
                $to = date_create($toDate);
                $diff = date_diff($from,$to);
                $cal = $diff->format("%a");
            ?>
            <?php
                $transactionalProfit = $percent = isset($_GET['percent']) ? $_GET['percent'] : '';
            ?>
            <table class="table table-hover">
                <tr style='background-color:#236281; color:white;'>
                    <th style="text-align:center">Date</th>
                    <th style="text-align:center">Daily Target</th>
                    <th style="text-align:center">Daily Transactional Profit</th>
                </tr>
                <tr>
                    <th style="text-align:center;">{{ date('d-M-Y',strtotime($projection)) }}</th>
                    <th style='text-align:center'>{{ number_format($totalTarget) }}</th>
                    <th style='text-align:center'>{{ number_format($totalTP) }}</th>
                </tr>
                @for($i = 1; $i < $cal; $i++)
                <tr>
                    <th style="text-align:center">{{ date('d-M-Y',strtotime('+'.$i.' days',$time)) }}</th>
                    <th style='text-align:center'>{{ number_format($totalTarget / $cal) }}</th>
                    <th style='text-align:center'>{{ number_format($totalTP / $cal) }}</th>
                </tr>
                @endfor
            </table>
        </div>
    </div>
</div>
@endsection