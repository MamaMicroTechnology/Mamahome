
@extends('layouts.app')
@section('content')
<br>
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-success">
    <div class="panel-heading">
        Total No of Projects In Zone 1 : {{$totalProjects}}
    </div>
    <div class="panel-body">
        <div class="col-md-6">
            <center>Ward</center>
            <form method="GET" action="{{ URL::to('/') }}/getprojectsize">
                <select required class="form-control" name="ward">
                    <option value="">--Select--</option>
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
            Total Project sizes under {{ $wardname->ward_name}} (based on stages)<br>
            Total No. of Projects : {{ $planningCount + $diggingCount + $foundationCount + $pillarsCount + $completionCount + $fixturesCount + $paintingCount + $carpentryCount + $flooringCount + $plasteringCount + $enpCount + $roofingCount + $wallsCount}}
            Total Sizes : <b>{{ $planningSize + $diggingSize + $foundationSize + $pillarsSize + $completionSize + $fixturesSize + $paintingSize + $carpentrySize + $flooringSize + $plasteringSize + $enpSize + $roofingSize + $wallsSize}}</b>
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
                        <td> {{ $planningSize }}</td>
                    </tr>
                    <tr>
                        <td>Digging</td>
                        <td class="text-center">{{ $diggingCount }}</td>
                        <td>{{ $diggingSize }}</td>
                    </tr>
                    <tr>
                        <td>Foundation</td>
                        <td class="text-center">{{ $foundationCount }}</td>
                        <td>{{ $foundationSize }}</td>
                    </tr>
                    <tr>
                        <td>Pillars</td>
                        <td class="text-center">{{ $pillarsCount }}</td>
                        <td>{{ $pillarsSize }}</td>
                    </tr>
                    <tr>
                        <td>Walls</td>
                        <td class="text-center">{{ $wallsCount }}</td>
                        <td>{{ $wallsSize }}</td>
                    </tr>
                    <tr>
                        <td>Roofing</td>
                        <td class="text-center">{{ $roofingCount }}</td>
                        <td>{{ $roofingSize }}</td>
                    </tr>
                    <tr>
                        <td>Electrical &amp; Plumbing</td>
                        <td class="text-center">{{ $enpCount }}</td>
                        <td>{{ $enpSize }}</td>
                    </tr>
                    <tr>
                        <td>Plastering</td>
                        <td class="text-center">{{ $plasteringCount }}</td>
                        <td>{{ $plasteringSize }}</td>
                    </tr>
                    <tr>
                        <td>Flooring</td>
                        <td class="text-center">{{ $flooringCount }}</td>
                        <td>{{ $flooringSize }}</td>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td class="text-center">{{ $carpentryCount }}</td>
                        <td>{{ $carpentrySize }}</td>
                    </tr>
                    <tr>
                        <td>Paintings</td>
                        <td class="text-center">{{ $paintingCount }}</td>
                        <td>{{ $paintingSize }}</td>
                    </tr>
                    <tr>
                        <td>Fixtures</td>
                        <td class="text-center">{{ $fixturesCount }}</td>
                        <td>{{ $fixturesSize }}</td>
                    </tr>
                    <tr>
                        <td>Completion</td>
                        <td class="text-center">{{ $completionCount }}</td>
                        <td>{{ $completionSize }}</td>
                    </tr>
                </tbody>
            </table> 
            @endif
        </div>

        @if($subwards != NULL)
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
            @if($planning != NULL)
            
            <!--Counting project size-->
            <?php $planC = 0; ?>
            @foreach($planning as $plan)
                <?php $planC += $plan->project_size; ?>
            @endforeach
            
            <?php $digC = 0; ?>
            @foreach($digging as $dig)
                <?php $digC += $dig->project_size; ?>
            @endforeach
            
            <?php $foundC = 0; ?>
            @foreach($foundation as $found)
                <?php $foundC += $found->project_size; ?>
            @endforeach
            
            <?php $pillarC = 0; ?>
            @foreach($pillars as $pillar)
                <?php $pillarC += $pillar->project_size; ?>
            @endforeach
            
            <?php $wallsC = 0; ?>
            @foreach($walls as $wall)
                <?php $wallsC += $wall->project_size; ?>
            @endforeach
            
            <?php $roofC = 0; ?>
            @foreach($roofing as $roof)
                <?php $roofC += $roof->project_size; ?>
            @endforeach
            
            <?php $enpC = 0; ?>
            @foreach($enp as $el)
                <?php $enpC += $el->project_size; ?>
            @endforeach
            
            <?php $plasterC = 0; ?>
            @foreach($plastering as $plaster)
                <?php $plasterC += $plaster->project_size; ?>
            @endforeach
            
            <?php $floorC = 0; ?>
            @foreach($flooring as $floor)
                <?php $floorC += $floor->project_size; ?>
            @endforeach
            
            <?php $carpC = 0; ?>
            @foreach($carpentry as $carp)
                <?php $carpentryC += $carp->project_size; ?>
            @endforeach
            
            <?php $paintC = 0; ?>
            @foreach($painting as $paint)
                <?php $paintC += $paint->project_size; ?>
            @endforeach
            
            <?php $fixC = 0; ?>
            @foreach($fixtures as $fix)
                <?php $fixC += $fix->project_size; ?>
            @endforeach
            
            <?php $completeC = 0; ?>
            @foreach($completion as $complete)
                <?php $completeC += $complete->project_size; ?>
            @endforeach
            
            <!--Project size counting ends-->
            
            
            Total Project sizes under {{ $subwardName}} (based on stages)<br>
            Total No. of Projects : {{ count($planning) + count($digging) + count($foundation) + count($pillars) + count($walls) + count($roofing) + count($enp) + count($completion) + count($fixtures) + count($painting) + count($carpentry) + count($flooring) + count($plastering) }}
            Total Sizes : <b>{{ $planC + $digC + $foundC + $pillarC + $completeC + $fixC + $paintC + $carpC + $floorC + $plasterC + $enpC + $roofC + $wallsC }}</b>
            <table class="table table-hover" border="1">
                <thead>
                    <th class="text-center">Stages</th>
                    <th class="text-center">No. of Projects</th>
                    <th class="text-center">Size<br>(in Sq. Ft.)</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Planning</td>
                        <td class="text-center"> {{ count($planning) }} </td>
                        <td>
                            {{ $planC }}
                        </td>
                    </tr>
                    <tr>
                        <td>Digging</td>
                        <td class="text-center">{{ count($digging) }}</td>
                        <td>
                            {{ $digC }}
                        </td>
                    </tr>
                    <tr>
                        <td>Foundation</td>
                        <td class="text-center">{{ count($foundation) }}</td>
                        <td>
                            {{ $foundC }}    
                        </td>
                    </tr>
                    <tr>
                        <td>Pillars</td>
                        <td class="text-center">{{ count($pillars) }}</td>
                        <td>
                            {{ $pillarC }}    
                        </td>
                    </tr>
                    <tr>
                        <td>Walls</td>
                        <td class="text-center">{{ count($walls) }}</td>
                        <td>
                            {{ $wallsC }}
                        </td>
                    </tr>
                    <tr>
                        <td>Roofing</td>
                        <td class="text-center">{{ count($roofing) }}</td>
                        <td>
                            {{ $roofC }}    
                        </td>
                    </tr>
                    <tr>
                        <td>Electrical &amp; Plumbing</td>
                        <td class="text-center">{{ count($enp) }}</td>
                        <td>
                            {{ $enpC }}
                        </td>
                    </tr>
                    <tr>
                        <td>Plastering</td>
                        <td class="text-center">{{ count($plastering) }}</td>
                        <td>
                            {{ $plasterC }}
                        </td>
                    </tr>
                    <tr>
                        <td>Flooring</td>
                        <td class="text-center">{{ count($flooring) }}</td>
                        <td>
                            {{ $floorC }}
                        </td>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td class="text-center">{{ count($carpentry) }}</td>
                        <td>
                            {{ $carpC }}
                        </td>
                    </tr>
                    <tr>
                        <td>Paintings</td>
                        <td class="text-center">{{ count($painting) }}</td>
                        <td>
                            {{ $paintC }}
                        </td>
                    </tr>
                    <tr>
                        <td>Fixtures</td>
                        <td class="text-center">{{ count($fixtures) }}</td>
                        <td>
                            {{ $fixC }}
                        </td>
                    </tr>
                    <tr>
                        <td>Completion</td>
                        <td class="text-center">{{ count($completion) }}</td>
                        <td>
                            {{ $completeC }}
                        </td>
                    </tr>
                </tbody>
            </table> 
            @endif
        </div>
    </div>
</div>
</div>
@endif
@endsection
