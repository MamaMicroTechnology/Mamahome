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
<br>
@if($dates == null)
    <p style="text-align: center;font-size: 20px;">First You Have To Lock The Target With Monthly Sales Projection.</p>
@else
<div class="container">
    <div class="row">
    <div class="col-md-6">
        <div class="col-md-12">
            <table border=1 class="table table-hover">
                <tr style="background-color: #e4ffe0;">
                    <th colspan=2 style=" text-align:center;">Model Zone Projection (MH_91_Z1)
                        <p class="pull-right"> {{ date('M-Y',strtotime($dates->from_date)) }}</p>
                    </th>
                </tr>
                <tr>
                    <td>Zone Name</td>
                    <td>{{ $zone_name }}</td>
                </tr>
                <tr>
                    <td>Projected Sales</td>
                    <td>{{ number_format($planning != null ? $planning->totalTarget : '0') }}</td>
                </tr>
                <tr>
                    <td>Transactional Profit</td>
                    <td>{{ number_format($planning != null ? $planning->totalTP : '0') }}</td>
                </tr>
            </table>
            <table class="table table-hover">
            <tr>
                <td>Total Number Of A Grade Zones</td>
                <td>15</td>
            </tr>
            <tr>
                <td>Total Number Of B Grade Zones</td>
                <td>30</td>
            </tr>
            <tr>
                <td>Total Number Of C Grade Zones</td>
                <td>50</td>
            </tr>
            <tr>
                <td>Total Number Of D Grade Zones</td>
                <td>50</td>
            </tr>
            <tr>
                <td>Total Number Of E Grade Zones</td>
                <td>40</td>
            </tr>
            <tr>
                <th>Total</th>
                <th>185</th>
            </tr>
        </table>
        </div>
    <div class="col-md-12">
        Projection Calculation:<br>
        'A' Grade Zone : Model Zone Projection<br>
        'B' Grade Zone : 70% of Model Zone Projection<br>
        'C' Grade Zone : 40% of Model Zone Projection<br>
        'D' Grade Zone : 10% of Model Zone Projection<br>
        'E' Grade Zone : 10% of Model Zone Projection<br>
        <table border=1 class="table table-hover">
                <tr style="background-color: #e4ffe0;">
                    <th colspan=3 style=" text-align:center;">Projection Based On Model Zone
                    </th>
                </tr>
                <tr>
                    <th>Zone Grade</th>
                    <th>Projected Sales</th>
                    <th>Transactional Profit</th>
                </tr>
                <tr>
                    <td>A</td>
                    <td>{{ number_format($planning != null ? $planning->totalTarget : '0') }}</td>
                    <td>{{ number_format($planning != null ? $planning->totalTP : '0') }}</td>
                </tr>
                <tr>
                    <td>B</td>
                    <td>{{ number_format($planning != null ? $bt = $planning->totalTarget / 100 * 70 : '0') }}</td>
                    <td>{{ number_format($planning != null ? $btp = $planning->totalTP / 100 * 70 : '0') }}</td>
                </tr>
                <tr>
                    <td>C</td>
                    <td>{{ number_format($planning != null ? $ct = $planning->totalTarget / 100 * 40 : '0') }}</td>
                    <td>{{ number_format($planning != null ? $ctp = $planning->totalTP / 100 * 40 : '0') }}</td>
                </tr>
                <tr>
                    <td>D</td>
                    <td>{{ number_format($planning != null ? $dt =$planning->totalTarget / 100 * 10 : '0') }}</td>
                    <td>{{ number_format($planning != null ? $dtp =$planning->totalTP / 100 * 10 : '0') }}</td>
                </tr>
                <tr>
                    <td>E</td>
                    <td>{{ number_format($planning != null ? $et =$planning->totalTarget / 100 * 10 : '0') }}</td>
                    <td>{{ number_format($planning != null ? $etp =$planning->totalTP / 100 * 10 : '0') }}</td>
                </tr>
            </table>
    </div>
        <div class="col-md-12">
            <table class="table table-hover" border=1>
                <tr>
                    <th colspan=6 style="text-align:center; background-color:#c9d5e8">Projection Planner
                        <a href="{{ URL::to('/') }}/editProjectionPlanner?number={{ count($numberOfZones) }}&edit=true" class="btn btn-xs btn-success pull-right">Edit</a>
                    </th>
                </tr>
                <tr>
                    <th style="text-align:center">Month</th>
                    <th style="text-align:center">Grade A</th>
                    <th style="text-align:center">Grade B</th>
                    <th style="text-align:center">Grade C</th>
                    <th style="text-align:center">Grade D</th>
                    <th style="text-align:center">Grade E</th>
                </tr>
                @for($i = 0;$i < count($numberOfZones); $i++)
                    <tr>
                        <td style="text-align:center">{{ $numberOfZones[$i]['month'] }}</td>
                        <td style="text-align:center">{{ $numberOfZones[$i]['grade_a'] }}</td>
                        <td style="text-align:center">{{ $numberOfZones[$i]['grade_b'] }}</td>
                        <td style="text-align:center">{{ $numberOfZones[$i]['grade_c'] }}</td>
                        <td style="text-align:center">{{ $numberOfZones[$i]['grade_d'] }}</td>
                        <td style="text-align:center">{{ $numberOfZones[$i]['grade_e'] }}</td>
                    </tr>
                @endfor
            </table>    
        </div>
    </div>
    <?php 
        $planningTargetA = 0;
        $planningTPA = 0;
        $planningTargetB = 0;
        $planningTPB = 0;
        $planningTargetC = 0;
        $planningTPC = 0;
        $planningTargetD = 0;
        $planningTPD = 0;
        $planningTargetE = 0;
        $planningTPE = 0;
    ?>
    @if($planning != null)
    <?php
        $a = 0;
        $b = 0;
        $c = 0;
        $d = 0;
        $e = 0;
    ?>
    <div class="col-md-6">
            @for($i = 0; $i < count($numberOfZones); $i++)
            <table border=1 class="table table-hover">
                <tr style="background-color: #eddae2;">
                    <th colspan=4 style=" text-align:center;">Projection Calculation Based On Expansion Plan For {{ $date = date('M-Y', strtotime('+' . $i . ' months',strtotime($dates->from_date))) }}</th>
                </tr>
                <?php
                    $a += $numberOfZones[$i]['grade_a'];
                    $b += $numberOfZones[$i]['grade_b'];
                    $c += $numberOfZones[$i]['grade_c'];
                    $d += $numberOfZones[$i]['grade_d'];
                    $e += $numberOfZones[$i]['grade_e'];
                ?>
                <tr>
                    <th>Zone Grade</th>
                    <th>Projected Sales</th>
                    <th>Transactional Profit</th>
                </tr>
                <tr>
                    <td>A</td>
                    <td>{{ number_format($planningTargetA += $planning->totalTarget * $a) }}</td>
                    <td>{{ number_format($planningTPA += $planning->totalTP * $a) }}</td>
                </tr>
                <tr>
                    <td>B</td>
                    <td>{{ number_format($planningTargetB += $bt * $b) }}</td>
                    <td>{{ number_format($planningTPB += $btp * $b) }}</td>
                </tr>
                <tr>
                    <td>C</td>
                    <td>{{ number_format($planningTargetC += $ct * $c) }}</td>
                    <td>{{ number_format($planningTPC += $ctp * $c) }}</td>
                </tr>
                <tr>
                    <td>D</td>
                    <td>{{ number_format($planningTargetD += $dt * $d) }}</td>
                    <td>{{ number_format($planningTPD += $dtp * $d) }}</td>
                </tr>
                <tr>
                    <td>E</td>
                    <td>{{ number_format($planningTargetE += $et * $e) }}</td>
                    <td>{{ number_format($planningTPE += $etp * $e) }}</td>
                </tr>
            </table>
            @endfor
        </div>
    @endif
    </div>
    </div>
@endif
@endsection