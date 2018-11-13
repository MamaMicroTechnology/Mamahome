@extends('finance.layouts.headers')
@section('content')

    @php
        $d=cal_days_in_month(CAL_GREGORIAN,11,2018);
        echo($d);
    @endphp

@endsection