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
                <td style="text-align:center">30</td>
                <td style="text-align:center">{{ number_format($planning->totalTarget * 30) }}</td>
                <td style="text-align:center">{{ number_format($planning->totalTP * 30) }}</td>
            </tr>
            <tr>
                <td style="text-align:center">'B' Grade Zones</td>
                <td style="text-align:center">46</td>
                <td style="text-align:center">{{ number_format(($planning->totalTarget * 46)/100*30) }}</td>
                <td style="text-align:center">{{ number_format(($planning->totalTP * 46)/100*30) }}</td>
            </tr>
            <tr>
                <td style="text-align:center">'C' Grade Zones</td>
                <td style="text-align:center">58</td>
                <td style="text-align:center">{{ number_format(($planning->totalTarget * 58)/100*50) }}</td>
                <td style="text-align:center">{{ number_format(($planning->totalTP * 58)/100*50) }}</td>
            </tr>
            <tr>
                <td style="text-align:center">'D' Grade Zones</td>
                <td style="text-align:center">58</td>
                <td style="text-align:center">{{ number_format(($planning->totalTarget * 58)/100*90) }}</td>
                <td style="text-align:center">{{ number_format(($planning->totalTP * 58)/100*90) }}</td>
            </tr>
            <tr>
                <th style="text-align:center"></th>
                <th style="text-align:center">Total</th>
                <th style="text-align:center">{{ number_format(($planning->totalTarget * 30) + (($planning->totalTarget * 46)/100*30) + (($planning->totalTarget * 58)/100*50) + (($planning->totalTarget * 58)/100*90)) }}</th>
                <th style="text-align:center">{{ number_format(($planning->totalTP * 30) + (($planning->totalTP * 46)/100*30) + (($planning->totalTP * 58)/100*50) + (($planning->totalTP * 58)/100*90)) }}</th>
            </tr>
        </table>
    </div>
@endsection