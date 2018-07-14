@extends('layouts.app')
@section('content')
    <div class="col-md-4 col-md-offset-2">
        <table border=1 class="table table-hover">
            <tr style="background-color: #e4ffe0;">
                <th colspan=2 style=" text-align:center;">Model Zone ({{ $zone->zone_name }})</th>
            </tr>
            <tr>
                <td>Zone Name</td>
                <td>{{ $zone_name }}</td>
            </tr>
            <tr>
                <td>Target</td>
                <td>{{ number_format($planning->totalTarget) }}</td>
            </tr>
            <tr>
                <td>Transactional Profit</td>
                <td>{{ number_format($planning->totalTP) }}</td>
            </tr>
        </table>
        <br>
        Projection Calculation:<br>
        'A' Grade Zone : Model Zone Target &#215; 40 <br>
        'B' Grade Zone : 30% of Model Zone Target &#215; 60<br>
        'C' Grade Zone : 60% of Model Zone Target &#215; 60<br>
        'D' Grade Zone : 90% of Model Zone Target &#215; 25

    </div>
    <div class="col-md-4">
        <table border=1 class="table table-hover">
            <tr style="background-color: #e4ffe0;">
                <th colspan=4 style=" text-align:center;">Projection From Model Zone</th>
            </tr>
            <tr>
                <th style="text-align:center">Grades Of Zones</th>
                <th style="text-align:center">Number Of Zones</th>
                <th style="text-align:center">Target</th>
                <th style="text-align:center">Transactional Profit</th>
            </tr>
            <tr>
                <td style="text-align:center">'A' Grade Zones</td>
                <td style="text-align:center">40</td>
                <td style="text-align:center">{{ number_format($planning->totalTarget * 40) }}</td>
                <td style="text-align:center">{{ number_format($planning->totalTP * 40) }}</td>
            </tr>
            <tr>
                <td style="text-align:center">'B' Grade Zones</td>
                <td style="text-align:center">60</td>
                <td style="text-align:center">{{ number_format(($planning->totalTarget / 100*70 * 60)) }}</td>
                <td style="text-align:center">{{ number_format(($planning->totalTP / 100*70 * 60)) }}</td>
            </tr>
            <tr>
                <td style="text-align:center">'C' Grade Zones</td>
                <td style="text-align:center">60</td>
                <td style="text-align:center">{{ number_format(($planning->totalTarget / 100*40 * 60)) }}</td>
                <td style="text-align:center">{{ number_format(($planning->totalTP / 100*40 * 60)) }}</td>
            </tr>
            <tr>
                <td style="text-align:center">'D' Grade Zones</td>
                <td style="text-align:center">25</td>
                <td style="text-align:center">{{ number_format(($planning->totalTarget / 100*10 * 25)) }}</td>
                <td style="text-align:center">{{ number_format(($planning->totalTP / 100*10 * 25)) }}</td>
            </tr>
            <tr>
                <th style="text-align:center"></th>
                <th style="text-align:center">Total</th>
                <th style="text-align:center">{{ number_format(($planning->totalTarget * 40) + (($planning->totalTarget / 100*70 * 60)) + (($planning->totalTarget / 100*40 * 60)) + (($planning->totalTarget / 100*10 * 25))) }}</th>
                <th style="text-align:center">{{ number_format(($planning->totalTP * 40) + (($planning->totalTP / 100*70 * 60)) + (($planning->totalTP / 100*40 * 60)) + (($planning->totalTP / 100*10 * 25))) }}</th>
            </tr>
        </table>
    </div>
@endsection