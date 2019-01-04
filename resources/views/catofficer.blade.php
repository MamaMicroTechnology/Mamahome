@extends('layouts.app')
@section('content')

<div class="col-md-4" style="overflow-y:scroll; height:570px; max-height:570px">
        <div class="panel panel-primary" style="overflow-x:scroll">
            <div class="panel-heading text-center">
                <b style="color:white">Category Officer Report</b>
            </div>
            <div class="panel-body">
				@if(Auth::user()->department_id != 1)
            	<form method="GET" action="{{ URL::to('/') }}/catofficer">
				@else
				<form method="GET" action="{{ URL::to('/') }}/catofficer">
				@endif
                    <table class="table table-responsive">
	                    <tbody>
	                        <tr>
	                            <td>Select Officer Name</td>
	                        </tr>
                            <tr>
                                <td>
                                    <select required name="se" class="form-control" id="selectle">
                                        <option disabled selected value="">(-- SELECT SE --)</option>
                                        <option value="ALL">All Category Officers</option>
                                        @if(Auth::user()->group_id != 22)
                                            @foreach($users as $list)
                                            <option {{ isset($_GET['se']) ? $_GET['se'] == $list->employeeId ? 'selected' : '' : ''}}  value="{{$list->id}}">{{$list->name}}</option>
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
        <div class="panel panel-default" style="border-color:green;">
            <div class="panel-heading text-center" style="background-color:green">
                <b style="color:white">Mini Report (Today)</b>
            </div>
            <div class="panel-body" style="overflow-x: scroll;">
                <table class="table table-striped" border="1">
                	<tr>
                		<th>Name</th>
                		<th>Projects Visited</th>
                		<th>Enquiry Added</th> 
                		<th>Genuine</th>
                		<th>call</th>
                	</tr>
                    @foreach($users as $user)
                    <tr>
 
                        <td style="font-size: 10px; text-align: center;">{{ $user->name }}</td>
                        <td style="font-size: 10px; text-align: center;">{{ $noOfCalls[$user->id]['projectupdate'] }}</td>
                        <td style="font-size: 10px; text-align: center;">{{ $noOfCalls[$user->id]['Enquiry'] }}</td>
                        <td style="font-size: 10px; text-align: center;">{{ $noOfCalls[$user->id]['Genuine'] }}</td>
                        <td style="font-size: 10px; text-align: center;">{{ $noOfCalls[$user->id]['calls'] }}</td>
                    </tr>
                    @endforeach                   
                </table>
            </div>
        </div>
    </div>

<div class="col-md-8">
    <div class="panel panel-primary" style="overflow-x:scroll">
        <div class="panel-heading" id="panelhead" style="padding:25px;">
           
            <button type="button" onclick="history.back(-1)" class="bk-btn-triangle pull-right" style="margin-top:-10px;" > <i class="fa fa-arrow-circle-left" style="padding:5px;width:50px;color:black;"></i></button>
        </div>
        <div class="panel-body" style="overflow-y:scroll; height:500px; max-height:500px">
            <table class='table pull-right' border="1" style="width:100%;margin-left:50%;">
                <thead>
                    <tr>
                        <th style="text-align:center">Project-ID</th>
                        <th style="text-align:center">Subward Name</th>
                        <th style="text-align:center" >Updater</th>
                        <th style="text-align:center">Quality</th>
                        <th style="text-align:center">Updated Location</th>
                        <th style="text-align:center">Project Location</th> 
                    </tr>
                </thead>
                <tbody id="mainPanel">
                        @foreach($str as $sales)
<!-- {{$sales->subwardids != null ? $sales->subwardids->sub_ward_name : ''}} -->

                       <tr>
                        <td style="text-align:center">
                        	<a href="{{URL::to('/')}}/showThisProject?id={{$sales->project_id}}">{{$sales->project_id}}</a>
                        </td>
                        <td style="text-align:center">
                       <a href="{{ URL::to('/')}}/viewsubward?projectid={{$sales->project_id}} && subward={{ $sales->subwardids != null ? $sales->subwardids->sub_ward_name : ''}}" target="_blank">
                                {{$sales->subwardids != null ? $sales->subwardids->sub_ward_name : ''}}

                                    </a>
                        </td>
                        <td style="text-align:center">{{ $sales->user != null ? $sales->user->name :''  }}</td>
                        <td style="text-align:center">{{$sales->quality}}</td>
                        <td style="text-align:center">{{$sales->location}}</td>
                        <td style="text-align:center">{{ $sales->siteaddress != null ? $sales->siteaddress->address :''  }}</td>
                    </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
