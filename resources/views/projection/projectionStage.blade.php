@extends('layouts.app')
@section('content')
    <?php $totalRequirement = 0; $totalPrice = 0; ?>
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-success">
            <div class="panel-heading">
            @if(isset($_GET['category']))
                {{ ucwords($_GET['category']) }}
                <div class="pull-right">
                @if($_GET['category'] != 'all')
                {{ date('d-m-Y',strtotime($category->from_date)) }} to {{ date('d-m-Y',strtotime($category->to_date)) }}
                @else
                @endif
                </div>
            @else
                Choose Categories and Wards
            @endif
            </div>
            <div class="panel-body">
                <form action="">
                    <div class="col-md-4">
                        <select required name="category" id="" class="form-control">
                            <option value="">--Select Category--</option>
                            <option {{ isset($_GET['category']) ? ($_GET['category'] == "all" ? 'selected' : '') : '' }} value="all">All</option>
                            @foreach($categories as $cat)
                                <option {{ isset($_GET['category']) ? ($cat->category == $_GET['category'] ? 'selected' : '') : '' }} value="{{ $cat->category }}">{{ ucwords($cat->category) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select required name="ward" id="" class="form-control">
                            <option value="">--Select Ward--</option>
                            <option {{ isset($_GET['ward']) ? ($_GET['ward'] == "all" ? 'selected' : '') : '' }} value="all">All</option>
                            @foreach($wards as $ward)
                                <option {{ isset($_GET['ward']) ? ($ward->id == $_GET['ward'] ? 'selected' : '') : '' }} value="{{ $ward->id }}">{{ $ward->ward_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="submit" value="Get" class="btn btn-success form-control">
                    </div>
                </form>
                @if(isset($_GET['ward']) && $_GET['category'] != "all")
                <br><br><br>
                <div class="pull-left" id="left">
                    <label for="">Business Cycle : {{ $category->business_cycle }}</label><br>
                    <label for="">Price : {{ $category->price }}</label><br>
                    <label for="">Target : {{ $category->target }}%</label><br>
                    <label for="">Transactional Profit Target : {{ $category->transactional_profit }}%</label><br>
                </div>
                <div class="pull-right" id="right">
                </div>
                <br><br><br><br><br>
                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#myModal">Reset</button>
                <br><br>
                <table class="table table-hover" border=1>
                <tr>
                    <th>Stage</th>
                    <th>Total {{ $conversion->unit }}</th>
                    <th>Amount</th>
                </tr>
                @foreach($projections as $projection)
                    <tr>
                        <td>{{ $projection['stage'] }}</td>
                        <td>
                            @if($projection['stage'] == "Electrical & Plumbing")
                                <?php $stage = "electrical"; ?>
                            @else
                                <?php $stage = $projection['stage']; ?>
                            @endif
                            {{ number_format(($projection['size'] * $conversion->minimum_requirement/$conversion->conversion)/100*($utilizations[strtolower($stage)])) }}
                            <?php $totalRequirement += ($projection['size'] * $conversion->minimum_requirement/$conversion->conversion)/100*($utilizations[strtolower($stage)]); ?>
                        </td>
                        <td>
                            {{ number_format(($projection['size'] * $conversion->minimum_requirement/$conversion->conversion)/100*($utilizations[strtolower($stage)]) * $category->price) }}
                            <?php $totalPrice += ($projection['size'] * $conversion->minimum_requirement/$conversion->conversion)/100*($utilizations[strtolower($stage)]) * $category->price; ?>
                        </td>
                    </tr>    
                @endforeach
                    <tr>
                        <th>Total Requirement</th>
                        <th>{{ number_format($totalRequirement) }}</th>
                        <th>{{ number_format($totalPrice) }}</th>
                    </tr>
                    <tr>
                        <th>Monthly Requirement</th>
                              <th>{{ number_format($monthly = $totalRequirement/$category->business_cycle) }}</th>
                        <th>{{ number_format($monthlyPrice = $totalPrice/$category->business_cycle) }}</th>
                    </tr>
                </table>
                <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirmation</h4>
                        </div>
                        <div class="modal-body">
                        <p>Are you sure you want to reset this planning?</p>
                        </div>
                        <div class="modal-footer">
                        <a href="/reset?category={{ $_GET['category'] }}" class="btn btn-danger pull-left">Yes</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div>
                    </div>
                </div>
                @elseif(isset($_GET['category']) && $_GET['category'] == "all")
                {!! $text !!}
                @endif
            </div>
        </div>
    </div>
    <!-- Modal -->
<div class="modal fade" id="reset" role="dialog">
    <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirmation</h4>
        </div>
        <div class="modal-body">
        <p style="text-align:center">Are you sure you want to reset the entire planning?</p>
        </div>
        <div class="modal-footer">
        <a href="/reset?category=all" class="btn btn-danger pull-left">Yes</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
    </div>
    </div>
</div>
    @if(isset($_GET['ward']) && $_GET['category'] != 'all')
    <script>
        var text = "<label>Monthly Target:</label><br>"+
        "<label>{{ $conversion->unit }} : {{ number_format($monthly/100*$category->target) }}</label><br>"+
        "<label>Amount : {{ number_format($amount = $monthlyPrice/100*$category->target) }}</label><br>"+
        "<label>Transactional Profit : {{ number_format($amount/100*$category->transactional_profit) }}</label></b>";
        document.getElementById("right").innerHTML = text;
    </script>
    @endif
@endsection