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
                <td>40</td>
            </tr>
            <tr>
                <td>Total Number Of B Grade Zones</td>
                <td>60</td>
            </tr>
            <tr>
                <td>Total Number Of C Grade Zones</td>
                <td>60</td>
            </tr>
            <tr>
                <td>Total Number Of D Grade Zones</td>
                <td>25</td>
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
            </table>
    </div>
    </div>
    @if($planning != null)
    <?php
        $a = 0;
        $b = 0;
        $c = 0;
        $d = 0;
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
                ?>
                <tr>
                    <th>Zone Grade</th>
                    <th>Projected Sales</th>
                    <th>Transactional Profit</th>
                </tr>
                <tr>
                    <td>A</td>
                    <td>{{ number_format($planning->totalTarget + $planning->totalTarget * $a) }}</td>
                    <td>{{ number_format($planning->totalTP + $planning->totalTP * $a) }}</td>
                </tr>
                <tr>
                    <td>B</td>
                    <td>{{ number_format($bt + $bt * $b) }}</td>
                    <td>{{ number_format($btp + $btp * $b) }}</td>
                </tr>
                <tr>
                    <td>C</td>
                    <td>{{ number_format($ct + $ct * $c) }}</td>
                    <td>{{ number_format($ctp + $ctp * $c) }}</td>
                </tr>
                <tr>
                    <td>D</td>
                    <td>{{ number_format($dt + $dt * $d) }}</td>
                    <td>{{ number_format($dtp + $dtp * $d) }}</td>
                </tr>
            </table>
            @endfor
        </div>
    @endif
    </div>
    </div>
</div>
@endsection