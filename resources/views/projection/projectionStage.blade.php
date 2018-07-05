@extends('layouts.app')
@section('content')
    <?php $totalRequirement = 0; $totalPrice = 0; ?>
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-success">
            <div class="panel-heading">
                {{ ucwords($_GET['category']) }}
                <div class="pull-right">
                {{ $date }}
                </div>
            </div>
            <div class="panel-body">
                <form action="">
                    <input type="hidden" name="category" value="{{ $_GET['category'] }}">
                    <div class="col-md-4">
                        <select onchange="this.form.submit();" name="ward" id="" class="form-control">
                            <option value="">--Select Ward--</option>
                            <!-- <option value="all">All</option> -->
                            @foreach($wards as $ward)
                                <option {{ isset($_GET['ward']) ? ($ward->id == $_GET['ward'] ? 'selected' : '') : '' }} value="{{ $ward->id }}">{{ $ward->ward_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                @if(isset($_GET['ward']))
                <br><br><br>
                <label for="">Business Cycle : {{ $category->business_cycle }}</label><br>
                <label for="">Price : {{ $category->price }}</label><br>
                <label for="">Target : {{ $category->target }}%</label><br>
                <label for="">Transactional Profit Target : {{ $category->transactional_profit }}%</label><br>
                <table class="table table-hover" border=1>
                <tr>
                    <th>Stage</th>
                    <th>Total {{ $conversion->unit }}</th>
                    <th>Amount</th>
                </tr>
                @foreach($projections as $projection)
                    <tr>
                        <td>{{ $projection->stage }}</td>
                        <td>
                            @if($projection->stage == "Electrical & Plubming")
                                <?php $stage = "electrical"; ?>
                            @else
                                <?php $stage = $projection->stage; ?>
                            @endif
                            {{ number_format(($projection->size * $conversion->minimum_requirement/$conversion->conversion)/100*($utilizations[strtolower($stage)])) }}
                            <?php $totalRequirement += ($projection->size * $conversion->minimum_requirement/$conversion->conversion)/100*($utilizations[strtolower($stage)]); ?>
                        </td>
                        <td>
                            {{ number_format(($projection->size * $conversion->minimum_requirement/$conversion->conversion)/100*($utilizations[strtolower($stage)]) * $category->price) }}
                            <?php $totalPrice += ($projection->size * $conversion->minimum_requirement/$conversion->conversion)/100*($utilizations[strtolower($stage)]) * $category->price; ?>
                        </td>
                    </tr>    
                @endforeach
                    <tr>
                        <th>Total</th>
                        <th>{{ number_format($totalRequirement) }}</th>
                        <th>{{ number_format($totalPrice) }}</th>
                    </tr>
                    <tr>
                        <th>Monthly Requirement</th>
                        <th>{{ number_format($monthly = $totalRequirement/$category->business_cycle) }}</th>
                        <th>{{ number_format($monthlyPrice = $totalPrice/$category->business_cycle) }}</th>
                    </tr>
                </table>
                <b>
                    Target:<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $conversion->unit }} : {{ number_format($monthly/100*$category->target) }}<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Amount : {{ number_format($amount = $monthlyPrice/100*$category->target) }}<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Transactional Profit : {{ number_format($amount/100*$category->transactional_profit) }}
                </b>
                @endif
            </div>
        </div>
    </div>
@endsection