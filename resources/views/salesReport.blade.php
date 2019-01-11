<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 1? "layouts.teamheader":"layouts.app");
?>
@extends($ext)
@section('content')
<div class="col-md-4" style="overflow-y:scroll; height:570px; max-height:570px">
        <div class="panel panel-primary" style="overflow-x:scroll">
            <div class="panel-heading text-center">
                <b style="color:white">Sales Report</b>
            </div>
            <div class="panel-body">
				@if(Auth::user()->department_id != 1)
            	<form method="GET" action="{{ URL::to('/') }}/salesreports">
				@else
				<form method="GET" action="{{ URL::to('/') }}/tlsalesreports">
				@endif
                    <table class="table table-responsive">
	                    <tbody>
	                        <tr>
	                            <td>Select  Employees</td>
	                        </tr>
                            <tr>
                                <td>
                                    <select required name="se" class="form-control" id="selectle">
                                        <option disabled selected value="">(-- SELECT SE --)</option>
                                        <option value="ALL">All Sales Engineers</option>
                                        @if(Auth::user()->group_id != 22)
                                            @foreach($users as $list)
                                            <option {{ isset($_GET['se']) ? $_GET['se'] == $list->employeeId ? 'selected' : '' : ''}}  value="{{$list->employeeId}}">{{$list->name}}</option>
                                            @endforeach
                                        @else
                                            @foreach($tlUsers as $user)
                                                <option {{ isset($_GET['se']) ? $_GET['se'] == $user->employeeId ? 'selected' : '' : ''}}  value="{{$user->employeeId}}">{{ $user->name }}</option>
    	                                    @endforeach
                                        @endif
	                                </select>
	                            </td>
	                        </tr>
	                        <tr>
	                            <td>Select From Date</td>
	                        </tr>
	                        <tr>
	                            <td>
	                                <input value="{{ isset($_GET['fromdate']) ? $_GET['fromdate'] : '' }}" type="date" placeholder= "From Date" class="form-control" id="fromdate" name="fromdate" />
	                            </td>
	                        </tr>
	                        <tr>
	                            <td>Select To Date</td>
	                        </tr>
	                        <tr>
	                            <td>
	                                <input value="{{ isset($_GET['todate']) ? $_GET['todate'] : '' }}" type="date"  placeholder= "To Date" class="form-control" id="todate" name="todate" />
	                            </td>
	                        </tr>
	                        <tr class="text-center">
	                            <td>
	                                <button class="btn bn-md btn-success" style="width:100%">Get Date Range Details</button>
	                            </td>
	                        </tr>
	                    </tbody>
	                </table>
            	</form>
            </div>
        </div>
        <div class="panel panel-default" styke="border-color:green">
            <div class="panel-heading text-center" style="background-color:green">
                <b style="color:white">Mini Report (Today)</b>
            </div>
            <div class="panel-body" style="overflow-x: scroll;">
                <table class="table table-striped" border="1">
                	<tr>
                		<th>Name</th>
                    @if(Auth::user()->group_id != 22)
                		<!-- <th>Ward</th> -->
                    @endif
                		<th>Calls</th>
                		<th>Fake</th>
                		<th>Genuine</th>
                		<th>Initiated</th>
                	</tr>
                       @if(Auth::user()->group_id != 22)

                    @foreach($users as $user)
                    <tr>

                        <td style="font-size: 10px; text-align: center;">{{ $user->name }}</td>
                       <!--  <td style="font-size: 10px; text-align: center;">{{ $user->sub_ward_name }}</td> -->
                        <td style="font-size: 10px; text-align: center;">{{ $noOfCalls[$user->id]['calls'] }}</td>
                        <td style="font-size: 10px; text-align: center;">{{ $noOfCalls[$user->id]['fake'] }}</td>
                        <td style="font-size: 10px; text-align: center;">{{ $noOfCalls[$user->id]['genuine'] }}</td>
                        <td style="font-size: 10px; text-align: center;">{{ $noOfCalls[$user->id]['initiated'] }}</td>
                    </tr>
                    @endforeach
                    @else
                     @foreach( $tlUsers as $user)

                    
                    <tr>
                        <td style="font-size: 10px; text-align: center;">{{ $user->name }}</td>
                        <td style="font-size: 10px; text-align: center;">{{ $noOfCalls[$user->id]['calls'] }}</td>
                        <td style="font-size: 10px; text-align: center;">{{ $noOfCalls[$user->id]['fake'] }}</td>
                        <td style="font-size: 10px; text-align: center;">{{ $noOfCalls[$user->id]['genuine'] }}</td>
                        <td style="font-size: 10px; text-align: center;">{{ $noOfCalls[$user->id]['initiated'] }}</td>
                    </tr>
                    @endforeach
                    @endif
                </table>
            </div>
        </div>
    </div>

<div class="col-md-8">
    <div class="panel panel-primary" style="overflow-x:scroll">
        <div class="panel-heading" id="panelhead">
            <label>
            	Daily Updating For The Date : <b>{{ date('d-m-Y',strtotime($date)) }} {{ isset($_GET['todate']) && $_GET['todate'] != null ? " to ".date('d-m-Y',strtotime($_GET['todate'])) : '' }}</b>
            	&nbsp;&nbsp;&nbsp;&nbsp;
            	No Of Udated Projects: <b>{{ $projectsCount }}</b>
            	&nbsp;&nbsp;&nbsp;&nbsp;
            	Sales Engineer :
            		
            </label>
            <button type="button" onclick="history.back(-1)" class="bk-btn-triangle pull-right" style="margin-top:-10px;" > <i class="fa fa-arrow-circle-left" style="padding:5px;width:50px;color:black;"></i></button>
        </div>
        <div class="panel-body" style="overflow-y:scroll; height:700px; max-height:700px">
            <table class='table table-responsive table-striped' style="color:black" border="1">
                <thead>
                    <tr>
                        <th style="text-align:center">Subward Name</th>
                        <th style="text-align:center">Project-ID</th>
                        <th style="text-align:center">Quality</th>
                        <th style="text-align:center" >Updater</th>
                        <th style="text-align:center">Followup</th>
                       
                    </tr>
                </thead>
                <tbody id="mainPanel">
                	@for($i = 0; $i<count($projectIds);$i++)
                     
                       <tr>
                        <td style="text-align:center">
                        <a href="{{ URL::to('/')}}/viewsubward?projectid={{$projectIds[$i]['projectId']}} && subward={{ $projectIds[$i]['sub_ward_name'] }}" data-toggle="tooltip" data-placement="top" title="click here to view map" class="red-tooltip" target="_blank">{{ $projectIds[$i]['sub_ward_name'] != null ? $projectIds[$i]['sub_ward_name'] : '' }}
                                    </a></td>
                        <td style="text-align:center">
                        	<a href="{{ URL::to('/') }}/admindailyslots?projectId={{$projectIds[$i]['projectId']}}&&lename={{ $projectIds[$i]['updater'] }}">{{ $projectIds[$i]['projectId'] }}</a>
                        </td>
                        <td style="text-align:center" class="{{ isset($_GET['se']) ? 'hidden' : '' }}">{{ $projectIds[$i]['updater'] }}</td>
                        <td style="text-align:center">{{ $projectIds[$i]['quality'] }}</td>
                        <td style="text-align:center">{{ $projectIds[$i]['caller'] }}</td>
                        
                    </tr>
                 
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
