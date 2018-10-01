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
            <!-- <p class="pull-right">{{ date('d-m-Y',strtotime($projection)) }} to {{ date('d-m-Y',strtotime($toDate)) }}</p> -->
        </div>
        <div class="panel-body">
            <?php
                $dates = explode(",",$projection);
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
                @for($i = 0; $i < count($dates); $i++)
                <tr>
                    <th style="text-align:center">{{ date('d-M-Y',strtotime($dates[$i])) }}</th>
                    <th style='text-align:center'>{{ number_format($totalTarget / count($dates)) }}</th>
                    <th style='text-align:center'>{{ number_format($totalTP / count($dates)) }}</th>
                </tr>
                @endfor
                <tr>
                    <th style="text-align:center;">Total</th>
                    <th style='text-align:center'>{{ number_format($totalTarget) }}</th>
                    <th style='text-align:center'>{{ number_format($totalTP) }}</th>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection