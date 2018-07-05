@extends('layouts.app')
@section('content')
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-success">
            <div class="panel-heading">
                {{ ucwords($_GET['category']) }}
                <div class="pull-right">
                </div>
            </div>
            <div class="panel-body">
                <form action="">
                    <input type="hidden" name="category" value="{{ $_GET['category'] }}">
                    <div class="col-md-4">
                        <select onchange="this.form.submit();" name="ward" id="" class="form-control">
                            <option value="">--Select Ward--</option>
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
                    <th>Total Size</th>
                    <th>Total Requirement</th>
                    <th>Amount</th>
                </tr>
                @foreach($projections as $projection)
                    <tr>
                        <td>{{ $projection->stage }}</td>
                        <td>{{ number_format($projection->size) }}</td>
                        <td>
                            @if($projection->stage == "Electrical & Plubming")
                                <?php $stage = "electrical"; ?>
                            @else
                                <?php $stage = $projection->stage; ?>
                            @endif
                            {{ number_format(($projection->size * $conversion->minimum_requirement/$conversion->conversion)/100*($utilizations[strtolower($stage)])) }}
                        </td>
                        <td>
                            {{ number_format(($projection->size * $conversion->minimum_requirement/$conversion->conversion)/100*($utilizations[strtolower($stage)]) * $category->price) }}
                        </td>
                    </tr>    
                @endforeach
                    <tr>
                        <th>Total</th>
                        <th>{{ number_format($total) }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                </table>
                @endif
            </div>
        </div>
    </div>
@endsection