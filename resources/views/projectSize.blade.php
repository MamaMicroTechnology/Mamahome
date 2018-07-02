
@extends('layouts.app')
@section('content')
<br>
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-success">
    <div class="panel-heading">
       {{-- Total No Of Projects In Zone 1 : {{$totalProjects}}--}}
    </div>
    <div class="panel-body">
        <div class="col-md-6">
            <center>Ward</center>
            <form method="GET" action="{{ URL::to('/') }}/getprojectsize">
                <select required class="form-control" name="ward">
                    <option value="">--Select--</option>
                    <option value="All">All</option>
                @foreach($wards as $ward)
                    <option value="{{ $ward->id}}" {{ $ward->id == $wardId? 'selected':'' }}>{{ $ward->ward_name }}</option>
                @endforeach
                </select><br>
                <button class="btn btn-primary form-control" type="submit">Fetch</button>
            </form>
            <br>
            @if(session('Error'))
                <p class="alert alert-error">{{ session('Error') }}</p>
            @endif
            @if($planningCount != NULL)
            Total Project Sizes {{ $_GET['ward'] != "All" ? 'Under '.$wardname->ward_name : ''}} (based on stages)<br>
            Total No. Of Projects : {{ $planningCount + $diggingCount + $foundationCount + $pillarsCount + $completionCount + $fixturesCount + $paintingCount + $carpentryCount + $flooringCount + $plasteringCount + $enpCount + $roofingCount + $wallsCount + $closedCount }}
            Total Sizes : <b>{{ $planningSize + $diggingSize + $foundationSize + $pillarsSize + $completionSize + $fixturesSize + $paintingSize + $carpentrySize + $flooringSize + $plasteringSize + $enpSize + $roofingSize + $wallsSize + $closedSize }}</b>
            <table class="table table-hover" border="1">
                <thead>
                    <th class="text-center">Stages</th>
                    <th class="text-center">No. of Projects</th>
                    <th class="text-center">Size<br>(in Sq. Ft.)</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Planning</td>
                        <td class="text-center"> {{ $planningCount }} </td>
                        <td> {{ number_format(round($planningSize)) }}</td>
                    </tr>
                    <tr>
                        <td>Digging</td>
                        <td class="text-center">{{ $diggingCount }}</td>
                        <td>{{ number_format(round($diggingSize)) }}</td>
                    </tr>
                    <tr>
                        <td>Foundation</td>
                        <td class="text-center">{{ $foundationCount }}</td>
                        <td>{{ number_format(round($foundationSize)) }}</td>
                    </tr>
                    <tr>
                        <td>Pillars</td>
                        <td class="text-center">{{ $pillarsCount }}</td>
                        <td>{{ number_format(round($pillarsSize)) }}</td>
                    </tr>
                    <tr>
                        <td>Walls</td>
                        <td class="text-center">{{ $wallsCount }}</td>
                        <td>{{ number_format(round($wallsSize)) }}</td>
                    </tr>
                    <tr>
                        <td>Roofing</td>
                        <td class="text-center">{{ $roofingCount }}</td>
                        <td>{{ number_format(round($roofingSize)) }}</td>
                    </tr>
                    
                    <tr>
                        <td>Electrical &amp; Plumbing</td>
                        <td class="text-center">{{ $enpCount }}</td>
                        <td>{{ number_format(round($enpSize)) }}</td>
                    </tr>
                    <tr>
                        <td>Plastering</td>
                        <td class="text-center">{{ $plasteringCount }}</td>
                        <td>{{ number_format(round($plasteringSize)) }}</td>
                    </tr>
                    <tr>
                        <td>Flooring</td>
                        <td class="text-center">{{ $flooringCount }}</td>
                        <td>{{ number_format(round($flooringSize)) }}</td>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td class="text-center">{{ $carpentryCount }}</td>
                        <td>{{ number_format(round($carpentrySize)) }}</td>
                    </tr>
                    <tr>
                        <td>Paintings</td>
                        <td class="text-center">{{ $paintingCount }}</td>
                        <td>{{ number_format(round($paintingSize)) }}</td>
                    </tr>
                    <tr>
                        <td>Fixtures</td>
                        <td class="text-center">{{ $fixturesCount }}</td>
                        <td>{{ number_format(round($fixturesSize)) }}</td>
                    </tr>
                    <tr>
                        <td>Completion</td>
                        <td class="text-center">{{ $completionCount }}</td>
                        <td>{{ number_format(round($completionSize)) }}</td>
                    </tr>
                </tbody>
            </table> 
            @endif
        </div>

        @if($subwards != NULL && $_GET['ward'] != "All")
        <div class="col-md-6">
            <center>Sub Ward</center>
            <form method="GET" action="{{ URL::to('/') }}/getprojectsize">
                <input type="hidden" name="ward" value={{ $wardId }}>
                <select required class="form-control" name="subward">
                    <option value="">--Select--</option>
                    @foreach($subwards as $ward)
                        <option value="{{ $ward->id}}" {{ $subwardId == $ward->id? 'selected':'' }}>{{ $ward->sub_ward_name }}</option>
                    @endforeach
                </select><br>
                <button class="btn btn-primary form-control" type="submit">Fetch</button>
            </form>
            <br>
            @if(session('Error'))
                <p class="alert alert-error">{{ session('Error') }}</p>
            @endif
            @if(isset($_GET['subward']))
            Total Project Sizes Under {{ $subwardName}} (based on stages)<br>
            Total No. of Projects : @if($total) {{ $total }} @endif
            Total Sizes : <b>@if($totalsubward) {{ $totalsubward }} @endif</b>
            <table class="table table-hover" border="1">
                <thead>
                    <th class="text-center">Stages</th>
                    <th class="text-center">No. of Projects</th>
                    <th class="text-center">Size<br>(in Sq. Ft.)</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Planning</td>
                        <td class="text-center">{{ $Cplanning }}</td>
                        <td>
                             
                              {{ $planning }} 
                        </td>
                    </tr>
                    <tr>
                        <td>Digging</td>
                        <td class="text-center">{{ $Cdigging }}</td>
                        <td>
                            
                            {{ $digging }}
                        </td>
                    </tr>
                    <tr>
                        <td>Foundation</td>
                        <td class="text-center">{{ $Cfoundation }}</td>
                        <td>
                            {{ $foundation }}
                        </td>
                    </tr>
                    <tr>
                        <td>Pillars</td>
                        <td class="text-center">{{ $Cpillars }}</td>
                        <td>
                            
                            {{ $pillars }}
                        </td>
                    </tr>
                    <tr>
                        <td>Walls</td>
                        <td class="text-center">{{ $Cwalls }}</td>
                        <td>
                            
                            {{ $walls }}
                        </td>
                    </tr>
                    <tr>
                        <td>Roofing</td>
                        <td class="text-center">{{ $Croofing }}</td>
                        <td>
                            {{ $roofing }}
                        </td>
                    </tr>
                    <tr>
                        <td>Electrical &amp; Plumbing</td>
                        <td class="text-center">{{ $Cenp }}</td>
                        <td>
                            
                            {{ $enp }}
                        </td>
                    </tr>
                    <tr>
                        <td>Plastering</td>
                        <td class="text-center">{{ $Cplastering }}</td>
                        <td>
                            
                            {{ $plastering }}
                        </td>
                    </tr>
                    <tr>
                        <td>Flooring</td>
                        <td class="text-center">{{ $Cflooring }}</td>
                        <td>
                            
                            {{ $flooring }}
                        </td>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td class="text-center">{{ $Ccarpentry }}</td>
                        <td>
                            
                            {{ $carpentry }}
                        </td>
                    </tr>
                    <tr>
                        <td>Paintings</td>
                        <td class="text-center">{{ $Cpainting }}</td>
                        <td>
                            
                            {{ $painting }}
                        </td>
                    </tr>
                    <tr>
                        <td>Fixtures</td>
                        <td class="text-center">{{ $Cfixtures }}</td>
                        <td>
                            
                            {{ $fixtures }}
                        </td>
                    </tr>
                    <tr>
                        <td>Completion</td>
                        <td class="text-center">{{ $Ccompletion }}</td>
                        <td>
                            
                            {{ $completion }}
                        </td>
                    </tr>
                </tbody>
            </table> 
        @endif
        </div>
    @endif
    </div>
</div>
</div>
@endsection
