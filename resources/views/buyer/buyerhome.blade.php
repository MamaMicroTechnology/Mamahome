@extends('layouts.buyerlayout')
@section('title','Buyer Dashboard')
@section('content')

<div class="col-md-12">
    <div class="col-md-7">
        <div class="panel panel-default">
            <div class="panel-heading text-center" style="background-color:#003000">
                <b style="color:white;font-size:1.3em">Your Orders</b>
            </div>
            <div class="panel-body">
                @if($count <= 0)
                <p style="color:black;font-size:1.4em;text-align:center">You have currently no orders.</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading text-center" style="background-color:#003000">
                <b style="color:white;font-size:1.3em">New Order</b>
            </div>
            <div class="panel-body">
    
            </div>
        </div>
    </div>
</div>

@endsection